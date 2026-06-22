<?php
$config = require __DIR__ . '/../config/database.php';
$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $config['host'], $config['database'], $config['charset']);
$pdo = new PDO($dsn, $config['username'], $config['password'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
]);

$patientStmt = $pdo->prepare('INSERT INTO patients (name, email, phone, gender, note) VALUES (:name, :email, :phone, :gender, :note)');
$appointmentStmt = $pdo->prepare('INSERT INTO appointments (appointment_code, patient_name, patient_email, appointment_date, status, note) VALUES (:code, :name, :email, :date, :status, :note)');
$genders = ['female', 'male', 'other'];
$statuses = ['scheduled', 'completed', 'cancelled', 'no_show'];

for ($i = 21; $i <= 150; $i++) {
    $name = 'Seed Patient ' . $i;
    $email = 'seed.patient.' . $i . '@example.com';
    $phone = '0910' . str_pad((string) $i, 6, '0', STR_PAD_LEFT);
    $gender = $genders[$i % count($genders)];
    $patientStmt->execute([
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'gender' => $gender,
        'note' => 'Generated seed patient for pagination and EXPLAIN test.',
    ]);

    $code = 'APT-2026-' . str_pad((string) $i, 4, '0', STR_PAD_LEFT);
    $date = date('Y-m-d H:i:s', strtotime('2026-07-01 +' . $i . ' hours'));
    $status = $statuses[$i % count($statuses)];
    $appointmentStmt->execute([
        'code' => $code,
        'name' => $name,
        'email' => $email,
        'date' => $date,
        'status' => $status,
        'note' => 'Generated seed appointment for pagination and EXPLAIN test.',
    ]);
}

echo "Seeded patients and appointments successfully." . PHP_EOL;
