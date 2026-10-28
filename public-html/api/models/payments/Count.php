<?php

namespace public\api\models\payments;

use public\DB\Database;
use PDO;

class Count
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    public function countTotalPaymentThisMonth(): int
    {
        $sql = "
            SELECT COUNT(id)
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

        return (int) $stmt->fetchColumn();
    }

    public function countTotalPendingPaymentThisMonth(): int
    {
        $sql = "
            SELECT COUNT(id)
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

        return (int) $stmt->fetchColumn();
    }

    public function countTotalRefundedPaymentThisMonth(): int
    {
        $sql = "
            SELECT COUNT(id)
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

        return (int) $stmt->fetchColumn();
    }
}