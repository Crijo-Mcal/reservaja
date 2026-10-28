<?php

use public\api\controller\company\Schedules_controller;

$router->get(
    '/html/company/schedules.php',
    [Schedules_controller::class, 'allData'],
   dirname(__DIR__,2). '/html/company/schedules.php'
);


$router->post(
    '/company/schedules/addNewSchedule',
    [Schedules_controller::class, 'addNewSchedule']
);

$router->post(
    '/company/schedules/updateSchedule',
    [Schedules_controller::class, 'updateSchedule']
);

$router->post(
    '/company/schedules/deleteSchedule',
    [Schedules_controller::class, 'deleteSchedule']
);
