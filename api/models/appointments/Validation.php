<?php

namespace public\api\models\appointments;

use public\DB\Database;
use PDO;

class Validation
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    public function isAppointmentConflict(array $data): bool
    {
        $stmt = $this->pdo->prepare("
        SELECT COUNT(*)
        FROM appointments
        WHERE professional_id = :professional_id
        AND appointment_date = :appointment_date
        AND appointment_time < :appointment_end
        AND appointment_end > :appointment_time
        AND id != :appointment_id
        AND status = 'scheduled'
      ");

        $stmt->execute([
            'professional_id' => $data['professional_id'],
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
            'appointment_end' => $data['appointment_end'],
            'appointment_id' => $data['appointment_id']
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function isClientIdExist(int $appointment_id): bool
    {
        $stmt = $this->pdo->prepare("
        SELECT client_id
        FROM appointments
        WHERE id = :appointment_id
        LIMIT 1
        ");

        $stmt->execute([
            'appointment_id' => $appointment_id
        ]);

        $client_id = $stmt->fetchColumn();

        return $client_id !== false && $client_id !== null;
    }
}
