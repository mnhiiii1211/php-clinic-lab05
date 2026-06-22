<?php
class HealthController
{
    public function index(): void
    {
        try {
            $config = require __DIR__ . '/../../config/database.php';
            $db = (new Database($config))->getConnection();
            $db->query('SELECT 1');
            json_response([
                'status' => 'ok',
                'database' => 'connected',
                'app' => 'clinic_appointment_db_app',
                'checked_at' => date('c'),
            ]);
        } catch (Throwable $e) {
            log_error($e);
            json_response([
                'status' => 'error',
                'database' => 'disconnected',
                'app' => 'clinic_appointment_db_app',
                'message' => 'Database connection failed.',
            ], 500);
        }
    }
}
