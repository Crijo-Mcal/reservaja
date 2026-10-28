<?php

/*
 * Rotas da gestão de horários (área profissional).
 */

use public\api\controller\company\Schedules_controller;

/* ---------- GET ---------- */

// Página do calendário de horários
$router->get(
    '/html/company/schedules.php',
    [Schedules_controller::class, 'allData'],
    dirname(__DIR__,2). '/html/company/schedules.php'
);

/* ---------- POST ---------- */

// Adicionar novos horários
$router->post(
    '/company/schedules/addNewSchedule',
    [Schedules_controller::class, 'addNewSchedule']
);

// Atualizar um horário
$router->post(
    '/company/schedules/updateSchedule',
    [Schedules_controller::class, 'updateSchedule']
);

// Eliminar um horário
$router->post(
    '/company/schedules/deleteSchedule',
    [Schedules_controller::class, 'deleteSchedule']
);
