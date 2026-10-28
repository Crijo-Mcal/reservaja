<?php

namespace public\api\controller\company;

use public\api\services\company\Schedules_service;
use public\api\validation\company\Schedule_validation;
use public\api\utility\Session;

class Schedules_controller
{

    private Schedules_service $schedules_service;
    private Schedule_validation $schedule_validator;

    private string $appBasePath;

    public function __construct(string $appBasePath)
    {
        $this->schedules_service = new Schedules_service();
        $this->schedule_validator = new Schedule_validation();

        $this->appBasePath=$appBasePath;
    }

    public function allData(): ?array
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            return [];
        }

        $User = $_SESSION['user'] ?? [];
        if (!isset($User) || $User['role'] !== 'professional') {
            header('Location:'.( $this->appBasePath ?? '' ).'/html/auth/login.php');
            exit();
        }

        $id = $User['id'];

        return $this->schedules_service->showAllService($id);
    }

    public function addNewSchedule()
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $User = $_SESSION['user'] ?? [];
        if (!isset($User) || $User['role'] !== 'professional') {
            header('Location:'.( $this->appBasePath ?? '' ).'/html/auth/login.php');
            exit();
        }

        $id =  $User['id'];

        $date        = $_POST['date'] ?? [];
        $start_time  = $_POST['start_time'] ?? [];
        $end_time    = $_POST['end_time'] ?? [];
        $start_lunch = $_POST['start_lunch'] ?? [];
        $end_lunch   = $_POST['end_lunch'] ?? [];

        $datas = [];

        for ($i = 0; $i < count($date); $i++) {

            $newData = [
                'date' => $date[$i],
                'start_time' => date('H:i:s', strtotime($start_time[$i])),
                'end_time' => date('H:i:s', strtotime($end_time[$i])),
                'start_lunch' => date('H:i:s', strtotime($start_lunch[$i])),
                'end_lunch' => date('H:i:s', strtotime($end_lunch[$i])),
            ];

            $datas[] = $newData;
        }


        foreach ($datas as $data) {
            $validation = $this->schedule_validator->validate($data);

            if ($validation['success'] === false) {
                $error = $validation['error'];

                Session::setError(
                    'updateSchedule',
                    $error['errorMessage']
                );

                header('Location:'.( $this->appBasePath ?? '' ).'/html/company/schedules.php');
                exit();
            }
        };


        $this->schedules_service->addNewService($id, $datas);
        header('Location:'.( $this->appBasePath ?? '' ).'/html/company/schedules.php');
    }

    public function updateSchedule()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $User = $_SESSION['user'] ?? [];
        if (!isset($User) || $User['role'] !== 'professional') {
            header('Location:'.( $this->appBasePath ?? '' ).'/html/auth/login.php');
            exit();
        }

        $professional_id = $User['id'];

        $data = [
            'id'          => $_POST['schedule_id'] ?? null,
            'date'        => $_POST['date'] ?? null,
            'start_time'  => $_POST['start_time'] ? date('H:i:s', strtotime($_POST['start_time'])) : null,
            'end_time'    => $_POST['end_time'] ? date('H:i:s', strtotime($_POST['end_time'])) : null,
            'start_lunch' => $_POST['start_lunch'] ? date('H:i:s', strtotime($_POST['start_lunch'])) : null,
            'end_lunch'   => $_POST['end_lunch'] ? date('H:i:s', strtotime($_POST['end_lunch'])) : null,
        ];


        $validation = $this->schedule_validator->validate($data);

        if ($validation['success'] === false) {
            $error = $validation['error'];

            Session::setError(
                'updateSchedule',
                $error['errorMessage']
            );
            header('Location:'.( $this->appBasePath ?? '' ).'/html/company/schedules.php');
            exit();
        }


        $response = $this->schedules_service->updateSchedule($professional_id, $data);

        if ($response['success'] === false) {
            $error = $response['error'];

            Session::setError(
                $error['errorType'],
                $error['errorMessage']
            );
        }


        header('Location:'.( $this->appBasePath ?? '' ).'/html/company/schedules.php');
        exit();
    }

    public function deleteSchedule()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        $User = $_SESSION['user'] ?? [];
        if (!isset($User) || $User['role'] !== 'professional') {
            header('Location:'.( $this->appBasePath ?? '' ).'/html/auth/login.php');
            exit();
        }



        $professional_id = $User['id'];

        $data = [
            'professional_id' => $User['id'],
            'schedule_id' => (int) $_POST['deleteschedule_id'] ?? null
        ];


        if (!$data['schedule_id']) {
            header('Location:'.( $this->appBasePath ?? '' ).'/html/company/schedules.php');
            exit();
        }

        $response = $this->schedules_service->deleteSchedule($data);

        if ($response['success'] === false) {
            $error = $response['error'];

            Session::setError(
                $error['errorType'],
                $error['errorMessage']
            );
        }

        header('Location:'.( $this->appBasePath ?? '' ).'/html/company/schedules.php');
        //exit();
    }
}
