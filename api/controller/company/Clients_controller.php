<?php

namespace public\api\controller\company;

use public\api\services\company\Clients_service;
use public\api\utility\Session;

class Clients_controller
{
    private Clients_service $clients_service;
    private string $appBasePath;

    public function __construct(string $appBasePath)
    {
        $this->clients_service = new Clients_service();
        $this->appBasePath = $appBasePath;
    }

    public function alldata(): ?array
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

        $professionalId = $user['id'];
        return $this->clients_service->getallDatas($professionalId);
    }

    public function filter(): ?array
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

        $data = [
            'professional_id' => $user['id'] ?? '',
            'client_name' => $_GET['client_name'] ?? ''
        ];

        if (!$data['client_name']) {
            header('Location: ' . $this->appBasePath . '/html/company/clients.php');
            exit();
        }

        return $this->clients_service->filterDatas($data);
    }
}

