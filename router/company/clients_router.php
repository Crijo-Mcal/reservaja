<?php

/*
 * Rotas da lista de clientes (área profissional).
 */

use public\api\controller\company\Clients_controller;

/* ---------- GET ---------- */

// Página com a lista de clientes
$router->get(
    '/html/company/clients.php',
    [Clients_controller::class, 'alldata'],
    dirname(__DIR__,2). '/html/company/clients.php'
);

// Filtrar clientes
$router->get(
    '/html/company/clients.php/filter',
    [Clients_controller::class, 'filter'],
    dirname(__DIR__,2). '/html/company/clients.php'
);
