<?php
class AppointmentController
{
    private function repository(): AppointmentRepository
    {
        $config = require __DIR__ . '/../../config/database.php';
        $db = (new Database($config))->getConnection();
        return new AppointmentRepository($db);
    }

    private function normalizeListParams(AppointmentRepository $repo): array
    {
        $q = trim((string) ($_GET['q'] ?? ''));
        $sort = (string) ($_GET['sort'] ?? 'created_at');
        $direction = strtolower((string) ($_GET['direction'] ?? 'desc'));
        $allowedSorts = ['id', 'appointment_code', 'patient_name', 'patient_email', 'appointment_date', 'status', 'created_at'];
        $allowedDirections = ['asc', 'desc'];
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }
        if (!in_array($direction, $allowedDirections, true)) {
            $direction = 'desc';
        }

        $perPage = 10;
        $total = $repo->countAll($q);
        $totalPages = max(1, (int) ceil($total / $perPage));
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;
        if ($page < 1) {
            $page = 1;
        }
        if ($page > $totalPages) {
            $page = $totalPages;
        }

        return [$q, $sort, $direction, $perPage, $total, $totalPages, $page];
    }

    public function index(): void
    {
        $repo = $this->repository();
        [$q, $sort, $direction, $perPage, $total, $totalPages, $page] = $this->normalizeListParams($repo);
        $offset = ($page - 1) * $perPage;
        $appointments = $repo->getPaginated($q, $perPage, $offset, $sort, $direction);

        view('appointments/index', compact('appointments', 'q', 'sort', 'direction', 'page', 'perPage', 'total', 'totalPages') + [
            'title' => 'Appointments',
        ]);
    }

    public function create(): void
    {
        view('appointments/create', [
            'title' => 'Create Appointment',
            'errors' => [],
            'old' => ['status' => 'scheduled'],
        ]);
    }

    public function store(): void
    {
        $data = $this->appointmentDataFromRequest();
        $errors = $this->validate($data);

        if ($errors) {
            view('appointments/create', ['title' => 'Create Appointment', 'errors' => $errors, 'old' => $data]);
            return;
        }

        try {
            $this->repository()->create($data);
            flash_set('success', 'Appointment created successfully.');
            redirect('/appointments');
        } catch (DuplicateRecordException $e) {
            $errors[$e->field() ?: 'appointment_code'] = 'This appointment code already exists. Please use another code.';
            view('appointments/create', ['title' => 'Create Appointment', 'errors' => $errors, 'old' => $data]);
        }
    }

    public function edit(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            http_response_code(404);
            view('errors/404', ['title' => 'Appointment Not Found']);
            return;
        }

        $appointment = $this->repository()->findById($id);
        if (!$appointment) {
            http_response_code(404);
            view('errors/404', ['title' => 'Appointment Not Found']);
            return;
        }

        view('appointments/edit', ['title' => 'Edit Appointment', 'errors' => [], 'old' => $appointment]);
    }

    public function update(): void
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $data = $this->appointmentDataFromRequest();
        $errors = $this->validate($data);

        if (!$id) {
            $errors['id'] = 'Invalid appointment id.';
        }

        if ($errors) {
            $data['id'] = (string) $id;
            view('appointments/edit', ['title' => 'Edit Appointment', 'errors' => $errors, 'old' => $data]);
            return;
        }

        try {
            $this->repository()->update((int) $id, $data);
            flash_set('success', 'Appointment updated successfully.');
            redirect('/appointments');
        } catch (DuplicateRecordException $e) {
            $errors[$e->field() ?: 'appointment_code'] = 'This appointment code already exists. Please use another code.';
            $data['id'] = (string) $id;
            view('appointments/edit', ['title' => 'Edit Appointment', 'errors' => $errors, 'old' => $data]);
        }
    }

    public function delete(): void
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $this->repository()->delete($id);
            flash_set('success', 'Appointment deleted successfully.');
        }
        redirect('/appointments');
    }

    private function appointmentDataFromRequest(): array
    {
        return [
            'appointment_code' => strtoupper(trim((string) ($_POST['appointment_code'] ?? ''))),
            'patient_name' => trim((string) ($_POST['patient_name'] ?? '')),
            'patient_email' => trim((string) ($_POST['patient_email'] ?? '')),
            'appointment_date' => trim((string) ($_POST['appointment_date'] ?? '')),
            'status' => trim((string) ($_POST['status'] ?? 'scheduled')),
            'note' => trim((string) ($_POST['note'] ?? '')),
        ];
    }

    private function validate(array $data): array
    {
        $errors = [];
        if ($data['appointment_code'] === '') {
            $errors['appointment_code'] = 'Appointment code is required.';
        } elseif (!preg_match('/^APT-[0-9]{4}-[0-9]{4}$/', $data['appointment_code'])) {
            $errors['appointment_code'] = 'Use code format APT-2026-0001.';
        }
        if ($data['patient_name'] === '') {
            $errors['patient_name'] = 'Patient name is required.';
        }
        if ($data['patient_email'] !== '' && !filter_var($data['patient_email'], FILTER_VALIDATE_EMAIL)) {
            $errors['patient_email'] = 'Please enter a valid patient email.';
        }
        if ($data['appointment_date'] === '') {
            $errors['appointment_date'] = 'Appointment date is required.';
        }
        if (!in_array($data['status'], ['scheduled', 'completed', 'cancelled', 'no_show'], true)) {
            $errors['status'] = 'Please select a valid appointment status.';
        }
        return $errors;
    }
}
