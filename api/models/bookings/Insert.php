<?php

namespace public\api\models\bookings;

use public\DB\Database;
use PDO;

class Insert
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    /*
     * Cria a reserva e devolve o id e o token.
     * O token (aleatório) é usado no URL da página de pagamento,
     * para que ninguém consiga abrir a reserva de outra pessoa adivinhando o id.
     */
    public function insert(array $data): array
    {
        $token = bin2hex(random_bytes(16));

        $expiredAt = date('Y-m-d H:i:s', strtotime('+20 minutes'));

        $stmt = $this->pdo->prepare("
            INSERT INTO bookings (
                token,
                professional_id,
                appointment_date,
                appointment_time,
                appointment_end,
                service_id,
                service_duration,
                service_name,
                service_vat,
                service_price,
                service_advance_payment,
                expired_at
            ) VALUES (
                :token,
                :professional_id,
                :appointment_date,
                :appointment_time,
                :appointment_end,
                :service_id,
                :service_duration,
                :service_name,
                :service_vat,
                :service_price,
                :service_advance_payment,
                :expired_at
            )
        ");

        $stmt->execute([
            'token' => $token,
            'professional_id' => $data['professional_id'],
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
            'appointment_end' => $data['appointment_end'],
            'service_id' => $data['service_id'],
            'service_duration' => $data['service_duration'],
            'service_name' => $data['service_name'],
            'service_vat' => $data['service_vat'],
            'service_price' => $data['service_price'],
            'service_advance_payment' => $data['service_advance_payment'],
            'expired_at' => $expiredAt
        ]);

        // id desta inserção (seguro mesmo com várias reservas ao mesmo tempo)
        return [
            'id' => (int) $this->pdo->lastInsertId(),
            'token' => $token,
        ];
    }
}