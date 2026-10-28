<?php

namespace public\api\models;

use public\DB\Database;
use PDO;

class Company
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    public function selectData(): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                id,
                name,
                email,
                phone,
                tax_number,
                logo,
                location,
                description,
                iban,
                access_key,
                created_at
            FROM company
            LIMIT 1
        ");

        $stmt->execute();

        $company = $stmt->fetch(PDO::FETCH_ASSOC);

        return $company ?: null;
    }

    public function selectDataForClientViews(): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                name,
                email,
                phone,
                tax_number,
                logo,
                location,
                description
            FROM company
            LIMIT 1
        ");

        $stmt->execute();

        $company = $stmt->fetch(PDO::FETCH_ASSOC);

        return $company ?: null;
    }

    public function updateCompany(array $data): bool
    {
        $stmt = $this->pdo->prepare("
        UPDATE company
        SET
            name = :name,
            email = :email,
            phone = :phone,
            location = :location,
            description = :description
        ");

        return $stmt->execute([
            'name' => $data['company_name'],
            'email' => $data['company_email'],
            'phone' => $data['company_phone'],
            'location' => $data['company_location'],
            'description' => $data['company_description']
        ]);
    }

    public function updateCompanyLogo(string $url): bool
{
    $stmt = $this->pdo->prepare("
        UPDATE company
        SET
            logo = :logo
    ");

    return $stmt->execute([
        'logo' => $url
    ]);
}
}
