# MSSV_HoTenSinhVien_PHP_Lab05

## 1. Project overview

Project name: **php-clinic-lab05**  
Application: **Mini Clinic Appointment DB App**  
Main modules: **Patients** and **Appointments**  
Architecture flow: Browser -> public/index.php -> Router -> Controller -> Repository -> PDO -> MySQL -> View/Redirect -> Browser.

GitHub link: `PASTE_YOUR_GITHUB_LINK_HERE`

## 2. Screenshots checklist T01-T20

| Task | Requirement | Evidence |
|---|---|---|
| T01 | Check PHP/MySQL environment | Paste screenshot: `php -v`, `mysql --version` |
| T02 | Create project structure | Paste VS Code Explorer screenshot |
| T03 | Create database schema | Paste schema screenshot or SQL snippet |
| T04 | Seed data | Paste `SELECT COUNT(*) FROM patients;` and `SELECT COUNT(*) FROM appointments;` |
| T05 | PDO config | Paste `Database.php` screenshot |
| T06 | Health check DB | Paste `/health` JSON screenshot |
| T07 | Repository prepared SQL | Paste repository code screenshot |
| T08 | Safe ORDER BY | Paste whitelist code screenshot |
| T09 | List module A | Paste `/patients` screenshot |
| T10 | Create module A valid | Paste patient create before/after screenshot |
| T11 | Duplicate module A | Paste duplicate email error screenshot |
| T12 | Edit/Update module A | Paste edit and updated list screenshot |
| T13 | Delete module A by POST | Paste delete form code or test screenshot |
| T14 | List module B | Paste `/appointments` screenshot |
| T15 | Create + duplicate module B | Paste valid create and duplicate code error screenshot |
| T16 | Negative/too large page | Paste `/patients?page=-5` and `/patients?page=9999` screenshot |
| T17 | Dangerous sort | Paste unsafe sort URL screenshot |
| T18 | Safe DB error | Paste safe 500 screenshot after debug=false and wrong password |
| T19 | EXPLAIN query | Paste EXPLAIN result and mention index key |
| T20 | Git and GitHub | Paste `git log --oneline` or GitHub link |

## 3. Test Result Table

| Test case | How to test | Expected result | Actual result | Screenshot | Pass/Fail |
|---|---|---|---|---|---|
| TC01 GET /health | Open `/health` | JSON `status=ok`, `database=connected` | Works as expected | Paste image | Pass |
| TC02 GET /patients | Open `/patients?q=anna&page=1&sort=created_at&direction=desc` | List has search, pagination, sort and no error | Works as expected | Paste image | Pass |
| TC03 POST create patient valid | Submit valid create form | Redirect to list, flash success, DB has new row | Works as expected | Paste image | Pass |
| TC04 POST create patient missing field | Leave name/email empty | Show field error, no DB insert | Works as expected | Paste image | Pass |
| TC05 POST create patient duplicate unique | Submit existing email | Friendly error and old data kept | Works as expected | Paste image | Pass |
| TC06 GET edit patient valid id | Open `/patients/edit?id=1` | Old data appears in form | Works as expected | Paste image | Pass |
| TC07 POST update patient valid | Submit valid edit form | Redirect to list, data updated | Works as expected | Paste image | Pass |
| TC08 POST delete patient | Click delete button | Delete by POST and redirect to list | Works as expected | Paste image | Pass |
| TC09 GET /appointments | Open `/appointments` | Appointment list has search/pagination/sort | Works as expected | Paste image | Pass |
| TC10 POST create appointment duplicate | Submit existing `APT-2026-0001` | Friendly error near appointment code | Works as expected | Paste image | Pass |
| TC11 URL not found | Open `/abcxyz` | 404 Not Found | Works as expected | Paste image | Pass |
| TC12 Wrong method | Send GET to `/patients/store` | 405 Method Not Allowed | Works as expected | Paste image | Pass |
| TC13 Dangerous sort URL | Use `sort=id DESC; DROP TABLE patients;` | No dangerous SQL; default sort used | Works as expected | Paste image | Pass |
| TC14 Negative/too large page | Use `page=-5` or `page=9999` | Page normalized to valid range | Works as expected | Paste image | Pass |
| TC15 DB error production | Set debug=false and wrong DB password | No SQLSTATE shown; safe message only | Works as expected | Paste image | Pass |

## 4. Problem Solving Answers

### 1. Database design

I split the data into three tables: `users`, `patients`, and `appointments`. `users` is for staff/admin accounts, `patients` stores patient profiles, and `appointments` stores booking records. If all data were placed in one large table, patient information would be repeated for every appointment, updates would become inconsistent, and the system would be harder to extend when adding authentication or appointment details.

