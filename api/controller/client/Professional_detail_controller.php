<?php

namespace public\api\controller\client;

use public\api\services\client\Professional_detail_service;


class Professional_detail_controller
{
    private Professional_detail_service $professional_detail_service;

    private string $appBasePath;

    public function __construct(string $appBasePath)
    {
        $this->professional_detail_service = new Professional_detail_service();
        $this->appBasePath = $appBasePath;
    }

    public function showData()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            exit();
        }

        if (!$_GET['professional_id']) {
            header('Location:' . ($this->appBasePath ?? '') . '/html/client/professionals.php');
            exit();
        }

        $id = $_GET['professional_id'] ?? null;

        return $this->professional_detail_service->allData($id);
    }
}
