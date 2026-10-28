<?php

namespace public\api\validation\auth_validation;

use public\api\utility\NifValidator;
use public\api\utility\PhoneValidator;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;


class Client_validation
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

            'date_of_birth' => [
                new Assert\NotBlank(
                    message: 'A data de nascimento é obrigatória.'
                ),
                new Assert\Date(
                    message: 'A data de nascimento deve ser válida.'
                ),
            ],

            'tax_number' => new Assert\Optional([
                new Assert\Regex(
                    pattern: '/^\d{9}$/',
                    message: 'O número de contribuinte deve ter exatamente 9 dígitos.'
                ),
            ]),

            'mobile_number' => [
                new Assert\NotBlank(
                    message: 'O número de telemóvel é obrigatório.'
                ),
                new Assert\Length(
                    min: 9,
                    max: 9,
                    exactMessage: 'O número de telemóvel deve ter 9 dígitos.'
                ),
                new Assert\Regex(
                    pattern: '/^9\d{8}$/',
                    message: 'O número de telemóvel deve ser válido.'
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

    public function singup(array $data): array
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


        /* custom vatidation */
        /* nif */
        if ($data['tax_number'] && !NifValidator::isValid($data['tax_number'])) {
            $errors['tax_number'] =
                'O número de contribuinte não é válido.';
        }

        /* numeru telemovel portugal */
        if (
            isset($data['mobile_number']) &&
            !PhoneValidator::isValid($data['mobile_number'])
        ) {
            $errors['mobile_number'] =
                'O número de telemóvel não é válido.';
        }

        /* password confirmation */
        if (
            isset($data['password'], $data['password_confirmation']) &&
            $data['password'] !== $data['password_confirmation']
        ) {
            $errors['password_confirmation'] =
                'A confirmação da palavra-passe não corresponde à palavra-passe.';
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
