<?php

use public\api\controller\client\Payment_controller;


$router->get(
    '/html/client/payment/payment.php', null,
    dirname(__DIR__,2). '/html/client/payment/payment.php'
);


$router->get(
    '/html/client/payment/payment_success.php', null,
    dirname(__DIR__,2) . '/html/client/payment/payment_success.php'
);

$router->get(
    '/html/client/payment/payment_failed.php', null,
    dirname(__DIR__,2) . '/html/client/payment/payment_failed.php'
);

$router->post(
    '/client/add_new_payment',
    [Payment_controller::class, 'insertData']
);
