<?php

use public\api\controller\client\Profile_controller;

$router->get(
    '/html/client/profile.php',
    null,
    dirname(__DIR__,2) . '/html/client/profile.php'
);

$router->post(
    '/client/profile/update',
    [Profile_controller::class,'updateData'],
);


