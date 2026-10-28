<?php

use public\api\controller\client\Professional_search_controller;

$router->get(
    '/html/client/professionals.php',
    [Professional_search_controller::class,'allData'],
    dirname(__DIR__,2). '/html/client/professionals.php'
);


