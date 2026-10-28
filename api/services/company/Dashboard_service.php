<?php

namespace public\api\services\company;

use public\api\models\appointments;
use public\api\models\payments;
use public\api\models\Ratings;

class Dashboard_service
{

    private Ratings $ratingsTable;

    private appointments\Count $appointmen_count;
    private appointments\Select $appointmen_select;

    private payments\Sum $payment_sum;
    private payments\Count $payment_count;



    public function __construct()
    {

        $this->ratingsTable = new Ratings();

        $this->appointmen_count = new appointments\Count();
        $this->appointmen_select = new appointments\Select();

        $this->payment_sum = new payments\Sum();
        $this->payment_count = new payments\Count();
    }

    public function getAllDatas(int $professional_id): ?array
    {
        $summary = $this->summary($professional_id);
        $todayAppointments = $this->appointmen_select->selectTodayAppointment($professional_id);
        $doughnutData = $this->doughnutData($professional_id);
        $totalPaymentPerMonths = $this->payment_sum->SumTotalPaymentPerMonth($professional_id);
        $topFiveServices = $this->appointmen_select->selectTopServicesByProfessional($professional_id);
        $newCLientThisMonth = $this->appointmen_select->selectNewClientsThisMonth($professional_id);

        return [
            'summary' => $summary,
            'todayAppointments' => $todayAppointments,
            'doughnutData' => $doughnutData,
            'totalPaymentPerMonths' => $totalPaymentPerMonths,
            'topFiveServices' => $topFiveServices,
            'newCLientThisMonth' => $newCLientThisMonth
        ];
    }


    private function summary(int $professional_id): array
    {
        $todayAppointment = $this->appointmen_count->countTodayAppointment($professional_id);
        $ScheduledAppointment = $this->appointmen_count->countScheduledAppointment($professional_id);
        $paymentsThisMonths = $this->payment_sum->SumTotalPaymentThisMonth($professional_id);
        $averageRatingAndCount = $this->ratingsTable->getAverageRatingAndCount($professional_id);

     
        return [
            'todayAppointment' => $todayAppointment,
            'ScheduledAppointment' => $ScheduledAppointment,
            'paymentsThisMonths' => $paymentsThisMonths,
            'averageRatingAndCount' => $averageRatingAndCount
        ];
    }

    private function doughnutData(int $professional_id): array
    {
        $paymentsThisMonths = $this->payment_count->CountTotalPaymentThisMonth($professional_id);
        $paymentsPandingThisMonths = $this->payment_count->CountTotalPendingPaymentThisMonth($professional_id);
        $paymentsRefundedThisMonths = $this->payment_count->CountTotalRefundedPaymentThisMonth($professional_id);


        return [
            'pago' => $paymentsThisMonths,
            'pendente' => $paymentsPandingThisMonths,
            'reembolsado' => $paymentsRefundedThisMonths
        ];
    }
}
