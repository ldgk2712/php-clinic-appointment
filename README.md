# Clinic Appointment DB App - PHP Lab05

Mini Clinic Appointment DB App built with PHP 8+, PDO and MySQL.
The project follows the Lab05 requirements: CRUD, Repository pattern, prepared statements, search, pagination, safe sorting, unique constraints, indexes, duplicate handling and safe error pages.

## 1. Project overview

This application manages a small clinic database with two main business modules:

* Patients
* Appointments

Main architecture:

```text
Browser -> public/index.php -> Router -> Controller -> Repository -> PDO -> MySQL -> View/Redirect -> Browser
```

## 2. Features

* Dashboard page
* Health check endpoint
* Patients CRUD:

  * List
  * Create
  * Edit
  * Update
  * Delete
* Appointments CRUD:

  * List
  * Create
  * Edit
  * Update
  * Delete
* Search by keyword
* Pagination
* Safe sorting with whitelist sort and direction
* Duplicate handling:

  * Patient email must be unique
  * Appointment code must be unique
* PRG Pattern after successful POST
* 404, 405 and 500 error views
* PDO prepared statements for database queries
* Safe production error message with log file

## 3. Project structure

```text
php-clinic-appointment-lab05/
├── public/
│   ├── index.php
│   └── assets/
│       └── style.css
│
├── config/
│   ├── app.php
│   └── database.php
│
├── app/
│   ├── Core/
│   │   ├── Database.php
│   │   ├── Router.php
│   │   ├── helpers.php
│   │   └── DuplicateRecordException.php
│   │
│   ├── Controllers/
│   │   ├── HomeController.php
│   │   ├── HealthController.php
│   │   ├── PatientController.php
│   │   └── AppointmentController.php
│   │
│   ├── Repositories/
│   │   ├── PatientRepository.php
│   │   └── AppointmentRepository.php
│   │
│   └── Views/
│       ├── layout.php
│       ├── dashboard.php
│       ├── errors/
│       ├── patients/
│       └── appointments/
│
├── database/
│   ├── schema.sql
│   └── seed.sql
│
└── storage/
    └── logs/
        └── app.log
```

## 4. Requirements

* PHP 8.1 or later
* MySQL or MariaDB
* VS Code
* Browser
* Git
* MySQL Workbench or phpMyAdmin for database import

## 5. Database setup

The application uses its own database:

```text
clinic_lab05
```

Main tables:

* `users`
* `patients`
* `appointments`

Important constraints:

* `patients.email` is unique
* `appointments.appointment_code` is unique

### Option 1: Import with MySQL Workbench

Open MySQL Workbench and run the SQL files in this order:

```text
database/schema.sql
database/seed.sql
```

After importing, check the data:

```sql
USE clinic_lab05;

SHOW TABLES;

SELECT COUNT(*) AS total_patients FROM patients;
SELECT COUNT(*) AS total_appointments FROM appointments;
```

### Option 2: Import with command line

From this project directory:

```bash
mysql -u root -p < database/schema.sql
mysql -u root -p < database/seed.sql
```

If the root user has no password, use:

```bash
mysql -u root < database/schema.sql
mysql -u root < database/seed.sql
```

## 6. Database configuration

Default connection values are stored in:

```text
config/database.php
```

Example:

```php
<?php

return [
    'host' => '127.0.0.1',
    'port' => 3306,
    'database' => 'clinic_lab05',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
];
```

If your MySQL root user has a password, update the `password` value.

## 7. Run the application

From this project directory:

```bash
php -S 127.0.0.1:8000 -t public
```

Then open:

```text
http://127.0.0.1:8000/
http://127.0.0.1:8000/health
http://127.0.0.1:8000/patients
http://127.0.0.1:8000/appointments
```

## 8. Main routes

| Method | URL                       | Description                                    |
| ------ | ------------------------- | ---------------------------------------------- |
| GET    | `/`                       | Dashboard                                      |
| GET    | `/health`                 | Database health check                          |
| GET    | `/patients`               | Patients list, search, pagination and sort     |
| GET    | `/patients/create`        | Create patient form                            |
| POST   | `/patients/store`         | Store new patient                              |
| GET    | `/patients/edit?id=1`     | Edit patient form                              |
| POST   | `/patients/update`        | Update patient                                 |
| POST   | `/patients/delete`        | Delete patient                                 |
| GET    | `/appointments`           | Appointments list, search, pagination and sort |
| GET    | `/appointments/create`    | Create appointment form                        |
| POST   | `/appointments/store`     | Store new appointment                          |
| GET    | `/appointments/edit?id=1` | Edit appointment form                          |
| POST   | `/appointments/update`    | Update appointment                             |
| POST   | `/appointments/delete`    | Delete appointment                             |

## 9. Testing checklist

Suggested test cases:

* `GET /health` returns database connected JSON
* `GET /patients` displays patient list
* Create a valid patient
* Create a patient with duplicate email
* Edit and update a patient
* Delete a patient by POST
* `GET /appointments` displays appointment list
* Create a valid appointment
* Create an appointment with duplicate appointment code
* Test invalid page, for example `?page=-5`
* Test dangerous sort parameter
* Test 404 with a non-existing URL
* Test 405 with a wrong HTTP method
* Test safe DB error with `debug=false`
* Run EXPLAIN for list/search/sort queries

## 10. Safe error mode

For production-like error output, set debug to false in:

```text
config/app.php
```

Example:

```php
'debug' => false,
```

Technical error details are written to:

```text
storage/logs/app.log
```

They are not shown directly to users.

## 11. Git

Suggested commit milestones:

```text
setup clinic appointment project structure
add clinic database schema and seed data
add patient and appointment repositories
add CRUD controllers and views
add testing notes and final documentation
```

Check commit history:

```bash
git log --oneline
```
