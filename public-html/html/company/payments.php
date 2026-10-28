<?php

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'professional') {
    header('Location: '.($appBasePath ?? '').'/html/auth/login.php');
    exit();
}

$User = $_SESSION['user'];
$User['subscription'] = 'free';
$error = $_SESSION['error']['paymentError'] ?? [];


$data = $dataBase ?? [];
$summary = $data['summary'] ?? [];
$payments_datas = $data['payments_datas'] ?? [];
$available_months = $data['months_options'] ?? [];

$dataInput = [
    'month' => $_GET['month'] ?? ''
];


?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1">

    <title>ReservaJá - Pagamentos</title>


    <link
        rel="stylesheet"
        href="<?= $appBasePath ?? '' ?>/resources/css/company/payment.css">

</head>

<body>

    <!-- Barra de navegação -->
    <?php require __DIR__ . "/../layout/professional_navBar.php"; ?>

    <div class="d-flex">

        <!-- Barra lateral -->
        <?php require __DIR__ . "/../layout/professional_sideBar.php"; ?>

        <main class="flex-grow-1 d-flex flex-column align-items-center gap-3 bg-body py-3">

            <!-- Cabeçalho -->
            <div class="container">

                <div class="d-flex justify-content-between align-items-center gap-3">

                    <div>

                        <h4 class="fw-semibold m-0">
                            Pagamentos
                        </h4>

                        <p class="cs-text-2 m-0">
                            Consulte e acompanhe os pagamentos das suas reservas.
                        </p>

                    </div>

                    <div class="d-none d-sm-flex align-items-center gap-2">

                        <?php
                        $roleLabels = [
                            'owner' => 'Proprietário',
                            'employee' => 'Funcionário',
                            'technician' => 'Técnico'
                        ];
                        ?>

                        <span class="cs-tag-success">
                            <?= htmlspecialchars($roleLabels[$User['roleInCompany']] ?? $User['roleInCompany']) ?>
                        </span>

                        <span class="small fw-normal">
                            <?= htmlspecialchars($User['name']) ?>
                        </span>

                        <a href="<?= $appBasePath ?? '' ?>/html/company/profile.php">

                            <img
                                src="<?= $User['profile_image'] ?? ($appBasePath ?? '').'/assset/image/profile.webp' ?>"
                                alt="Fotografia do profissional"
                                class="rounded-circle object-fit-cover border"
                                width="36"
                                height="36">

                        </a>

                    </div>

                </div>

            </div>

            <!-- Mensagem de erro -->
            <?php if ($error): ?>

                <div class="container cs-fadeIn-y1">

                    <div
                        class="alert alert-warning d-flex align-items-center justify-content-between py-2 px-3 mb-0"
                        role="alert">

                        <div class="small">
                            <?= htmlspecialchars($error) ?>
                        </div>

                        <button
                            type="button"
                            class="btn-close ms-3"
                            data-bs-dismiss="alert"
                            aria-label="Fechar">
                        </button>

                    </div>

                </div>

            <?php endif; ?>

            <!-- Resumo dos pagamentos -->
            <div class="container cs-fadeIn-y1">

                <div class="row g-3">

                    <!-- Total recebido -->
                    <div class="col-6 col-xl-3">

                        <div class="card cs-shadow border-0 h-100 cs-summary-today">

                            <div class="card-body p-3">

                                <span class="small">
                                    Total recebido
                                </span>

                                <h4 class="fw-medium mt-1 mb-1">
                                    €<?= $summary['totalAllPayments'] ?? 0 ?>
                                </h4>

                                <span class="small opacity-75">
                                    Total recebido até agora
                                </span>

                            </div>

                        </div>

                    </div>

                    <!-- Pagamentos deste mês -->
                    <div class="col-6 col-xl-3">

                        <div class="card cs-shadow border-0 h-100 cs-summary-light">

                            <div class="card-body p-3">

                                <span class="small">
                                    Pagamentos deste mês
                                </span>

                                <h4 class="fw-medium mt-1 mb-1">
                                    €<?= $summary['totalPaymentThisMonth'] ?? 0 ?>
                                </h4>

                                <span class="small opacity-75">
                                    Recebido neste mês
                                </span>

                            </div>

                        </div>

                    </div>

                    <!-- Pagamentos pendentes -->
                    <div class="col-6 col-xl-3">

                        <div class="card cs-shadow border-0 h-100 cs-summary-light">

                            <div class="card-body p-3">

                                <span class="small">
                                    Pagamentos pendentes
                                </span>

                                <h4 class="fw-medium mt-1 mb-1">
                                    €<?= $summary['totalPendingPaymentThisMonth'] ?? 0 ?>
                                </h4>

                                <span class="small opacity-75">
                                    Neste mês
                                </span>

                            </div>

                        </div>

                    </div>

                    <!-- Pagamentos reembolsados -->
                    <div class="col-6 col-xl-3">

                        <div class="card cs-shadow border-0 h-100 cs-summary-light">

                            <div class="card-body p-3">

                                <span class="small">
                                    Pagamentos reembolsados
                                </span>

                                <h4 class="fw-medium mt-1 mb-1">
                                    €<?= $summary['totalRefundedPaymentThisMonth'] ?? 0 ?>
                                </h4>

                                <span class="small opacity-75">
                                    Neste mês
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- Filtro -->
            <div class="container cs-fadeIn-y1">

                <form
                    method="GET"
                    action="<?= $appBasePath ?? '' ?>/html/company/payments.php/filter">

                    <div class="card border">

                        <div class="card-body p-3">

                            <div class="row g-2 justify-content-center">

                                <div class="col-12 col-sm-auto">

                                    <select
                                        class="form-select form-select-sm"
                                        name="month"
                                        aria-label="Selecionar mês">

                                        <option value="">
                                            Este mês
                                        </option>

                                        <?php foreach ($available_months as $month): ?>
                                            <option
                                                value="<?= htmlspecialchars($month['numFormat']) ?>"
                                                <?= ($dataInput['month'] ?? '') === $month['numFormat'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($month['strFormat']) ?>
                                            </option>
                                        <?php endforeach; ?>

                                    </select>

                                </div>

                                <div class="col-12 col-sm-auto">

                                    <button
                                        type="submit"
                                        class="btn btn-sm cs-btn-primary w-100">

                                        Pesquisar

                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

            <!-- Lista de pagamentos -->
            <div class="container cs-fadeIn-y1">
                <div class="card cs-shadow border-0">

                    <!-- Cabeçalho da lista -->
                    <div class="card-header py-3 px-4 cs-bg-primary cs-text-1">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-1">
                            <h6 class="mb-0 fw-medium">
                                Pagamentos
                            </h6>

                            <span class="small">
                                Setembro 2026
                            </span>
                        </div>
                    </div>

                    <!-- Pagamentos -->
                    <div class="card-body p-0">
                        <?php if ($payments_datas): ?>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 payment-table">

                                    <thead>
                                        <tr>
                                            <th class="px-4 text-start">
                                                ID do Pagamento
                                            </th>

                                            <th class="text-start">
                                                Cliente
                                            </th>

                                            <th class="d-none d-xl-table-cell text-start">
                                                Serviço
                                            </th>

                                            <th class="d-none d-xl-table-cell text-start">
                                                Tipo
                                            </th>

                                            <th class="d-none d-xl-table-cell text-start">
                                                Método
                                            </th>

                                            <th class="d-none d-md-table-cell text-start">
                                                Valor
                                            </th>

                                            <th class="d-none d-md-table-cell text-start">
                                                Estado
                                            </th>

                                            <th class="d-none d-xl-table-cell text-start">
                                                Data
                                            </th>

                                            <th class="px-4 text-center">
                                                Detalhes
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($payments_datas as $payment): ?>

                                            <tr>

                                                <!-- ID do pagamento -->
                                                <td class="px-4 text-start">
                                                    <span class="fw-semibold">
                                                        #PAY-<?= htmlspecialchars($payment['payment_id']) ?>
                                                    </span>
                                                </td>

                                                <!-- Cliente -->
                                                <td class="text-start">
                                                    <span class="fw-medium">
                                                        <?= htmlspecialchars($payment['client_name']) ?>
                                                    </span>
                                                </td>

                                                <!-- Serviço -->
                                                <td class="d-none d-xl-table-cell text-start">
                                                    <span class="fw-medium">
                                                        <?= htmlspecialchars($payment['service_name']) ?>
                                                    </span>
                                                </td>

                                                <!-- Tipo -->
                                                <td class="d-none d-xl-table-cell text-start">
                                                    <span class="small">
                                                        <?= htmlspecialchars($payment['payment_type']) ?>
                                                    </span>
                                                </td>

                                                <!-- Método -->
                                                <td class="d-none d-xl-table-cell text-start">
                                                    <span class="small">
                                                        <?= $payment['payment_method']
                                                            ? htmlspecialchars($payment['payment_method'])
                                                            : '-' ?>
                                                    </span>
                                                </td>

                                                <!-- Valor -->
                                                <td class="d-none d-md-table-cell text-start">
                                                    <span class="fw-semibold">
                                                        €<?= number_format($payment['amount'], 2, ',', '.') ?>
                                                    </span>
                                                </td>

                                                <!-- Estado -->
                                                <td class="d-none d-md-table-cell text-start">
                                                    <span>
                                                        <?= htmlspecialchars($payment['status']) ?>
                                                    </span>
                                                </td>

                                                <!-- Data -->
                                                <td class="d-none d-xl-table-cell text-start">
                                                    <span class="small text-nowrap">
                                                        <?php if ($payment['paid_at']): ?>
                                                            <?= date('d/m/Y H:i', strtotime($payment['paid_at'])) ?>
                                                        <?php else: ?>
                                                            -
                                                        <?php endif; ?>
                                                    </span>
                                                </td>

                                                <!-- Detalhes -->
                                                <td class="px-4 text-center">
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm cs-btn-primary payment-detail-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#paymentDetailModal"

                                                        data-payment-id="<?= htmlspecialchars($payment['payment_id']) ?>"
                                                        data-booking-id="<?= htmlspecialchars($payment['booking_id']) ?>"

                                                        data-client-id="<?= htmlspecialchars($payment['client_id'] ?? '') ?>"
                                                        data-client-name="<?= htmlspecialchars($payment['client_name'], ENT_QUOTES) ?>"
                                                        data-client-email="<?= htmlspecialchars($payment['client_email'], ENT_QUOTES) ?>"

                                                        data-service-name="<?= htmlspecialchars($payment['service_name'], ENT_QUOTES) ?>"

                                                        data-payment-type="<?= htmlspecialchars($payment['payment_type'], ENT_QUOTES) ?>"
                                                        data-payment-method="<?= htmlspecialchars($payment['payment_method'] ?? '-', ENT_QUOTES) ?>"

                                                        data-amount="<?= number_format($payment['amount'], 2, ',', '.') ?>"

                                                        data-status="<?= htmlspecialchars($payment['status'], ENT_QUOTES) ?>"

                                                        data-date="<?= $payment['paid_at']
                                                                        ? date('d/m/Y H:i', strtotime($payment['paid_at']))
                                                                        : '-' ?>">

                                                        Detalhes
                                                    </button>
                                                </td>

                                            </tr>

                                        <?php endforeach; ?>
                                    </tbody>

                                </table>
                            </div>

                        <?php else: ?>

                            <div class="p-5 text-center">
                                <h6 class="fw-semibold mb-2">
                                    Nenhum pagamento encontrado
                                </h6>

                                <p class="small cs-text-2 mb-0">
                                    Não existem pagamentos para o período selecionado.
                                </p>
                            </div>

                        <?php endif; ?>
                    </div>

                </div>
            </div>

        </main>

    </div>

    <!-- Modal de detalhes do pagamento -->
    <div
        class="modal fade"
        id="paymentDetailModal"
        tabindex="-1"
        aria-labelledby="paymentDetailModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                <!-- Cabeçalho -->
                <div class="modal-header px-3 px-md-4 py-3">

                    <div class="min-w-0">

                        <h5
                            class="modal-title fw-medium mb-1"
                            id="paymentDetailModalLabel">

                            Detalhes do pagamento

                        </h5>

                        <p class="text-body-secondary small mb-0">
                            Consulte as informações deste pagamento.
                        </p>

                    </div>

                    <button
                        type="button"
                        class="btn-close flex-shrink-0"
                        data-bs-dismiss="modal"
                        aria-label="Fechar">
                    </button>

                </div>

                <!-- Corpo -->
                <div class="modal-body px-3 px-md-4 py-3 py-md-4">

                    <!-- IDs -->
                    <div class="border rounded-3 mb-3">

                        <div class="row g-0">

                            <div class="col-12 col-md-6">

                                <div class="px-3 py-3">

                                    <span class="text-body-secondary small d-block mb-1">
                                        Payment ID
                                    </span>

                                    <span
                                        class="fw-medium text-break"
                                        id="modalPaymentId">
                                    </span>

                                </div>

                            </div>

                            <div class="col-12 col-md-6">

                                <div class="px-3 py-3">

                                    <span class="text-body-secondary small d-block mb-1">
                                        Booking ID
                                    </span>

                                    <span
                                        class="fw-medium text-break"
                                        id="modalBookingId">
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Cliente e serviço -->
                    <div class="border rounded-3 mb-3">

                        <div class="row g-0">

                            <div class="col-12 col-md-6">

                                <div class="px-3 py-3">

                                    <span class="text-body-secondary small d-block mb-1">
                                        Cliente
                                    </span>

                                    <span
                                        class="fw-medium text-break"
                                        id="modalClientName">
                                    </span>

                                </div>

                            </div>

                            <div class="col-12 col-md-6">

                                <div class="px-3 py-3">

                                    <span class="text-body-secondary small d-block mb-1">
                                        Serviço
                                    </span>

                                    <span
                                        class="fw-medium text-break"
                                        id="modalServiceName">
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Dados do pagamento -->
                    <div class="border rounded-3">

                        <div class="row g-0">

                            <div class="col-12 col-md-6">

                                <div class="px-3 py-3">

                                    <span class="text-body-secondary small d-block mb-1">
                                        Tipo de pagamento
                                    </span>

                                    <span
                                        class="fw-medium text-break"
                                        id="modalPaymentType">
                                    </span>

                                </div>

                            </div>

                            <div class="col-12 col-md-6">

                                <div class="px-3 py-3">

                                    <span class="text-body-secondary small d-block mb-1">
                                        Método de pagamento
                                    </span>

                                    <span
                                        class="fw-medium text-break"
                                        id="modalPaymentMethod">
                                    </span>

                                </div>

                            </div>

                            <div class="col-12 col-md-4">

                                <div class="px-3 py-3">

                                    <span class="text-body-secondary small d-block mb-1">
                                        Valor
                                    </span>

                                    <span
                                        class="fw-semibold"
                                        id="modalAmount">
                                    </span>

                                </div>

                            </div>

                            <div class="col-12 col-md-4">

                                <div class="px-3 py-3">

                                    <span class="text-body-secondary small d-block mb-1">
                                        Estado
                                    </span>

                                    <span
                                        class="fw-medium text-break"
                                        id="modalStatus">
                                    </span>

                                </div>

                            </div>

                            <div class="col-12 col-md-4">

                                <div class="px-3 py-3">

                                    <span class="text-body-secondary small d-block mb-1">
                                        Data do pagamento
                                    </span>

                                    <span
                                        class="fw-medium text-break"
                                        id="modalDate">
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- Rodapé -->
                <div class="modal-footer px-3 px-md-4 py-3 bg-body-tertiary">

                    <button
                        type="button"
                        class="btn btn-light border btn-sm"
                        data-bs-dismiss="modal">

                        Fechar

                    </button>

                </div>

            </div>

        </div>

    </div>

    <!-- Scripts -->
    <script src="<?= $appBasePath ?? '' ?>/resources/js/bootstrap.min.js"></script>
    <script src="<?= $appBasePath ?? '' ?>/resources/js/company/payment.js"></script>

</body>

</html>