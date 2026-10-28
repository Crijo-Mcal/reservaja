<?php

namespace public\api\services\client;

use public\api\models\appointments;


class History_service
{

    private appointments\Select $appointments_select;
  

    public function __construct()
    {
        $this->appointments_select = new appointments\Select();
    }

    public function allData(string $client_email): array
    {
        $data=$this->appointments_select->selectClientHistory($client_email);
        return $data;
    }

   
}
