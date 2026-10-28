<?php

/*
 * Rotas da gestão de serviços (área profissional).
 */

use public\api\controller\company\Services_controller;

/* ---------- GET ---------- */

// Página com a lista de serviços
$router->get(
    '/html/company/services.php',
    [Services_controller::class,'allData'],
    dirname(__DIR__,2). '/html/company/services/services.php'
);

// Filtrar serviços
$router->get(
    '/html/company/services.php/filter',
    [Services_controller::class,'filterData'],
    dirname(__DIR__,2). '/html/company/services/services.php'
);

/* ---------- POST ---------- */

// Adicionar um novo serviço
$router->post(
    '/company/services/addnewservice',
    [Services_controller::class,'addNewService']
);

// Atualizar um serviço
$router->post(
    '/company/services/update_service',
    [Services_controller::class,'updateService']
);

// Eliminar um serviço
$router->post(
    '/company/services/delete_service',
    [Services_controller::class,'deleteService']
);
