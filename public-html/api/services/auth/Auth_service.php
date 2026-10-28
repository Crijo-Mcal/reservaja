<?php

namespace public\api\services\auth;

use public\api\models\User;
use public\api\models\Client;
use public\api\models\Professional;
use public\api\utility\PasswordHash;
use public\api\models\Subscription;

class Auth_service
{
    private User $userTable;
    private Client $clientTable;
    private Professional $professionalTable;

    public function __construct()
    {
        $this->userTable = new User();
        $this->clientTable = new Client();
        $this->professionalTable = new Professional();
    }

    public function createClient(
        string $name,
        string $email,
        string $password,
        string $taxNumber,
        string $mobileNumber,
        string $birthDate
    ): array {

        //Database  Validation
        if ($this->userTable->isEmailExist($email)) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => 'email',
                    'errorMessage' => 'Este email já está registado. Por favor, utilize outro email.'
                ]

            ];
        }


        // 1. Create User
        $userId = $this->userTable->insert(
            $name,
            $email,
            $password,
            'client'
        );

        // 2. Create Client using User ID
        $this->clientTable->insert(
            $userId,
            $name,
            $taxNumber,
            $mobileNumber,
            $birthDate
        );

        return [
            'success' => true,
            'data' => ['id' => $userId, 'name' => $name, 'email' => $email, 'role' => 'client', 'tax_number' =>  $taxNumber, 'mobile_number' => $mobileNumber]
        ];
    }


    public function createProfessional(
        string $name,
        string $email,
        string $password,
        string $mobileNumber,
        string $TaxNumber
    ): array {

        //Auth  Validation
        if ($this->userTable->isEmailExist($email)) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => 'email',
                    'errorMessage' => 'Este email já está registado. Por favor, utilize outro email.'
                ]

            ];
        }


        if ($this->professionalTable->isTax_number_exist($TaxNumber)) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => 'tax_number',
                    'errorMessage' => 'O número de contribuinte já está registado.'
                ]
            ];
        }

        /* User */
        $userId = $this->userTable->insert(
            $name,
            $email,
            $password,
            'professional'
        );
        /* professional */
        $this->professionalTable->insertInitial(
            $userId,
            $name,
            $mobileNumber,
            $TaxNumber
        );

        return [
            'success' => true,
            'data' => [
                'id' => $userId,
                'name' => $name,
                'email' => $email,
                'role' => 'professional',
                'roleInCompany' => 'employee',
                'profile_image' => null,
            ]
        ];
    }

    public function login(
        string $email,
        string $password
    ): array {
        $user = $this->userTable->selectByEmail($email);


        /* Auth Validation */
        if (!$user) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => 'email',
                    'errorMessage' => 'O email não existe.'
                ]
            ];
        }

        if (!PasswordHash::verify($password, $user['user_password'])) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => 'password',
                    'errorMessage' => 'Palavra-passe incorreta.'
                ]
            ];
        }

        /* success */

        if ($user['user_role'] === 'client') {
            $userInfo = [
                'id' => $user['user_id'],
                'name' => $user['user_name'],
                'email' => $user['user_email'],
                'role' => $user['user_role'],
                'tax_number' => $user['client_tax_number'],
                'birth_date' => $user['client_birth_date'],
                'mobile_number' => $user['client_mobile_number'],
                'address' => $user['client_address'],
                'postal_code' => $user['client_postal_code'],
                'city'=>$user['client_city']
            ];


            return [
                'success' => true,
                'data' => $userInfo
            ];
        }

        if ($user['user_role'] === 'professional') {

            $userInfo = [
                'id' => $user['user_id'],
                'name' => $user['user_name'],
                'email' => $user['user_email'],
                'role' => $user['user_role'],
                'roleInCompany' => $user['professional_role_company'],
                'profile_image' => $user['professional_profile_image'],
            ];

            return [
                'success' => true,
                'data' => $userInfo
            ];
        }

        return [
            'success' => false,
        ];
    }
}
