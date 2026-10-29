<?php

namespace public\api\validation\auth_validation;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class Login_validation
{
    private array $rules;

    public function __construct() {
        
        $this->rules = [
            'email' => [
                new Assert\NotBlank(
                    message: 'O e-mail é obrigatório.'
                ),
                new Assert\Email(
                    message: 'O e-mail deve ser válido.'
                ),
            ],

            'password' => [
                new Assert\NotBlank(
                    message: 'A palavra-passe é obrigatória.'
                ),
            ],
        ];
    }

    public function login(array $data): array
    {
        $validator = Validation::createValidator();

        $constraints = new Assert\Collection(
            $this->rules
        );

        $violations = $validator->validate(
            $data,
            $constraints
        );

        $errors = [];

        foreach ($violations as $violation) {

            $propertyPath = trim(
                $violation->getPropertyPath(),
                '[]'
            );

            $errors[$propertyPath] = $violation->getMessage();
        }

        return $errors;
    }
}