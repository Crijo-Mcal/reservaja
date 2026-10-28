<?php

namespace public\api\models;

use public\DB\Database;


use PDO;


class Schedule
{
    private PDO $pdo;


    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    // insert
    public function insert(
        string $professional_id,
        array $datas
    ): bool {

        $stmt = $this->pdo->prepare("
        INSERT INTO schedules (
            professional_id,
            date,
            start_time,
            end_time,
            start_lunch,
            end_lunch
        ) VALUES (
            :professional_id,
            :date,
            :start_time,
            :end_time,
            :start_lunch,
            :end_lunch
        )
        ");

        foreach ($datas  as  $data) {

            $result = $stmt->execute([
                'professional_id' => $professional_id,
                'date'            => $data['date'],
                'start_time'      => $data['start_time'] ?? null,
                'end_time'        => $data['end_time'] ?? null,
                'start_lunch'     => $data['start_lunch'] ?? null,
                'end_lunch'       => $data['end_lunch'] ?? null
            ]);

            if (!$result) {
                return false;
            }
        }

        return true;
    }

    // select
    public function selectAllDataByID(
        string $professional_id
    ): ?array {
        $stmt = $this->pdo->prepare("
        SELECT *
        FROM schedules
        WHERE professional_id = :professional_id
        AND date >= CURDATE()
        ORDER BY date ASC
        ");

        $stmt->execute([
            'professional_id' => $professional_id
        ]);

        $schedule = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $schedule ?: null;
    }

    //update
    public function update(
        int $professional_id,
        array $data
    ): bool {

        $stmt = $this->pdo->prepare("
        UPDATE schedules
        SET
            date = :date,
            start_time = :start_time,
            end_time = :end_time,
            start_lunch = :start_lunch,
            end_lunch = :end_lunch
        WHERE
            id = :id
            AND professional_id = :professional_id
        ");

        return $stmt->execute([
            'id'              => $data['id'],
            'professional_id' => $professional_id,
            'date'            => $data['date'],
            'start_time'      => $data['start_time'],
            'end_time'        => $data['end_time'],
            'start_lunch'     => $data['start_lunch'],
            'end_lunch'       => $data['end_lunch']
        ]);
    }

    //delete
    public function delete(
        int $professional_id,
        int $id
    ): bool {
        $stmt = $this->pdo->prepare("
        DELETE FROM schedules
        WHERE
            id = :id
            AND professional_id = :professional_id
        ");

        return $stmt->execute([
            'id'              => $id,
            'professional_id' => $professional_id
        ]);
    }

    //validation
    public function isDateExist(
        int $professional_id,
        string $date,
        int $schedule_id
    ): bool {

        $stmt = $this->pdo->prepare("
        SELECT id
        FROM schedules
        WHERE
            professional_id = :professional_id
            AND date = :date
            AND id != :schedule_id
        LIMIT 1
        ");

        $stmt->execute([
            'professional_id' => $professional_id,
            'date'            => $date,
            'schedule_id'     => $schedule_id
        ]);

        return $stmt->fetch() !== false;
    }

    public function cheackDateByDate(
        int $professional_id,
        string $date,
    ): bool {

        $stmt = $this->pdo->prepare("
        SELECT id
        FROM schedules
        WHERE
            professional_id = :professional_id
            AND date = :date
        LIMIT 1
        ");

        $stmt->execute([
            'professional_id' => $professional_id,
            'date'            => $date,
        ]);

        return $stmt->fetch() !== false;
    }

    public function checkScheduleBooked(
        int $professional_id,
        int $schedule_id
    ): bool {
        $stmt = $this->pdo->prepare("
        SELECT COUNT(*)
        FROM schedules
        INNER JOIN bookings
            ON schedules.professional_id = bookings.professional_id
            AND schedules.date = bookings.appointment_date
        WHERE schedules.id = :schedule_id
        AND schedules.professional_id = :professional_id
        AND bookings.status = 'confirmed'
        ");

        $stmt->execute([
            'professional_id' => $professional_id,
            'schedule_id' => $schedule_id
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }
}
