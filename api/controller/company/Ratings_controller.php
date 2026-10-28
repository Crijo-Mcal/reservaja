<?php

namespace public\api\controller\company;

use public\api\services\company\Ratings_service;
use public\api\validation\company\Rating_validation;
use public\api\utility\Session;

class Ratings_controller
{
    private Ratings_service $ratings_service;
    private Rating_validation $rating_validation;
    private string $appBasePath;

    public function __construct(string $appBasePath)
    {
        $this->ratings_service = new Ratings_service();
        $this->rating_validation = new Rating_validation();

        $this->appBasePath = $appBasePath;
    }

    public function allData(): array
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            exit();
        }

        $User = $_SESSION['user'] ?? [];
        if (!isset($User) || $User['role'] !== 'professional') {
            header('Location:' . ($this->appBasePath ?? '') . '/html/auth/login.php');
            exit();
        }

        $data = [
            'professional' => $_GET['professional'] ?? null
        ];

        $response = $this->ratings_service->alltData($data, $User['id']);
        return $response;
    }

    public function updateData(): void
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit();
        }

        $data_input = [
            'client_id' => $_SESSION['user']['id'] ?? '',
            'appointment_id' => (int) $_POST['appointment_id'] ?? '',
            'rating' => (int) $_POST['rating'] ?? '',
            'description' => $_POST['description'] ?? ''
        ];




        $validate_input = $this->rating_validation->validate($data_input);


        if ($validate_input['success'] === false) {
            header('Location:' . ($this->appBasePath ?? '') . '/html/client/professionals.php');
        }



        $this->ratings_service->updateRating($data_input);
        header('Location:' . ($this->appBasePath ?? '') . '/html/client/professionals.php');
    }

    public function deleteData(): void
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit();
        }

        $User = $_SESSION['user'] ?? [];
        if (!isset($User) || $User['role'] !== 'professional') {
            header('Location:' . ($this->appBasePath ?? '') . '/html/auth/login.php');
            exit();
        }

        $data = [
            'rating_id' => $_POST['rating_id'] ?? '',
            'professional' => $_POST['professional'] ?? ''
        ];

        $this->ratings_service->deleteRating($data);

        header('Location:' . ($this->appBasePath ?? '') . '/html/company/ratings.php?professional='.$data['professional']);
    }
}
