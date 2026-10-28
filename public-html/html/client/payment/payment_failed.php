<!DOCTYPE html>
<html lang="pt-PT">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Pagamento não concluído</title>

    <link
        rel="stylesheet"
        href="<?= $appBasePath ?? '' ?>/resources/css/client/payments/payment_failed.css">

</head>

<body class="bg-light">

    <main class="min-vh-100 d-flex align-items-center">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-12 col-md-7 col-lg-5">

                    <section class="bg-white rounded-4 shadow-sm p-4 p-md-5 text-center cs-fadeIn-y2">

                        <div class="payment-failed-icon mb-3">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>

                        <h1 class="h4 fw-semibold text-dark mb-4">
                            Pagamento não concluído
                        </h1>

                        <div class="payment-failed-content">

                            <div class="payment-failed-notice d-flex align-items-start gap-2 text-start rounded-3 p-3 mb-3">

                                <i class="bi bi-exclamation-circle-fill flex-shrink-0 mt-1"></i>

                                <p class="small mb-0 lh-base">
                                    <strong>
                                        Não foi possível concluir o seu pagamento.
                                    </strong>
                                    A sua marcação não foi confirmada.
                                </p>

                            </div>

                            <div class="d-flex align-items-start gap-2 text-start mb-4 px-1">

                                <i class="bi bi-arrow-repeat flex-shrink-0 mt-1 text-secondary"></i>

                                <p class="small text-secondary mb-0 lh-base">
                                    O pagamento foi cancelado ou não foi concluído.
                                    Pode tentar novamente.
                                </p>

                            </div>

                            <a
                                href="<?= $appBasePath ?? '' ?>/html/client/professionals.php"
                                class="btn payment-failed-button d-inline-flex align-items-center justify-content-center gap-2 px-3 py-2">

                                Tentar novamente

                                <i class="bi bi-arrow-right"></i>

                            </a>

                        </div>

                    </section>

                </div>

            </div>

        </div>

    </main>

</body>

</html>