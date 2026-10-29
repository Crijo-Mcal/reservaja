<?php

namespace public\api\validation\client;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class Booking_validation
{
    private array $rules;

    public function __construct()
    {
        $this->rules = [
            'professional_id' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'O profissional é obrigatório.'
                ),
                new Assert\Regex(
                    pattern: '/^[1-9][0-9]*$/',
                    message: 'O ID do profissional deve ser válido.'
                ),
            ]),

            'service_id' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'O serviço é obrigatório.'
                ),
                new Assert\Regex(
                    pattern: '/^[1-9][0-9]*$/',
                    message: 'O ID do serviço deve ser válido.'
                ),
            ]),

            'service_name' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'O nome do serviço é obrigatório.'
                ),
                new Assert\Length(
                    max: 255,
                    maxMessage: 'O nome do serviço não pode ter mais de 255 caracteres.'
                ),
            ]),

            'service_duration' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'A duração do serviço é obrigatória.'
                ),
                new Assert\Regex(
                    pattern: '/^[1-9][0-9]*$/',
                    message: 'A duração do serviço deve ser um número inteiro positivo.'
                ),
            ]),

            'service_price' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'O preço do serviço é obrigatório.'
                ),
                new Assert\Regex(
                    pattern: '/^\d+(\.\d{1,2})?$/',
                    message: 'O preço do serviço deve ter um formato monetário válido.'
                ),
            ]),

            'service_vat' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'O IVA do serviço é obrigatório.'
                ),
                new Assert\Regex(
                    pattern: '/^\d+(\.\d{1,2})?$/',
                    message: 'O IVA do serviço deve ser numérico.'
                ),
                new Assert\Range(
                    min: 0,
                    max: 100,
                    notInRangeMessage: 'O IVA deve estar entre 0 e 100.'
                ),
            ]),

            'service_advance_payment' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'O pagamento antecipado é obrigatório.'
                ),
                new Assert\Regex(
                    pattern: '/^\d+(\.\d{1,2})?$/',
                    message: 'O pagamento antecipado deve ser numérico.'
                ),
                new Assert\Range(
                    min: 0,
                    max: 100,
                    notInRangeMessage: 'O pagamento antecipado deve estar entre 0 e 100.'
                ),
            ]),

            'appointment_date' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'A data da marcação é obrigatória.'
                ),
                new Assert\Date(
                    message: 'A data da marcação deve ter um formato válido.'
                ),
            ]),

            'appointment_time' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'A hora da marcação é obrigatória.'
                ),
                new Assert\Regex(
                    pattern: '/^(?:[01]\d|2[0-3]):[0-5]\d$/',
                    message: 'A hora da marcação deve ter o formato HH:MM.'
                ),
            ]),

            'appointment_end' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'A hora de fim da marcação é obrigatória.'
                ),
                new Assert\Regex(
                    pattern: '/^(?:[01]\d|2[0-3]):[0-5]\d$/',
                    message: 'A hora de fim deve ter o formato HH:MM.'
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
            allowMissingFields: false
        );

        $violations = $validator->validate(
            $data,
            $constraints
        );

        if (count($violations) > 0) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => 'invalidBooking',
                    'errorMessage' => $violations->get(0)->getMessage(),
                ],
            ];
        }

        return [
            'success' => true,
            'error' => null,
        ];
    }
}