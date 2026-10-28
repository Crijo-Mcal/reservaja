<?php

namespace public\api\validation\company;

use DateTime;

class Schedule_validation
{
    private array $errors = [];

    public function validate(array $data): array
    {
        $this->errors = [];

        $this->validateDate($data['date'] ?? null);

        $this->validateTime($data['start_time'] ?? null);
        $this->validateTime($data['end_time'] ?? null);

        if (
            !$this->hasError() &&
            $data['start_time'] >= $data['end_time']
        ) {
            $this->addError(
                'INVALID_TIME_RANGE',
                'O horário inicial deve ser anterior ao horário final.'
            );
        }

        if (!empty($data['start_lunch']) || !empty($data['end_lunch'])) {
            $this->validateTime($data['start_lunch'] ?? null);
            $this->validateTime($data['end_lunch'] ?? null);

            if (
                !$this->hasError() &&
                $data['start_lunch'] >= $data['end_lunch']
            ) {
                $this->addError(
                    'INVALID_LUNCH_RANGE',
                    'O horário inicial de almoço deve ser anterior ao horário final.'
                );
            }

            if (
                !$this->hasError() &&
                (
                    $data['start_lunch'] < $data['start_time'] ||
                    $data['end_lunch'] > $data['end_time']
                )
            ) {
                $this->addError(
                    'INVALID_LUNCH_RANGE',
                    'O horário de almoço deve estar dentro do horário de trabalho.'
                );
            }
        }

        if (!$this->hasError()) {
            return [
                'success' => true,
                'error' => null
            ];
        }

        return [
            'success' => false,
            'error' => $this->errors
        ];
    }

    private function validateDate(?string $date): void
    {
        if (empty($date)) {
            $this->addError(
                'INVALID_DATE_FORMAT',
                'A data é obrigatória.'
            );
            return;
        }

        $dateObject = DateTime::createFromFormat('!Y-m-d', $date);

        if (
            !$dateObject ||
            $dateObject->format('Y-m-d') !== $date
        ) {
            $this->addError(
                'INVALID_DATE_FORMAT',
                'A data deve estar no formato Y-m-d.'
            );
            return;
        }

        $today = new DateTime('today');

        if ($dateObject < $today) {
            $this->addError(
                'INVALID_DATE_RANGE',
                'A data não pode ser anterior à data atual.'
            );
        }
    }

    private function validateTime(?string $time): void
    {
        if (empty($time)) {
            $this->addError(
                'INVALID_TIME_FORMAT',
                'O horário é obrigatório.'
            );
            return;
        }

        $timeObject = DateTime::createFromFormat('!H:i:s', $time);

        if (
            !$timeObject ||
            $timeObject->format('H:i:s') !== $time
        ) {
            $this->addError(
                'INVALID_TIME_FORMAT',
                'O horário deve estar no formato H:i:s.'
            );
        }
    }

    private function hasError(): bool
    {
        return !empty($this->errors);
    }

    private function addError(
        string $errorType,
        string $errorMessage
    ): void {
        if (!$this->hasError()) {
            $this->errors = [
                'errorType' => $errorType,
                'errorMessage' => $errorMessage
            ];
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}