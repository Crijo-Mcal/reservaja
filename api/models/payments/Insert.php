<?php

namespace public\api\models\payments;

use public\DB\Database;
use PDO;

class Insert
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    public function insert(array $data): int
    {
        $servicePrice = (float) $data['service_price'];
        $vat = (float) $data['service_vat'];
        $advancePayment = (float) $data['service_advance_payment'];

        $paymentAmount = $servicePrice * ($advancePayment / 100);
        $paymentType = $advancePayment >= 100 ? 'full' : 'advance';

        $sql = "
        INSERT INTO payments (
            booking_id,
            payment_type,
            amount,
            vat,
            advance_payment
        )
        VALUES (
            :booking_id,
            :payment_type,
            :amount,
            :vat,
            :advance_payment
        )
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'booking_id' => $data['booking_id'],
            'payment_type' => $paymentType,
            'amount' => $paymentAmount,
            'vat' => $vat,
            'advance_payment' => $advancePayment
        ]);

        return (int) $this->pdo->lastInsertId();
    }
}
