<?php

class AppointmentController
{
    private const ALLOWED_SORTS = [
        'id',
        'appointment_code',
        'patient_name',
        'patient_email',
        'appointment_date',
        'department',
        'status',
        'created_at',
    ];
    private const ALLOWED_DIRECTIONS = ['asc', 'desc'];

    private function repository(): AppointmentRepository
    {
        $config = require __DIR__ . '/../../config/database.php';
        $pdo = (new Database($config))->getConnection();

        return new AppointmentRepository($pdo);
    }

    public function index(): void
    {
        try {
            $q = trim($_GET['q'] ?? '');
            $page = max(1, (int) ($_GET['page'] ?? 1));
            $perPage = 10;
            $sort = (string) ($_GET['sort'] ?? 'created_at');
            $direction = strtolower((string) ($_GET['direction'] ?? 'desc'));

            if (!in_array($sort, self::ALLOWED_SORTS, true)) {
                $sort = 'created_at';
            }

            if (!in_array($direction, self::ALLOWED_DIRECTIONS, true)) {
                $direction = 'desc';
            }

            $repo = $this->repository();
            $total = $repo->countAll($q);
            $totalPages = max(1, (int) ceil($total / $perPage));

            if ($page > $totalPages) {
                $page = $totalPages;
            }

            $offset = ($page - 1) * $perPage;
            $appointments = $repo->getPaginated($q, $perPage, $offset, $sort, $direction);

            render('appointments/index', [
                'appointments' => $appointments,
                'q' => $q,
                'page' => $page,
                'perPage' => $perPage,
                'total' => $total,
                'totalPages' => $totalPages,
                'sort' => $sort,
                'direction' => $direction,
            ], 'Appointment Management');
        } catch (Throwable $e) {
            log_error($e);
            http_response_code(500);
            render('errors/500', [
                'message' => 'Sorry, we could not load appointments right now.',
            ], 'Something went wrong');
        }
    }

    public function create(array $data = [], array $errors = []): void
    {
        $data = array_merge([
            'appointment_code' => '',
            'patient_name' => '',
            'patient_email' => '',
            'appointment_date' => date('Y-m-d\TH:i'),
            'department' => 'General',
            'status' => 'scheduled',
            'note' => '',
        ], $data);

        render('appointments/create', [
            'data' => $data,
            'errors' => $errors,
        ], 'Create Appointment');
    }

    public function store(): void
    {
        $data = $this->appointmentDataFromRequest();
        $errors = $this->validateAppointment($data);

        if ($errors !== []) {
            $this->create($data, $errors);
            return;
        }

        try {
            $this->repository()->create($this->appointmentDataForDatabase($data));
            flash_set('success', 'Appointment created successfully.');
            redirect('/appointments');
        } catch (DuplicateRecordException $e) {
            $errors['appointment_code'] = 'Mã lịch hẹn này đã tồn tại. Vui lòng nhập mã khác.';
            $this->create($data, $errors);
        } catch (Throwable $e) {
            log_error($e);
            http_response_code(500);
            render('errors/500', [
                'message' => 'Sorry, we could not create this appointment right now.',
            ], 'Something went wrong');
        }
    }

    public function edit(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            http_response_code(404);
            render('errors/404', [], '404 Not Found');
            return;
        }

        try {
            $appointment = $this->repository()->findById($id);

            if (!$appointment) {
                http_response_code(404);
                render('errors/404', [], '404 Not Found');
                return;
            }

            $appointment['appointment_date'] = date('Y-m-d\TH:i', strtotime($appointment['appointment_date']));

            render('appointments/edit', [
                'data' => $appointment,
                'errors' => [],
            ], 'Edit Appointment');
        } catch (Throwable $e) {
            log_error($e);
            http_response_code(500);
            render('errors/500', [
                'message' => 'Sorry, we could not load this appointment right now.',
            ], 'Something went wrong');
        }
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $data = $this->appointmentDataFromRequest();
        $errors = $this->validateAppointment($data);

        if ($id <= 0) {
            http_response_code(404);
            render('errors/404', [], '404 Not Found');
            return;
        }

        if ($errors !== []) {
            $data['id'] = $id;
            render('appointments/edit', [
                'data' => $data,
                'errors' => $errors,
            ], 'Edit Appointment');
            return;
        }

