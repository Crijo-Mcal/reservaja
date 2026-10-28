<?php

namespace public\api\controller\company;

use public\api\services\company\Appointments_service;
use public\api\validation\company\Appointment_validation;
use public\api\services\company\Ratings_service;
use public\api\utility\Session;

class Appointments_controller
{
    private Appointments_service $appointments_service;
    private Appointment_validation $appointment_validation;
    private Ratings_service $ratings_service;
    private string $appBasePath;

    public function __construct(string $appBasePath)
    {
        $this->appointments_service = new Appointments_service();
        $this->appointment_validation = new Appointment_validation();
        $this->ratings_service = new Ratings_service();
        $this->appBasePath = $appBasePath;
    }

    public function alldata(): ?array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return [];
        }

        $user = $_SESSION['user'] ?? [];

        if (!$user || ($user['role'] ?? '') !== 'professional') {
            header('Location: ' . $this->appBasePath . '/html/auth/login.php');
            exit();
        }

        $professionalId = $user['id'];
        return $this->appointments_service->getallDatas($professionalId);
    }

    public function filter(): ?array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return [];
        }

        $user = $_SESSION['user'] ?? [];

        if (!$user || ($user['role'] ?? '') !== 'professional') {
            header('Location: ' . $this->appBasePath . '/html/auth/login.php');
            exit();
        }

        $dataInput = [
            'professional_id' => $user['id'],
            'appointment_id' => $_GET['appointment_id'] ?? '',
            'date' => $_GET['date'] ?? ''
        ];

        if (!$dataInput['appointment_id'] && !$dataInput['date']) {
            header('Location: ' . $this->appBasePath . '/html/company/appointments.php');
            exit();
        }

        return $this->appointments_service->filterDatas($dataInput);
    }

    public function update_appointment(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $user = $_SESSION['user'] ?? [];

        if (!$user || ($user['role'] ?? '') !== 'professional') {
            header('Location: ' . $this->appBasePath . '/html/auth/login.php');
            exit();
        }

        $appointmentDate = $_POST['appointment_date'] ?? '';
        $appointmentTime = $_POST['appointment_time'] ?? '';
        $serviceDuration = (int) ($_POST['service_duration'] ?? 0);

        $appointmentEnd = date(
            'H:i',
            strtotime($appointmentTime) + ($serviceDuration * 60)
        );

        $dataInput = [
            'professional_id' => $user['id'],
            'appointment_id' => (int) ($_POST['appointment_id'] ?? 0),
            'booking_id' => (int) ($_POST['booking_id'] ?? 0),
            'appointment_date' => $appointmentDate,
            'appointment_time' => $appointmentTime,
            'service_duration' => $serviceDuration,
            'appointment_end' => $appointmentEnd,
            'appointment_status' => $_POST['appointment_status'] ?? ''
        ];

        $validation = $this->appointment_validation->validate($dataInput);

        if ($validation['success'] === false) {
            Session::setError(
                'appointmentError',
                $validation['errorMessage']
            );

            header('Location: ' . $this->appBasePath . '/html/company/appointments.php');
            exit();
        }

        $response = $this->appointments_service->update_Data($dataInput);

        if ($response['success'] === false) {
            Session::setError(
                'appointmentError',
                $response['errorMessage']
            );

            header('Location: ' . $this->appBasePath . '/html/company/appointments.php');
            exit();
        }

        // Setup ratings
        if ($dataInput['appointment_status'] === 'completed') {
            $this->ratings_service->insertData($dataInput);
        }

        header(
            'Location: ' .
            $this->appBasePath .
            '/html/company/appointments.php/search?appointment_id=&date=' .
            urlencode($dataInput['appointment_date'])
        );

        exit();
    }
}

