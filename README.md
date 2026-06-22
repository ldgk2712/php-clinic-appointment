# Clinic Appointment DB App - PHP Lab05

Mini Clinic Appointment DB App built with PHP 8+, PDO, MySQL, Repository pattern,
CRUD, search, pagination, safe sorting, unique constraints and indexes.

## Modules

- Patients
- Appointments

## Database setup

The application uses its own `clinic_lab05` database. Import in this order:

```bash
mysql -u root -p < database/schema.sql
mysql -u root -p clinic_lab05 < database/seed.sql
```

Default connection values are in `config/database.php`. They can be overridden:

```bash
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=clinic_lab05
DB_USERNAME=root
DB_PASSWORD=123456
APP_TIMEZONE=Asia/Ho_Chi_Minh
```

## Run

From this project directory:

```bash
php -S localhost:8000 -t public
```

Then open:

- `http://localhost:8000/`
- `http://localhost:8000/health`
- `http://localhost:8000/patients`
- `http://localhost:8000/appointments`

For production-like error output, set `APP_DEBUG=false`. Technical details are
written to `storage/logs/app.log` and are not shown to users.
