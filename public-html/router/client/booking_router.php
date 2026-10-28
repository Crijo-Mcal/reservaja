<?php

use public\api\controller\client\Booking_controller;

$router->get(
    '/html/client/booking.php',
    [Booking_controller::class,'alldata'],
    dirname(__DIR__,2). '/html/client/booking.php'
);


$router->post(
    '/client/booking/add_new_booking',
    [Booking_controller::class,'insertData']);