<?php
$User = $_SESSION['user'] ?? [];

if (!isset($_SESSION['user']) || ($User['role'] ?? '') !== 'professional') {
    header('Location: '.($appBasePath ?? '').'/html/auth/login.php');
    exit();
}

$data = $dataBase ?? [];
$summary = $data['summary'] ?? [];
$todayAppointments = $data['todayAppointments'] ?? [];
$topFiveServices = $data['topFiveServices'] ?? [];
$newClientThisMonth = $data['newCLientThisMonth'] ?? [];
$doughnutValue = $data['doughnutData'] ?? [];

$roleInCompany = $User['roleInCompany'] ?? '';
$isOwner = $roleInCompany === 'owner';

$roleLabels = [
    'owner' => 'Proprietário',
    'employee' => 'Funcionário',
    'technician' => 'Técnico'
];
?>
<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReservaJá - Dashboard</title>
    <link rel="stylesheet" href="<?= $appBasePath ?? '' ?>/resources/css/company/dashboard.css">

</head>

<body>
    <!-- Barra de navegação (mobile) -->
    <?php require(__DIR__ . "/../layout/professional_navBar.php") ?>

    <div class="d-flex">
        <!-- Barra lateral -->
        <?php require(__DIR__ . "/../layout/professional_sideBar.php") ?>

        <main class="flex-grow-1 d-flex flex-column align-items-center gap-3 bg-body py-3">
            <!-- Cabeçalho -->
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-semibold m-0">Dashboard</h4>
                        <?php if (($User['roleInCompany'] ?? '') === 'owner'): ?>
                            <p class="cs-text-2 m-0">
                                Olá, <?= htmlspecialchars($User['name'] ?? '') ?>,
                                aqui está uma visão geral da atividade da sua empresa.
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="d-none d-sm-flex align-items-center gap-2">
                        <span class="cs-tag-success">
                            <?= htmlspecialchars($roleLabels[$roleInCompany] ?? $roleInCompany) ?>
                        </span>

                        <span class="small fw-normal">
                            <?= htmlspecialchars($User['name'] ?? '') ?>
                        </span>

                        <a href="<?= $appBasePath ?? '' ?>/html/company/profile.php">
                            <img
                                src="<?= htmlspecialchars($User['profile_image'] ?? ($appBasePath ?? '').'/asset/image/profile.webp') ?>"
                                alt="Fotografia do profissional"
                                class="rounded-circle object-fit-cover border-2"
                                width="36"
                                height="36">
                        </a>
                    </div>
                </div>
            </div>

            <!-- Resumo -->
            <div class="container cs-fadeIn-y1">
                <div class="row g-3">
                    <!-- Agendamentos de hoje -->
                    <div class="col-12 col-sm-6 <?= $isOwner ? 'col-xl-3' : 'col-xl-4' ?>">
                        <div class="card cs-shadow border-0 h-100 cs-summary-today">
                            <div class="card-body p-3">
                                <span class="small">Agendamentos de Hoje</span>
                                <h4 class="fw-medium mt-1 mb-1">
                                    <?= $summary['todayAppointment'] ?? 0 ?>
                                </h4>
                                <span class="small opacity-75">
                                    <?= date('d M') ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Agendamentos marcados -->
                    <div class="col-12 col-sm-6 <?= $isOwner ? 'col-xl-3' : 'col-xl-4' ?>">
                        <div class="card cs-shadow border-0 h-100 cs-summary-light">
                            <div class="card-body p-3">
                                <span class="small">Próximos Agendamentos</span>
                                <h4 class="fw-medium mt-1 mb-1">
                                    <?= $summary['ScheduledAppointment'] ?? 0 ?>
                                </h4>
                                <span class="small opacity-75">
                                    Agendamentos futuros
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Receita: apenas proprietário -->
                    <?php if ($isOwner): ?>
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="card cs-shadow border-0 h-100 cs-summary-light">
                                <div class="card-body p-3">
                                    <span class="small">Receita</span>
                                    <h4 class="fw-medium mt-1 mb-1">
                                        €<?= number_format(
                                                $summary['paymentsThisMonths'] ?? 0,
                                                2,
                                                ',',
                                                '.'
                                            ) ?>
                                    </h4>
                                    <span class="small opacity-75">
                                        Este mês
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Avaliações -->
                    <div class="col-12 col-sm-6 <?= $isOwner ? 'col-xl-3' : 'col-xl-4' ?>">
                        <div class="card cs-shadow border-0 h-100 cs-summary-light">
                            <div class="card-body p-3">
                                <span class="small">Avaliações</span>
                                <h4 class="fw-medium mt-1 mb-1">
                                    <?= number_format(
                                        $summary['averageRatingAndCount']['average'] ?? 0,
                                        1,
                                        ',',
                                        ''
                                    ) ?> ★
                                </h4>
                                <span class="small opacity-75">
                                    <?= $summary['averageRatingAndCount']['total'] ?? 0 ?> avaliações
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agendamentos + Estado dos pagamentos -->
            <div class="container cs-fadeIn-y1">
                <div class="row g-3">
                    <!-- Agendamentos de hoje -->
                    <div class="<?= $isOwner ? 'col-12 col-xl-8' : 'col-12' ?> cs-fadeIn-x1">
                        <div class="card cs-shadow h-100">
                            <div class="card-header py-3 px-4 cs-bg-primary cs-text-1">
                                <h6 class="mb-0 fw-medium">Agendamentos de Hoje</h6>
                            </div>

                            <div class="card-body p-0">
                                <div class="list-group list-group-flush overflow-auto" style="max-height: 300px;">
                                    <?php if (!empty($todayAppointments)): ?>
                                        <?php foreach ($todayAppointments as $appointment): ?>
                                            <?php
                                            $status = $appointment['appointment_status'];

                                            $statusLabel = match ($status) {
                                                'scheduled' => 'Agendado',
                                                'completed' => 'Concluído',
                                                'cancelled' => 'Cancelado',
                                                'no_show' => 'Não compareceu',
                                                default => ucfirst($status)
                                            };

                                            $statusClass = match ($status) {
                                                'scheduled' => 'cs-tag-warning',
                                                'completed' => 'cs-tag-success',
                                                'cancelled' => 'cs-tag-danger',
                                                'no_show' => 'cs-tag-secondary',
                                                default => 'cs-tag-secondary'
                                            };

                                            $date = date(
                                                'd M',
                                                strtotime($appointment['appointment_date'])
                                            );

                                            $time = date(
                                                'H:i',
                                                strtotime($appointment['appointment_time'])
                                            );
                                            ?>

                                            <div class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                                                <div>
                                                    <div class="fw-semibold">
                                                        <?= $time ?> -
                                                        <?= htmlspecialchars($appointment['client_name']) ?>
                                                    </div>

                                                    <small class="cs-text-2 fw-medium">
                                                        <?= htmlspecialchars($appointment['service_name']) ?>
                                                        • <?= $date ?>
                                                    </small>
                                                </div>

                                                <span class="<?= $statusClass ?> small fw-medium">
                                                    <?= $statusLabel ?>
                                                </span>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="p-4 text-center">
                                            <p class="mb-0 cs-text-2">
                                                Nenhum agendamento para hoje.
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="card-footer py-3 text-center">
                                <a
                                    href="<?= $appBasePath ?? '' ?>/html/company/appointments.php"
                                    class="cs-text-decoration-none cs-text-3 small">
                                    Ver Todos os Agendamentos
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Estado dos pagamentos: apenas proprietário -->
                    <?php if ($isOwner && !empty($doughnutValue['pago'])): ?>
                        <div class="col-12 col-xl-4">
                            <div class="card cs-shadow h-100 cs-fadeIn-x2">
                                <div class="card-header py-3 px-4 cs-bg-primary cs-text-1">
                                    <h6 class="mb-0 fw-medium">
                                        Estado dos Pagamentos
                                        <span class="fw-normal small">(Este mês)</span>
                                    </h6>
                                </div>

                                <div class="card-body d-flex justify-content-center align-items-center">
                                    <div id="doughnut_container">
                                        <canvas id="doughnut"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Gráfico de receitas: apenas proprietário -->
            <?php if ($isOwner): ?>
                <div class="container cs-fadeIn-y2">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="card cs-shadow">
                                <div class="card-body p-3">
                                    <h6 class="fw-medium mb-3">
                                        Receita e Pagamentos
                                    </h6>

                                    <div style="height: 280px;">
                                        <canvas id="lineChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Serviços + Clientes: apenas proprietário -->
            <?php if ($isOwner): ?>
                <div class="container">
                    <div class="row g-3">
                        <!-- Serviços mais reservados -->
                        <div class="col-12 col-lg-6 cs-fadeIn-x1">
                            <div class="card cs-shadow h-100">
                                <div class="card-header py-3 px-4 cs-bg-primary cs-text-1">
                                    <h6 class="mb-0 fw-medium">
                                        Serviços Mais Reservados
                                    </h6>
                                </div>

                                <div class="card-body p-0">
                                    <div class="list-group list-group-flush">
                                        <?php if (!empty($topFiveServices)): ?>
                                            <?php foreach ($topFiveServices as $service): ?>
                                                <div class="list-group-item px-4 py-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <div class="small fw-medium">
                                                                <?= htmlspecialchars($service['service_name']) ?>
                                                            </div>

                                                            <small class="text-secondary">
                                                                Serviço
                                                            </small>
                                                        </div>

                                                        <span class="badge cs-tag-success rounded-pill px-3 py-2">
                                                            <?= (int) $service['total_bookings'] ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="text-center py-4 px-3">
                                                <small class="text-secondary">
                                                    Nenhum serviço reservado ainda.
                                                </small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="card-footer text-center py-3">
                                    <a
                                        href="<?= $appBasePath ?? '' ?>/html/company/services.php"
                                        class="text-decoration-none cs-text-3 small">
                                        Ver Todos os Serviços
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Clientes recentes -->
                        <div class="col-12 col-lg-6 cs-fadeIn-x2">
                            <div class="card cs-shadow h-100">
                                <div class="card-header py-3 px-4 cs-bg-primary cs-text-1">
                                    <h6 class="mb-0 fw-medium">
                                        Clientes Recentes
                                    </h6>
                                </div>

                                <div class="card-body p-0">
                                    <div
                                        class="list-group list-group-flush overflow-auto"
                                        style="max-height: 330px;">

                                        <?php if (!empty($newClientThisMonth)): ?>
                                            <?php foreach ($newClientThisMonth as $client): ?>
                                                <?php
                                                $name = trim($client['client_name']);
                                                $nameParts = preg_split('/\s+/', $name);

                                                if (count($nameParts) >= 2) {
                                                    $initials = strtoupper(
                                                        mb_substr($nameParts[0], 0, 1) .
                                                            mb_substr($nameParts[count($nameParts) - 1], 0, 1)
                                                    );
                                                } else {
                                                    $initials = strtoupper(mb_substr($name, 0, 2));
                                                }

                                                $months = [
                                                    1 => 'Jan',
                                                    2 => 'Fev',
                                                    3 => 'Mar',
                                                    4 => 'Abr',
                                                    5 => 'Mai',
                                                    6 => 'Jun',
                                                    7 => 'Jul',
                                                    8 => 'Ago',
                                                    9 => 'Set',
                                                    10 => 'Out',
                                                    11 => 'Nov',
                                                    12 => 'Dez'
                                                ];

                                                $bookingDate = strtotime($client['booking_date']);
                                                $date = date('d', $bookingDate) . ' ' .
                                                    $months[(int) date('n', $bookingDate)];
                                                ?>

                                                <div class="list-group-item px-4 py-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="rounded-circle cs-tag-success cs-text-success fw-medium d-flex justify-content-center align-items-center me-3"
                                                                style="width:36px;height:36px;">
                                                                <?= htmlspecialchars($initials) ?>
                                                            </div>

                                                            <div>
                                                                <div class="small fw-medium">
                                                                    <?= htmlspecialchars($name) ?>
                                                                </div>

                                                                <small class="text-secondary">
                                                                    <?= htmlspecialchars($client['service_name']) ?>
                                                                </small>
                                                            </div>
                                                        </div>

                                                        <small class="text-secondary">
                                                            <?= htmlspecialchars($date) ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="text-center py-4">
                                                <small class="text-secondary">
                                                    Nenhum cliente novo este mês.
                                                </small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="card-footer text-center py-3">
                                    <a
                                        href="<?= $appBasePath ?? '' ?>/html/company/clients.php"
                                        class="text-decoration-none cs-text-3 small">
                                        Ver Todos os Clientes
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Scripts -->
    <script src="<?= $appBasePath ?? '' ?>/resources/js/bootstrap.min.js"></script>

    <?php if ($isOwner): ?>
        <!-- Gráficos (apenas proprietário) -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const doughnut_value = <?= json_encode($doughnutValue) ?>;
            const lineChart_value = <?= json_encode($data['totalPaymentPerMonths'] ?? []) ?>;
        </script>

        <script src="<?= $appBasePath ?? '' ?>/resources/js/company/dashboard.js"></script>
    <?php endif; ?>
</body>

</html>