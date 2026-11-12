<?php

namespace public\api\controller\webhook;

use public\api\services\webhook\CallbackIfthenpay_service;

class CallbackIfthenpay_controller
{
    private CallbackIfthenpay_service $callback_ifthenpay_service;

    public function __construct()
    {
        $this->callback_ifthenpay_service = new CallbackIfthenpay_service();
    }

    public function updateData()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !$_GET) {
            http_response_code(405);
            exit();
        }

        $antiPhishingKey = $_ENV['ANTI_PHISHING_KEY'] ?? '';

        $data = [
            'key' => $_GET['key'] ?? null,
            // [ID] da Ifthenpay = id do pagamento (enviado em Payment_service::createPinPay)
            'payment_id' => (int) ($_GET['id'] ?? 0),
            'amount' => $_GET['amount'],
            'payment_datetime' => $_GET['payment_datetime'],
            'payment_method' => $_GET['payment_method'],
        ];

        error_log('key= '.$data['key'].' ');
        error_log('payment_id= '.$data['payment_id'].' ');
        error_log('amount= '.$data['amount'].' ');
        error_log('payment_datetime= '.$data['payment_datetime'].' ');
        error_log('payment_method= '.$data['payment_method'].' ');


        if ($antiPhishingKey === '' || $data['key'] === '' || !hash_equals($antiPhishingKey, $data['key'])) {
            http_response_code(403);
            exit('Forbidden');
        }


        $result = $this->callback_ifthenpay_service->payment_booking_success($data);

        if ($result === 'not_found') {
            http_response_code(404);
            exit('Payment not found');
        }

        http_response_code(200);
        exit($result === 'already_paid' ? 'Already paid' : 'OK');
    }
}
