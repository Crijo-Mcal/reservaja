<?php

/*
 * Rotas do perfil público de um profissional.
 */

use public\api\controller\client\Professional_detail_controller;

/* ---------- GET ---------- */

// Página de detalhe do profissional
$router->get(
    '/html/client/professional_detail.php',
    [Professional_detail_controller::class,'showData'],
    dirname(__DIR__,2). '/html/client/professional_detail.php'
);
