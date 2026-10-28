<?php

use public\api\controller\client\History_controller;

$router->get(
    '/html/client/history.php',
    [History_controller::class,'alldata'],
    dirname(__DIR__,2). '/html/client/history.php'
);


