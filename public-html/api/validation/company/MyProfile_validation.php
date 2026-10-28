<?php

namespace public\api\validation\company;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class MyProfile_Validation
{
    private array $allRules;

    public function __construct()
    {
        $this->allRules = [

            'id' => new Assert\Optional([
                new Assert\NotBlank(
                    message: 'O ID do profissional é obrigatório.'
                ),
                new Assert\Type(
                    type: 'integer',
                    message: 'O ID do profissional deve ser um número inteiro.'
                ),
                new Assert\Positive(
                    message: 'O ID do profissional deve ser maior que zero.'
                ),
            ]),

            'name' => new Assert\Optional([
                new Assert\Type(
                    type: 'string',
                    message: 'O nome deve ser um texto.'
                ),
                new Assert\Length(
                    max: 100,
                    maxMessage: 'O nome não pode ter mais de 100 caracteres.'
                ),
            ]),
            'speciality' => new Assert\Optional([
                new Assert\Type(
                    type: 'string',
                    message: 'A especialidade deve ser um texto.'
                ),
                new Assert\Length(
                    max: 100,
                    maxMessage: 'A especialidade não pode ter mais de 100 caracteres.'
                ),
            ]),
            'mobile_number' => new Assert\Optional([
                new Assert\Regex(
                    pattern: '/^[0-9]{9}$/',
                    message: 'O número de telemóvel deve ter exatamente 9 dígitos.'
                ),
            ]),
            'description' => new Assert\Optional([
                new Assert\Type(
                    type: 'string',
                    message: 'A descrição deve ser um texto.'
                ),
                new Assert\Length(
                    max: 1000,
                    maxMessage: 'A descrição não pode ter mais de 1000 caracteres.'
                ),
            ]),
            'company_phone' => new Assert\Optional([
                new Assert\Regex(
                    pattern: '/^[0-9]{9}$/',
                    message: 'O número de telefone da empresa deve ter exatamente 9 dígitos.'
                ),
            ]),
            'company_email' => new Assert\Optional([
                new Assert\Email(
                    message: 'O e-mail da empresa deve ser válido.'
                ),
            ]),
            'company_location' => new Assert\Optional([
                new Assert\Type(
                    type: 'string',
                    message: 'A localização deve ser um texto.'
                ),
                new Assert\Length(
                    max: 255,
                    maxMessage: 'A localização não pode ter mais de 255 caracteres.'
                ),
            ]),
            'company_website' => new Assert\Optional([
                new Assert\Url(
                    message: 'O website da empresa deve ser um URL válido.'
                ),
            ]),
            'company_description' => new Assert\Optional([
                new Assert\Type(
                    type: 'string',
                    message: 'A descrição da empresa deve ser um texto.'
                ),
                new Assert\Length(
                    max: 1000,
                    maxMessage: 'A descrição da empresa não pode ter mais de 1000 caracteres.'
                ),
            ]),

            'role_company' => new Assert\Optional([
                new Assert\Choice(
                    choices: ['owner', 'employee', 'technician'],
                    message: 'A função selecionada não é válida.'
                ),
            ]),
            'status' => new Assert\Optional([
                new Assert\Choice(
                    choices: ['active', 'inactive'],
                    message: 'O estado selecionado não é válido.'
                ),
            ]),


        ];
    }

    public function validate(array $data_input): array
    {
        $rules = [];
        $data = [];

        foreach ($data_input as $key => $value) {
            if (!isset($this->allRules[$key])) {
                return [
                    'success' => false,
                    'errorMessage' => "O campo '{$key}' não é permitido."
                ];
            }

            $rules[$key] = $this->allRules[$key];
            $data[$key] = $value;
        }

        $validator = Validation::createValidator();

        $constraints = new Assert\Collection(
            fields: $rules,
            allowExtraFields: false,
            allowMissingFields: true
        );

        $violations = $validator->validate($data, $constraints);

        if ($violations->count() === 0) {
            return [
                'success' => true
            ];
        }

        return [
            'success' => false,
            'errorMessage' => $violations[0]->getMessage()
        ];
    }
}
