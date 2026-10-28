<?php

namespace public\api\controller\client;

use public\api\services\client\History_service;


class History_controller
{
    private History_service $history_servicee;
private string $appBasePath;

    public function __construct(string $appBasePath)
    {
        $this->history_servicee = new History_service();
        $this->appBasePath = $appBasePath;
    }

    public function alldata(): array
    {
        $user = $_SESSION['user'] ?? [];

        if (!$user || ($user['role'] ?? '') !== 'client') {
            header('Location: ' . $this->appBasePath . '/html/auth/login.php');
            exit();
        }

        $user=$_SESSION['user'];
        $response = $this->history_servicee->allData($user['email']);

        return $response;
    }
}
