<?php

/*
 * Rotas das notificações do fornecedor de pagamento (Ifthenpay).
 */

use public\api\controller\webhook\CallbackIfthenpay_controller;

/* ---------- GET ---------- */

// Callback da Ifthenpay: atualiza o estado do pagamento
$router->get(
    '/ifthenpay/callback',
    [CallbackIfthenpay_controller::class, 'updateData'],
    ''
);
