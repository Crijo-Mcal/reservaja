<?php

namespace public\api\models\bookings;

use public\DB\Database;
use PDO;

class Update
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    public function updateAllExpiredBookings(): bool
    {
        $stmt = $this->pdo->prepare("
        UPDATE bookings
        SET status = 'cancelled'
        WHERE status = 'pending'
        AND expired_at < CURRENT_TIMESTAMP
        ");

        return $stmt->execute();
    }

    public function UpdateBookingCancel(int $booking_id): bool
    {
        $stmt = $this->pdo->prepare("
        UPDATE bookings
        SET status = 'cancelled'
        WHERE id = :booking_id
        AND status = 'pending'
        ");

        return $stmt->execute([
            'booking_id' => $booking_id
        ]);
    }

    public function UpdateBookingConfirm(string $booking_id): bool
    {
        $stmt = $this->pdo->prepare("
        UPDATE bookings
        SET status = 'confirmed'
        WHERE id = :booking_id
        ");

        $stmt->execute([
            'booking_id' => $booking_id
        ]);

        return $stmt->rowCount() > 0;
    }

    public function UpdateBookingClient(array $data): bool
    { 
        $stmt = $this->pdo->prepare("
        UPDATE bookings
        SET
            client_id = :client_id,
            client_name = :client_name,
            client_email = :client_email,
            client_mobile = :client_mobile,
            client_tax_number = :client_tax_number,
            status = 'confirmed'
        WHERE id = :booking_id
        ");

        $stmt->execute([
            'booking_id' => $data['booking_id'],
            'client_id'=>$data['client_id'],
            'client_name' => $data['client_name'],
            'client_email' => $data['client_email'],
            'client_mobile' => $data['client_mobile'],
            'client_tax_number' => $data['client_tax_number']
        ]);

        return $stmt->rowCount() > 0;
    }

    
}
