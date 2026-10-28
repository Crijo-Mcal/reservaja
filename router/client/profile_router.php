<?php

/*
 * Rotas do perfil do cliente.
 */

use public\api\controller\client\Profile_controller;

/* ---------- GET ---------- */

// Página do perfil (apenas clientes autenticados)
$router->get(
    '/html/client/profile.php',
    [Profile_controller::class,'showData'],
    dirname(__DIR__,2) . '/html/client/profile.php'
);

/* ---------- POST ---------- */

// Atualizar os dados do perfil
$router->post(
    '/client/profile/update',
    [Profile_controller::class,'updateData'],
);
