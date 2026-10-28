<?php

namespace public\api\services\client;

use public\api\models\bookings;
use public\api\models\payments;
use public\api\models\appointments;
use public\api\models\Schedule;
use public\api\models\Services;

class Booking_service
{
    private appointments\Select $appointment_select;

    private payments\Update $payments_update;

    private bookings\Insert $booking_insert;
    private bookings\Update $booking_update;
    private bookings\Select $booking_select;
    private bookings\Validation $booking_validation;

    private Schedule $scheduleTable;
    private Services $serviceTable;

    public function __construct()
    {

        $this->appointment_select = new appointments\Select();
        $this->payments_update = new payments\Update();
        $this->booking_insert = new bookings\Insert();
        $this->booking_update = new bookings\Update();
        $this->booking_select = new bookings\Select();
        $this->booking_validation = new bookings\Validation();

        $this->scheduleTable = new Schedule();
        $this->serviceTable = new Services();
    }

    public function allData(int $professional_id, int $service_id): array
    {
        /* Update Payments expire */
        $this->payments_update->updateAllExpiredPayments();
        
        /* Update Bookings expire */
        $this->booking_update->updateAllExpiredBookings();

        $appointments_datas = $this->appointment_select->selectAppointmentSchedule($professional_id) ?? [];
        $bookings_datas=$this->booking_select->selectBookingSchedule($professional_id);
        $schedules_datas = $this->scheduleTable->selectAllDataByID($professional_id) ?? [];
        $services_datas = $this->serviceTable->selectAllDataByServiceID($service_id) ?? [];


        if (empty($services_datas)) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => 'serviceNotFound',
                    'errorMessage' => 'O serviço selecionado não foi encontrado.'
                ]
            ];
        }


        $service = $services_datas;
        $service_duration = (int) $service['duration'];
        $available_data = [];

        foreach ($schedules_datas as $schedule) {

            /* Generate hours */
            $available_hours = [];

            $start_time = strtotime($schedule['start_time']);
            $end_time = strtotime($schedule['end_time']);

            while ($start_time < $end_time) {
                $available_hours[] = date('H:i', $start_time);
                $start_time += 60 * 60;
            }

            /* Filter lunch */
            if (!empty($schedule['start_lunch']) && !empty($schedule['end_lunch'])) {
                
                $lunch_start = strtotime($schedule['start_lunch']);
                $lunch_end = strtotime($schedule['end_lunch']);

                $available_hours = array_filter(
                    $available_hours,
                    function ($hour) use ($lunch_start, $lunch_end) {
                        $hour_time = strtotime($hour);

                        return $hour_time < $lunch_start ||
                            $hour_time >= $lunch_end;
                    }
                );
            } else {
                $lunch_start = null;
                $lunch_end = null;
            }

            /* Filter appointment */
            foreach ($appointments_datas as $appointment) {
                if ($appointment['appointment_date'] !== $schedule['date']) {
                    continue;
                }

                $available_hours = array_filter(
                    $available_hours,
                    function ($hour) use ($appointment, $service_duration) {
                        $slot_start = strtotime($hour);
                        $slot_end = $slot_start + ($service_duration * 60);

                        $booking_start = strtotime($appointment['appointment_time']);
                        $booking_duration = (int) $appointment['service_duration'];

                        $booking_end = $booking_start +
                            ($booking_duration * 60);

                        return !(
                            $slot_start < $booking_end &&
                            $slot_end > $booking_start
                        );
                    }
                );
            }

            /* Filter appointment */
            foreach ($bookings_datas as $booking) {
                if ($booking['appointment_date'] !== $schedule['date']) {
                    continue;
                }

                $available_hours = array_filter(
                    $available_hours,
                    function ($hour) use ($booking, $service_duration) {
                        $slot_start = strtotime($hour);
                        $slot_end = $slot_start + ($service_duration * 60);

                        $booking_start = strtotime($booking['appointment_time']);
                        $booking_duration = (int) $booking['service_duration'];

                        $booking_end = $booking_start +
                            ($booking_duration * 60);

                        return !(
                            $slot_start < $booking_end &&
                            $slot_end > $booking_start
                        );
                    }
                );
            }

            /* Filter service duration */
            $schedule_end = strtotime($schedule['end_time']);

            $available_hours = array_filter(
                $available_hours,
                function ($hour) use (
                    $service_duration,
                    $schedule_end,
                    $lunch_start,
                    $lunch_end
                ) {
                    $slot_start = strtotime($hour);
                    $slot_end = $slot_start + ($service_duration * 60);

                    if ($slot_end > $schedule_end) {
                        return false;
                    }

                    if (
                        $lunch_start !== null &&
                        $lunch_end !== null &&
                        $slot_start < $lunch_end &&
                        $slot_end > $lunch_start
                    ) {
                        return false;
                    }

                    return true;
                }
            );

            $available_hours = array_values($available_hours);

            if (!empty($available_hours)) {
                $available_data[] = [
                    'id' => $schedule['id'],
                    'date' => $schedule['date'],
                    'available_hours' => $available_hours
                ];
            }
        }

        if (empty($available_data)) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => 'noSchedule',
                    'errorMessage' => 'Este profissional não tem horários disponíveis neste momento.'
                ]
            ];
        }



        return [
            'success' => true,
            'data' => [
                'professional_id' => $professional_id,
                'service_id' => $service_id,

                'service' => [
                    'name' => $service['name'],
                    'duration' => (int) $service['duration'],
                    'price' => (float) $service['price'],
                    'vat' => (float) $service['vat'],
                    'advance_payment' => (float) $service['advance_payment']
                ],

                'available_data' => $available_data
            ]
        ];
    }

    public function insertData(array $data): array
    {
        $isServiceValid = $this->serviceTable->isServiceExist($data);


        if (!$isServiceValid) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => 'invalidBooking',
                    'errorMessage' => 'O serviço selecionado não é válido.'
                ]
            ];
        }



        $isDateValid = $this->scheduleTable->cheackDateByDate($data['professional_id'], $data['appointment_date']);

        if (!$isDateValid) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => 'invalidBooking',
                    'errorMessage' => 'A agenda deste profissional está cheia neste momento.'
                ]
            ];
        }

        $hasBookingConflict = $this->booking_validation->isBookingConflict($data);

        if ($hasBookingConflict) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => 'invalidBooking',
                    'errorMessage' => 'O horário selecionado já foi escolhido por outro cliente.'
                ]
            ];
        }
        /* Create booking */
        $this->booking_insert->insert($data);

        $booking_id = $this->booking_select->selectLastBookingId($data['professional_id']);

        return [
            'success' => true,
            'data' => [
                'booking_id' => (string) $booking_id
            ]
        ];
    }
}
