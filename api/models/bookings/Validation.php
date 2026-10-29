<?php

namespace public\api\models\bookings;

use public\DB\Database;
use PDO;

class Validation
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }


    public function isBookingConflict(array $data): bool
    {
        $stmt = $this->pdo->prepare("
        SELECT COUNT(*)
        FROM bookings
        WHERE professional_id = :professional_id
        AND appointment_date = :appointment_date
        AND status IN ('pending', 'confirmed')
        AND appointment_time < :appointment_end
        AND appointment_end > :appointment_time
        ");

        $stmt->execute([
            'professional_id' => $data['professional_id'],
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
            'appointment_end' => $data['appointment_end']
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function isBookingValidForPayment(int $booking_id): bool
    {
        $stmt = $this->pdo->prepare("
        SELECT COUNT(*)
        FROM bookings
        WHERE id = :booking_id
        AND status = 'pending'
        AND expired_at > NOW()
        ");

        $stmt->execute([
            'booking_id' => $booking_id
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }

}
