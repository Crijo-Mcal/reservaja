<?php

namespace public\api\controller\auth;

use public\api\utility\Session;
use public\api\utility\PasswordHash;

use public\api\utility\NifValidator;

use public\api\validation\auth_validation\Client_validation;
use public\api\validation\auth_validation\Login_validation;
use public\api\validation\auth_validation\Professional_validation;
use public\api\services\auth\Auth_service;


class Auth_controller
{
    private Auth_service $authService;
    private Client_validation $client_validation;
    private Login_validation $login_validation;
    private Professional_validation $professional_validation;

    private string $appBasePath;

    public function __construct(string $appBasePath)
    {
        $this->authService = new Auth_service();
        $this->client_validation = new Client_validation();
        $this->professional_validation = new Professional_validation();
        $this->login_validation = new Login_validation();

        $this->appBasePath=$appBasePath;
    }

    public function clientSingup(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        // Form Data
        $data = [
            'first_name' => $_POST['first_name'] ?? '',
            'last_name' => $_POST['last_name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'date_of_birth' => $_POST['date_of_birth'] ?? '',
            'mobile_number' => $_POST['mobile_number'] ?? '',
            'tax_number' => $_POST['tax_number'] ?? '',
            'password' => $_POST['password'] ?? '',
            'password_confirmation' => $_POST['password_confirmation'] ?? '',
        ];

   
        // Validation Form Data
        $inputValidation = $this->client_validation->singup($data);

        var_dump(NifValidator::isValid($data['tax_number']) === false);


        if ($inputValidation) {
            Session::setOldData($data);
            foreach ($inputValidation as $field => $message) {
                Session::setError($field, $message);
            }
            header('Location:'.( $this->appBasePath ?? '' ).'/html/auth/client_singUp.php');
            exit();
        }

        // Create Client
        $newClient = $this->authService->createClient(
            $data['first_name'] . ' ' . $data['last_name'],
            $data['email'],
            PasswordHash::hash($data['password']),
            $data['tax_number'],
            $data['mobile_number'],
            $data['date_of_birth']
        );

        /* Auth Validation */
        if ($newClient['success'] === false) {
            Session::setOldData($data);

            Session::setError(
                $newClient['error']['errorType'],
                $newClient['error']['errorMessage']
            );

            header('Location:'.( $this->appBasePath ?? '' ).'/html/auth/client_singUp.php');
            exit();
        }

        /* Success */
        Session::set('user',  $newClient['data']);
        header('Location:'.( $this->appBasePath ?? '' ).'/html/client/professionals.php');
        exit();
    }

    public function employeeSingup(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        // Form Data
        $data = [
            'first_name' => $_POST['first_name'] ?? '',
            'last_name' => $_POST['last_name'] ?? '',
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'password_confirmation' => $_POST['password_confirmation'] ?? '',
            'mobile_number' => $_POST['mobile_number'] ?? '',
            'tax_number' => $_POST['tax_number'] ?? '',
        ];

        // Validation Form Data
        $inputValidation = $this->professional_validation->singupFrom($data);

        if ($inputValidation) {
            Session::setOldData($data);

            foreach ($inputValidation as $errorType => $errorMessage) {
                Session::setError(
                    $errorType,
                    $errorMessage
                );
            }

            header('Location:'.( $this->appBasePath ?? '' ).'/html/auth/employee_singUp.php');
            exit();
        }

        // Combine first name and last name
        $name = $data['first_name'] . ' ' . $data['last_name'];

        // Create new Professional
        $newProfessional = $this->authService->createProfessional(
            $name,
            $data['email'],
            PasswordHash::hash($data['password']),
            $data['mobile_number'],
            $data['tax_number'],
        );

        // Auth Validation
        if ($newProfessional['success'] === false) {
            Session::setOldData($data);

            Session::setError(
                $newProfessional['error']['errorType'],
                $newProfessional['error']['errorMessage']
            );

            header('Location:'.( $this->appBasePath ?? '' ).'/html/auth/employee_singUp.php');
            exit();
        }

        // Success
        Session::set(
            'user',
            $newProfessional['data']
        );

        header('Location:'.( $this->appBasePath ?? '' ).'/html/company/dashboard.php');
        exit();
    }

    public function logIn()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

     

        // Form Data
        $dataInput = [
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
        ];

   
        // Validation Form Data
        $inputValidation = $this->login_validation->login($dataInput);
        if ($inputValidation) {
            Session::setOldData($dataInput);
            foreach ($inputValidation as $errorType => $errorMessage) {
                Session::setError($errorType, $errorMessage);
            }
            header('Location: '.($this->appBasePath ?? '').'/html/auth/login.php');
            exit();
        }

        // Login
        $result = $this->authService->login(
            $dataInput['email'],
            $dataInput['password']
        );

        //validate Authentication 
        if (!$result['success']) {
            $error = $result['error'] ?? '';

            Session::setOldData($dataInput);
            Session::setError(
                $error['errorType'],
                $error['errorMessage'],
            );

            header('Location: '.($this->appBasePath ?? '').'/html/auth/login.php');
            exit();
        }

        // Login success
        $userData = $result['data'] ?? '';
        Session::set('user', $userData);

        switch ($userData['role']) {

            case 'client':
                header('Location:'.($this->appBasePath ?? '').'/html/client/professionals.php');
                break;

            case 'professional':
                header('Location:'.($this->appBasePath ?? '').'/html/company/dashboard.php');
                break;
        }

        exit();
    }

    public function logOut()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        unset($_SESSION['user']);
        header('Location:'.($this->appBasePath ?? '').'/html/auth/login.php');
        exit();
    }
}
