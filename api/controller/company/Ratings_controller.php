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

        // Todos os profissionais podem ver a página. Só o proprietário escolhe
        // o profissional; os outros veem apenas as suas próprias avaliações.
        // (Antes redirecionava para esta mesma página -> ciclo infinito.)
        $isOwner = ($User['roleInCompany'] ?? '') === 'owner';

        $data = [
            'professional' => $isOwner ? $this->validProfessionalFilter($_GET['professional'] ?? null) : null
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

        // Só o proprietário pode eliminar avaliações
        if (($User['roleInCompany'] ?? '') !== 'owner') {
            header('Location:' . ($this->appBasePath ?? '') . '/html/company/ratings.php');
            exit();
        }

        $ratingId = (string) ($_POST['rating_id'] ?? '');
        $professional = $this->validProfessionalFilter($_POST['professional'] ?? null);

        if (ctype_digit($ratingId) && (int) $ratingId > 0) {
            $this->ratings_service->deleteRating(['rating_id' => (int) $ratingId]);
        }

        // Voltar à mesma lista (mesmo filtro) de onde veio o pedido
        $query = $professional !== null ? '?' . http_build_query(['professional' => $professional]) : '';

        header('Location:' . ($this->appBasePath ?? '') . '/html/company/ratings.php' . $query);
        exit();
    }

    // Filtro de profissional aceite: 'all' ou um id numérico; qualquer outro valor é ignorado
    private function validProfessionalFilter(mixed $value): ?string
    {
        $value = is_string($value) ? $value : '';

        if ($value === 'all' || (ctype_digit($value) && (int) $value > 0)) {
            return $value;
        }

        return null;
    }
}
