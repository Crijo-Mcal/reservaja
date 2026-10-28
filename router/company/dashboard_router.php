<?php

use public\api\controller\company\Dashboard_controller;

 $router->get(
        '/html/company/dashboard.php',
        [Dashboard_controller::class,'alldata'],
        dirname(__DIR__,2). '/html/company/dashboard.php'
    );