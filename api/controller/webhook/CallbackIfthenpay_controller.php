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
            'booking_id' => $_GET['id'],
            'amount' => $_GET['amount'],
            'payment_datetime' => $_GET['payment_datetime'],
            'payment_method' => $_GET['payment_method'],
        ];

        error_log('key= '.$data['key'].' ');
        error_log('booking_id= '.$data['booking_id'].' ');
        error_log('amount= '.$data['amount'].' ');
        error_log('payment_datetime= '.$data['payment_datetime'].' ');
        error_log('payment_method= '.$data['payment_method'].' ');


        if ($antiPhishingKey === '' || $data['key'] === '' || !hash_equals($antiPhishingKey, $data['key'])) {
            http_response_code(403);
            exit('Forbidden');
        }


        $this->callback_ifthenpay_service->payment_booking_success($data);
        http_response_code(200);
        exit();
    }
}