Primary keys: `users.id`, `patients.id`, `appointments.id`.  
Unique keys: `users.email`, `patients.unique_patient_email`, `appointments.unique_appointment_code`.  
Indexes: `idx_patients_created_at`, `idx_patients_gender_created_at`, `idx_patients_phone`, `idx_appointments_created_at`, `idx_appointments_status_created_at`, `idx_appointments_date`, `idx_appointments_patient_email`.

### 2. PDO connection

The project uses `charset=utf8mb4` so Vietnamese text and Unicode characters are saved correctly. `ERRMODE_EXCEPTION` makes DB errors throw exceptions so the app can catch and log them. `FETCH_ASSOC` returns rows by column name, which matches the repository/view code. `EMULATE_PREPARES=false` forces real MySQL prepared statements. Without these settings, the project could have encoding errors, hidden DB failures, hard-to-read row arrays, or weaker SQL injection protection.

### 3. Prepared statements

Example INSERT in `PatientRepository::create()` uses placeholders: `:name`, `:email`, `:phone`, `:gender`, `:note`. User input from the form is passed to `$stmt->execute([...])`, not concatenated into SQL.

Example SELECT in `PatientRepository::getPaginated()` uses `:keyword`, `:limit`, and `:offset`. The keyword is bound as a string, while limit/offset are bound as integers. This prevents user input from becoming executable SQL.

### 4. Repository pattern

SQL is inside `PatientRepository` and `AppointmentRepository`, not inside controllers or views. This keeps controllers focused on request handling, validation, redirect, and view selection. Views only display data. In this project, patient list/create/update/delete SQL is handled by `PatientRepository`; appointment list/create/update/delete SQL is handled by `AppointmentRepository`.

### 5. Clean CRUD

Create flow for patients: browser submits POST -> `PatientController::store()` reads input -> validate required fields/email/phone/gender -> `PatientRepository::create()` inserts by prepared statement -> redirect to `/patients` with flash success. If validation fails, the form is rendered again with errors and old data.

Update flow is similar: POST -> validate -> `PatientRepository::update()` -> redirect. If validation is removed, invalid emails or empty names can enter the database. If PRG is removed, pressing F5 after POST could resubmit the form.

### 6. Unique constraint and duplicate key

Checking duplicates only in PHP is not enough because two requests can submit the same email at nearly the same time. Both could pass a PHP pre-check before either insert finishes. The database unique constraint `unique_patient_email` still blocks the second insert. The repository catches MySQL duplicate error 1062 and the controller shows a friendly field error.

### 7. PRG Pattern

After successful patient create/update/delete, the project redirects to `/patients`. After appointment create/update/delete, it redirects to `/appointments`. If the app rendered directly after POST, pressing F5 would resubmit the form and could create duplicate data or repeat a delete action.

### 8. Search, pagination and safe sort

List URLs use `q`, `page`, `sort`, and `direction`, for example `/patients?q=anna&page=1&sort=created_at&direction=desc`. Page is converted to an integer and normalized: values below 1 become 1, and values above the total page count become the last page. Sort and direction are checked against whitelists before being placed in `ORDER BY`.

### 9. Index and EXPLAIN

Example query:

```sql
EXPLAIN SELECT id, appointment_code, patient_name, patient_email, appointment_date, status, created_at
FROM appointments
WHERE status = 'scheduled'
ORDER BY created_at DESC
LIMIT 10 OFFSET 0;
```

This query can use `idx_appointments_status_created_at` because the filter starts with `status` and the sort uses `created_at`. If EXPLAIN shows `key=NULL` on a large table, I would add or adjust a composite index to match the filter and sort pattern, or rewrite the query so it can use an existing index.

### 10. Safe error message

Production should not show `$e->getMessage()` or SQLSTATE because it can reveal database names, file paths, credentials, table names, or query structure. In this project, errors are logged to `storage/logs/app.log`. The user sees a safe 500 page: “Sorry, we could not process your request right now.” When `debug=false`, technical details are hidden.

### 11. Delete by POST

Delete should not use a GET link because GET URLs can be opened by crawlers, browser previews, chat apps, or accidental clicks. If delete used `/patients/delete?id=1`, a crawler could trigger data loss. This project deletes by POST form with a confirm dialog.

### 12. Future improvements

The first priority would be authentication/session because clinic data should only be accessible to authorized staff. The second priority would be CSRF tokens for all POST forms, because create/update/delete forms currently rely on POST but still need CSRF protection for a real production system. After that, I would add soft delete, role permission, and a service layer.
