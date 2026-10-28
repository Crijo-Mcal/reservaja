<?php

namespace public\api\validation\company\profile;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;
use public\api\utility\PhoneValidator;

class Company_Validation
{
    private array $rules;

    public function __construct()
    {
        $this->rules = [
            'company_name' => [
                new Assert\NotBlank(
                    message: 'O nome da empresa é obrigatório.'
                ),
                new Assert\Length(
                    max: 50,
                    maxMessage: 'O nome da empresa não pode ter mais de 50 caracteres.'
                ),
            ],

            'company_phone' => [
                new Assert\NotBlank(
                    message: 'O telefone da empresa é obrigatório.'
                ),
                new Assert\Regex(
                    pattern: '/^[0-9]{9}$/',
                    message: 'O telefone deve ter exatamente 9 dígitos.'
                ),
            ],

            'company_email' => [
                new Assert\NotBlank(
                    message: 'O email da empresa é obrigatório.'
                ),
                new Assert\Email(
                    message: 'O email da empresa não é válido.'
                ),
            ],

            'company_location' => new Assert\Optional([
                new Assert\Length(
                    max: 100,
                    maxMessage: 'A localização não pode ter mais de 100 caracteres.'
                ),
            ]),

            'company_description' => new Assert\Optional([
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

        if (
            isset($data['company_phone']) &&
            !PhoneValidator::isValid($data['company_phone'])
        ) {
            $errors['company_phone'] = 'O telefone da empresa não é válido.';
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