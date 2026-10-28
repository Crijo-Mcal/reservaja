<?php

/* namespace public\api\services\client;

use public\api\models\payments;
use public\api\models\bookings;

class Paymnet_update_data_service
{

    private payments\Select $payment_select;
    private payments\Update $payment_update;
    private bookings\Update $bookins_update;
    private bookings\Validation $bookins_validation;
    private payments\Insert $payment_insert;

    public function __construct()
    {
        $this->payment_select = new payments\Select();
        $this->payment_update = new payments\Update();
        $this->payment_insert = new payments\Insert();

        $this->bookins_validation = new bookings\Validation();
        $this->bookins_update = new bookings\Update();
    }

    public function bookingValidationForpayment(array $data): array
    {
        $isBookingValideForPayment = $this->bookins_validation->isBookingValidForPayment($data);

        if ($isBookingValideForPayment) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => 'invalidBooking',
                    'errorMessage' => 'O tempo para concluir a reserva expirou. Por favor, tente novamente.'
                ]
            ];
        }

        $this->bookins_update->UpdateBookingClient($data);
        return ['success' => true,];
    }
}
 */