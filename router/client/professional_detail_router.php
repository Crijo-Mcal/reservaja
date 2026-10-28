<?php

use public\api\controller\client\Professional_detail_controller;

$router->get(
    '/html/client/professional_detail.php',
    [Professional_detail_controller::class,'showData'],
    dirname(__DIR__,2). '/html/client/professional_detail.php'
);
