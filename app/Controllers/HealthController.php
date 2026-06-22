<?php

class HealthController
{
    public function index(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            $config = require __DIR__ . '/../../config/database.php';
            $pdo = (new Database($config))->getConnection();
            $repository = new HealthRepository($pdo);

            if (!$repository->databaseIsAvailable()) {
                throw new RuntimeException('Database health check returned an unexpected result.');
            }

            echo json_encode([
                'status' => 'ok',
                'database' => 'connected',
                'app' => 'clinic_appointment_lab05',
                'time' => date('Y-m-d H:i:s'),
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } catch (Throwable $e) {
            log_error($e);
            http_response_code(500);

            echo json_encode([
                'status' => 'error',
                'database' => 'disconnected',
                'app' => 'clinic_appointment_lab05',
                'message' => 'Database connection failed.',
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    }
}
