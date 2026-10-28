<?php

namespace public\api\models\appointments;

use public\DB\Database;
use PDO;

class Count
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    public function countTodayAppointment(int $professional_id): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM appointments
            WHERE professional_id = :professional_id
            AND status = 'scheduled'
            AND appointment_date = CURRENT_DATE
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'professional_id' => $professional_id
        ]);

        return (int) $stmt->fetchColumn();
    }

    public function countScheduledAppointment(int $professional_id): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM appointments
            WHERE professional_id = :professional_id
            AND status = 'scheduled'
            AND appointment_date >= CURRENT_DATE
            AND MONTH(appointment_date) = MONTH(CURRENT_DATE)
            AND YEAR(appointment_date) = YEAR(CURRENT_DATE)
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'professional_id' => $professional_id
        ]);

        return (int) $stmt->fetchColumn();
    }

    public function countCompletedAppointment(int $professional_id): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM appointments
            WHERE professional_id = :professional_id
            AND status = 'completed'
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'professional_id' => $professional_id
        ]);

        return (int) $stmt->fetchColumn();
    }

    public function countAllAppointment(int $professional_id): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM appointments
            WHERE professional_id = :professional_id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'professional_id' => $professional_id
        ]);

        return (int) $stmt->fetchColumn();
    }

    public function countNewClientsThisMonth(int $professional_id): int
    {
        $sql = "
            SELECT COUNT(DISTINCT current.client_email)
            FROM appointments AS current
            WHERE current.professional_id = :professional_id
              AND current.client_email IS NOT NULL
              AND current.client_email != ''
              AND current.appointment_date >= DATE_FORMAT(CURRENT_DATE, '%Y-%m-01')
              AND current.appointment_date < DATE_ADD(
                  DATE_FORMAT(CURRENT_DATE, '%Y-%m-01'),
                  INTERVAL 1 MONTH
              )
              AND NOT EXISTS (
                  SELECT 1
                  FROM appointments AS previous
                  WHERE previous.professional_id = current.professional_id
                    AND previous.client_email = current.client_email
                    AND previous.appointment_date < DATE_FORMAT(
                        CURRENT_DATE,
                        '%Y-%m-01'
                    )
              )
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'professional_id' => $professional_id
        ]);

        return (int) $stmt->fetchColumn();
    }

    public function countClientsByProfessional(int $professional_id): int
    {
        $sql = "
            SELECT COUNT(DISTINCT client_email)
            FROM appointments
            WHERE professional_id = :professional_id
              AND client_email IS NOT NULL
              AND client_email != ''
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'professional_id' => $professional_id
        ]);

        return (int) $stmt->fetchColumn();
    }

    public function countActiveClients(int $professional_id): int
    {
        $sql = "
            SELECT COUNT(*)
            FROM (
                SELECT client_email
                FROM appointments
                WHERE professional_id = :professional_id
                  AND client_email IS NOT NULL
                  AND client_email != ''
                  AND appointment_date >= DATE_FORMAT(
                      CURRENT_DATE,
                      '%Y-%m-01'
                  )
                  AND appointment_date < DATE_ADD(
                      DATE_FORMAT(CURRENT_DATE, '%Y-%m-01'),
                      INTERVAL 1 MONTH
                  )
                GROUP BY client_email
                HAVING COUNT(id) >= 3
            ) AS active_clients
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'professional_id' => $professional_id
        ]);

        return (int) $stmt->fetchColumn();
    }
}