<?php

/*
 * Rotas do perfil do cliente.
 */

use public\api\controller\client\Profile_controller;

/* ---------- GET ---------- */

// Página do perfil
$router->get(
    '/html/client/profile.php',
    null,
    dirname(__DIR__,2) . '/html/client/profile.php'
);

/* ---------- POST ---------- */

// Atualizar os dados do perfil
$router->post(
    '/client/profile/update',
    [Profile_controller::class,'updateData'],
);
