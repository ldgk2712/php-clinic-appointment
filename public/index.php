<?php

$appConfig = require __DIR__ . '/../config/app.php';
date_default_timezone_set($appConfig['timezone']);

$sessionPath = __DIR__ . '/../storage/sessions';
if (!is_dir($sessionPath)) {
    mkdir($sessionPath, 0777, true);
}
session_save_path($sessionPath);
session_start();

require __DIR__ . '/../app/Core/helpers.php';
require __DIR__ . '/../app/Core/Router.php';
require __DIR__ . '/../app/Core/Database.php';
require __DIR__ . '/../app/Core/DuplicateRecordException.php';

require __DIR__ . '/../app/Repositories/HealthRepository.php';
require __DIR__ . '/../app/Repositories/PatientRepository.php';
require __DIR__ . '/../app/Repositories/AppointmentRepository.php';

require __DIR__ . '/../app/Controllers/HomeController.php';
require __DIR__ . '/../app/Controllers/HealthController.php';
require __DIR__ . '/../app/Controllers/PatientController.php';
require __DIR__ . '/../app/Controllers/AppointmentController.php';

ini_set('display_errors', $appConfig['debug'] ? '1' : '0');
ini_set('display_startup_errors', $appConfig['debug'] ? '1' : '0');
error_reporting(E_ALL);

set_exception_handler(function (Throwable $e) use ($appConfig): void {
    log_error($e);

    if (headers_sent()) {
        return;
    }

    http_response_code(500);
    render('errors/500', [
        'message' => 'Sorry, something went wrong.',
        'debugMessage' => $appConfig['debug'] ? $e->getMessage() : null,
    ], 'Something went wrong');
});

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/health', [HealthController::class, 'index']);

$router->get('/patients', [PatientController::class, 'index']);
$router->get('/patients/create', [PatientController::class, 'create']);
$router->post('/patients/store', [PatientController::class, 'store']);
$router->get('/patients/edit', [PatientController::class, 'edit']);
$router->post('/patients/update', [PatientController::class, 'update']);
$router->post('/patients/delete', [PatientController::class, 'delete']);

$router->get('/appointments', [AppointmentController::class, 'index']);
$router->get('/appointments/create', [AppointmentController::class, 'create']);
$router->post('/appointments/store', [AppointmentController::class, 'store']);
$router->get('/appointments/edit', [AppointmentController::class, 'edit']);
$router->post('/appointments/update', [AppointmentController::class, 'update']);
$router->post('/appointments/delete', [AppointmentController::class, 'delete']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
