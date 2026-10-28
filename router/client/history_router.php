<?php

/*
 * Rotas do histórico de agendamentos do cliente.
 */

use public\api\controller\client\History_controller;

/* ---------- GET ---------- */

// Página do histórico
$router->get(
    '/html/client/history.php',
    [History_controller::class,'alldata'],
    dirname(__DIR__,2). '/html/client/history.php'
);
