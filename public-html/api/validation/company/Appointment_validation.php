<?php

namespace public\api\validation\company;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;


class Appointment_validation
{

    private array $allRules;

    public function __construct()
    {

        $this->allRules = [

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

            'booking_id' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'O ID da reserva é obrigatório.'
                ),
                new Assert\Type(
                    type: 'integer',
                    message: 'O ID da reserva deve ser um número inteiro.'
                ),
                new Assert\Positive(
                    message: 'O ID da reserva deve ser maior que zero.'
                ),
            ]),

            'appointment_date' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'A data do agendamento é obrigatória.'
                ),
                new Assert\Date(
                    message: 'A data do agendamento deve ser válida.'
                ),
            ]),

            'appointment_time' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'A hora do agendamento é obrigatória.'
                ),
                new Assert\Time(
                    withSeconds: false,
                    message: 'A hora do agendamento deve ser válida.'
                ),
            ]),

            'appointment_end' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'A hora do agendamento é obrigatória.'
                ),
                new Assert\Time(
                    withSeconds: false,
                    message: 'A hora do agendamento deve ser válida.'
                ),
            ]),

            'service_duration' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'A duração do serviço é obrigatória.'
                ),
                new Assert\Type(
                    type: 'integer',
                    message: 'A duração do serviço deve ser um número inteiro.'
                ),
                new Assert\Positive(
                    message: 'A duração do serviço deve ser maior que zero.'
                ),
                new Assert\LessThanOrEqual(
                    value: 600,
                    message: 'A duração do serviço não pode ser superior a 600 minutos.'
                ),
            ]),

            'appointment_status' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'O estado do agendamento é obrigatório.'
                ),
                new Assert\Choice(
                    choices: [
                        'scheduled',
                        'completed',
                        'no_show',
                        'cancelled'
                    ],
                    message: 'O estado do agendamento não é válido.'
                ),
            ]),
        ];
    }

    public function validate(array $data_input)
    {

        if (isset($data_input['appointment_date']) && strtotime($data_input['appointment_date']) < strtotime(date('Y-m-d'))) {
            return [
                'success' => false,
                'errorMessage' => 'A data do agendamento deve ser hoje ou uma data futura.'
            ];
        }


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


        $violations = $validator->validate(
            $data,
            $constraints
        );


        if ($violations->count() === 0) {
            return ['success' => true];
        }

        return [
            'success' => false,
            'errorMessage' => $violations[0]->getMessage()
        ];
    }
}
