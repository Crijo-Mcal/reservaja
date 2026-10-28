<?php

namespace public\api\models\appointments;

use public\DB\Database;
use PDO;

class Insert
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    public function insert(int $booking_id): bool
    {
        $sql = "
        INSERT INTO appointments (
            booking_id,
            client_id,
            professional_id,
            client_name,
            client_email,
            client_mobile,
            client_tax_number,
            appointment_date,
            appointment_time,
            appointment_end,
            service_id,
            service_duration,
            service_name
        )
        SELECT
            id,
            client_id,
            professional_id,
            client_name,
            client_email,
            client_mobile,
            client_tax_number,
            appointment_date,
            appointment_time,
            appointment_end,
            service_id,
            service_duration,
            service_name
        FROM bookings
        WHERE id = :booking_id
        LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'booking_id' => $booking_id
        ]);
    }
}
