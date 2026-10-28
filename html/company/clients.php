<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'professional') {
    header('Location:'.($appBasePath ?? '').'/html/auth/login.php');
    exit();
}
$User = $_SESSION['user'];
$User['subscription'] = 'free';
$data = $dataBase ?? [];
$summary = $data['summary'] ?? [];
$clients = $data['clients'] ?? [];

$tadaInput = ['search' => trim($_GET['client_name'] ?? '')];
?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReservaJá - Clientes</title>
    <link rel="stylesheet" href="<?= $appBasePath ?? '' ?>/resources/css/company/client.css">
</head>

<body>

    <!-- Barra de navegação (mobile) -->
    <?php require __DIR__ . "/../layout/professional_navBar.php"; ?>

    <div class="d-flex">
        <!-- Barra lateral -->
        <?php require __DIR__ . "/../layout/professional_sideBar.php"; ?>

        <main class="flex-grow-1 bg-body py-3">

            <!-- Cabeçalho -->
            <div class="container mb-3">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
                    <div>
                        <h4 class="fw-semibold mb-1">Clientes</h4>
                        <p class="cs-text-2 mb-0">Consulte os clientes que já tiveram agendamentos consigo.</p>
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
                                src="<?= $User['profile_image'] ?? ($appBasePath ?? '').'/asset/image/profile.webp' ?>"
                                alt="Fotografia do profissional"
                                class="rounded-circle object-fit-cover border"
                                width="36"
                                height="36">
                        </a>

                    </div>
                </div>
            </div>

            <!-- Resumo -->
            <div class="container mb-3 cs-fadeIn-y1">
                <div class="row g-3">
                    <div class="col-6 col-xl-4">
                        <div class="card border-0 shadow-sm h-100 cs-summary-today">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div> <span class="small opacity-75">Total de clientes</span>
                                        <h4 class="fw-semibold mt-1 mb-0"> <?= $summary['total_client'] ?? 0 ?> </h4>
                                    </div> <i class="bi bi-people fs-5 opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-xl-4">
                        <div class="card border-0 shadow-sm h-100 cs-summary-light">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div> <span class="small opacity-75">Novos clientes</span>
                                        <h4 class="fw-semibold mt-1 mb-1"> <?= $summary['new_client'] ?? 0 ?> </h4> <span class="small opacity-75">Este mês</span>
                                    </div> <i class="bi bi-person-plus fs-5 opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="card border-0 shadow-sm h-100 cs-summary-light">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div> <span class="small opacity-75">Clientes ativos</span>
                                        <h4 class="fw-semibold mt-1 mb-1"> <?= $summary['active_client'] ?? 0 ?> </h4> <span class="small opacity-75">Mais de 3 bookings este mês</span>
                                    </div> <i class="bi bi-arrow-repeat fs-5 opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtro -->
            <div class="container mb-3 cs-fadeIn-y1">
                <form method="GET" action="<?= $appBasePath ?? '' ?>/html/company/clients.php/filter">
                    <div class="card border">
                        <div class="card-body p-3">
                            <div class="input-group input-group-sm">
                                <input type="text"
                                    class="form-control"
                                    name="client_name"
                                    placeholder="Pesquisar cliente por nome"
                                    aria-label="Pesquisar cliente por nome"
                                    value="<?= htmlspecialchars($tadaInput['search'] ?? null) ?>">

                                <button type="submit" class="btn cs-btn-primary px-3">
                                    Pesquisar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Lista de clientes -->
            <div class="container cs-fadeIn-y1">
                <div class="card border-0 shadow-sm overflow-hidden">

                    <div class="card-header px-3 px-md-4 py-3 cs-bg-primary cs-text-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0 fw-semibold">
                                Clientes
                            </h6>

                            <span class="badge rounded-pill text-bg-light">
                                <?= count($clients) ?>
                            </span>
                        </div>
                    </div>

                    <?php if (!empty($clients)): ?>

                        <!-- Tabela Desktop -->
                        <div class="d-none d-lg-block">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="px-3 px-xl-4 py-3">
                                            Cliente
                                        </th>
                                        <th class="py-3">
                                            Contacto
                                        </th>
                                        <th class="py-3">
                                            Último atendimento
                                        </th>
                                        <th class="py-3 text-center">
                                            Total
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($clients as $client): ?>
                                        <tr>

                                            <td class="px-3 px-xl-4">
                                                <div>
                                                    <div class="fw-medium">
                                                        <?= htmlspecialchars($client['client_name']) ?>
                                                    </div>

                                                    <div class="small cs-text-2">
                                                        <?= htmlspecialchars($client['client_email']) ?>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($client['client_mobile']) ?>
                                            </td>

                                            <td>
                                                <?= date('d/m/Y', strtotime($client['last_appointment'])) ?>
                                            </td>

                                            <td class="text-center">
                                                <?= $client['total_appointments'] ?>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Cartões tablet / mobile -->
                        <div class="d-lg-none p-2 p-sm-3">
                            <div class="row g-2 g-sm-3">

                                <?php foreach ($clients as $client): ?>
                                    <div class="col-12">
                                        <article class="card border shadow-sm rounded-4">
                                            <div class="card-body p-3">

                                                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start gap-2">
                                                    <div>
                                                        <h6 class="fw-semibold mb-1">
                                                            <?= htmlspecialchars($client['client_name']) ?>
                                                        </h6>

                                                        <span class="small cs-text-2">
                                                            <?= htmlspecialchars($client['client_email']) ?>
                                                        </span>
                                                    </div>

                                                    <span class="badge rounded-pill text-bg-light">
                                                        <?= $client['total_appointments'] ?> agendamentos
                                                    </span>
                                                </div>

                                                <div class="row g-2 mt-2">

                                                    <div class="col-12 col-sm-6">
                                                        <div class="border rounded-3 p-2">
                                                            <span class="small cs-text-2 d-block">
                                                                Contacto
                                                            </span>

                                                            <strong class="small">
                                                                <?= htmlspecialchars($client['client_mobile']) ?>
                                                            </strong>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-sm-6">
                                                        <div class="border rounded-3 p-2">
                                                            <span class="small cs-text-2 d-block">
                                                                Último atendimento
                                                            </span>

                                                            <strong class="small">
                                                                <?= date('d/m/Y', strtotime($client['last_appointment'])) ?>
                                                            </strong>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </div>

                    <?php else: ?>

                        <!-- Estado vazio -->
                        <div class="p-3">
                            <div
                                class="border rounded d-flex align-items-center justify-content-center text-center"
                                style="min-height: 160px;">
                                <p class="mb-0 text-secondary">
                                    Não existem clientes registados.
                                </p>
                            </div>
                        </div>

                    <?php endif; ?>

                </div>
            </div>

        </main>
    </div>

    <!-- Scripts -->
    <script src="<?= $appBasePath ?? '' ?>/resources/js/bootstrap.min.js"></script>

</body>

</html>