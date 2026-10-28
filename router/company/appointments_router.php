<?php

/*
 * Rotas da gestão de agendamentos (área profissional).
 */

use public\api\controller\company\Appointments_controller;

/* ---------- GET ---------- */

// Página com a lista de agendamentos
$router->get(
    '/html/company/appointments.php',
    [Appointments_controller::class, 'allData'],
    dirname(__DIR__,2). '/html/company/appointments.php'
);

// Pesquisar / filtrar agendamentos
$router->get(
    '/html/company/appointments.php/search',
    [Appointments_controller::class, 'filter'],
    dirname(__DIR__,2). '/html/company/appointments.php'
);

/* ---------- POST ---------- */

// Atualizar um agendamento
$router->post(
    '/company/appointments/update',
    [Appointments_controller::class,'update_appointment']
);
