<?php

namespace public\api\models;

use public\DB\Database;

use PDO;

class User
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    //insert
    public function insert(
        string $name,
        string $email,
        string $password,
        string $role
    ): int {

        $stmt = $this->pdo->prepare("
            INSERT INTO users (
                name,
                email,
                password,
                role
            ) VALUES (
                :name,
                :email,
                :password,
                :role
            )
        ");

        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => $role
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    //validate
    public function isEmailExist(string $email): bool
    {
        $stmt = $this->pdo->prepare("
            SELECT 1
            FROM users
            WHERE email = :email
            LIMIT 1
        ");

        $stmt->execute([
            'email' => $email
        ]);

        return $stmt->fetchColumn() !== false;
    }

    //select
    public function selectByEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare("
        SELECT
            u.id AS user_id,
            u.name AS user_name,
            u.email AS user_email,
            u.password AS user_password,
            u.role AS user_role,

            c.id AS client_id,
            c.name AS client_name,
            c.mobile_number AS client_mobile_number,
            c.tax_number AS client_tax_number,
            c.birth_date AS client_birth_date,
            c.address AS client_address,
            c.postal_code AS client_postal_code,
            c.city AS client_city,

            p.id AS professional_id,
            p.name AS professional_name,
            p.profile_image AS professional_profile_image,
            p.role_company AS professional_role_company

        FROM users u
        LEFT JOIN clients c ON c.id = u.id
        LEFT JOIN professionals p ON p.id = u.id
        WHERE u.email = :email
        LIMIT 1
       ");

        $stmt->execute([
            'email' => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
