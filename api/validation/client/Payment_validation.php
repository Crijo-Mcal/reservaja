<?php

namespace public\api\validation\client;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;
use public\api\utility\PhoneValidator;
use public\api\utility\NifValidator;

class Payment_validation
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
                    message: 'O ID do profissional é inválido.'
                ),
            ]),

            'booking_id' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'A marcação é obrigatória.'
                ),
                new Assert\Regex(
                    pattern: '/^[1-9][0-9]*$/',
                    message: 'O ID da marcação é inválido.'
                ),
            ]),

            'client_id' => new Assert\Optional(),

            'service_name' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'O nome do serviço é obrigatório.'
                ),
            ]),

            'service_price' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'O preço do serviço é obrigatório.'
                ),
                new Assert\Regex(
                    pattern: '/^\d+(\.\d{1,2})?$/',
                    message: 'O preço do serviço é inválido.'
                ),
            ]),

            'service_vat' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'O IVA do serviço é obrigatório.'
                ),
                new Assert\Regex(
                    pattern: '/^\d+(\.\d{1,2})?$/',
                    message: 'O IVA do serviço é inválido.'
                ),
                new Assert\Range(
                    min: 0,
                    max: 100,
                    notInRangeMessage: 'O IVA deve estar entre 0 e 100%.'
                ),
            ]),

            'service_advance_payment' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'A percentagem de pagamento antecipado é obrigatória.'
                ),
                new Assert\Regex(
                    pattern: '/^\d+(\.\d{1,2})?$/',
                    message: 'A percentagem de pagamento antecipado é inválida.'
                ),
                new Assert\Range(
                    min: 0,
                    max: 100,
                    notInRangeMessage: 'A percentagem de pagamento antecipado deve estar entre 0 e 100%.'
                ),
            ]),

            'client_name' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'O nome é obrigatório.'
                ),
            ]),

            'client_mobile' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'O telemóvel é obrigatório.'
                ),
                new Assert\Length(
                    min: 9,
                    max: 9,
                    exactMessage: 'O número de telemóvel deve ter 9 dígitos.'
                ),
            ]),

            'client_email' => new Assert\Required([
                new Assert\NotBlank(
                    message: 'O e-mail é obrigatório.'
                ),
                new Assert\Email(
                    message: 'O e-mail não é válido.'
                ),
            ]),

            'client_tax_number' => new Assert\Optional([
                new Assert\Type(
                    type: 'string',
                    message: 'O número de contribuinte deve ser um texto.'
                ),
                new Assert\Regex(
                    pattern: '/^\d{9}$/',
                    message: 'O número de contribuinte deve ter exatamente 9 dígitos.'
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

            $violation = $violations[0];

            return [
                'success' => false,
                'error' => [
                    'errorType' => 'invalidPayment',
                    'errorMessage' => $violation->getMessage(),
                ],
            ];
        }

        if (empty($data['client_mobile']) || !PhoneValidator::isValid($data['client_mobile'])) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => 'invalidPayment',
                    'errorMessage' =>
                    'O número de telemóvel não é válido.',
                ],
            ];
        }

        if ($data['client_tax_number'] && !NifValidator::isValid($data['client_tax_number'])) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => 'invalidPayment',
                    'errorMessage' =>
                    'O número de contribuente não é válido.',
                ],
            ];
        }

        return [
            'success' => true,
            'error' => null,
        ];
    }
}
