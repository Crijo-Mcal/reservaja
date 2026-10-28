<?php

namespace public\api\models\appointments;

use public\DB\Database;
use PDO;

class Select
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    // funtion for webhook
    public function selectAppointmentNotificationDataByBookingId(int $booking_id): ?array
    {
        $sql = "
            SELECT
                id AS appointment_id,
                booking_id,
                status AS appointment_status,
                created_at AS appointment_created_at,
                updated_at AS appointment_updated_at,
                client_name,
                client_email,
                client_mobile,
                client_tax_number,
                appointment_date,
                appointment_time,
                appointment_end,
                service_id,
                service_name,
                service_duration,
                professional_id
            FROM appointments
            WHERE booking_id = :booking_id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'booking_id' => $booking_id
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    // funtion for client
    public function selectAppointmentSchedule(int $professional_id): array
    {
        $sql = "
        SELECT
            appointment_date,
            appointment_time,
            appointment_end,
            service_duration
        FROM appointments
        WHERE professional_id = :professional_id
        ORDER BY appointment_date ASC, appointment_time ASC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'professional_id' => $professional_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectClientHistory(string $client_email): array
    {
        $sql = "
        SELECT
            a.id AS appointment_id,
            a.appointment_date,
            a.appointment_time,
            a.service_duration,
            a.service_name,
            a.professional_id,
            p.name AS professional_name
        FROM appointments a
        INNER JOIN professionals p
            ON p.id = a.professional_id
        WHERE a.client_email = :client_email
        ORDER BY a.appointment_date DESC, a.appointment_time DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'client_email' => $client_email
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // funtion for company

    public function selectTodayAppointment(int $professional_id): array
    {
        $sql = "
            SELECT
                id AS appointment_id,
                booking_id,
                status AS appointment_status,
                created_at AS appointment_created_at,
                updated_at AS appointment_updated_at,
                client_id,
                client_name,
                client_email,
                client_mobile,
                client_tax_number,
                appointment_date,
                appointment_time,
                appointment_end,
                service_id,
                service_duration,
                service_name,
                professional_id
            FROM appointments
            WHERE professional_id = :professional_id
            AND appointment_date = CURRENT_DATE
            ORDER BY appointment_time ASC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'professional_id' => $professional_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectAppointmentByDate(string $date): array
    {
        $sql = "
            SELECT
                id AS appointment_id,
                booking_id,
                status AS appointment_status,
                created_at AS appointment_created_at,
                updated_at AS appointment_updated_at,
                client_id,
                client_name,
                client_email,
                client_mobile,
                client_tax_number,
                appointment_date,
                appointment_time,
                appointment_end,
                service_id,
                service_duration,
                service_name,
                professional_id
            FROM appointments
            WHERE appointment_date = :date
            ORDER BY appointment_time ASC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'date' => date('Y-m-d', strtotime($date))
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectAppointmentById(int $appointmentId): array
    {
        $sql = "
            SELECT
                id AS appointment_id,
                booking_id,
                status AS appointment_status,
                created_at AS appointment_created_at,
                updated_at AS appointment_updated_at,
                client_id,
                client_name,
                client_email,
                client_mobile,
                client_tax_number,
                appointment_date,
                appointment_time,
                appointment_end,
                service_id,
                service_duration,
                service_name,
                professional_id
            FROM appointments
            WHERE id = :appointment_id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'appointment_id' => $appointmentId
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectAppointmentByDateAndId(string $date, int $appointment_id): array
    {
        $sql = "
            SELECT
                id AS appointment_id,
                booking_id,
                status AS appointment_status,
                created_at AS appointment_created_at,
                updated_at AS appointment_updated_at,
                client_id,
                client_name,
                client_email,
                client_mobile,
                client_tax_number,
                appointment_date,
                appointment_time,
                appointment_end,
                service_id,
                service_duration,
                service_name,
                professional_id
            FROM appointments
            WHERE appointment_date = :date
            AND id = :appointment_id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'date' => date('Y-m-d', strtotime($date)),
            'appointment_id' => $appointment_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectappointmentDates(int $professional_id): array
    {
        $sql = "
            SELECT DISTINCT appointment_date
            FROM appointments
            WHERE professional_id = :professional_id
            AND appointment_date > CURRENT_DATE
            ORDER BY appointment_date ASC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'professional_id' => $professional_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function selectTopServicesByProfessional(int $professional_id): array
    {
        $sql = "
            SELECT
                service_name,
                COUNT(id) AS total_bookings
            FROM appointments
            WHERE professional_id = :professional_id
            GROUP BY service_name
            ORDER BY total_bookings DESC
            LIMIT 5
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'professional_id' => $professional_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectNewClientsThisMonth(int $professional_id): array
    {
        $sql = "
            SELECT
                a.client_name,
                a.client_email,
                a.service_name,
                a.created_at AS booking_date
            FROM appointments a
            WHERE a.professional_id = :professional_id
              AND a.client_email IS NOT NULL
              AND a.client_email != ''
              AND a.appointment_date >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
              AND a.appointment_date < DATE_ADD(
                  DATE_FORMAT(CURDATE(), '%Y-%m-01'),
                  INTERVAL 1 MONTH
              )
              AND NOT EXISTS (
                  SELECT 1
                  FROM appointments previous
                  WHERE previous.professional_id = a.professional_id
                    AND previous.client_email = a.client_email
                    AND previous.appointment_date < DATE_FORMAT(CURDATE(), '%Y-%m-01')
              )
              AND a.id = (
                  SELECT MAX(latest.id)
                  FROM appointments latest
                  WHERE latest.professional_id = a.professional_id
                    AND latest.client_email = a.client_email
                    AND latest.appointment_date >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
                    AND latest.appointment_date < DATE_ADD(
                        DATE_FORMAT(CURDATE(), '%Y-%m-01'),
                        INTERVAL 1 MONTH
                    )
              )
            ORDER BY a.created_at DESC
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'professional_id' => $professional_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function selectClientsByProfessional(int $professional_id): array
    {
        $sql = "
        SELECT
            client_name,
            client_email,
            client_mobile,
            MAX(appointment_date) AS last_appointment,
            COUNT(id) AS total_appointments
        FROM appointments
        WHERE professional_id = :professional_id
          AND client_email IS NOT NULL
          AND client_email != ''
        GROUP BY
            client_email,
            client_name,
            client_mobile
        ORDER BY last_appointment DESC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'professional_id' => $professional_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectClientByData(array $data): array
    {
        $sql = "
        SELECT
            client_name,
            client_email,
            client_mobile,
            MAX(appointment_date) AS last_appointment,
            COUNT(id) AS total_appointments
        FROM appointments
        WHERE professional_id = :professional_id
          AND client_name LIKE :clientName
          AND client_tax_number IS NOT NULL
          AND client_tax_number != ''
        GROUP BY
            client_tax_number,
            client_name,
            client_email,
            client_mobile
        ORDER BY last_appointment DESC
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'professional_id' => $data['professional_id'],
            'clientName' => '%' . $data['client_name'] . '%'
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