        try {
            $repository = $this->repository();
            if ($repository->findById($id) === null) {
                http_response_code(404);
                render('errors/404', [], '404 Not Found');
                return;
            }

            $repository->update($id, $this->appointmentDataForDatabase($data));
            flash_set('success', 'Appointment updated successfully.');
            redirect('/appointments');
        } catch (DuplicateRecordException $e) {
            $data['id'] = $id;
            $errors['appointment_code'] = 'Mã lịch hẹn này đã thuộc về lịch hẹn khác.';
            render('appointments/edit', [
                'data' => $data,
                'errors' => $errors,
            ], 'Edit Appointment');
        } catch (Throwable $e) {
            log_error($e);
            http_response_code(500);
            render('errors/500', [
                'message' => 'Sorry, we could not update this appointment right now.',
            ], 'Something went wrong');
        }
    }

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0) {
            flash_set('error', 'Invalid appointment id.');
            redirect('/appointments');
        }

        try {
            $deleted = $this->repository()->delete($id);
            flash_set(
                $deleted ? 'success' : 'error',
                $deleted ? 'Appointment deleted successfully.' : 'Appointment was not found.'
            );
            redirect('/appointments');
        } catch (Throwable $e) {
            log_error($e);
            flash_set('error', 'Could not delete appointment right now.');
            redirect('/appointments');
        }
    }

    private function appointmentDataFromRequest(): array
    {
        $rawDate = trim($_POST['appointment_date'] ?? '');

        return [
            'appointment_code' => trim($_POST['appointment_code'] ?? ''),
            'patient_name' => trim($_POST['patient_name'] ?? ''),
            'patient_email' => trim($_POST['patient_email'] ?? ''),
            'appointment_date' => $rawDate,
            'department' => trim($_POST['department'] ?? 'General'),
            'status' => trim($_POST['status'] ?? 'scheduled'),
            'note' => trim($_POST['note'] ?? ''),
        ];
    }

    private function appointmentDataForDatabase(array $data): array
    {
        $date = DateTimeImmutable::createFromFormat('!Y-m-d\TH:i', $data['appointment_date']);
        $data['appointment_date'] = $date->format('Y-m-d H:i:s');

        return $data;
    }

    private function validateAppointment(array $data): array
    {
        $errors = [];

        if ($data['appointment_code'] === '') {
            $errors['appointment_code'] = 'Appointment code is required.';
        } elseif (mb_strlen($data['appointment_code']) > 50) {
            $errors['appointment_code'] = 'Appointment code must not exceed 50 characters.';
        }

        if ($data['patient_name'] === '') {
            $errors['patient_name'] = 'Patient name is required.';
        } elseif (mb_strlen($data['patient_name']) > 100) {
            $errors['patient_name'] = 'Patient name must not exceed 100 characters.';
        }

        if ($data['patient_email'] !== '' && !filter_var($data['patient_email'], FILTER_VALIDATE_EMAIL)) {
            $errors['patient_email'] = 'Patient email format is invalid.';
        } elseif (mb_strlen($data['patient_email']) > 150) {
            $errors['patient_email'] = 'Patient email must not exceed 150 characters.';
        }

        $date = DateTimeImmutable::createFromFormat('!Y-m-d\TH:i', $data['appointment_date']);
        $dateErrors = DateTimeImmutable::getLastErrors();
        if (
            $data['appointment_date'] === ''
            || $date === false
            || ($dateErrors !== false && ($dateErrors['warning_count'] > 0 || $dateErrors['error_count'] > 0))
        ) {
            $errors['appointment_date'] = 'Appointment date is required and must be valid.';
        }

        if ($data['department'] === '') {
            $errors['department'] = 'Department is required.';
        } elseif (mb_strlen($data['department']) > 100) {
            $errors['department'] = 'Department must not exceed 100 characters.';
        }

        if (!in_array($data['status'], ['scheduled', 'confirmed', 'completed', 'cancelled'], true)) {
            $errors['status'] = 'Status is invalid.';
        }

        if (mb_strlen($data['note']) > 65535) {
            $errors['note'] = 'Note is too long.';
        }

        return $errors;
    }
}
