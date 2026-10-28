<?php

namespace public\api\models\payments;

use public\DB\Database;
use PDO;

class Update
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }


    public function updateAsPaid(array $data): void
    {
        $sql = "
        UPDATE payments
        SET
            payment_method = :payment_method,
            stripe_payment_intent_id = :booking_id,
            paid_at = :paid_at,
            status = 'paid'
        WHERE booking_id = :booking_id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'booking_id' => $data['booking_id'],
            'payment_method' => $data['payment_method'],
            'paid_at' => $data['payment_datetime'],
        ]);
    }

    public function updatePaymentFromIfthepay(array $data): void
    {
        $sql = "
        UPDATE payments
        SET
            expired_payment = :expired_payment,
            pinpay_number = :pinpay_number,
            redirect_url = :redirect_url
        WHERE id = :payment_id
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'payment_id'      => $data['payment_id'],
            'expired_payment' => $data['expired_payment'],
            'pinpay_number'   => $data['pinpay_number'],
            'redirect_url'    => $data['redirect_url'],
        ]);
    }

    public function updateAllExpiredPayments(): bool
    {
        $stmt = $this->pdo->prepare("
        UPDATE payments
        SET status = 'failed'
        WHERE status = 'pending'
          AND expired_payment IS NOT NULL
          AND expired_payment < CURRENT_TIMESTAMP
        ");

        if (!$stmt->execute()) {
            return false;
        }

        $stmt = $this->pdo->prepare("
        UPDATE bookings b
        INNER JOIN payments p ON p.booking_id = b.id
        SET b.status = 'cancelled'
        WHERE p.status = 'failed'
          AND p.expired_payment IS NOT NULL
          AND p.expired_payment < CURRENT_TIMESTAMP
          AND b.status = 'pending'
        ");

        return $stmt->execute();
    }

    public function cancelPayment(int $bookingId): void
    {
        $this->pdo->beginTransaction();

        $stmt = $this->pdo->prepare("
        UPDATE payments
        SET status = 'failed'
        WHERE booking_id = :booking_id
        ");

        $stmt->execute([
            'booking_id' => $bookingId,
        ]);

        $stmt = $this->pdo->prepare("
        UPDATE bookings
        SET status = 'cancelled'
        WHERE id = :booking_id
        ");

        $stmt->execute([
            'booking_id' => $bookingId,
        ]);

        $this->pdo->commit();
    }
}
