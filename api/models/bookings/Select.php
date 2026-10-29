<?php

namespace public\api\models\bookings;

use public\DB\Database;
use PDO;

class Select
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }


    public function selectBookingById(int $booking_id): ?array
    {
        $sql = "
        SELECT *
        FROM bookings
        WHERE id = :booking_id
        LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'booking_id' => $booking_id
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    public function selectLastBookingId(int $professional_id): int
    {
        $sql = "
        SELECT id
        FROM bookings
        WHERE professional_id = :professional_id
        ORDER BY id DESC
        LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'professional_id' => $professional_id
        ]);

        return (int) $stmt->fetchColumn();
    }

    // funtion for client
    public function selectBookingSchedule(int $professional_id): array
    {
        $sql = "
        SELECT
            appointment_date,
            appointment_time,
            appointment_end,
            service_duration
        FROM bookings
        WHERE professional_id = :professional_id
        AND status IN ('pending', 'confirmed')
        ORDER BY appointment_date ASC, appointment_time ASC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'professional_id' => $professional_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
