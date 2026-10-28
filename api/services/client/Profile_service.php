<?php

namespace public\api\services\client;

use public\api\models\Client;
use public\api\models\User;
use public\api\utility\Session;

class Profile_service
{

    private Client $client_table;
    private User $user_table;


    public function __construct()
    {
        $this->client_table = new Client();
        $this->user_table = new User();
    }

    public function updateData(int $client_id, array $data_input): void
    {
        $this->client_table->update($client_id, $data_input);
    }

    // Dados do perfil guardados na base de dados, com as mesmas chaves da sessão
    public function profileData(string $email): array
    {
        $user = $this->user_table->selectByEmail($email);

        if (!$user) {
            return [];
        }

        return [
            'name' => $user['client_name'],
            'tax_number' => $user['client_tax_number'],
            'birth_date' => $user['client_birth_date'],
            'mobile_number' => $user['client_mobile_number'],
            'address' => $user['client_address'],
            'postal_code' => $user['client_postal_code'],
            'city' => $user['client_city'],
        ];
    }
}
