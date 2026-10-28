<?php

namespace public\api\controller\client;

use public\api\services\client\Professionals_service;

class Professionals_controller
{
    private Professionals_service $professional_search_service;

    public function __construct()
    {
        $this->professional_search_service = new Professionals_service;
    }

    public function allData()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            exit();
        }

       
        $User =$_SESSION['user'] ?? [];

        $data_input=[
            'professional_name'=> $_GET['professional_name'] ?? '',
            'professional_speciality'=> $_GET['professional_speciality'] ?? '',
            'client_id'=>$User['id']?? null,
        ];

        

       return $this->professional_search_service->showAllData($data_input);
    }
}
