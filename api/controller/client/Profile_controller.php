<?php

namespace public\api\controller\client;

use public\api\services\client\Profile_service;
use public\api\validation\client\Profile_validation;
use public\api\utility\Session;

class Profile_controller
{
    private Profile_service $profile_service;
    private Profile_validation $profile_validation;
    private string $appBasePath;

    public function __construct(string $appBasePath)
    {
        $this->profile_service = new Profile_service();
        $this->profile_validation = new Profile_validation();
        $this->appBasePath = $appBasePath;
    }

    public function showData(): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            exit();
        }

        $user = $_SESSION['user'] ?? null;

        if (!$user || ($user['role'] ?? '') !== 'client') {
            header('Location: ' . $this->appBasePath . '/html/auth/login.php');
            exit();
        }

        return [];
    }

    public function updateData(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit();
        }

        $user = $_SESSION['user'] ?? null;

        if (!$user || ($user['role'] ?? '') !== 'client') {
            header('Location: ' . $this->appBasePath . '/html/auth/login.php');
            exit();
        }

        $dataInput = [
            'name' => $_POST['name'] ?? '',
            'tax_number' => $_POST['tax_number'] ?? '',
            'mobile_number' => $_POST['mobile_number'] ?? '',
            'birth_date' => $_POST['birth_date'] ?? '',
            'address' => $_POST['address'] ?? '',
            'postal_code' => $_POST['postal_code'] ?? '',
            'city' => $_POST['city'] ?? '',
        ];

        $inputValidation = $this->profile_validation->validate($dataInput);

        if ($inputValidation) {
            Session::setOldData($dataInput);

            foreach ($inputValidation as $field => $message) {
                Session::setError($field, $message);
            }

            header('Location: ' . $this->appBasePath . '/html/client/profile.php');
            exit();
        }

        $this->profile_service->updateData($user['id'], $dataInput);

        // Atualizar a sessão com os dados do perfil guardados
        $profileData = $this->profile_service->profileData($user['email']);
        Session::set('user', array_merge($user, $profileData));

        header('Location: ' . $this->appBasePath . '/html/client/profile.php');
        exit();
    }
}

