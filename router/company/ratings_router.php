<?php

/*
 * Rotas das avaliações (área profissional).
 */

use public\api\controller\company\Ratings_controller;

/* ---------- GET ---------- */

// Página com a lista de avaliações
$router->get(
    '/html/company/ratings.php',
    [Ratings_controller::class, 'allData'],
    dirname(__DIR__, 2) . '/html/company/ratings.php'
);

/* ---------- POST ---------- */

// Atualizar uma avaliação
$router->post(
    '/company/ratings/update',
    [Ratings_controller::class, 'updateData']
);

// Eliminar uma avaliação
$router->post(
    '/html/company/ratings.php/delete',
    [Ratings_controller::class, 'deleteData']
);
