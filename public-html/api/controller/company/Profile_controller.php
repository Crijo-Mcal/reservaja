<?php

namespace public\api\controller\company;

use public\api\services\company\Profile_service;
use public\api\validation\company\profile\Professional_Validation;
use public\api\validation\company\profile\Company_Validation;
use public\api\validation\company\Img_Validation;
use public\api\utility\Session;

class Profile_controller
{
    private Profile_service $profile_service;
    private Img_Validation $img_validation;
    private Professional_Validation $professional_validation;
    private Company_Validation $company_validation;
    private string $appBasePath;

    public function __construct(string $appBasePath)
    {
        $this->profile_service = new Profile_service();
        $this->img_validation = new Img_Validation();
        $this->professional_validation = new Professional_Validation();
        $this->company_validation = new Company_Validation();
        $this->appBasePath = $appBasePath;
    }

    public function alldata(): ?array
    {
        $user = $_SESSION['user'] ?? [];

        if (!$user || ($user['role'] ?? '') !== 'professional') {
            header('Location: ' . $this->appBasePath . '/html/auth/login.php');
            exit();
        }

        return $this->profile_service->allData($user['id']);
    }

    public function update_Professional(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $user = $_SESSION['user'] ?? [];

        if (!$user || ($user['role'] ?? '') !== 'professional') {
            header('Location: ' . $this->appBasePath . '/html/auth/login.php');
            exit();
        }

        $id = $user['id'];

        $data = [
            'professional_name' => $_POST['professional_name'] ?? '',
            'speciality' => $_POST['speciality'] ?? '',
            'professional_number' => $_POST['professional_number'] ?? '',
            'description' => trim($_POST['description'] ?? '')
        ];

        $inputValidation = $this->professional_validation->validate($data);

        if ($inputValidation) {
            Session::setOldData($data);

            foreach ($inputValidation as $errorType => $errorMessage) {
                Session::setError($errorType, $errorMessage);
            }

            header('Location: ' . $this->appBasePath . '/html/company/profile.php');
            exit();
        }

        $this->profile_service->updateProfessionalProfile($id, $data);

        header('Location: ' . $this->appBasePath . '/html/company/profile.php');
        exit();
    }

    public function update_Company(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $user = $_SESSION['user'] ?? [];

        if (($user['role'] ?? '') !== 'professional') {
            header('Location: ' . $this->appBasePath . '/html/auth/login.php');
            exit();
        }

        $data = [
            'company_name' => $_POST['company_name'] ?? '',
            'company_phone' => $_POST['company_phone'] ?? '',
            'company_email' => $_POST['company_email'] ?? '',
            'company_location' => $_POST['company_location'] ?? '',
            'company_description' => trim($_POST['company_description'] ?? '')
        ];

        $inputValidation = $this->company_validation->validate($data);

        if ($inputValidation) {
            Session::setOldData($data);

            foreach ($inputValidation as $errorType => $errorMessage) {
                Session::setError($errorType, $errorMessage);
            }

            header('Location: ' . $this->appBasePath . '/html/company/profile.php');
            exit();
        }

        $this->profile_service->updateCompanyProfile($data);

        header('Location: ' . $this->appBasePath . '/html/company/profile.php');
        exit();
    }

    public function setProfileImage(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $user = $_SESSION['user'] ?? [];

        if (!$user || ($user['role'] ?? '') !== 'professional') {
            header('Location: ' . $this->appBasePath . '/html/auth/login.php');
            exit();
        }

        $id = $user['id'];
        $image = $_FILES['profile_image'] ?? null;

        $validation = $this->img_validation->validate($image, 'profile_image');

        if ($validation['success'] === false) {
            Session::setError(
                $validation['error']['errorType'],
                $validation['error']['errorMessage']
            );

            header('Location: ' . $this->appBasePath . '/html/company/profile.php');
            exit();
        }

        $this->profile_service->saveProfileImg($id, $image,$this->appBasePath);

        header('Location: ' . $this->appBasePath . '/html/company/profile.php');
        exit();
    }

    public function setCompanyLogo(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $user = $_SESSION['user'] ?? [];

        if (!$user || ($user['role'] ?? '') !== 'professional') {
            header('Location: ' . $this->appBasePath . '/html/auth/login.php');
            exit();
        }

        $id = $user['id'];
        $image = $_FILES['company_logo'] ?? null;

        $validation = $this->img_validation->validate($image, 'company_logo');

        if ($validation['success'] === false) {
            Session::setError(
                $validation['error']['errorType'],
                $validation['error']['errorMessage']
            );

            header('Location: ' . $this->appBasePath . '/html/company/profile.php');
            exit();
        }

        $this->profile_service->saveLogoImg($id, $image,$this->appBasePath);

        header('Location: ' . $this->appBasePath . '/html/company/profile.php');
        exit();
    }
}

