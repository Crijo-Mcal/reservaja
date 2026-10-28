<?php

namespace public\api\services\company;

use public\api\models\appointments;
use public\api\models\bookings;

class Clients_service
{
    private appointments\Count $appointments_count;
    private appointments\Select $appointments_select;

    private bookings\Select $bookings_select;

    public function __construct()
    {
        $this->appointments_count = new appointments\Count();
        $this->appointments_select = new appointments\Select();

        $this->bookings_select = new bookings\Select();
    }

    public function getallDatas(int $professional_id)
    {
        $summary = $this->summary($professional_id);
        $data = $this->appointments_select->selectClientsByProfessional($professional_id);

        return ['summary' => $summary, 'clients' => $data];
    }

    public function filterDatas(array $data)
    {
        $summary = $this->summary($data['professional_id']);
        $response= $this->appointments_select->selectClientByData($data);

        return ['summary' => $summary,'clients' => $response];
    }

    private function summary(int $professional_id)
    {
        $totalClient = $this->appointments_count->countClientsByProfessional($professional_id);
        $newClient = $this->appointments_count->countNewClientsThisMonth($professional_id);
        $activeClient = $this->appointments_count->countActiveClients($professional_id);

        return [
            'total_client' => $totalClient,
            'new_client' => $newClient,
            'active_client' => $activeClient
        ];
    }
}
