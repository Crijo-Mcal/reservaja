<?php

/*
 * Rotas dos pagamentos pendentes do cliente.
 */

use public\api\controller\client\ActivePayment_controller;

/* ---------- GET ---------- */

// Página com a lista de pagamentos pendentes
$router->get(
    '/html/client/active_payment.php',
    [ActivePayment_controller::class,'allData'],
    dirname(__DIR__,2). '/html/client/active_payment.php'
);

// Cancelar um pagamento pendente
$router->get(
    '/html/client/active_payment.php/cancel_payment',
    [ActivePayment_controller::class,'cancel_payment'],
    dirname(__DIR__,2). '/html/client/active_payment.php'
);
