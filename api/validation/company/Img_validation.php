<?php

namespace public\api\validation\company;

class Img_Validation
{

    private array $availableType;


    public function __construct()
    {
        $this->availableType = ['image/png', 'image/jpeg', 'image/webp'];
    }

    public function validate(?array $image, string $forImage): ?array
    {
        if ($image === null || $image['error'] !== UPLOAD_ERR_OK) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => $forImage,
                    'errorMessage' => 'Não foi possível carregar a fotografia.'
                ]
            ];
        }

        if (!in_array($image['type'], $this->availableType, true)) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => $forImage,
                    'errorMessage' => 'O formato da fotografia não é válido.'
                ]
            ];
        }

        return [
            'success' => true
        ];
    }
}
