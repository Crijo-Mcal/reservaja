<?php

$data = $dataBase ?? [];

$User = $_SESSION['user'] ?? [];
$appBasePath = $appBasePath ?? '';


$roleLabels = [
    'owner' => 'Proprietário',
    'employee' => 'Funcionário',
    'technician' => 'Técnico'
];

$statusLabels = [
    'active' => 'Ativo',
    'inactive' => 'Inativo'
];

?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReservaJá - Profissionais</title>
    <link rel="stylesheet" href="<?= $appBasePath ?>/resources/css/company/professionals.css">
</head>

<body>

    <?php require __DIR__ . "/../../layout/professional_navBar.php"; ?>

    <div class="d-flex">

        <?php require __DIR__ . "/../../layout/professional_sideBar.php"; ?>

        <main class="flex-grow-1 d-flex flex-column gap-3 bg-body py-3">

            <!-- Header -->
            <div class="container">
                <div class="d-flex justify-content-between align-items-center gap-3">
                    <div>
                        <h4 class="fw-semibold m-0">Profissionais</h4>
                        <p class="cs-text-2 m-0">
                            Consulte e gira os profissionais da sua empresa.
                        </p>
                    </div>

                    <div class="d-none d-sm-flex align-items-center gap-2">
                        <span class="cs-tag-success">Proprietário</span>

                        <span class="small fw-medium">
                            <?= htmlspecialchars($User['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </span>

                        <a href="<?= $appBasePath ?>/html/company/profile.php">
                            <img
                                src="<?= htmlspecialchars($User['profile_image'] ?? $appBasePath . '/asset/image/profile.webp', ENT_QUOTES, 'UTF-8') ?>"
                                alt="Fotografia"
                                class="rounded-circle object-fit-cover"
                                width="36"
                                height="36">
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filter -->
            <!-- <div class="container">
                <form method="GET" action="<?= $appBasePath ?>/html/company/professionals.php">
                    <div class="card border">
                        <div class="card-body p-3">
                            <div class="row g-2 align-items-center">

                                <div class="col-12 col-md">
                                    <input
                                        type="search"
                                        name="search"
                                        class="form-control form-control-sm"
                                        placeholder="Pesquisar profissional..."
                                        value="<?= htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        aria-label="Pesquisar profissional">
                                </div>

                                <div class="col-12 col-md-auto">
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="all">Todos os estados</option>
                                        <option value="active" <?= ($_GET['status'] ?? '') === 'active' ? 'selected' : '' ?>>
                                            Ativos
                                        </option>
                                        <option value="inactive" <?= ($_GET['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>
                                            Inativos
                                        </option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-auto">
                                    <button type="submit" class="btn btn-sm cs-btn-primary w-100">
                                        Pesquisar
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div> -->

            <!-- Professionals list -->
            <div class="container cs-fadeIn-y1">
                <section class="professional-list rounded-3">

                    <header class="professional-list-header d-flex align-items-center justify-content-between gap-3">
                        <h5>Equipa de profissionais</h5>
                        <span class="professional-list-count">
                            <?= count($data) ?> profissionais
                        </span>
                    </header>

                    <div class="professional-list-body p-3">

                        <?php if (empty($data)): ?>

                            <div class="text-center text-secondary py-4">
                                Nenhum profissional encontrado.
                            </div>

                        <?php else: ?>

                            <?php foreach ($data as $professional): ?>

                                <?php
                                $status = $professional['status'] ?? 'inactive';
                                $isActive = $status === 'active';
                                $image = $professional['profile_image']
                                    ?: $appBasePath . '/asset/image/profile.webp';

                                $professionalJson = htmlspecialchars(
                                    json_encode($professional, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP),
                                    ENT_QUOTES,
                                    'UTF-8'
                                );
                                ?>

                                <article class="card professional-card mb-3">
                                    <div class="card-body p-3">
                                        <div class="row g-3 align-items-center">

                                            <!-- Profile -->
                                            <div class="col-12 col-md">
                                                <div class="d-flex align-items-center gap-3">

                                                    <img
                                                        src="<?= htmlspecialchars($image, ENT_QUOTES, 'UTF-8') ?>"
                                                        alt="Fotografia do profissional"
                                                        class="professional-avatar rounded-circle object-fit-cover">

                                                    <div class="professional-info">
                                                        <h6 class="fw-semibold mb-1">
                                                            <?= htmlspecialchars($professional['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                                        </h6>

                                                        <p class="text-secondary small mb-2">
                                                            <?= htmlspecialchars(
                                                                $roleLabels[$professional['role_company'] ?? ''] ?? $professional['role_company'] ?? '',
                                                                ENT_QUOTES,
                                                                'UTF-8'
                                                            ) ?>

                                                            <?= !empty($professional['speciality'])
                                                                ? ' · ' . htmlspecialchars($professional['speciality'], ENT_QUOTES, 'UTF-8')
                                                                : '' ?>
                                                        </p>

                                                        <span class="badge rounded-pill <?= $isActive ? 'professional-status-active' : 'professional-status-inactive' ?>">
                                                            <span class="professional-status-dot"></span>
                                                            <?= htmlspecialchars($statusLabels[$status] ?? $status, ENT_QUOTES, 'UTF-8') ?>
                                                        </span>
                                                    </div>

                                                </div>
                                            </div>

                                            <!-- Actions -->
                                            <div class="col-12 col-md-auto">
                                                <div class="d-flex flex-wrap align-items-center gap-2">
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-outline-secondary"
                                                        data-professional-update
                                                        data-id="<?= (int) $professional['id'] ?>"
                                                        data-name="<?= htmlspecialchars($professional['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                                        data-mobile="<?= htmlspecialchars($professional['mobile_number'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                                        data-speciality="<?= htmlspecialchars($professional['speciality'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                                        data-role="<?= htmlspecialchars($professional['role_company'] ?? 'employee', ENT_QUOTES, 'UTF-8') ?>"
                                                        data-status="<?= htmlspecialchars($professional['status'] ?? 'inactive', ENT_QUOTES, 'UTF-8') ?>"
                                                        data-description="<?= htmlspecialchars($professional['description'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                                                        Atualizar
                                                    </button>


                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-outline-secondary"
                                                        data-professional-schedules
                                                        data-id="<?= (int) $professional['id'] ?>"
                                                        data-name="<?= htmlspecialchars($professional['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                                        data-schedules="<?= htmlspecialchars(json_encode($professional['schedules'] ?? [], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP), ENT_QUOTES, 'UTF-8') ?>">
                                                        Horários
                                                    </button>



                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-outline-secondary"
                                                        data-professional-services
                                                        data-id="<?= (int) $professional['id'] ?>"
                                                        data-name="<?= htmlspecialchars($professional['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                                        data-services="<?= htmlspecialchars(json_encode($professional['services'] ?? [], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP), ENT_QUOTES, 'UTF-8') ?>">
                                                        Serviços
                                                    </button>

                                                    <button
                                                        type="button"
                                                        class="btn btn-sm cs-btn-primary"
                                                        data-professional-appointments
                                                        data-id="<?= (int) $professional['id'] ?>"
                                                        data-name="<?= htmlspecialchars($professional['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                                        data-appointments="<?= htmlspecialchars(json_encode($professional['appointments'] ?? [], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP), ENT_QUOTES, 'UTF-8') ?>">
                                                        Agendamentos
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </article>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </div>
                </section>
            </div>

        </main>
    </div>

    <?php require_once __DIR__ . '/apointment_modal.php' ?>
    <?php require_once __DIR__ . '/schedule_modal.php' ?>
    <?php require_once __DIR__ . '/service_modal.php' ?>
    <?php require_once __DIR__ . '/update_modal.php' ?>


    <script src="<?= $appBasePath ?>/resources/js/bootstrap.min.js"></script>
    <script src="<?= $appBasePath ?>/resources/js/company/professionals.js"></script>

</body>

</html>