<?php

use public\api\controller\auth\Auth_controller;

    $router->get(
        '/html/auth/login.php',
        null,
        dirname(__DIR__,1). '/html/auth/logIn.php'
    );

    $router->get(
        '/html/auth/client_singUp.php',
        
        null,
        dirname(__DIR__,1). '/html/auth/client_singUp.php'
    );

    $router->get(
        '/html/auth/employee_singUp.php',
        null,
        dirname(__DIR__,1). '/html/auth/employee_singUp.php'
    );

   
    $router->post(
        '/auth/client_register',
        [Auth_Controller::class, 'clientSingup']
    );

    $router->post(
        '/auth/employee_register',
        [Auth_Controller::class, 'employeeSingup']
    );

    $router->post(
        '/auth/login',
        [Auth_Controller::class, 'logIn']
    );

    $router->post(
        '/auth/logout',
        [Auth_Controller::class, 'logOut']
    );


