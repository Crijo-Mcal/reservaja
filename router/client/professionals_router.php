<?php

/*
 * Rotas da pesquisa de profissionais pelo cliente.
 */

use public\api\controller\client\Professionals_controller;

/* ---------- GET ---------- */

// Página com a lista e a pesquisa de profissionais
$router->get(
    '/html/client/professionals.php',
    [Professionals_controller::class,'allData'],
    dirname(__DIR__,2). '/html/client/professionals.php'
);
