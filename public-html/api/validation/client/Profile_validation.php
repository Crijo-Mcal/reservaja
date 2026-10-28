<?php

namespace public\api\validation\client;

use public\api\utility\NifValidator;
use public\api\utility\PhoneValidator;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;


class Profile_validation
{
    private array $rules;

    public function __construct()
    {
        $this->rules = [
            'name' => [
                new Assert\NotBlank(
                    message: 'O primeiro nome é obrigatório.'
                ),
                new Assert\Length(
                    max: 100,
                    maxMessage: 'O primeiro nome não pode ter mais de 100 caracteres.'
                ),
            ],


            'birth_date' => [
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

            'address' => new Assert\Optional([
                new Assert\Length(
                    max: 255,
                    maxMessage: 'A morada não pode ter mais de 255 caracteres.'
                ),
            ]),

            'postal_code' => new Assert\Optional([
                new Assert\Regex(
                    pattern: '/^\d{4}-\d{3}$/',
                    message: 'O código postal deve ter o formato 0000-000.'
                ),
            ]),

            'city' => new Assert\Optional([
                new Assert\Length(
                    max: 100,
                    maxMessage: 'A localidade não pode ter mais de 100 caracteres.'
                ),
            ]),
        ];
    }

    public function validate(array $data): array
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

        return $errors;
    }
}
