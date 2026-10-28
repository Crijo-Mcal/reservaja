<?php

namespace public\api\controller\client;

use public\api\services\client\Booking_service;
use public\api\validation\client\Booking_Validation;
use public\api\utility\Session;

class Booking_controller
{
    private Booking_service $booking_servicee;
    private Booking_Validation $booking_validation;

    private string $appBasePath;

    public function __construct(string $appBasePath)
    {
        $this->booking_servicee = new Booking_service();
        $this->booking_validation = new Booking_Validation();

        $this->appBasePath=$appBasePath;
    }

    public function insertData()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $data = [
            'professional_id' => $_POST['professional_id'] ?? '',
            'service_id' => $_POST['service_id'] ?? '',
            'service_name' => $_POST['service_name'] ?? '',
            'service_duration' => $_POST['service_duration'] ?? '',
            'service_price' => $_POST['service_price'] ?? '',
            'service_vat' => $_POST['service_vat'] ?? '',
            'service_advance_payment' => $_POST['service_advance_payment'] ?? '',
            'appointment_date' => $_POST['appointment_date'] ?? '',
            'appointment_time' => $_POST['appointment_time'] ?? '',
            'appointment_end' => !empty($_POST['appointment_time'])
                ? date(
                    'H:i',
                    strtotime($_POST['appointment_time']) +
                        ((int) ($_POST['service_duration'] ?? 0) * 60)
                )
                : '',
        ];


        /* input validation */
        $inputError = $this->booking_validation->validate($data);
        if ($inputError['success'] == false) {
            Session::setError(
                $inputError['error']['errorType'],
                $inputError['error']['errorMessage']
            );

            header(
                "Location:".($this->appBasePath ?? '')."/html/client/professional_detail.php?professional_id=" .
                    $data['professional_id']
            );

            exit();
        }

        $response = $this->booking_servicee->insertData($data);

        /* database validation */
        if ($response['success'] == false) {
            Session::setError(
                $response['error']['errorType'],
                $response['error']['errorMessage']
            );

            header(
                "Location:".($this->appBasePath ?? '')."/html/client/professional_detail.php?professional_id=" .
                    $data['professional_id']
            );

            exit();
        }

        $price = (float) $data['service_price'];
        $advance = (float) $data['service_advance_payment'];

        $amount = $price * ($advance / 100);

        Session::set('payment_data', [
            'professional_id' => $_POST['professional_id'] ?? '',
            'booking_id' => $response['data']['booking_id'],
            'service_name' => $data['service_name'],
            'service_duration' => $data['service_duration'],
            'service_vat' => $data['service_vat'],
            'service_price' => $data['service_price'],
            'service_advance_payment' => $data['service_advance_payment'],
            'amount' => $amount,
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
        ]);


        header('Location:'.($this->appBasePath ?? '').'/html/client/payment/payment.php');
        exit();
    }

    public function alldata(): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return [];
        }

        $professional_id = $_GET['professional_id'] ?? '';
        $service_id = $_GET['service_id'] ?? '';

        $response = $this->booking_servicee->allData($professional_id, $service_id);

        if ($response['success'] == false) {

            Session::setError($response['error']['errorType'], $response['error']['errorMessage']);
            header("Location:".($this->appBasePath ?? '')."/html/client/professional_detail.php?professional_id=$professional_id");
            exit();
        };

        return $response['data'];
    }
}
