<?php

use public\api\controller\company\Professionals_controller;


$router->get(
    '/html/company/professionals/professionals.php',
    [Professionals_controller::class,'allData'],
    dirname(__DIR__,2). '/html/company/professionals/professionals.php'
);

$router->post(
    '/html/company/professionals/professionals.php/update',
    [Professionals_controller::class,'update_Professional'],
);
