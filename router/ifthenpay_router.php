<?php

use public\api\controller\webhook\StripeWebhook_controller;
use public\api\controller\webhook\CallbackIfthenpay_controller;

$router->post(
    '/stripe/webhook',
    [StripeWebhook_controller::class, 'updateData']
);

$router->get(
    '/ifthenpay/callback',
    [CallbackIfthenpay_controller::class, 'updateData'],
    ''
);
