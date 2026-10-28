<?php

namespace public\api\controller\company;

use public\api\services\company\Payments_service;

class Payments_controller
{
    private Payments_service $payment_service;
    private string $appBasePath;

    public function __construct(string $appBasePath)
    {
        $this->payment_service = new Payments_service();
        $this->appBasePath = $appBasePath;
    }

    public function alldata(): ?array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return [];
        }

        $user = $_SESSION['user'] ?? [];

        if (!$user || ($user['role'] ?? '') !== 'professional') {
            header('Location: ' . $this->appBasePath . '/html/auth/login.php');
            exit();
        }

        $professionalId = $user['id'];

        return $this->payment_service->getallDatas($professionalId);
    }

    public function filter(): ?array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return [];
        }

        $user = $_SESSION['user'] ?? [];

        if (!$user || ($user['role'] ?? '') !== 'professional') {
            header('Location: ' . $this->appBasePath . '/html/auth/login.php');
            exit();
        }

        $data = [
            'professional_id' => $user['id'],
            'month' => $_GET['month'] ?? ''
        ];

        if ($data['month'] === '') {
            header('Location: ' . $this->appBasePath . '/html/company/payments.php');
            exit();
        }

        return $this->payment_service->filterDatas($data);
    }
}

