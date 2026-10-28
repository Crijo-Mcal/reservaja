<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'professional') {
    header('Location:'.($appBasePath ?? '').'/html/auth/login.php');
    exit();
}

$User = $_SESSION['user'];
$User['subscription'] = 'free';
$error = $_SESSION['error']['serviceInput'] ?? '';
unset($_SESSION['error']);

$servicesData = $dataBase ?? null;

$tadaInput = ['search' => trim($_GET['service_name'] ?? '')];
?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReservaJá - Services</title>

    <!-- Estilos -->
    <link rel="stylesheet" href="<?= $appBasePath ?? '' ?>/resources/css/company/services.css">

</head>

<body>
    <!-- Barra de navegação -->
    <?php require __DIR__ . "/../../layout/professional_navBar.php"; ?>

    <div class="d-flex">
        <!-- Barra lateral -->
        <?php require __DIR__ . "/../../layout/professional_sideBar.php"; ?>

        <main class="flex-grow-1 d-flex flex-column gap-3 bg-body py-3 ">

            <!-- Cabeçalho -->
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-semibold m-0">Services</h4>
                        <p class="cs-text-2 m-0">
                            Gerir os serviços que disponibiliza aos seus clientes.
                        </p>
                    </div>

                    <!-- Perfil do profissional -->
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
                                class="rounded-circle object-fit-cover border-2"
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

            <!-- Gestão de serviços -->
            <div class="container cs-fadeIn-y1">
                <div class="bg-white border rounded shadow-sm overflow-hidden">

                    <!-- Pesquisa e novo serviço -->
                    <div class="p-3">
                        <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                            <form
                                method="GET"
                                action="<?= $appBasePath ?? '' ?>/html/company/services.php/filter"
                                class="flex-grow-1">
                                <div class="input-group input-group-sm">
                                    <input
                                        type="search"
                                        name="service_name"
                                        class="form-control"
                                        placeholder="Pesquisar serviço..."
                                        value="<?= htmlspecialchars($tadaInput['search'] ?? '') ?>">
                                    <button
                                        type="submit"
                                        class="btn cs-btn-primary">
                                        Pesquisar
                                    </button>
                                </div>
                            </form>

                            <button
                                type="button"
                                class="btn btn-sm cs-btn-primary flex-shrink-0"
                                data-bs-toggle="modal"
                                data-bs-target="#addServiceModal">
                                <span class="me-1">+</span>
                                Novo serviço
                            </button>
                        </div>
                    </div>

                    <?php if (!empty($servicesData)): ?>

                        <!-- Lista mobile e tablet -->
                        <div class="d-lg-none">
                            <div class="p-3">
                                <?php foreach ($servicesData as $service): ?>
                                    <div class="border rounded p-3 mb-3">

                                        <div class="d-flex justify-content-between align-items-start gap-2">
                                            <h6 class="mb-1 service-name fw-medium">
                                                <?= htmlspecialchars($service['name']) ?>
                                            </h6>

                                            <?php if ($service['status'] === 'active'): ?>
                                                <span class="cs-tag-success">
                                                    Ativo
                                                </span>
                                            <?php else: ?>
                                                <span class="cs-tag-muted">
                                                    Inativo
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="row g-3 mt-1">
                                            <div class="col-6">
                                                <div class="cs-text-2 small">Duração</div>
                                                <div>
                                                    <?= htmlspecialchars($service['duration']) ?> min
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="cs-text-2 small">Preço</div>
                                                <div class="service-price">
                                                    €<?= number_format($service['price'], 2, ',', '.') ?>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="cs-text-2 small">IVA</div>
                                                <div>
                                                    <?= number_format($service['vat'], 0, ',', '.') ?>%
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="cs-text-2 small">
                                                    Pagamento antecipado
                                                </div>
                                                <div>
                                                    <?php if ($service['advance_payment'] > 0): ?>
                                                        <?= number_format($service['advance_payment'], 0, ',', '.') ?>%
                                                    <?php else: ?>
                                                        <span class="cs-text-2">—</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="border-top mt-3 pt-3">
                                            <div class="d-flex gap-2">

                                                <button
                                                    type="button"
                                                    class="btn btn-sm btn-outline-secondary flex-grow-1 edit-service"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editServiceModal"
                                                    data-id="<?= htmlspecialchars($service['id']) ?>"
                                                    data-name="<?= htmlspecialchars($service['name'], ENT_QUOTES) ?>"
                                                    data-status="<?= htmlspecialchars($service['status']) ?>"
                                                    data-duration="<?= htmlspecialchars($service['duration']) ?>"
                                                    data-price="<?= htmlspecialchars($service['price']) ?>"
                                                    data-vat="<?= htmlspecialchars($service['vat']) ?>"
                                                    data-advance-payment="<?= htmlspecialchars($service['advance_payment']) ?>"
                                                    data-description="<?= htmlspecialchars($service['description'], ENT_QUOTES) ?>">
                                                    Editar
                                                </button>

                                                <form
                                                    method="POST"
                                                    action="<?= $appBasePath ?? '' ?>/company/services/delete_service"
                                                    class="flex-grow-1">
                                                    <input
                                                        type="hidden"
                                                        name="service_id"
                                                        value="<?= htmlspecialchars($service['id']) ?>">
                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-outline-danger w-100">
                                                        Eliminar
                                                    </button>
                                                </form>

                                            </div>
                                        </div>

                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Lista desktop -->
                        <div class="d-none d-lg-block">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-4 fw-medium text-secondary">
                                                Serviço
                                            </th>
                                            <th class="fw-medium text-secondary">
                                                Duração
                                            </th>
                                            <th class="fw-medium text-secondary">
                                                Preço
                                            </th>
                                            <th class="fw-medium text-secondary">
                                                IVA
                                            </th>
                                            <th class="fw-medium text-secondary">
                                                Pagamento antecipado
                                            </th>
                                            <th class="fw-medium text-secondary">
                                                Estado
                                            </th>
                                            <th class="text-end pe-4 fw-medium text-secondary">
                                                Ações
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($servicesData as $service): ?>
                                            <tr>

                                                <td class="ps-4">
                                                    <div class="service-name">
                                                        <?= htmlspecialchars($service['name']) ?>
                                                    </div>
                                                </td>

                                                <td>
                                                    <?= htmlspecialchars($service['duration']) ?> min
                                                </td>

                                                <td>
                                                    <span class="service-price">
                                                        €<?= number_format($service['price'], 2, ',', '.') ?>
                                                    </span>
                                                </td>

                                                <td>
                                                    <?= number_format($service['vat'], 0, ',', '.') ?>%
                                                </td>

                                                <td>
                                                    <?php if ($service['advance_payment'] > 0): ?>
                                                        <?= number_format($service['advance_payment'], 0, ',', '.') ?>%
                                                    <?php else: ?>
                                                        <span class="cs-text-2">—</span>
                                                    <?php endif; ?>
                                                </td>

                                                <td>
                                                    <?php if ($service['status'] === 'active'): ?>
                                                        <span class="cs-tag-success">
                                                            Ativo
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="cs-tag-muted">
                                                            Inativo
                                                        </span>
                                                    <?php endif; ?>
                                                </td>

                                                <td class="text-end pe-4">
                                                    <div class="d-flex justify-content-end gap-2">

                                                        <button
                                                            type="button"
                                                            class="btn btn-sm btn-light service-action edit-service"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editServiceModal"
                                                            data-id="<?= htmlspecialchars($service['id']) ?>"
                                                            data-name="<?= htmlspecialchars($service['name'], ENT_QUOTES) ?>"
                                                            data-status="<?= htmlspecialchars($service['status']) ?>"
                                                            data-duration="<?= htmlspecialchars($service['duration']) ?>"
                                                            data-price="<?= htmlspecialchars($service['price']) ?>"
                                                            data-vat="<?= htmlspecialchars($service['vat']) ?>"
                                                            data-advance-payment="<?= htmlspecialchars($service['advance_payment']) ?>"
                                                            data-description="<?= htmlspecialchars($service['description'], ENT_QUOTES) ?>"
                                                            title="Editar">
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                width="17"
                                                                height="17"
                                                                viewBox="0 0 24 24"
                                                                fill="none"
                                                                stroke="currentColor"
                                                                stroke-width="2"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <path d="M13 21h8"></path>
                                                                <path d="m15 5 4 4"></path>
                                                                <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path>
                                                            </svg>
                                                        </button>

                                                        <form
                                                            method="POST"
                                                            action="<?= $appBasePath ?? '' ?>/company/services/delete_service"
                                                            class="m-0">
                                                            <input
                                                                type="hidden"
                                                                name="service_id"
                                                                value="<?= htmlspecialchars($service['id']) ?>">
                                                            <button
                                                                type="submit"
                                                                class="btn btn-sm btn-light service-action service-action-delete"
                                                                title="Eliminar">
                                                                <svg
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    width="17"
                                                                    height="17"
                                                                    viewBox="0 0 24 24"
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    stroke-width="2"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round">
                                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                                                                    <path d="M3 6h18"></path>
                                                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                </svg>
                                                            </button>
                                                        </form>

                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    <?php else: ?>

                        <!-- Estado vazio -->
                        <div class="p-3">
                            <div
                                class="border rounded d-flex align-items-center justify-content-center text-center"
                                style="min-height: 160px;">
                                <p class="mb-0 text-secondary">
                                    Não existem serviços disponíveis.
                                </p>
                            </div>
                        </div>

                    <?php endif; ?>

                </div>
            </div>
        </main>
    </div>

    <!-- Modal para editar serviço -->
    <?php require __DIR__ . '/editService_modal.php'; ?>

    <!-- Modal para adicionar serviço -->
    <?php require __DIR__ . '/addService_modal.php'; ?>

    <!-- Scripts -->
    <script src="<?= $appBasePath ?? '' ?>/resources/js/bootstrap.min.js"></script>
    <script src="<?= $appBasePath ?? '' ?>/resources/js/company/services.js"></script>
</body>

</html>