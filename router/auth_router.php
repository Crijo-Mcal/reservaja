<?php

/*
 * Rotas de autenticação: login, registo de cliente e de profissional, e logout.
 */

use public\api\controller\auth\Auth_controller;

/* ---------- GET: páginas ---------- */

// Página de login
$router->get(
    '/html/auth/login.php',
    null,
    dirname(__DIR__,1). '/html/auth/logIn.php'
);

// Página de registo de cliente
$router->get(
    '/html/auth/client_singUp.php',
    null,
    dirname(__DIR__,1). '/html/auth/client_singUp.php'
);

// Página de registo de profissional
$router->get(
    '/html/auth/employee_singUp.php',
    null,
    dirname(__DIR__,1). '/html/auth/employee_singUp.php'
);

/* ---------- POST: ações ---------- */

// Registar um novo cliente
$router->post(
    '/auth/client_register',
    [Auth_controller::class, 'clientSingup']
);

// Registar um novo profissional
$router->post(
    '/auth/employee_register',
    [Auth_controller::class, 'employeeSingup']
);

// Iniciar sessão
$router->post(
    '/auth/login',
    [Auth_controller::class, 'logIn']
);

// Terminar sessão
$router->post(
    '/auth/logout',
    [Auth_controller::class, 'logOut']
);
