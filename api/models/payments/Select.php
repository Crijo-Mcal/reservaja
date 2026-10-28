<?php

namespace public\api\models\payments;

use public\DB\Database;
use PDO;

class Select
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    public function selectAllPayments(): array
    {
        $sql = "
            SELECT
                p.id AS payment_id,
                p.booking_id,
                p.payment_method,
                p.payment_type,
                p.amount,
                p.status,
                p.paid_at,
                a.id AS appointment_id,
                a.client_id,
                a.client_name,
                a.client_email,
                a.client_mobile,
                a.service_id,
                a.service_name,
                a.professional_id,
                a.appointment_date,
                a.appointment_time,
                a.appointment_end
            FROM payments p
            INNER JOIN appointments a
                ON a.booking_id = p.booking_id
            ORDER BY p.created_at DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectAllPaymentsThisMonth(): array
    {
        $sql = "
            SELECT
                p.id AS payment_id,
                p.booking_id,
                p.payment_method,
                p.payment_type,
                p.amount,
                p.status,
                p.paid_at,
                a.id AS appointment_id,
                a.client_id,
                a.client_name,
                a.client_email,
                a.client_mobile,
                a.service_id,
                a.service_name,
                a.professional_id,
                a.appointment_date,
                a.appointment_time,
                a.appointment_end
            FROM payments p
            INNER JOIN appointments a
                ON a.booking_id = p.booking_id
            WHERE p.created_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
              AND p.created_at < DATE_ADD(
                  DATE_FORMAT(CURDATE(), '%Y-%m-01'),
                  INTERVAL 1 MONTH
              )
            ORDER BY p.created_at DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectAllAvailableMonths(): array
    {
        $sql = "
            SELECT DISTINCT
                YEAR(created_at) AS year,
                MONTH(created_at) AS month
            FROM payments
            ORDER BY year DESC, month DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectAllPaymentsByMonth(array $data): array
    {
        $sql = "
            SELECT
                p.id AS payment_id,
                p.booking_id,
                p.payment_method,
                p.payment_type,
                p.amount,
                p.status,
                p.paid_at,
                a.id AS appointment_id,
                a.client_id,
                a.client_name,
                a.client_email,
                a.client_mobile,
                a.service_id,
                a.service_name,
                a.professional_id,
                a.appointment_date,
                a.appointment_time,
                a.appointment_end
            FROM payments p
            INNER JOIN appointments a
                ON a.booking_id = p.booking_id
            WHERE DATE_FORMAT(p.created_at, '%Y-%m') = :month
            ORDER BY p.created_at DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'month' => $data['month']
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectLastPaymentId(): ?int
    {
        $stmt = $this->pdo->query("
            SELECT id
            FROM payments
            ORDER BY id DESC
            LIMIT 1
        ");

        $id = $stmt->fetchColumn();

        return $id !== false ? (int) $id : null;
    }



    public function selectPendingPaymentsByClientId(int $clientId): array
    {
        $sql = "
        SELECT
            b.id AS booking_id,
            b.client_id,
            b.service_price,
            b.service_name,

            p.id AS payment_id,
            p.amount,
            p.redirect_url,
            p.status,
            p.expired_payment,
            p.created_at

        FROM bookings b

        INNER JOIN payments p
            ON p.booking_id = b.id

        WHERE b.client_id = :client_id
          AND p.status = 'pending'
          AND p.expired_payment > NOW()

        ORDER BY p.created_at DESC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            ':client_id' => $clientId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
