<?php

namespace public\api\models\payments;

use public\DB\Database;
use PDO;

class Sum
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    public function sumTotalPayment(): float
    {
        $sql = "
            SELECT COALESCE(SUM(amount), 0)
            FROM payments
            WHERE status = 'paid'
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return (float) $stmt->fetchColumn();
    }

    public function sumTotalPaymentThisMonth(): float
    {
        $sql = "
            SELECT COALESCE(SUM(amount), 0)
            FROM payments
            WHERE status = 'paid'
              AND paid_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
              AND paid_at < DATE_ADD(
                  DATE_FORMAT(CURDATE(), '%Y-%m-01'),
                  INTERVAL 1 MONTH
              )
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return (float) $stmt->fetchColumn();
    }

    public function sumTotalPendingPaymentThisMonth(): float
    {
        $sql = "
            SELECT COALESCE(SUM(amount), 0)
            FROM payments
            WHERE status = 'pending'
              AND created_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
              AND created_at < DATE_ADD(
                  DATE_FORMAT(CURDATE(), '%Y-%m-01'),
                  INTERVAL 1 MONTH
              )
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return (float) $stmt->fetchColumn();
    }

    public function sumTotalRefundedPaymentThisMonth(): float
    {
        $sql = "
            SELECT COALESCE(SUM(amount), 0)
            FROM payments
            WHERE status = 'refunded'
              AND created_at >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
              AND created_at < DATE_ADD(
                  DATE_FORMAT(CURDATE(), '%Y-%m-01'),
                  INTERVAL 1 MONTH
              )
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return (float) $stmt->fetchColumn();
    }

    public function sumTotalPaymentPerMonth(): array
    {
        $sql = "
            SELECT
                MONTH(paid_at) AS month,
                COALESCE(SUM(amount), 0) AS total
            FROM payments
            WHERE status = 'paid'
              AND YEAR(paid_at) = YEAR(CURDATE())
            GROUP BY MONTH(paid_at)
            ORDER BY MONTH(paid_at)
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $months = [
            1 => 'janeiro',
            2 => 'fevereiro',
            3 => 'março',
            4 => 'abril',
            5 => 'maio',
            6 => 'junho',
            7 => 'julho',
            8 => 'agosto',
            9 => 'setembro',
            10 => 'outubro',
            11 => 'novembro',
            12 => 'dezembro',
        ];

        $result = array_fill_keys(array_values($months), 0);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $month = (int) $row['month'];
            $result[$months[$month]] = (float) $row['total'];
        }

        return $result;
    }
}
