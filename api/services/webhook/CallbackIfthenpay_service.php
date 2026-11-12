<?php

namespace public\api\services\webhook;

use public\api\models\payments;
use public\api\models\appointments;
use public\api\models\bookings;
use public\api\utility\Notification;

class CallbackIfthenpay_service
{
    private bookings\Update $bookings_update;
    private payments\Update $payment_update;
    private appointments\Update $appointments_update;
    private appointments\Insert $appointments_Insert;
    private appointments\Select $appointments_select;
    private Notification $notification;
    private payments\Select $payments_select;


    public function __construct()
    {
        $this->bookings_update = new bookings\Update();
        $this->payment_update = new payments\Update();
        $this->payments_select = new payments\Select();
        $this->appointments_select = new appointments\Select();
        $this->appointments_update = new appointments\Update();
        $this->appointments_Insert = new appointments\Insert();
        $this->notification = new Notification();

    }

    public function payment_booking_success(array $data): string
    {
        $payment = $this->payments_select->selectPaymentById($data['payment_id']);

        if (!$payment) {
            error_log('Ifthenpay callback: pagamento não encontrado id=' . $data['payment_id']);
            return 'not_found';
        }

        // A Ifthenpay pode repetir o callback: não criar o agendamento duas vezes
        if ($payment['status'] === 'paid') {
            return 'already_paid';
        }

        $data['booking_id'] = (int) $payment['booking_id'];

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

        return 'ok';
    }

}
