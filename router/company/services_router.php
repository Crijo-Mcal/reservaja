<?php

use public\api\controller\company\Services_controller;

    $router->get(
        '/html/company/services.php',
        [Services_controller::class,'allData'],
        dirname(__DIR__,2). '/html/company/services/services.php'
    );

    $router->get(
        '/html/company/services.php/filter',
        [Services_controller::class,'filterData'],
        dirname(__DIR__,2). '/html/company/services/services.php'
    );

    $router->post(
        '/company/services/addnewservice',
        [Services_controller::class,'addNewService']
    );

    $router->post(
        '/company/services/update_service',
        [Services_controller::class,'updateService']
    );

        $router->post(
        '/company/services/delete_service',
        [Services_controller::class,'deleteService']
    );



   
    
    


