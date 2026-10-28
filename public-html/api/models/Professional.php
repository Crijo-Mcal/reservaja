<?php

namespace public\api\models;

use public\DB\Database;

use PDO;

class Professional
{
    private PDO $pdo;
    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    //insert
    public function insertInitial(
        string $id,
        string $name,
        string $mobileNumber,
        string $TaxNumber
    ): bool {

        $stmt = $this->pdo->prepare("
          INSERT INTO professionals (
            id,
            name,
            mobile_number,
            tax_number
         ) VALUES (
            :id,
            :name,
            :mobile_number,
            :tax_number
        )");

        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'mobile_number' => $mobileNumber,
            'tax_number' => $TaxNumber
        ]);
    }


    //select
    public function selectAllData(): ?array
    {
        $stmt = $this->pdo->prepare("
        SELECT
            professionals.*,
            COALESCE(ROUND(AVG(ratings.rating), 1), 0) AS rating_average,
            COUNT(ratings.id) AS rating_count
        FROM professionals
        LEFT JOIN ratings
            ON ratings.professional_id = professionals.id
        WHERE professionals.status='active'
        GROUP BY professionals.id
        ORDER BY professionals.id DESC;
        ");

        $stmt->execute();

        $professionals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $professionals ?: null;
    }

    public function selectByName(
        string $professional_name
    ): ?array {

        $stmt = $this->pdo->prepare("
        SELECT
            professionals.*,
            COALESCE(ROUND(AVG(ratings.rating), 1), 0) AS rating_average,
            COUNT(ratings.id) AS rating_count
        FROM professionals
        LEFT JOIN ratings
            ON ratings.professional_id = professionals.id
        WHERE professionals.name LIKE :professional_name
        AND professionals.status='active'
        GROUP BY professionals.id
        ORDER BY professionals.id DESC
        ");

        $stmt->execute([
            'professional_name' => '%' . $professional_name . '%'
        ]);

        $professionals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $professionals ?: null;
    }

    public function selectBySpeciality(
        string $professional_speciality
    ): ?array {

        $stmt = $this->pdo->prepare("
        SELECT
            professionals.*,
            COALESCE(ROUND(AVG(ratings.rating), 1), 0) AS rating_average,
            COUNT(ratings.id) AS rating_count
        FROM professionals
        LEFT JOIN ratings
            ON ratings.professional_id = professionals.id
        WHERE professionals.speciality LIKE :professional_speciality
        AND professionals.status='active'
        GROUP BY professionals.id
        ORDER BY professionals.id DESC
        ");

        $stmt->execute([
            'professional_speciality' => '%' . $professional_speciality . '%'
        ]);

        $professionals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $professionals ?: null;
    }

    public function selectBySpecialityAndName(
        string $professional_speciality,
        string $professional_name
    ): ?array {

        $stmt = $this->pdo->prepare("
        SELECT
            professionals.*,
            COALESCE(ROUND(AVG(ratings.rating), 1), 0) AS rating_average,
            COUNT(ratings.id) AS rating_count
        FROM professionals
        LEFT JOIN ratings
            ON ratings.professional_id = professionals.id
        WHERE professionals.speciality LIKE :professional_speciality
        AND professionals.name LIKE :professional_name
        GROUP BY professionals.id
        ORDER BY professionals.id DESC
        ");

        $stmt->execute([
            'professional_speciality' => '%' . $professional_speciality . '%',
            'professional_name' => '%' . $professional_name . '%'
        ]);

        $professionals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $professionals ?: null;
    }

    public function getAllProfessionals(): array
    {
        $stmt = $this->pdo->prepare("
        SELECT *
        FROM professionals
        ORDER BY name
        ");
        $stmt->execute();
        $professionals = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->pdo->prepare("
        SELECT *
        FROM services
        ORDER BY name
        ");
        $stmt->execute();
        $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->pdo->prepare("
        SELECT *
        FROM schedules
        ORDER BY date, start_time
        ");
        $stmt->execute();
        $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $this->pdo->prepare("
        SELECT *
        FROM appointments
        ORDER BY appointment_date, appointment_time
        ");
        $stmt->execute();
        $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($professionals as &$professional) {
            $professional['services'] = array_values(array_filter(
                $services,
                fn($service) => $service['professional_id'] == $professional['id']
            ));

            $professional['schedules'] = array_values(array_filter(
                $schedules,
                fn($schedule) => $schedule['professional_id'] == $professional['id']
            ));

            $professional['appointments'] = array_values(array_filter(
                $appointments,
                fn($appointment) => $appointment['professional_id'] == $professional['id']
            ));
        }

        unset($professional);

        return $professionals;
    }

    public function selectById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
        SELECT
            professionals.*,
            COALESCE(ROUND(AVG(ratings.rating), 1), 0) AS rating_average,
            COUNT(ratings.id) AS rating_count
        FROM professionals
        LEFT JOIN ratings
            ON ratings.professional_id = professionals.id
        WHERE professionals.id = :id
        GROUP BY professionals.id
        LIMIT 1
        ");

        $stmt->execute([
            'id' => $id
        ]);

        $professional = $stmt->fetch(PDO::FETCH_ASSOC);

        return $professional ?: null;
    }

    public function selectallSpeciality(): ?array
    {

        $stmt = $this->pdo->prepare("
        SELECT speciality FROM `professionals`
        ");

        $stmt->execute();

        $schedule = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $schedule ?: null;
    }

    public function selectAllNamesProfessionals(): ?array
    {
        $stmt = $this->pdo->prepare("
        SELECT id, name FROM professionals
        ");
        $stmt->execute();
        $professionals = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $professionals ?: null;
    }

    public function selectProfileImage(int $id): ?string
    {
        $stmt = $this->pdo->prepare("
        SELECT profile_image
        FROM professionals
        WHERE id = :id
        ");

        $stmt->execute([
            'id' => $id,
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['profile_image'] ?? null;
    }



    //update
    public function updateProfileForOwner(int $id, array $data): bool
    {

        $stmt = $this->pdo->prepare("
        UPDATE professionals
        SET
            name = :name,
            speciality = :speciality,
            mobile_number = :mobile_number,
            description = :description,
            status = :status,
            role_company = :role_company
        WHERE id = :id
        ");

        $success = $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'speciality' => $data['speciality'],
            'mobile_number' => $data['mobile_number'],
            'description' => $data['description'],
            'status' => $data['status'],
            'role_company' => $data['role_company']
        ]);

        if (!$success) {
            return false;
        }

        $stmt = $this->pdo->prepare("
        UPDATE users
        SET name = :name
        WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id,
            'name' => $data['name']
        ]);
    }

    public function updateProfile(int $id, array $data): bool
    {

        $stmt = $this->pdo->prepare("
        UPDATE professionals
        SET
            name = :name,
            speciality = :speciality,
            mobile_number = :mobile_number,
            description = :description,
        WHERE id = :id
        ");

        $success = $stmt->execute([
            'id' => $id,
            'name' => $data['professional_name'],
            'speciality' => $data['speciality'],
            'mobile_number' => $data['professional_number'],
            'description' => $data['description']
        ]);

        if (!$success) {
            return false;
        }

        $stmt = $this->pdo->prepare("
        UPDATE users
        SET name = :name
        WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id,
            'name' => $data['professional_name']
        ]);
    }

    public function updateProfile_image(int $id, string $urlImage): bool
    {
        $stmt = $this->pdo->prepare("
        UPDATE professionals
        SET
            profile_image =:profile_image
        WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id,
            'profile_image' => $urlImage,
        ]);
    }

    public function updateProfile_company_logo(int $id, string $urlImage): bool
    {
        $stmt = $this->pdo->prepare("
        UPDATE professionals
        SET
            company_logo =:company_logo
        WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id,
            'company_logo' => $urlImage,
        ]);
    }

    //validate
    public function isCompany_name_exit(string $companyName): bool
    {

        $stmt = $this->pdo->prepare("
        SELECT *
        FROM professionals
        WHERE company_name = :companyName
        LIMIT 1");


        $stmt->execute([
            'companyName' => $companyName
        ]);


        return $stmt->fetchColumn() !== false;
    }

    public function isTax_number_exist(string $taxNumber): bool
    {
        $stmt = $this->pdo->prepare("
        SELECT 1
        FROM professionals
        WHERE tax_number = :tax_number
        LIMIT 1
        ");

        $stmt->execute([
            'tax_number' => $taxNumber
        ]);

        return $stmt->fetchColumn() !== false;
    }
}
