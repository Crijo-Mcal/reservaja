<?php

use public\api\controller\company\Appointments_controller;

$router->get(
    '/html/company/appointments.php',
    [Appointments_controller::class, 'allData'],
    dirname(__DIR__,2). '/html/company/appointments.php'
);

$router->get(
    '/html/company/appointments.php/search',
    [Appointments_controller::class, 'filter'],
    dirname(__DIR__,2). '/html/company/appointments.php'
);

$router->post(
    '/company/appointments/update',
    [Appointments_controller::class,'update_appointment']
);
