<?php

namespace public\api\controller\company;

use public\api\services\company\Professionals_service;
use public\api\validation\company\MyProfile_validation;
use public\api\utility\Session;

class Professionals_controller
{
    private Professionals_service $professionals_service;
    private MyProfile_validation $my_profile_validation;
    private string $appBasePath;

    public function __construct(string $appBasePath)
    {
        $this->professionals_service = new Professionals_service();
        $this->my_profile_validation = new MyProfile_validation();
        $this->appBasePath = $appBasePath;
    }

    public function allData(): array
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            exit();
        }

        $user = $_SESSION['user'] ?? [];
        if (!$user || ($user['role'] ?? '') !== 'professional') {
            header('Location: ' . $this->appBasePath . '/html/auth/login.php');
            exit();
        }

        if (($user['roleInCompany'] ?? '') !== 'owner') {
            header('Location: ' . $this->appBasePath . '/html/company/dashboard.php');
            exit();
        }

        $response = $this->professionals_service->alltData();

        return  $response;
    }

    public function update_Professional(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit();
        }

        $user = $_SESSION['user'] ?? [];
        if (!$user || ($user['role'] ?? '') !== 'professional') {
            header('Location: ' . $this->appBasePath . '/html/auth/login.php');
            exit();
        }

        if (($user['roleInCompany'] ?? '') !== 'owner') {
            header('Location: ' . $this->appBasePath . '/html/company/dashboard.php');
            exit();
        }


        $data = [
            'id' => (int) $_POST['id'] ?? '',
            'name' => $_POST['name'] ?? '',
            'mobile_number' => $_POST['mobile_number'] ?? '',
            'speciality' => $_POST['speciality'] ?? '',
            'role_company' => $_POST['role_company'] ?? '',
            'status' => $_POST['status'] ?? '',
            'description' => trim($_POST['description'] ?? '')
        ];

       

        $inputValidation = $this->my_profile_validation->validate($data);

        if ($inputValidation['success']==false) {
            var_dump($inputValidation);
            exit;
            /* Session::setOldData($data);

            foreach ($inputValidation as $errorType => $errorMessage) {
                Session::setError($errorType, $errorMessage);
            }

            header('Location: ' . $this->appBasePath . '/html/company/profile.php');
            exit(); */
        }

        $response=$this->professionals_service->updateProfessionalProfile($data['id'],$data);

        header('Location: ' . $this->appBasePath . '/html/company/professionals/professionals.php');
        exit();
    }
}
