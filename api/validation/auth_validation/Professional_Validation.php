<?php

namespace public\api\validation\auth_validation;

use public\api\utility\NifValidator;
use public\api\utility\PhoneValidator;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class Professional_validation
{
    private array $rules;

    public function __construct()
    {
        $this->rules = [
            'first_name' => [
                new Assert\NotBlank(
                    message: 'O nome é obrigatório.'
                ),
            ],

            'last_name' => [
                new Assert\NotBlank(
                    message: 'O apelido é obrigatório.'
                ),
            ],

            'email' => [
                new Assert\NotBlank(
                    message: 'O e-mail é obrigatório.'
                ),
                new Assert\Email(
                    message: 'O e-mail deve ser válido.'
                ),
            ],

            'tax_number' => [
                new Assert\NotBlank(
                    message: 'O número de identificação fiscal é obrigatório.'
                ),
                new Assert\Length(
                    min: 9,
                    max: 9,
                    exactMessage: 'O número de identificação fiscal deve ter exatamente 9 caracteres.'
                ),
            ],

            'mobile_number' => [
                new Assert\NotBlank(
                    message: 'O número de telemóvel é obrigatório.'
                ),
            ],

            'password' => [
                new Assert\NotBlank(
                    message: 'A palavra-passe é obrigatória.'
                ),
                new Assert\Length(
                    min: 8,
                    minMessage: 'A palavra-passe deve ter pelo menos 8 caracteres.'
                ),
            ],

            'password_confirmation' => [
                new Assert\NotBlank(
                    message: 'A confirmação da palavra-passe é obrigatória.'
                ),
            ],
        ];
    }

    public function singupFrom(array $data): array
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

            $errors[$propertyPath] =
                $violation->getMessage();
        }

        // Custom validation NIF
        if (!NifValidator::isValid($data['tax_number'])) {
            $errors['tax_number'] =
                'O número de contribuinte não é válido.';
        }

        // Custom validation número de telemóvel
        if (
            isset($data['mobile_number']) &&
            !PhoneValidator::isValid($data['mobile_number'])
        ) {
            $errors['mobile_number'] =
                'O número de telemóvel não é válido.';
        }

        // Custom validation password confirmation
        if (
            isset(
                $data['password'],
                $data['password_confirmation']
            ) &&
            $data['password'] !== $data['password_confirmation']
        ) {
            $errors['password_confirmation'] =
                'A confirmação da palavra-passe não corresponde à palavra-passe.';
        }

        return $errors;
    }
}