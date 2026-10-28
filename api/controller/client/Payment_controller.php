<?php

namespace public\api\controller\client;

use public\api\services\client\Payment_service;
use public\api\validation\client\Payment_validation;
use public\api\utility\Session;

class Payment_controller
{
    private Payment_service $payment_service;
    private Payment_validation $payment_validation;

    private string $appBasePath;

    public function __construct(string $appBasePath)
    {
        $this->payment_service = new Payment_service();
        $this->payment_validation = new Payment_validation();

        $this->appBasePath=$appBasePath;
    }

    public function insertData()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' ) {
            return;
        }

        $User = !isset($_SESSION['user']) || $_SESSION['user'] == '' ? null : $_SESSION['user'];

        $data = [
            'professional_id' => $_POST['professional_id'] ?? '',
            'booking_id' =>(int) $_POST['booking_id'] ?? '',
            'service_name' => $_POST['service_name'] ?? '',
            'service_price' => $_POST['service_price'] ?? '',
            'service_vat' => $_POST['service_vat'] ?? '',
            'service_advance_payment' => $_POST['service_advance_payment'] ?? '',
            'client_id' => $User['id'] ?? null,
            'client_name' => $_POST['client_name'] ?? '',
            'client_mobile' => $_POST['client_mobile'] ?? '',
            'client_email' => $_POST['client_email'] ?? '',
            'client_tax_number' => !isset($_POST['client_tax_number']) && $_POST['client_tax_number'] == ''  ? null : $_POST['client_tax_number'],
        ];
        
        
        $inputError = $this->payment_validation->validate($data);


        if ($inputError['success'] === false) {
            Session::setError(
                $inputError['error']['errorType'],
                $inputError['error']['errorMessage']
            );

            header('Location:'.($this->appBasePath ?? '').'/html/client/payment/payment.php');
            exit();
        }


        $checkout = $this->payment_service->processPayment($data,$this->appBasePath);

        if ($checkout['success'] === false) {
            Session::setError(
                $checkout['error']['errorType'],
                $checkout['error']['errorMessage']
            );

            header('Location:'.($this->appBasePath ?? '').'/html/client/professional_detail.php?professional_id=' . $data['professional_id']);
            exit();
        }

        
        header('Location: ' . $checkout['data']['redirect_url']);

        exit();
    }

    public function activePayment(){
        return[];
    }
}
