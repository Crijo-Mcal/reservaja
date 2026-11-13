<?php

namespace public\api\controller\client;

use public\api\services\client\ActivePayment_service;

class ActivePayment_controller
{
    private ActivePayment_service $active_payment_service;


    private string $appBasePath;

    public function __construct(string $appBasePath)
    {
        $this->active_payment_service = new ActivePayment_service();
        $this->appBasePath = $appBasePath;
    }

    public function allData()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            exit();
        }

        $user = $_SESSION['user'] ?? [];

        if (!$user || ($user['role'] ?? '') !== 'client') {
            header('Location: ' . $this->appBasePath . '/html/auth/login.php');
            exit();
        }

        $response = $this->active_payment_service->alldata($user['id']);

        return $response;
    }

    public function cancel_payment()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            exit();
        }

        $user = $_SESSION['user'] ?? [];

        if (!$user || ($user['role'] ?? '') !== 'client') {
            header('Location: ' . $this->appBasePath . '/html/auth/login.php');
            exit();
        }

        // A reserva é identificada pelo token; o id e o URL da Ifthenpay
        // são lidos da base de dados no service
        $token = (string) ($_GET['booking'] ?? '');

        if (preg_match('/^[a-f0-9]{32}$/', $token)) {
            $this->active_payment_service->cancel_payment($token, (int) $user['id']);
        }

        header('Location:'.($this->appBasePath ?? '').'/html/client/active_payment.php');
        exit();
    }
}
