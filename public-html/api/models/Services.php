<?php

namespace public\api\models;

use public\DB\Database;

use PDO;


class Services
{
    private PDO $pdo;

    public function __construct()
    {

        $this->pdo = Database::connection();
    }

    //insert
    public function insert(
        string $professional_id,
        string $name,
        string $description,
        string $duration,
        string $price,
        string $vat,
        string $advance_payment,
        string $status
    ): bool {

        $stmt = $this->pdo->prepare("
        INSERT INTO services (
            professional_id,
            name,
            description,
            duration,
            price,
            vat,
            advance_payment,
            status
        ) VALUES (
            :professional_id,
            :name,
            :description,
            :duration,
            :price,
            :vat,
            :advance_payment,
            :status
        )
        ");

        return $stmt->execute([
            'professional_id' => $professional_id,
            'name' => $name,
            'description' => $description,
            'duration' => $duration,
            'price' => $price,
            'vat' => $vat,
            'advance_payment' => $advance_payment,
            'status' => $status
        ]);
    }

    //select
    public function selectAllServices(int $profesional_id): ?array
    {
        $stmt = $this->pdo->prepare("
        SELECT *
        FROM services
        WHERE professional_id = :professional_id
        ");

        $stmt->execute([
            'professional_id' => $profesional_id
        ]);

        $profesionals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $profesionals ?: null;
    }

    public function selectActiveServices(int $profesional_id): ?array
    {
        $stmt = $this->pdo->prepare("
        SELECT *
        FROM services
        WHERE professional_id = :professional_id
        AND status = 'active'
        ");

        $stmt->execute([
            'professional_id' => $profesional_id
        ]);

        $profesionals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $profesionals ?: null;
    }

    public function selectAllDataByServiceID(int $service_id): ?array
    {
        $stmt = $this->pdo->prepare("
        SELECT *
        FROM services
        WHERE id = :service_id
        LIMIT 1
        ");

        $stmt->execute([
            'service_id' => $service_id
        ]);

        $profesionals = $stmt->fetch(PDO::FETCH_ASSOC);

        return $profesionals ?: null;
    }

    public function updateAllData(int $professional_id, array $data): bool
    {
        $stmt = $this->pdo->prepare("
        UPDATE services
        SET
            name = :name,
            description = :description,
            duration = :duration,
            price = :price,
            vat = :vat,
            advance_payment = :advance_payment,
            status = :status
        WHERE
            id = :id
            AND professional_id = :professional_id
        ");

        return $stmt->execute([
            ':name'             => $data['name'],
            ':description'      => $data['description'],
            ':duration'         => $data['duration'],
            ':price'            => $data['price'],
            ':vat'              => $data['vat'],
            ':advance_payment'  => $data['advance_payment'],
            ':status'           => $data['status'],
            ':id'               => $data['service_id'],
            ':professional_id'  => $professional_id
        ]);
    }

    public function selectDataByName(string $name): ?array
    {
        $stmt = $this->pdo->prepare("
        SELECT *
        FROM services
        WHERE name LIKE :name
     ");

        $stmt->execute([
            'name' => '%' . $name . '%'
        ]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $results ?: null;
    }

    //delete
    public function deleteData(int $professional_id, int $service_id): bool
    {
        $stmt = $this->pdo->prepare("
        DELETE FROM services
        WHERE
            id = :service_id
            AND professional_id = :professional_id
       ");

        return $stmt->execute([
            ':service_id'      => $service_id,
            ':professional_id' => $professional_id
        ]);
    }

    //validate
    public function isServiceExist(array $data): bool
    {
        $stmt = $this->pdo->prepare("
        SELECT COUNT(*)
        FROM services
        WHERE id = :service_id
        ");

        $stmt->execute([
            'service_id' => $data['service_id']
        ]);

        return (int) $stmt->fetchColumn() > 0;
    }
}
