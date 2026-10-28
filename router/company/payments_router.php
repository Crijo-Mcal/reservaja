<?php

/*
 * Rotas da lista de pagamentos (área profissional).
 */

use public\api\controller\company\Payments_controller;

/* ---------- GET ---------- */

// Página com a lista de pagamentos
$router->get(
    '/html/company/payments.php',
    [Payments_controller::class, 'alldata'],
    dirname(__DIR__,2). '/html/company/payments.php'
);

// Filtrar pagamentos
$router->get(
    '/html/company/payments.php/filter',
    [Payments_controller::class, 'filter'],
    dirname(__DIR__,2). '/html/company/payments.php'
);
