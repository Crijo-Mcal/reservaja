<?php

namespace public\api\models;

use public\DB\Database;
use PDO;

class Ratings
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    //insert
    public function insert(int $appointment_id, int $booking_id): bool
    {
        $stmt = $this->pdo->prepare("
        INSERT INTO ratings (
            appointments_id,
            client_id,
            professional_id,
            professional_name,
            professional_speciality,
            service_name
        )
        SELECT
            a.id,
            b.client_id,
            p.id,
            p.name,
            p.speciality,
            b.service_name
        FROM appointments a
        INNER JOIN bookings b
            ON b.id = a.booking_id
        INNER JOIN professionals p
            ON p.id = b.professional_id
        WHERE a.id = :appointment_id
        AND b.id = :booking_id
        LIMIT 1
        ");

        $stmt->execute([
            ':appointment_id' => $appointment_id,
            ':booking_id' => $booking_id
        ]);

        return $stmt->rowCount() > 0;
    }

    //select
    public function getByClientId(int $client_id): array
    {
        $stmt = $this->pdo->prepare("
        SELECT
            id,
            appointments_id,
            client_id,
            professional_id,
            professional_name,
            professional_speciality,
            service_name,
            rating,
            description,
            delay_at
        FROM ratings
        WHERE client_id = :client_id
        AND status = 'hidden'
        AND delay_at < NOW()
        ORDER BY delay_at DESC
       ");

        $stmt->execute([
            ':client_id' => $client_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Select avaliações por profissional
    public function getByProfessionalId(int $professional_id): array
    {
        $stmt = $this->pdo->prepare("
        SELECT
            r.*,
            c.name AS client_name,
            stats.average_rating,
            stats.total_rating
        FROM ratings r
        INNER JOIN clients c
            ON c.id = r.client_id
        CROSS JOIN (
            SELECT
                AVG(rating) AS average_rating,
                COUNT(rating) AS total_rating
            FROM ratings
            WHERE professional_id = :professional_id
            AND status = 'complete'
        ) stats
        WHERE r.professional_id = :professional_id
        AND r.status = 'complete'
        ORDER BY r.id DESC
      ");

        $stmt->execute([
            'professional_id' => $professional_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->prepare("
        SELECT
            r.*,
            c.name AS client_name,
            stats.average_rating,
            stats.total_rating
        FROM ratings r
        INNER JOIN clients c ON c.id = r.client_id
        CROSS JOIN (
            SELECT
                AVG(rating) AS average_rating,
                COUNT(rating) AS total_rating
            FROM ratings
            WHERE status = 'complete'
        ) stats
        WHERE r.status = 'complete'
        ORDER BY r.id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Count
    public function getAverageRatingAndCount(int $professional_id): array
    {
        $stmt = $this->pdo->prepare("
        SELECT
            AVG(rating) AS average_rating,
            COUNT(rating) AS total_rating
        FROM ratings
        WHERE professional_id = :professional_id
        AND status = 'complete'
      ");

        $stmt->execute([
            ':professional_id' => $professional_id
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'average' => $result['average_rating'] !== null
                ? round((float) $result['average_rating'], 1)
                : 0,
            'total' => (int) $result['total_rating']
        ];
    }

    //update
    public function updateRating(array $data): bool
    {
        $stmt = $this->pdo->prepare("
        UPDATE ratings
        SET
            rating = :rating,
            description = :description,
            status = 'complete'
        WHERE client_id = :client_id
        AND appointments_id = :appointment_id
        ");

        return $stmt->execute([
            ':client_id' => $data['client_id'],
            ':appointment_id' => $data['appointment_id'],
            ':rating' => $data['rating'],
            ':description' => $data['description']
        ]);
    }

    public function delete(array $data): bool
    {
        $stmt = $this->pdo->prepare("
        UPDATE ratings
        SET status = 'delete'
        WHERE id = :id
       ");

        return $stmt->execute(['id' => $data['rating_id']]);
    }

    //validation
    public function isRatingExist(int $appointment_id): bool
    {
        $stmt = $this->pdo->prepare("
        SELECT COUNT(*)
        FROM ratings
        WHERE appointments_id = :appointment_id
        ");

        $stmt->execute([
            ':appointment_id' => $appointment_id
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }
}
