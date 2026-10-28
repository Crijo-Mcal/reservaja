<?php

namespace public\api\controller\company;

use public\api\services\company\Services_service;
use public\api\validation\company\Service_validation;
use public\api\utility\Session;

class Services_controller
{
    private Service_validation $service_validation;
    private Services_service $services_service;

    private string $appBasePath;

    public function __construct(string $appBasePath)
    {
        $this->service_validation = new Service_validation();
        $this->services_service = new Services_service();

        $this->appBasePath=$appBasePath;
    }


    public function allData(): ?array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return [];
        }

        $User = $_SESSION['user'] ?? [];
        if (!isset($User) || $User['role'] !== 'professional') {
            header('Location:'.( $this->appBasePath ?? '' ).'/html/auth/login.php');
            exit();
        }

        $search = $_GET['search'] ?? '';
        $id = $_SESSION['user']['id'];

        $reponse = $this->services_service->showData($id, $search);

        return $reponse;
    }

    public function filterData(): ?array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return [];
        }

        $User = $_SESSION['user'] ?? [];
        if (!isset($User) || $User['role'] !== 'professional') {
            header('Location:'.( $this->appBasePath ?? '' ).'/html/auth/login.php');
            exit();
        }

        $service_name = $_GET['service_name'] ?? '';

        if (!$service_name) {
            header('Location:'.( $this->appBasePath ?? '' ).'/html/company/services.php');
        }

        $reponse = $this->services_service->filterData($service_name);
        return $reponse;
    }

    public function addNewService(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $User = $_SESSION['user'] ?? [];
        if (!isset($User) || $User['role'] !== 'professional') {
            header('Location:'.( $this->appBasePath ?? '' ).'/html/auth/login.php');
            exit();
        }

        $data = [
            'professional_id' => $_POST['professional_id'] ?? null,
            'name' => $_POST['name'] ?? null,
            'status' => $_POST['status'] ?? null,
            'duration' => $_POST['duration'] ?? null,
            'price' => $_POST['price'] ?? null,
            'vat' => $_POST['vat'] ?? null,
            'advance_payment' => $_POST['advance_payment'] ?? null,
            'description' => $_POST['description'] ?? null,
        ];

        /* input form validation */
        $inputValidation = $this->service_validation->validate($data);
        if ($inputValidation['success'] == false) {
            $errorType = $inputValidation['error']['errorType'];
            $errorMessage = $inputValidation['error']['errorMessage'];
            Session::setError($errorType, $errorMessage);

            header('Location:'.( $this->appBasePath ?? '' ).'/html/company/services.php');
            exit();
        }

        /* add new service */
        $this->services_service->addNewService($data);
        header('Location:'.( $this->appBasePath ?? '' ).'/html/company/services.php');
    }

    public function updateService(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $User = $_SESSION['user'] ?? [];
        if (!isset($User) || $User['role'] !== 'professional') {
            header('Location:'.( $this->appBasePath ?? '' ).'/html/auth/login.php');
            exit();
        }

        $professional_id = $User['id'];

        $data = [
            'service_id' => $_POST['service_id'] ?? null,
            'name' => $_POST['name'] ?? null,
            'status' => $_POST['status'] ?? null,
            'duration' => $_POST['duration'] ?? null,
            'price' => $_POST['price'] ?? null,
            'vat' => $_POST['vat'] ?? null,
            'advance_payment' => $_POST['advance_payment'] ?? null,
            'description' => $_POST['description'] ?? null,
        ];

        /* input form validation */
        $inputValidation = $this->service_validation->validate($data);
        if ($inputValidation['success'] == false) {
            $errorType = $inputValidation['error']['errorType'];
            $errorMessage = $inputValidation['error']['errorMessage'];
            Session::setError($errorType, $errorMessage);

            header('Location:'.( $this->appBasePath ?? '' ).'/html/company/services.php');
            exit();
        }

        $this->services_service->updateData($professional_id, $data);
        header('Location:'.( $this->appBasePath ?? '' ).'/html/company/services.php');
    }

    public function deleteService(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            return;
        }

        $User = $_SESSION['user'] ?? [];
        if (!isset($User) || $User['role'] !== 'professional') {
            header('Location:'.( $this->appBasePath ?? '' ).'/html/auth/login.php');
            exit();
        }

        $professional_id =  $User['id'];
        $service_id = $_POST['service_id'] ?? null;


        $this->services_service->deleteData($professional_id, $service_id);
        header('Location:'.( $this->appBasePath ?? '' ).'/html/company/services.php');
    }
}
