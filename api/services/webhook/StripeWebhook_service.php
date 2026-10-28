<?php

namespace public\api\services\webhook;

use public\api\models\payments;
use public\api\models\appointments;
use public\api\models\bookings;
use public\api\utility\Notification;

class StripeWebhook_service
{
    private bookings\Update $bookings_update;
    private payments\Update $payment_update;
    private appointments\Update $appointments_update;
    private appointments\Insert $appointments_Insert;
    private appointments\Select $appointments_select;
    private Notification $notification;


    public function __construct()
    {
        $this->bookings_update = new bookings\Update();
        $this->payment_update = new payments\Update();
        $this->appointments_select = new appointments\Select();
        $this->appointments_update = new appointments\Update();
        $this->appointments_Insert = new appointments\Insert();
        $this->notification = new Notification();

    }

    public function payment_booking_success(array $data)
    {
        $this->appointments_Insert->insert($data['booking_id']);
        $this->payment_update->updateAsPaid($data);

        $appointment_data = $this->appointments_select
            ->selectAppointmentNotificationDataByBookingId($data['booking_id']);

        if ($appointment_data) {
            $this->notification->email(
                $appointment_data['client_email'],
                'Agendamento confirmado - ReservaJa',
                "
            <h2>Olá, {$appointment_data['client_name']}!</h2>

            <p>O seu agendamento foi confirmado com sucesso.</p>

            <p>
                <strong>Número do agendamento:</strong> #{$appointment_data['appointment_id']}<br>
                <strong>Serviço:</strong> {$appointment_data['service_name']}<br>
                <strong>Data:</strong> {$appointment_data['appointment_date']}<br>
                <strong>Hora:</strong> {$appointment_data['appointment_time']}
            </p>

            <p>Obrigado por utilizar a ReservaJá.</p>
           "
            );
        }
    }

    public function payment_booking_failed(array $data)
    {
        $this->payment_update->updateAsFailed($data);
        $this->bookings_update->UpdateBookingCancel($data['booking_id']);
    }


}
