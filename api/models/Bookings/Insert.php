<?php

namespace public\api\models\bookings;

use public\DB\Database;
use PDO;

class Insert
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    public function insert(array $data): bool
    {
        $expiredAt = date('Y-m-d H:i:s', strtotime('+20 minutes'));

        $stmt = $this->pdo->prepare("
            INSERT INTO bookings (
                professional_id,
                appointment_date,
                appointment_time,
                appointment_end,
                service_id,
                service_duration,
                service_name,
                service_vat,
                service_price,
                service_advance_payment,
                expired_at
            ) VALUES (
                :professional_id,
                :appointment_date,
                :appointment_time,
                :appointment_end,
                :service_id,
                :service_duration,
                :service_name,
                :service_vat,
                :service_price,
                :service_advance_payment,
                :expired_at
            )
        ");

        return $stmt->execute([
            'professional_id' => $data['professional_id'],
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
            'appointment_end' => $data['appointment_end'],
            'service_id' => $data['service_id'],
            'service_duration' => $data['service_duration'],
            'service_name' => $data['service_name'],
            'service_vat' => $data['service_vat'],
            'service_price' => $data['service_price'],
            'service_advance_payment' => $data['service_advance_payment'],
            'expired_at' => $expiredAt
        ]);
    }
}