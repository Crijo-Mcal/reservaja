<?php

/*
 * Rotas do pagamento de uma reserva pelo cliente.
 */

use public\api\controller\client\Payment_controller;

/* ---------- GET ---------- */

// Página de pagamento
$router->get(
    '/html/client/payment/payment.php',
    null,
    dirname(__DIR__,2). '/html/client/payment/payment.php'
);

// Página de pagamento concluído
$router->get(
    '/html/client/payment/payment_success.php',
    null,
    dirname(__DIR__,2) . '/html/client/payment/payment_success.php'
);

// Página de pagamento não concluído
$router->get(
    '/html/client/payment/payment_failed.php',
    null,
    dirname(__DIR__,2) . '/html/client/payment/payment_failed.php'
);

/* ---------- POST ---------- */

// Criar um novo pagamento
$router->post(
    '/client/add_new_payment',
    [Payment_controller::class, 'insertData']
);
