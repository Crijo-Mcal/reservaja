<?php

namespace public\api\services\client;

use Stripe\Stripe;
use public\api\models\payments;
use public\api\models\bookings;
use Stripe\Checkout\Session;

class ActivePayment_service
{

    private payments\Insert $payments_insert;
    private payments\Select $payments_select;
    private payments\Update $payments_update;
    private bookings\Validation $bookings_validation;
    private bookings\Update $bookings_update;

    public function __construct()
    {
        $this->payments_insert = new payments\Insert();
        $this->payments_select = new payments\Select();
        $this->payments_update = new payments\Update();
        $this->bookings_update = new bookings\Update();
        $this->bookings_validation = new bookings\Validation();
    }

    public function alldata(int $client_id): array
    {
        return $this->payments_select->selectPendingPaymentsByClientId($client_id);
    }

    public function cancel_payment(array $data): void
    {

        //disable pinpay
        $this->disablePinpay($data['url']);
        //update table payment and booking
        $this->payments_update->cancelPayment($data['booking_id']);
    }

    private function disablePinpay(string $url): void
    {
        $gatewayKey = $_ENV['GATEWAY_KEY'];
        $requestStatus = 'disable';

        $data = [
            'url' => $url,
        ];

        $endpoint = "https://api.ifthenpay.com/gateway/pinpay/{$gatewayKey}/{$requestStatus}/";

        $curl = curl_init($endpoint);

        curl_setopt_array($curl, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($curl);

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);
        var_dump($response); 
        var_dump($httpCode);

    }
}
