<?php

class PatientController
{
    private const ALLOWED_SORTS = ['id', 'name', 'email', 'phone', 'gender', 'status', 'created_at'];
    private const ALLOWED_DIRECTIONS = ['asc', 'desc'];

    private function repository(): PatientRepository
    {
        $config = require __DIR__ . '/../../config/database.php';
        $pdo = (new Database($config))->getConnection();

        return new PatientRepository($pdo);
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
            $patients = $repo->getPaginated($q, $perPage, $offset, $sort, $direction);

            render('patients/index', [
                'patients' => $patients,
                'q' => $q,
                'page' => $page,
                'perPage' => $perPage,
                'total' => $total,
                'totalPages' => $totalPages,
                'sort' => $sort,
                'direction' => $direction,
            ], 'Patient Management');
        } catch (Throwable $e) {
            log_error($e);
            http_response_code(500);
            render('errors/500', [
                'message' => 'Sorry, we could not load patients right now.',
            ], 'Something went wrong');
        }
    }

    public function create(array $data = [], array $errors = []): void
    {
        $data = array_merge([
            'name' => '',
            'email' => '',
            'phone' => '',
            'gender' => 'other',
            'status' => 'active',
            'note' => '',
        ], $data);

        render('patients/create', [
            'data' => $data,
            'errors' => $errors,
        ], 'Create Patient');
    }

    public function store(): void
    {
        $data = $this->patientDataFromRequest();
        $errors = $this->validatePatient($data);

        if ($errors !== []) {
            $this->create($data, $errors);
            return;
        }

        try {
            $this->repository()->create($data);
            flash_set('success', 'Patient created successfully.');
            redirect('/patients');
        } catch (DuplicateRecordException $e) {
            $errors['email'] = 'Email bệnh nhân này đã tồn tại. Vui lòng dùng email khác.';
            $this->create($data, $errors);
        } catch (Throwable $e) {
            log_error($e);
            http_response_code(500);
            render('errors/500', [
                'message' => 'Sorry, we could not create this patient right now.',
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
            $patient = $this->repository()->findById($id);

            if (!$patient) {
                http_response_code(404);
                render('errors/404', [], '404 Not Found');
                return;
            }

            render('patients/edit', [
                'data' => $patient,
                'errors' => [],
            ], 'Edit Patient');
        } catch (Throwable $e) {
            log_error($e);
            http_response_code(500);
            render('errors/500', [
                'message' => 'Sorry, we could not load this patient right now.',
            ], 'Something went wrong');
        }
    }

    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $data = $this->patientDataFromRequest();
        $errors = $this->validatePatient($data);

        if ($id <= 0) {
            http_response_code(404);
            render('errors/404', [], '404 Not Found');
            return;
        }

        if ($errors !== []) {
            $data['id'] = $id;
            render('patients/edit', [
                'data' => $data,
                'errors' => $errors,
            ], 'Edit Patient');
            return;
        }

        try {
            $repository = $this->repository();
            if ($repository->findById($id) === null) {
                http_response_code(404);
                render('errors/404', [], '404 Not Found');
                return;
            }

            $repository->update($id, $data);
            flash_set('success', 'Patient updated successfully.');
            redirect('/patients');
        } catch (DuplicateRecordException $e) {
            $data['id'] = $id;
            $errors['email'] = 'Email bệnh nhân này đã thuộc về bệnh nhân khác.';
            render('patients/edit', [
                'data' => $data,
                'errors' => $errors,
            ], 'Edit Patient');
        } catch (Throwable $e) {
            log_error($e);
            http_response_code(500);
            render('errors/500', [
                'message' => 'Sorry, we could not update this patient right now.',
            ], 'Something went wrong');
        }
    }

    public function delete(): void
    {
        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0) {
            flash_set('error', 'Invalid patient id.');
            redirect('/patients');
        }

        try {
            $deleted = $this->repository()->delete($id);
            flash_set(
                $deleted ? 'success' : 'error',
                $deleted ? 'Patient deleted successfully.' : 'Patient was not found.'
            );
            redirect('/patients');
        } catch (Throwable $e) {
            log_error($e);
            flash_set('error', 'Could not delete patient right now.');
            redirect('/patients');
        }
    }

    private function patientDataFromRequest(): array
    {
        return [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'gender' => trim($_POST['gender'] ?? 'other'),
            'status' => trim($_POST['status'] ?? 'active'),
            'note' => trim($_POST['note'] ?? ''),
        ];
    }

    private function validatePatient(array $data): array
    {
        $errors = [];

        if ($data['name'] === '') {
            $errors['name'] = 'Patient name is required.';
        } elseif (mb_strlen($data['name']) > 100) {
            $errors['name'] = 'Patient name must not exceed 100 characters.';
        }

        if ($data['email'] === '') {
            $errors['email'] = 'Patient email is required.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Patient email format is invalid.';
        } elseif (mb_strlen($data['email']) > 150) {
            $errors['email'] = 'Patient email must not exceed 150 characters.';
        }

        if ($data['phone'] !== '' && !preg_match('/^[0-9+\-\s]{8,20}$/', $data['phone'])) {
            $errors['phone'] = 'Phone must contain 8-20 digits or symbols + - space.';
        }

        if (!in_array($data['gender'], ['male', 'female', 'other'], true)) {
            $errors['gender'] = 'Gender is invalid.';
        }

        if (!in_array($data['status'], ['active', 'inactive'], true)) {
            $errors['status'] = 'Status is invalid.';
        }

        if (mb_strlen($data['note']) > 65535) {
            $errors['note'] = 'Note is too long.';
        }

        return $errors;
    }
}
