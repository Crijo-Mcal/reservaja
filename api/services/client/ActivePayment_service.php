<?php

namespace public\api\services\client;

use public\api\models\payments;
use public\api\models\bookings;

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

    /*
     * Cancela o pagamento da reserva identificada pelo token.
     * O id da reserva e o URL da Ifthenpay vêm da base de dados, nunca do pedido.
     */
    public function cancel_payment(string $booking_token, int $client_id): bool
    {
        $payment = $this->payments_select->selectPendingPaymentByBookingToken($booking_token, $client_id);

        // Não existe, já não está pendente, ou pertence a outro cliente
        if (!$payment) {
            return false;
        }

        //disable pinpay
        if (!empty($payment['redirect_url'])) {
            $this->disablePinpay($payment['redirect_url']);
        }

        //update table payment and booking
        $this->payments_update->cancelPayment((int) $payment['booking_id']);

        return true;
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

        // Sem var_dump: qualquer saída aqui impedia o redirecionamento do controller
        if ($response === false || $httpCode < 200 || $httpCode >= 300) {
            error_log('Ifthenpay disable pinpay falhou: HTTP ' . $httpCode . ' ' . (string) $response);
        }
    }
}
