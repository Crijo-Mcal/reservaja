<?php

namespace public\api\controller\company;

use public\api\services\company\Dashboard_service;

class Dashboard_controller
{
    private Dashboard_service $dashboard_service;
    private string $appBasePath;

    public function __construct(string $appBasePath)
    {
        $this->dashboard_service = new Dashboard_service();
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

        return $this->dashboard_service->getAllDatas($professionalId);
    }
}

