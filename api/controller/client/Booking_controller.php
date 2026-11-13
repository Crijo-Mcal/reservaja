<?php

namespace public\api\controller\client;

use public\api\services\client\Booking_service;
use public\api\validation\client\Booking_validation;
use public\api\utility\Session;

class Booking_controller
{
    private Booking_service $booking_servicee;
    private Booking_validation $booking_validation;

    private string $appBasePath;

    public function __construct(string $appBasePath)
    {
        $this->booking_servicee = new Booking_service();
        $this->booking_validation = new Booking_validation();

        $this->appBasePath=$appBasePath;
    }

    public function insertData()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit();
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

        // Data ou hora não selecionada: mostrar o aviso na própria página de reserva
        $bookingFields = ['appointment_date', 'appointment_time', 'appointment_end'];

        if (
            $inputError['success'] == false &&
            in_array($inputError['error']['field'], $bookingFields, true)
        ) {
            $this->redirectToBooking($data, $inputError['error']['errorMessage']);
        }

        if ($inputError['success'] == false) {
            $this->redirectToProfessional(
                $data['professional_id'],
                $inputError['error']['errorType'],
                $inputError['error']['errorMessage']
            );
        }

        $response = $this->booking_servicee->insertData($data);

        /* database validation */
        if ($response['success'] == false) {
            // Erro da data/hora escolhida (ex.: horário já ocupado) -> página de reserva
            if ($response['error']['errorType'] === 'bookingSelection') {
                $this->redirectToBooking($data, $response['error']['errorMessage']);
            }

            // Serviço inválido -> página do profissional
            $this->redirectToProfessional(
                $data['professional_id'],
                $response['error']['errorType'],
                $response['error']['errorMessage']
            );
        }

        // A página de pagamento lê os dados da reserva da base de dados
        header(
            'Location:' . ($this->appBasePath ?? '') . '/html/client/payment/payment.php?' . http_build_query([
                'booking' => $response['data']['booking_token'],
            ])
        );
        exit();
    }

    public function alldata(): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            http_response_code(405);
            exit();
        }

        $professional_id = (string) ($_GET['professional_id'] ?? '');
        $service_id = (string) ($_GET['service_id'] ?? '');

        // Sem profissional válido não há página de detalhe para onde voltar
        if (!ctype_digit($professional_id) || (int) $professional_id < 1) {
            header('Location:' . ($this->appBasePath ?? '') . '/html/client/professionals.php');
            exit();
        }

        if (!ctype_digit($service_id) || (int) $service_id < 1) {
            $this->redirectToProfessional(
                $professional_id,
                'serviceNotFound',
                'O serviço selecionado não foi encontrado.'
            );
        }

        $response = $this->booking_servicee->allData((int) $professional_id, (int) $service_id);

        // Serviço ou horários não encontrados -> página do profissional
        if ($response['success'] == false) {
            $this->redirectToProfessional(
                $professional_id,
                $response['error']['errorType'],
                $response['error']['errorMessage']
            );
        }

        return $response['data'];
    }

    // Erros da escolha de data/hora: aviso na página de reserva (booking.php)
    private function redirectToBooking(array $data, string $message): never
    {
        Session::setError('bookingSelection', $message);

        header(
            'Location:' . ($this->appBasePath ?? '') . '/html/client/booking.php?' . http_build_query([
                'service_id' => $data['service_id'],
                'professional_id' => $data['professional_id'],
            ])
        );

        exit();
    }

    // Erros do serviço/agenda: aviso na página do profissional
    private function redirectToProfessional(string $professionalId, string $type, string $message): never
    {
        Session::setError($type, $message);

        header(
            'Location:' . ($this->appBasePath ?? '') . '/html/client/professional_detail.php?' . http_build_query([
                'professional_id' => $professionalId,
            ])
        );

        exit();
    }
}
