<?php

$data = $dataBase ?? [];

?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ReservaJá - Pagamentos Pendentes</title>

    <link
        rel="stylesheet"
        href="<?= $appBasePath ?? '' ?>/resources/css/client/active_payment.css">
</head>

<body>
    <!-- Barra de navegação -->
    <?php require(__DIR__ . '/../layout/nav.php'); ?>

    <!-- Conteúdo principal: pagamentos pendentes -->
    <main class="container py-5 flex-grow-1">
        <h1 class="history-title fw-bold fs-4 mb-4">
            Pagamentos Pendentes
        </h1>

        <?php if (!empty($data)): ?>

            <!-- Lista de pagamentos pendentes -->
            <div class="d-flex flex-column gap-2 cs-fadeIn-y2">

                <?php foreach ($data as $payment): ?>
                    <?php $expireAt = new DateTimeImmutable($payment['expired_payment']); ?>

                    <article class="card payment-card">
                        <div class="card-body p-3 p-md-4">

                            <div class="payment-info d-grid align-items-center gap-3">

                                <div class="payment-service d-flex flex-column gap-1">
                                    <span>Serviço</span>
                                    <strong>
                                        <?= htmlspecialchars(
                                            $payment['service_name'] ?? 'Serviço',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </strong>
                                </div>

                                <div class="payment-price d-flex flex-column gap-1">
                                    <span>Preço</span>
                                    <strong>
                                        €<?= number_format(
                                                (float) $payment['service_price'],
                                                2,
                                                ',',
                                                '.'
                                            ) ?>
                                    </strong>
                                </div>

                                <div class="payment-expiry d-flex flex-column gap-1">
                                    <span>Expira em</span>
                                    <strong>
                                        <?= $expireAt->format('d/m/Y') ?>
                                    </strong>
                                </div>

                                <!-- Ações: continuar ou cancelar o pagamento -->
                                <div class="payment-actions d-flex align-items-center flex-wrap gap-2">
                                    <a
                                        href="<?= htmlspecialchars(
                                                    $payment['redirect_url'] ?? '#',
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>"
                                        class="btn btn-continue-payment">
                                        Continuar pagamento
                                    </a>

                                    <a
                                        href="<?= $appBasePath ?? '' ?>/html/client/active_payment.php/cancel_payment?url=<?= urlencode((string) $payment['redirect_url']) ?>&booking_id=<?= urlencode((string) $payment['booking_id']) ?>"
                                        class="btn btn-cancel-payment">
                                        Cancelar pagamento
                                    </a>
                                </div>

                            </div>
                        </div>
                    </article>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <!-- Estado vazio -->
            <div class="history-empty text-center py-5 px-3 border rounded-3">
                <i class="bi bi-credit-card fs-1"></i>

                <p class="text-secondary small mb-0 mt-2">
                    Sem pagamentos pendentes.
                </p>
            </div>

        <?php endif; ?>
    </main>

    <!-- Scripts -->
    <script src="<?= $appBasePath ?? '' ?>/resources/js/bootstrap.min.js"></script>
</body>

</html>