<?php

namespace public\api\services\client;

use public\api\models\payments;
use public\api\models\bookings;

class Payment_service
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

    public function processPayment(array $data, string $appBasePath)
    {
        $isBookingConflict = $this->bookings_validation->isBookingValidForPayment($data['booking_id']);


        if (!$isBookingConflict) {
            return [
                'success' => false,
                'error' => [
                    'errorType' => 'invalidBooking',
                    'errorMessage' => 'A marcação já não está disponível porque foi reservada por outro cliente.'
                ]
            ];
        }

        // update data booking
        $this->bookings_update->UpdateBookingClient($data);

        //iser payment
        $this->payments_insert->insert($data);
        $payment_id = $this->payments_select->selectLastPaymentId();
        $data['payment_id'] = $payment_id;


        $checkout = $this->createPinPay($data, $appBasePath);

        $this->payments_update->updatePaymentFromIfthepay($checkout['data']);

        return $checkout;
    }

    function createPinPay(array $data, string $appBasePath): array
    {

        $expirationDate = date('Ymd', strtotime('+2 day'));

        $servicePrice = (float) $data['service_price'];
        $advancePayment = (float) $data['service_advance_payment'];
        $amount = $servicePrice * ($advancePayment / 100);
        //number_format($amount, 2, '.', '')

        $url = 'https://api.ifthenpay.com/gateway/pinpay/' . $_ENV['GATEWAY_KEY'];

        $CloseUrl = isset($_SESSION['user'])
            ? '/html/client/active_payment.php'
            : '/html/client/professionals.php';

        $payload = [
            'id' => $data['payment_id'],
            'amount' => '1.00',
            'description' => $data['service_name'],
            'accounts' => "MBWAY|{$_ENV['MBWAY_KEY']};MB|{$_ENV['MB_KEY']};CCARD|{$_ENV['CCARD_KEY']}",
            'expiredate' => $expirationDate,
            'success_url' => $_ENV['APP_URL'] . ($appBasePath ?? '') . '/html/client/payment/payment_success.php',
            'error_url' => $_ENV['APP_URL'] . ($appBasePath ?? '') . '/html/client/payment/payment_failed.php',
            'cancel_url' => $_ENV['APP_URL'] . ($appBasePath ?? '') . '/html/client/payment/payment_failed.php',
            'btnCloseUrl' => $_ENV['APP_URL'] . ($appBasePath ?? '') .  $CloseUrl,
            'btnCloseLabel' => 'Voltar',
            'otp' => 'true',
            'lang' => 'pt',
            'selected_method' => '1',
        ];


        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);

            echo 'Request gagal: ' . $error;
            exit;
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $dataIfthepay = json_decode($response, true);


        if ($statusCode < 200 || $statusCode >= 300) {
            echo 'Ifthenpay HTTP error: ' . $statusCode;
            echo '<pre>' . htmlspecialchars($response) . '</pre>';
            exit;
        }

        if (!is_array($dataIfthepay)) {
            echo 'Respons bukan JSON yang valid:';
            echo '<pre>' . htmlspecialchars($response) . '</pre>';
            exit;
        }


        return [
            'success' => true,
            'data' => [
                'payment_id' => $data['payment_id'],
                'expired_payment' => date('Y-m-d', strtotime($expirationDate)),
                'pinpay_number' => $dataIfthepay['PinCode'],
                'redirect_url' => $dataIfthepay['RedirectUrl'],
                'pinpay_url' => $dataIfthepay['PinpayUrl'],
            ]
        ];
    }
}
