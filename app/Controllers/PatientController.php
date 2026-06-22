<?php
class PatientController
{
    private function repository(): PatientRepository
    {
        $config = require __DIR__ . '/../../config/database.php';
        $db = (new Database($config))->getConnection();
        return new PatientRepository($db);
    }

    private function normalizeListParams(PatientRepository $repo): array
    {
        $q = trim((string) ($_GET['q'] ?? ''));
        $sort = (string) ($_GET['sort'] ?? 'created_at');
        $direction = strtolower((string) ($_GET['direction'] ?? 'desc'));
        $allowedSorts = ['id', 'name', 'email', 'phone', 'gender', 'created_at'];
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
        $patients = $repo->getPaginated($q, $perPage, $offset, $sort, $direction);

        view('patients/index', compact('patients', 'q', 'sort', 'direction', 'page', 'perPage', 'total', 'totalPages') + [
            'title' => 'Patients',
        ]);
    }

    public function create(): void
    {
        view('patients/create', [
            'title' => 'Create Patient',
            'errors' => [],
            'old' => ['gender' => 'female'],
        ]);
    }

    public function store(): void
    {
        $data = $this->patientDataFromRequest();
        $errors = $this->validate($data);

        if ($errors) {
            view('patients/create', ['title' => 'Create Patient', 'errors' => $errors, 'old' => $data]);
            return;
        }

        try {
            $this->repository()->create($data);
            flash_set('success', 'Patient created successfully.');
            redirect('/patients');
        } catch (DuplicateRecordException $e) {
            $errors[$e->field() ?: 'email'] = 'This patient email already exists. Please use another email.';
            view('patients/create', ['title' => 'Create Patient', 'errors' => $errors, 'old' => $data]);
        }
    }

    public function edit(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            http_response_code(404);
            view('errors/404', ['title' => 'Patient Not Found']);
            return;
        }

        $patient = $this->repository()->findById($id);
        if (!$patient) {
            http_response_code(404);
            view('errors/404', ['title' => 'Patient Not Found']);
            return;
        }

        view('patients/edit', ['title' => 'Edit Patient', 'errors' => [], 'old' => $patient]);
    }

    public function update(): void
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $data = $this->patientDataFromRequest();
        $errors = $this->validate($data);

        if (!$id) {
            $errors['id'] = 'Invalid patient id.';
        }

        if ($errors) {
            $data['id'] = (string) $id;
            view('patients/edit', ['title' => 'Edit Patient', 'errors' => $errors, 'old' => $data]);
            return;
        }

        try {
            $this->repository()->update((int) $id, $data);
            flash_set('success', 'Patient updated successfully.');
            redirect('/patients');
        } catch (DuplicateRecordException $e) {
            $errors[$e->field() ?: 'email'] = 'This patient email already exists. Please use another email.';
            $data['id'] = (string) $id;
            view('patients/edit', ['title' => 'Edit Patient', 'errors' => $errors, 'old' => $data]);
        }
    }

    public function delete(): void
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $this->repository()->delete($id);
            flash_set('success', 'Patient deleted successfully.');
        }
        redirect('/patients');
    }

    private function patientDataFromRequest(): array
    {
        return [
            'name' => trim((string) ($_POST['name'] ?? '')),
            'email' => trim((string) ($_POST['email'] ?? '')),
            'phone' => trim((string) ($_POST['phone'] ?? '')),
            'gender' => trim((string) ($_POST['gender'] ?? 'female')),
            'note' => trim((string) ($_POST['note'] ?? '')),
        ];
    }

    private function validate(array $data): array
    {
        $errors = [];
        if ($data['name'] === '') {
            $errors['name'] = 'Patient name is required.';
        }
        if ($data['email'] === '') {
            $errors['email'] = 'Patient email is required.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address.';
        }
        if ($data['phone'] !== '' && !preg_match('/^[0-9+\-\s]{8,20}$/', $data['phone'])) {
            $errors['phone'] = 'Phone must contain only digits, spaces, + or -.';
        }
        if (!in_array($data['gender'], ['female', 'male', 'other'], true)) {
            $errors['gender'] = 'Please select a valid gender.';
        }
        return $errors;
    }
}
