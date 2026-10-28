<?php

namespace public\api\validation\company;

class Service_validation{

    public function validate(array $inputData): array{

        $response = [
            'success' => true,
        ];

        foreach ($inputData as $key => $value) {

            if ($key !== 'description' && $value == '') {
                $response = [
                    'success' => false,
                    'error' => [
                        'errorType' => 'serviceInput',
                        'errorMessage' => 'Por favor, preencha todos os campos necessários do formulário.'
                    ]
                ]; 
                
               break;            
            }
        }

         return $response;
    }
}
