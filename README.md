# Lab05 - Clinic Appointment Database Management App

This project is a new equivalent implementation for **PHP Lab05 Database CRUD**. It is not the original Lead/Order sample app. The new business domain is a small clinic that manages patients and appointment bookings.

## Main flow

Browser -> `public/index.php` -> Router -> Controller -> Repository -> PDO -> MySQL -> View/Redirect -> Browser

## Modules

- `patients`: CRUD for patient profiles. `email` is unique.
- `appointments`: CRUD for appointment bookings. `appointment_code` is unique.
- `users`: base user table for the required database design.

## Routes

| Method | URL | Controller@Action |
|---|---|---|
| GET | `/` | `HomeController@index` |
| GET | `/health` | `HealthController@index` |
| GET | `/patients` | `PatientController@index` |
| GET | `/patients/create` | `PatientController@create` |
| POST | `/patients/store` | `PatientController@store` |
| GET | `/patients/edit?id=1` | `PatientController@edit` |
| POST | `/patients/update` | `PatientController@update` |
| POST | `/patients/delete` | `PatientController@delete` |
| GET | `/appointments` | `AppointmentController@index` |
| GET | `/appointments/create` | `AppointmentController@create` |
| POST | `/appointments/store` | `AppointmentController@store` |
| GET | `/appointments/edit?id=1` | `AppointmentController@edit` |
| POST | `/appointments/update` | `AppointmentController@update` |
| POST | `/appointments/delete` | `AppointmentController@delete` |

## Setup

```bash
cd php-clinic-lab05
mysql -u root -p < database/schema.sql
mysql -u root -p < database/seed.sql
php -S localhost:8000 -t public
```

Then open:

- `http://localhost:8000/`
- `http://localhost:8000/health`
- `http://localhost:8000/patients`
- `http://localhost:8000/appointments`

If your MySQL account is not `root` with an empty password, edit `config/database.php`.

## Optional large seed

```bash
php database/seed_data.php
```

This generates more records for pagination and EXPLAIN tests.

## Required tests to capture screenshots

1. `php -v`, `mysql --version`.
2. VS Code project structure.
3. phpMyAdmin/MySQL Workbench schema with primary key, unique key, and indexes.
4. `SELECT COUNT(*) FROM patients;` and `SELECT COUNT(*) FROM appointments;`.
5. `GET /health` JSON.
6. Patient list, create, duplicate email error, edit/update, delete by POST.
7. Appointment list, create, duplicate appointment code error, edit/update, delete by POST.
8. Unsafe sort URL such as `/patients?sort=id%20DESC;%20DROP%20TABLE%20patients;&direction=hack`.
9. Page tests such as `/patients?page=-5` and `/patients?page=9999`.
10. Safe DB error: set `debug` to `false` in `config/app.php`, temporarily break DB password, then open a DB route.
11. EXPLAIN: run `database/explain.sql`.
12. `git log --oneline` after at least 5 commits.

## Suggested Git commits

```bash
git init
git add .
git commit -m "setup clinic lab05 project structure"
git commit -m "add database schema and seed data"
git commit -m "add PDO database and repositories"
git commit -m "add patient and appointment CRUD"
git commit -m "add validation pagination safe sort and error handling"
```
