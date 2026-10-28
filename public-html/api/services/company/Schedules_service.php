<?php

namespace public\api\services\company;

use public\api\models\Schedule;

class Schedules_service
{

    private Schedule $scheduleTable;

    public function __construct()
    {
        $this->scheduleTable = new Schedule;
    }

    public function showAllService(int $professional_id): ?array
    {
        return $this->scheduleTable->selectAllDataByID($professional_id);
    }

    public function addNewService(int $id, array $data): void
    {

        $this->scheduleTable->insert($id, $data);
    }

    public function updateSchedule(
        int $professional_id,
        array $data
    ): array {
        $isDateExist = $this->scheduleTable->isDateExist($professional_id, $data['date'], $data['id']);
        $isDateBooked = $this->scheduleTable->checkScheduleBooked($professional_id, $data['id']);

        if ($isDateExist) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => 'updateSchedule',
                    'errorMessage' => "Já existe um horário cadastrado para data {$data['date']}."
                ]
            ];
        }

        if ($isDateBooked) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => 'updateSchedule',
                    'errorMessage' => "Não é possível alterar este horário porque já existem agendamentos para a data {$data['date']}."
                ]
            ];
        }


        $this->scheduleTable->update(
            $professional_id,
            $data
        );
        return ['success' => true,];
    }

    public function deleteSchedule(
        array $data
        ): array {
        $isDateBooked = $this->scheduleTable->checkScheduleBooked($data['professional_id'], $data['schedule_id']);

        if ($isDateBooked) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => 'updateSchedule',
                    'errorMessage' => "Não é possível alterar este horário porque já existe outro agendamento nesta data."
                ]
            ];
        }

        $this->scheduleTable->delete(
            $data['professional_id'],
            $data['schedule_id']
        );

        return ['success' => true];
    }
}
