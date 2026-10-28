<?php

use public\api\controller\company\Ratings_controller;

$router->get(
    '/html/company/ratings.php',
    [Ratings_controller::class, 'allData'],
    dirname(__DIR__, 2) . '/html/company/ratings.php'
);

$router->post(
    '/company/ratings/update',
    [Ratings_controller::class, 'updateData']
);

$router->post(
    '/html/company/ratings.php/delete',
    [Ratings_controller::class, 'deleteData']
);
