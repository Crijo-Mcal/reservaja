<?php

namespace public\api\services\client;

use public\api\models\Client;
use public\api\utility\Session;

class Profile_service
{

    private Client $client_table;


    public function __construct()
    {
        $this->client_table = new Client();
    }

    public function updateData(int $client_id, array $data_input): void
    {
        $this->client_table->update($client_id, $data_input);

        //update session
        foreach ($data_input as $key => $value) {
            $_SESSION['user'][$key] = $value;
        }
    }
}
