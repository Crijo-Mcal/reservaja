<?php

use public\api\controller\company\Payments_controller;

$router->get(
    '/html/company/payments.php',
    [Payments_controller::class, 'alldata'],
    dirname(__DIR__,2). '/html/company/payments.php'
);

$router->get(
    '/html/company/payments.php/filter',
    [Payments_controller::class, 'filter'],
    dirname(__DIR__,2). '/html/company/payments.php'
);
