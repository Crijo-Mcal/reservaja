<?php

/*
 * Rotas da reserva de um serviço pelo cliente.
 */

use public\api\controller\client\Booking_controller;

/* ---------- GET ---------- */

// Página de reserva
$router->get(
    '/html/client/booking.php',
    [Booking_controller::class,'alldata'],
    dirname(__DIR__,2). '/html/client/booking.php'
);

/* ---------- POST ---------- */

// Criar uma nova reserva
$router->post(
    '/client/booking/add_new_booking',
    [Booking_controller::class,'insertData']
);
