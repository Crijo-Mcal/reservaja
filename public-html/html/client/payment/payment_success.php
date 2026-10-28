<!DOCTYPE html>
<html lang="pt-PT">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Pagamento concluído</title>

    <link
        rel="stylesheet"
        href="<?= $appBasePath ?? '' ?>/resources/css/client/payments/payment_success.css">

</head>

<body class="bg-light">

    <!-- Conteúdo principal: pagamento concluído -->
    <main class="min-vh-100 d-flex align-items-center">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-12 col-md-7 col-lg-5">

                    <section class="bg-white rounded-4 shadow-sm p-4 p-md-5 text-center cs-fadeIn-y2">

                        <div class="payment-success-icon mb-3">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>

                        <h1 class="h4 fw-semibold text-dark mb-4">
                            Pagamento concluído com sucesso
                        </h1>

                        <!-- Informação sobre a reserva -->
                        <div class="payment-success-content">

                            <div class="payment-success-notice d-flex align-items-start gap-2 text-start rounded-3 p-3 mb-3">

                                <i class="bi bi-check-circle-fill flex-shrink-0 mt-1"></i>

                                <p class="small mb-0 lh-base">
                                    <strong>
                                        O seu pagamento foi confirmado.
                                    </strong>
                                    A sua reserva foi processada com sucesso.
                                </p>

                            </div>

                            <div class="d-flex align-items-start gap-2 text-start mb-4 px-1">

                                <i class="bi bi-envelope flex-shrink-0 mt-1 text-secondary"></i>

                                <p class="small text-secondary mb-0 lh-base">
                                    Enviaremos os dados da sua reserva para o seu
                                    <strong class="text-dark">Gmail</strong>.
                                </p>

                            </div>

                            <!-- Botão para continuar -->
                            <a href="<?= $appBasePath ?? '' ?>/html/client/professionals.php">
                                <button
                                    type="submit"
                                    class="btn payment-success-button d-inline-flex align-items-center justify-content-center gap-2 px-3 py-2">

                                    Continuar

                                    <i class="bi bi-arrow-right"></i>

                                </button>
                            </a>

                        </div>

                    </section>

                </div>

            </div>

        </div>

    </main>

</body>

</html>