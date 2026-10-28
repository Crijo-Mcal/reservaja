<?php

namespace public\api\services\company;

use public\api\models\Bookings;
use public\api\models\payments;

class Payments_service
{
    private payments\Sum $payment_Sum;
    private payments\Select $payment_Select;


    public function __construct()
    {
        $this->payment_Sum = new payments\Sum();
        $this->payment_Select = new payments\Select();
    }

    public function getallDatas(int $professional_id)
    {
        $summary = $this->summary($professional_id);
        $ddata_payment = $this->payment_Select->selectAllPaymentsThisMonth($professional_id);
        $month_options =  $this->payment_Select->selectAllAvailableMonths($professional_id);
        $translateMonthsToPortuguese = $this->translateMonthsToPortuguese($month_options);


        return ['summary' => $summary, 'months_options' => $translateMonthsToPortuguese, 'payments_datas' => $ddata_payment];
    }

    public function filterDatas(array $data)
    {
        $summary = $this->summary($data['professional_id']);
        $month_options =  $this->payment_Select->selectAllAvailableMonths($data['professional_id']);
        $translateMonthsToPortuguese = $this->translateMonthsToPortuguese($month_options);
        $data_payment = $this->payment_Select->selectAllPaymentsByMonth($data);

        return ['summary' => $summary, 'months_options' => $translateMonthsToPortuguese, 'payments_datas' => $data_payment];
    }

    private function summary(int $professional_id)
    {
        $totalPayment = $this->payment_Sum->SumTotalPayment($professional_id);
        $totalPaymentThisMonth = $this->payment_Sum->SumTotalPaymentThisMonth($professional_id);
        $totalPendingPaymentThisMonth = $this->payment_Sum->SumTotalPendingPaymentThisMonth($professional_id);
        $totalRefundedPaymentThisMonth = $this->payment_Sum->SumTotalRefundedPaymentThisMonth($professional_id);

        return [
            'totalAllPayments' => $totalPayment,
            'totalPaymentThisMonth' => $totalPaymentThisMonth,
            'totalPendingPaymentThisMonth' => $totalPendingPaymentThisMonth,
            'totalRefundedPaymentThisMonth' => $totalRefundedPaymentThisMonth
        ];
    }

    private function translateMonthsToPortuguese(array $months): array
    {
        $monthNames = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro',
        ];

        $result = [];

        foreach ($months as $month) {
            $result[] = [
                'strFormat' => $monthNames[$month['month']] . ' ' . $month['year'],
                'numFormat' => sprintf('%04d-%02d', $month['year'], $month['month']),
            ];
        }

        return $result;
    }
}
