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
            return;
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
            return;
        }

        $user = $_SESSION['user'] ?? [];

        if (!$user || ($user['role'] ?? '') !== 'client') {
            header('Location: ' . $this->appBasePath . '/html/auth/login.php');
            exit();
        }

        $data = [
            'url' => $_GET['url'],
            'booking_id' => $_GET['booking_id'],
        ];

        /* var_dump($data);
        exit(); */

        $this->active_payment_service->cancel_payment($data);


        header('Location:'.($this->appBasePath ?? '').'/html/client/active_payment.php');
        exit();

        var_dump($_GET);
        exit();
    }
}
