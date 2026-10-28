<?php

/*
 * Rotas da gestão de profissionais da empresa (área profissional).
 */

use public\api\controller\company\Professionals_controller;

/* ---------- GET ---------- */

// Página com a lista de profissionais
$router->get(
    '/html/company/professionals/professionals.php',
    [Professionals_controller::class,'allData'],
    dirname(__DIR__,2). '/html/company/professionals/professionals.php'
);

/* ---------- POST ---------- */

// Atualizar os dados de um profissional
$router->post(
    '/html/company/professionals/professionals.php/update',
    [Professionals_controller::class,'update_Professional'],
);
