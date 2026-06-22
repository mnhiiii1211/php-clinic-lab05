USE web_php_lab05_clinic;

EXPLAIN SELECT id, name, email, phone, gender, created_at
FROM patients
WHERE name LIKE '%anna%' OR email LIKE '%anna%' OR phone LIKE '%anna%'
ORDER BY created_at DESC
LIMIT 10 OFFSET 0;

EXPLAIN SELECT id, appointment_code, patient_name, patient_email, appointment_date, status, created_at
FROM appointments
WHERE appointment_code LIKE '%APT%' OR patient_name LIKE '%APT%' OR patient_email LIKE '%APT%'
ORDER BY appointment_date DESC
LIMIT 10 OFFSET 0;

EXPLAIN SELECT id, appointment_code, patient_name, patient_email, appointment_date, status, created_at
FROM appointments
WHERE status = 'scheduled'
ORDER BY created_at DESC
LIMIT 10 OFFSET 0;
