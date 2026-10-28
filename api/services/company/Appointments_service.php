<?php

namespace public\api\services\company;

use public\api\models\appointments;
use public\api\models\bookings;

class Appointments_service
{

    private appointments\Count $appointments_count;
    private appointments\Select $appointments_select;
    private appointments\Update $appointments_update;
    private appointments\Validation $appointments_validation;

       private bookings\Validation $booking_validation;


    public function __construct()
    {

        $this->appointments_count = new appointments\Count();
        $this->appointments_select = new appointments\Select();
        $this->appointments_update = new appointments\Update();
        $this->appointments_validation= new appointments\Validation();

        $this->booking_validation= new bookings\Validation();
    }

    public function getallDatas(string $professional_id)
    {
        $avaliable_Dates = $this->avaliable_Dates($professional_id);
        $summary = $this->appointment_summary($professional_id);
        $datas_appointments = $this->appointments_select->selectTodayAppointment($professional_id);
        $today = date('Y-m-d');
        return [
            'avaliable_Date' => $avaliable_Dates,
            'summary' => $summary,
            'appointments_datas' => $datas_appointments,
            'string_date' => $this->formatDatePortuguese($today)
        ];
    }

    public function filterDatas(array $data_input)
    {
        $professional_id = $data_input['professional_id'];
        $appointment_id = $data_input['appointment_id'];
        $date = $data_input['date'];

        $avaliable_Dates = $this->avaliable_Dates($professional_id);
        $summary = $this->appointment_summary($professional_id);
        $datas_appointments = [];

        if ($appointment_id && $date) {
            $datas_appointments = $this->appointments_select->selectAppointmentByDateAndId($date,(int) $appointment_id);
        } elseif ($appointment_id) {
            $datas_appointments = $this->appointments_select->selectAppointmentById((int) $appointment_id);
        } elseif ($date) {
            $datas_appointments = $this->appointments_select->selectAppointmentByDate($date);
        }

        return [
            'avaliable_Date' => $avaliable_Dates,
            'summary' => $summary,
            'appointments_datas' => $datas_appointments,
            'string_date' => $this->formatDatePortuguese($date),
        ];
    }

    public function update_Data(array $data_input): array
    {
        $appointmentConflict = $this->appointments_validation->isAppointmentConflict($data_input);


        if ($appointmentConflict) {
            return [
                'success' => false,
                'errorMessage' => 'O agendamento está sobreposto com outro agendamento existente.'
            ];
        }


        $this->appointments_update->updateAppointment($data_input);

        return ['success' => true];
    }

    private function avaliable_Dates(int $professional_id): array
    {
        $datas_schedule = $this->appointments_select->selectappointmentDates($professional_id);

        return $datas_schedule;
    }


    private function appointment_summary(int $professional_id): array
    {
        $today = $this->appointments_count->countTodayAppointment($professional_id);
        $scheduled = $this->appointments_count->countScheduledAppointment($professional_id);
        $completed = $this->appointments_count->countCompletedAppointment($professional_id);
        $total = $this->appointments_count->countAllAppointment($professional_id);

        return [
            'today' => $today,
            'scheduled' => $scheduled,
            'completed' => $completed,
            'total' => $total
        ];
    }

    private function formatDatePortuguese(string $date): string
    {
        $months = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro'
        ];

        $timestamp = strtotime($date);

        return date('d', $timestamp) . ' ' .
            $months[(int) date('m', $timestamp)] . ' ' .
            date('Y', $timestamp);
    }
}
