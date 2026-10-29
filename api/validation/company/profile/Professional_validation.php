<?php

namespace public\api\validation\company\profile;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;
use public\api\utility\PhoneValidator;

class Professional_validation
{

    private array $rules;

    public function __construct()
    {
        $this->rules = [

            'professional_name' => [
                new Assert\NotBlank(
                    message: 'O nome é obrigatório.'
                ),
                new Assert\Length(
                    max: 50,
                    maxMessage: 'O nome não pode ter mais de 100 caracteres.'
                ),
            ],

            'speciality' => [
                new Assert\NotBlank(
                    message: 'O nome é obrigatório.'
                ),
                new Assert\Length(
                    max: 500,
                    maxMessage: 'A especialidade não pode ter mais de 500 caracteres.'
                ),
            ],

            'professional_number' => [
                new Assert\NotBlank(
                    message: 'O nome é obrigatório.'
                ),
                new Assert\Regex(
                    pattern: '/^[0-9]{9}$/',
                    message: 'O número de telemóvel deve ter exatamente 9 dígitos.'
                ),
            ],

            'description' => new Assert\Optional([
                new Assert\Length(
                    max: 1000,
                    maxMessage: 'A descrição não pode ter mais de 1000 caracteres.'
                ),
            ]),
        ];
    }

    public function validate(array $data): array
    {
        $validator = Validation::createValidator();

        $constraints = new Assert\Collection(
            fields: $this->rules,
            allowExtraFields: false,
            allowMissingFields: true
        );

        $violations = $validator->validate(
            $data,
            $constraints
        );

        $errors = [];

        // Custom validation número de telemóvel
        if (
            isset($data['professional_number']) &&
            !PhoneValidator::isValid($data['professional_number'])
        ) {
            $errors['professional_number'] =
                'O número de telemóvel não é válido.';
        }

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
