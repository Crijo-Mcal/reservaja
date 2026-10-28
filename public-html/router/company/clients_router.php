<?php

use public\api\controller\company\Clients_controller;

$router->get(
    '/html/company/clients.php',
    [Clients_controller::class, 'alldata'],
    dirname(__DIR__,2). '/html/company/clients.php'
);

$router->get(
    '/html/company/clients.php/filter',
    [Clients_controller::class, 'filter'],
    dirname(__DIR__,2). '/html/company/clients.php'
);

