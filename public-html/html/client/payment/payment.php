<?php

$payment_data = $_SESSION['payment_data'] ?? [];

if (count($payment_data) <= 0) {
    header('Location:' . ($appBasePath ?? '') . '/html/client/professionals.php');
    exit();
}

$error = $_SESSION['error'] ?? null;

unset($_SESSION['error']);

// Dados do utilizador
$User = (
    isset($_SESSION['user']) &&
    $_SESSION['user']['role'] === 'client'
) ? $_SESSION['user'] : [];

$isLoggedIn = !empty($User);

// Dados do cliente
$clientName = $isLoggedIn
    ? ($User['name'] ?? '')
    : ($payment_data['client_name'] ?? '');

$clientMobile = $isLoggedIn
    ? ($User['mobile_number'] ?? '')
    : ($payment_data['client_mobile'] ?? '');

$clientEmail = $isLoggedIn
    ? ($User['email'] ?? '')
    : ($payment_data['client_email'] ?? '');

$clientTaxNumber = $isLoggedIn
    ? ($User['tax_number'] ?? '')
    : ($payment_data['client_tax_number'] ?? '');

$remainingAmount =
    (float) $payment_data['service_price'] -
    (float) $payment_data['amount'];

?>

<!DOCTYPE html>

<html lang="pt-PT">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Pagamento</title>

    <link
        rel="stylesheet"
        href="<?= $appBasePath ?? '' ?>/resources/css/client/payments/payment.css">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Barra de navegação -->
    <?php require(__DIR__ . '/../../layout/nav.php') ?>

    <main class="flex-grow-1 d-flex flex-column justify-content-center align-items-center">

        <!-- Mensagem de erro -->
        <?php if (!empty($error['invalidPayment'])): ?>

            <div class="container p-3">

                <div
                    class="alert alert-danger alert-dismissible fade show mb-0"
                    role="alert">

                    <small>
                        <?= htmlspecialchars($error['invalidPayment']) ?>
                    </small>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Fechar">
                    </button>

                </div>

            </div>

        <?php endif; ?>

        <div class="container py-4 py-md-5">

            <div class="payment-container mx-auto">

                <!-- CABEÇALHO DA PÁGINA -->

                <div class="mb-4">

                    <h4 class="fw-semibold mb-1">
                        Confirmar pagamento
                    </h4>

                    <p class="text-secondary small mb-0">
                        Verifique os dados da sua marcação antes de continuar.
                    </p>

                </div>

                <form
                    action="<?= $appBasePath ?? '' ?>/client/add_new_payment"
                    method="POST"
                    id="payment-form">

                    <div class="row g-3">

                        <!-- COLUNA ESQUERDA -->

                        <div class="col-12 col-lg-7">

                            <!-- RESUMO DA MARCAÇÃO -->

                            <div class="payment-card border rounded-3 bg-white">

                                <div class="payment-card-header">

                                    <h6 class="fw-semibold mb-0">
                                        Resumo da marcação
                                    </h6>

                                </div>

                                <div class="payment-card-body">

                                    <div class="info-group">

                                        <span class="info-label">
                                            Serviço
                                        </span>

                                        <span class="info-value">
                                            <?= htmlspecialchars(
                                                $payment_data['service_name']
                                            ) ?>
                                        </span>

                                    </div>

                                    <div class="info-group">

                                        <span class="info-label">
                                            Duração
                                        </span>

                                        <span class="info-value">
                                            <?= htmlspecialchars(
                                                $payment_data['service_duration']
                                            ) ?>
                                            min
                                        </span>

                                    </div>

                                    <div class="info-group">

                                        <span class="info-label">
                                            Data
                                        </span>

                                        <span class="info-value">
                                            <?= date(
                                                'd/m/Y',
                                                strtotime(
                                                    $payment_data['appointment_date']
                                                )
                                            ) ?>
                                        </span>

                                    </div>

                                    <div class="info-group">

                                        <span class="info-label">
                                            Hora
                                        </span>

                                        <span class="info-value">
                                            <?= htmlspecialchars(
                                                $payment_data['appointment_time']
                                            ) ?>
                                        </span>

                                    </div>

                                </div>

                            </div>

                            <!-- DADOS DO CLIENTE -->

                            <div class="payment-card border rounded-3 bg-white mt-3">

                                <div class="payment-card-header">

                                    <div>

                                        <h6 class="fw-semibold mb-0">
                                            Dados do cliente
                                        </h6>

                                        <?php if ($isLoggedIn): ?>

                                            <small class="text-secondary">
                                                Os seus dados foram preenchidos automaticamente.
                                            </small>

                                        <?php else: ?>

                                            <small class="text-secondary">
                                                Preencha os seus dados para continuar.
                                            </small>

                                        <?php endif; ?>

                                    </div>

                                </div>

                                <div class="payment-card-body">

                                    <!-- NOME -->
                                    <div class="mb-3">

                                        <label
                                            for="client_name"
                                            class="form-label small fw-medium">
                                            Nome
                                        </label>

                                        <input
                                            type="text"
                                            id="client_name"
                                            name="client_name"
                                            class="form-control"
                                            value="<?= htmlspecialchars($clientName) ?>"
                                            required>

                                    </div>

                                    <!-- TELEMÓVEL -->
                                    <div class="mb-3">

                                        <label
                                            for="client_mobile"
                                            class="form-label small fw-medium">
                                            Telemóvel
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text">
                                                +351
                                            </span>

                                            <input
                                                type="tel"
                                                id="client_mobile"
                                                name="client_mobile"
                                                class="form-control"
                                                value="<?= htmlspecialchars($clientMobile) ?>"
                                                required>
                                        </div>

                                    </div>

                                    <!-- EMAIL -->
                                    <div class="mb-3">

                                        <label
                                            for="client_email"
                                            class="form-label small fw-medium">
                                            E-mail
                                        </label>

                                        <input
                                            type="email"
                                            id="client_email"
                                            name="client_email"
                                            class="form-control"
                                            value="<?= htmlspecialchars($clientEmail) ?>"
                                            required>

                                    </div>

                                    <!-- NIF -->
                                    <div class="mb-0">

                                        <label
                                            for="client_tax_number"
                                            class="form-label small fw-medium">

                                            NIF

                                            <span class="text-secondary fw-normal">
                                                (opcional)
                                            </span>

                                        </label>

                                        <input
                                            type="text"
                                            id="client_tax_number"
                                            name="client_tax_number"
                                            class="form-control"
                                            value="<?= htmlspecialchars($clientTaxNumber) ?>">

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- COLUNA DIREITA -->

                        <div class="col-12 col-lg-5">

                            <div class="payment-card border rounded-3 bg-white">

                                <div class="payment-card-header">

                                    <h6 class="fw-semibold mb-0">
                                        Pagamento
                                    </h6>

                                </div>

                                <div class="payment-card-body">

                                    <!-- PREÇO -->

                                    <div class="price-row">

                                        <span>
                                            Preço do serviço
                                        </span>

                                        <span>
                                            €<?= number_format(
                                                    (float) $payment_data['service_price'],
                                                    2,
                                                    ',',
                                                    '.'
                                                ) ?>
                                        </span>

                                    </div>

                                    <!-- IVA -->

                                    <div class="price-row">

                                        <span>
                                            IVA
                                        </span>

                                        <span>
                                            <?= htmlspecialchars(
                                                $payment_data['service_vat']
                                            ) ?>%
                                        </span>

                                    </div>

                                    <!-- PAGAMENTO ANTECIPADO -->

                                    <div class="price-row">

                                        <span>
                                            Pagamento antecipado
                                        </span>

                                        <span>
                                            <?= htmlspecialchars(
                                                $payment_data['service_advance_payment']
                                            ) ?>%
                                        </span>

                                    </div>

                                    <hr>

                                    <!-- TOTAL -->

                                    <div class="total-row">

                                        <span>
                                            Total a pagar
                                        </span>

                                        <strong>
                                            €<?= number_format(
                                                    (float) $payment_data['amount'],
                                                    2,
                                                    ',',
                                                    '.'
                                                ) ?>
                                        </strong>

                                    </div>

                                    <!-- VALOR RESTANTE -->

                                    <div class="remaining-row">

                                        <span>
                                            Valor restante
                                        </span>

                                        <strong>
                                            €<?= number_format(
                                                    $remainingAmount,
                                                    2,
                                                    ',',
                                                    '.'
                                                ) ?>
                                        </strong>

                                    </div>

                                    <!-- CONTINUAR PARA PAGAMENTO -->

                                    <div class="mt-4">

                                        <button
                                            type="submit"
                                            id="payment-submit"
                                            class="cs-btn-primary w-100 py-2 rounded-2">

                                            Continuar para pagamento

                                        </button>

                                        <p class="text-secondary text-center small mt-3 mb-0">

                                            Será redirecionado para a página de pagamento
                                            para concluir a sua marcação.

                                        </p>

                                    </div>

                                    <!-- DADOS OCULTOS DA RESERVA -->

                                    <input
                                        type="hidden"
                                        name="professional_id"
                                        value="<?= htmlspecialchars(
                                                    $payment_data['professional_id']
                                                ) ?>">

                                    <input
                                        type="hidden"
                                        name="booking_id"
                                        value="<?= htmlspecialchars(
                                                    $payment_data['booking_id']
                                                ) ?>">

                                    <input
                                        type="hidden"
                                        name="service_name"
                                        value="<?= htmlspecialchars(
                                                    $payment_data['service_name']
                                                ) ?>">

                                    <input
                                        type="hidden"
                                        name="service_duration"
                                        value="<?= htmlspecialchars(
                                                    $payment_data['service_duration']
                                                ) ?>">

                                    <input
                                        type="hidden"
                                        name="service_vat"
                                        value="<?= htmlspecialchars(
                                                    $payment_data['service_vat']
                                                ) ?>">

                                    <input
                                        type="hidden"
                                        name="service_price"
                                        value="<?= htmlspecialchars(
                                                    $payment_data['service_price']
                                                ) ?>">

                                    <input
                                        type="hidden"
                                        name="service_advance_payment"
                                        value="<?= htmlspecialchars(
                                                    $payment_data['service_advance_payment']
                                                ) ?>">

                                    <input
                                        type="hidden"
                                        name="remaining_amount"
                                        value="<?= htmlspecialchars(
                                                    $remainingAmount
                                                ) ?>">

                                    <input
                                        type="hidden"
                                        name="appointment_date"
                                        value="<?= htmlspecialchars(
                                                    $payment_data['appointment_date']
                                                ) ?>">

                                    <input
                                        type="hidden"
                                        name="appointment_time"
                                        value="<?= htmlspecialchars(
                                                    $payment_data['appointment_time']
                                                ) ?>">

                                </div>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </main>

    <!-- Scripts -->
    <script src="<?= $appBasePath ?? '' ?>/resources/bootstrap/bootstrap.min.js"></script>
</body>

</html>