<?php

namespace public\api\models\appointments;

use public\DB\Database;
use PDO;

class Update
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    public function updateAppointment(array $data): bool
    {
        $sql = "
            UPDATE appointments
            SET
                appointment_date = :appointment_date,
                appointment_time = :appointment_time,
                service_duration = :service_duration,
                appointment_end = :appointment_end,
                status = :status,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = :appointment_id
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
            'service_duration' => $data['service_duration'],
            'appointment_end' => $data['appointment_end'],
            'status' => $data['appointment_status'],
            'appointment_id' => $data['appointment_id']
        ]);
    }
}