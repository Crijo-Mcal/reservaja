<?php

use public\api\controller\client\Professionals_controller;

$router->get(
    '/html/client/professionals.php',
    [Professionals_controller::class,'allData'],
    dirname(__DIR__,2). '/html/client/professionals.php'
);


