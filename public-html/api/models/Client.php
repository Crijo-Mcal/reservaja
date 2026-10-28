<?php

namespace public\api\models;

use public\DB\Database;

use PDO;


class Client
{
    private PDO $pdo;

    public function __construct()
    {

        $this->pdo = Database::connection();
    }


    public function insert(
        int $id,
        string $name,
        string $tax_number,
        string $mobile_number,
        string $birth_date
    ): bool {

        $stmt = $this->pdo->prepare("
        INSERT INTO clients (
            id,
            name,
            tax_number,
            mobile_number,
            birth_date
        ) VALUES (
            :id,
            :name,
            :tax_number,
            :mobile_number,
            :birth_date
        )
        ");

        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'tax_number' => $tax_number,
            'mobile_number' => $mobile_number,
            'birth_date' => $birth_date
        ]);
    }

    public function selectTaxNumberByID(int $id): ?string
    {
        $stmt = $this->pdo->prepare("
        SELECT tax_number
        FROM clients
        WHERE id = :id
        LIMIT 1
        ");

        $stmt->execute([
            'id' => $id
        ]);

        $taxNumber = $stmt->fetchColumn();

        return $taxNumber !== false ? $taxNumber : null;
    }

    public function selectMobileNumberByID(int $id): ?string
    {
        $stmt = $this->pdo->prepare("
        SELECT mobile_number
        FROM clients
        WHERE id = :id
        LIMIT 1
        ");

        $stmt->execute([
            'id' => $id
        ]);

        $mobileNumber = $stmt->fetchColumn();

        return $mobileNumber !== false ? $mobileNumber : null;
    }

    
    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare("
        UPDATE clients
        SET
            name = :name,
            tax_number = :tax_number,
            mobile_number = :mobile_number,
            birth_date = :birth_date,
            address = :address,
            postal_code = :postal_code,
            city = :city
        WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'tax_number' => $data['tax_number'] ?: null,
            'mobile_number' => $data['mobile_number'],
            'birth_date' => $data['birth_date'] ?: null,
            'address' => $data['address'] ?: null,
            'postal_code' => $data['postal_code'] ?: null,
            'city' => $data['city'] ?: null
        ]);
    }
}
