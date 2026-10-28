<?php

namespace public\api\validation\company;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class Rating_validation
{
    private array $allRules;

    public function __construct()
    {
        $this->allRules = [

        'client_id' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'O ID do Cliente é obrigatório.'
                ),
                new Assert\Type(
                    type: 'integer',
                    message: 'O ID do Cliente deve ser um número inteiro.'
                ),
                new Assert\Positive(
                    message: 'O ID do Cliente deve ser maior que zero.'
                ),
            ]),

            'appointment_id' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'O ID do agendamento é obrigatório.'
                ),
                new Assert\Type(
                    type: 'integer',
                    message: 'O ID do agendamento deve ser um número inteiro.'
                ),
                new Assert\Positive(
                    message: 'O ID do agendamento deve ser maior que zero.'
                ),
            ]),

            'rating' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'A avaliação é obrigatória.'
                ),
                new Assert\Type(
                    type: 'integer',
                    message: 'A avaliação deve ser um número inteiro.'
                ),
                new Assert\Range(
                    min: 1,
                    max: 5,
                    notInRangeMessage: 'A avaliação deve estar entre 1 e 5.'
                ),
            ]),

            'description' => new Assert\Optional([
                new Assert\Type(
                    type: 'string',
                    message: 'A descrição deve ser um texto.'
                ),
                new Assert\Length(
                    max: 500,
                    maxMessage: 'A descrição não pode ter mais de 500 caracteres.'
                ),
            ]),
        ];
    }

    public function validate(array $data_input): array
    {
        $rules = [];
        $data = [];

        foreach ($data_input as $key => $value) {
            if (isset($this->allRules[$key])) {
                $rules[$key] = $this->allRules[$key];
                $data[$key] = $value;
            }
        }

        $validator = Validation::createValidator();

        $constraints = new Assert\Collection(
            fields: $rules,
            allowExtraFields: false,
            allowMissingFields: true
        );

        $violations = $validator->validate(
            $data,
            $constraints
        );

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