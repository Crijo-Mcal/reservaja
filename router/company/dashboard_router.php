<?php

/*
 * Rotas do painel (área profissional).
 */

use public\api\controller\company\Dashboard_controller;

/* ---------- GET ---------- */

// Página do painel
$router->get(
    '/html/company/dashboard.php',
    [Dashboard_controller::class,'alldata'],
    dirname(__DIR__,2). '/html/company/dashboard.php'
);
