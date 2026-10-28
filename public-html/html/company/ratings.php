<?php
$data = $dataBase ?? [];
$ratingData = $data['rating_data'] ?? [];
$professionals = $data['professionals'] ?? [];
$User = $_SESSION['user'] ?? [];
$appBasePath = $appBasePath ?? '';

$averageRating = (float) ($ratingData[0]['average_rating'] ?? 0);
$totalRatings = (int) ($ratingData[0]['total_rating'] ?? 0);
$ratingCount = count($ratingData);

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
    <title>ReservaJá - Avaliações</title>
    <link rel="stylesheet" href="<?= $appBasePath ?>/resources/css/company/rating.css">
    <link rel="stylesheet" href="<?= $appBasePath ?>/resources/css/components/sideBar.css">
</head>

<body>
    <!-- Barra de navegação (mobile) -->
    <?php require __DIR__ . "/../layout/professional_navBar.php"; ?>
    <div class="d-flex">
        <!-- Barra lateral -->
        <?php require __DIR__ . "/../layout/professional_sideBar.php"; ?>
        <!-- Conteúdo principal -->
        <main class="flex-grow-1 d-flex flex-column gap-3 bg-body py-3">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center gap-3">
                    <div>
                        <h4 class="fw-semibold m-0">Avaliações</h4>
                        <p class="cs-text-2 m-0">Consulte as avaliações e comentários recebidos dos seus clientes.</p>
                    </div>
                    <div class="d-none d-sm-flex align-items-center gap-2">
                        <span class="cs-tag-success">
                            <?= htmlspecialchars($roleLabels[$User['roleInCompany'] ?? ''] ?? $User['roleInCompany'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </span>
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

            <!-- Informação -->
            <div class="container cs-fadeIn-y1">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="card border-0 h-100 cs-shadow rating-summary-primary">
                            <div class="card-body p-3">
                                <span class="small">Média das avaliações</span>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <h4 class="fw-semibold mb-0">
                                        <?= number_format($averageRating, 1, ',', '.') ?>
                                    </h4>
                                    <div class="rating-stars" aria-label="Classificação média">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                                fill="<?= $i <= round($averageRating) ? 'currentColor' : 'none' ?>"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 0-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
                                            </svg>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <span class="small opacity-75">Classificação média dos clientes</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="card border-0 h-100 cs-shadow rating-summary-light">
                            <div class="card-body p-3">
                                <span class="small">Total de avaliações</span>
                                <h4 class="fw-semibold mt-1 mb-1">
                                    <?= number_format($totalRatings, 0, ',', '.') ?>
                                </h4>
                                <span class="small opacity-75">Avaliações recebidas dos clientes</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtro -->
            <?php if ($User['roleInCompany'] == 'owner'): ?>
                <div class="container cs-fadeIn-y1">
                    <form id="ratingFilterForm" method="GET" action="<?= $appBasePath ?>/html/company/ratings.php">
                        <div class="card border">
                            <div class="card-body p-3">
                                <div class="row g-2 justify-content-center">
                                    <div class="col-12 col-sm-auto">
                                        <select id="professionalFilter" class="form-select form-select-sm" name="professional" aria-label="Selecionar profissional">
                                            <option value="all" <?= ($_GET['professional'] ?? 'all') === 'all' ? 'selected' : '' ?>>
                                                Todos os profissionais
                                            </option>
                                            <?php foreach ($professionals as $professional): ?>
                                                <option
                                                    value="<?= (int) $professional['id'] ?>"
                                                    <?= (string) ($_GET['professional'] ?? 'all') === (string) $professional['id'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($professional['name'], ENT_QUOTES, 'UTF-8') ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-auto">
                                        <button type="submit" class="btn btn-sm cs-btn-primary w-100">Pesquisar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Lista -->
            <div class="container cs-fadeIn-y1">
                <section class="rating-list rounded-3">
                    <header class="rating-list-header d-flex align-items-center justify-content-between gap-3">
                        <h5>Avaliações dos clientes</h5>
                        <span class="rating-list-count">
                            <?= $ratingCount ?> <?= $ratingCount === 1 ? 'avaliação' : 'avaliações' ?>
                        </span>
                    </header>

                    <?php if (!empty($ratingData)): ?>
                        <div class="rating-list-body d-flex flex-column">
                            <?php foreach ($ratingData as $rating): ?>
                                <?php
                                $clientName = trim((string) ($rating['client_name'] ?? ''));
                                $nameParts = preg_split('/\s+/u', $clientName, -1, PREG_SPLIT_NO_EMPTY) ?: [];
                                $firstInitial = isset($nameParts[0]) ? mb_substr($nameParts[0], 0, 1, 'UTF-8') : '?';
                                $lastInitial = count($nameParts) > 1 ? mb_substr($nameParts[count($nameParts) - 1], 0, 1, 'UTF-8') : '';
                                $initials = mb_strtoupper($firstInitial . $lastInitial, 'UTF-8');
                                $ratingValue = (int) ($rating['rating'] ?? 0);
                                $professionalId = (string) ($rating['professional_id'] ?? '');
                                ?>
                                <article class="rating-item p-4" data-professional="<?= htmlspecialchars($professionalId, ENT_QUOTES, 'UTF-8') ?>">
                                    <div class="rating-item-header d-flex align-items-center justify-content-between gap-3">
                                        <div class="rating-client d-flex align-items-center gap-3">
                                            <div class="rating-client-avatar rounded-circle flex-shrink-0">
                                                <?= htmlspecialchars($initials, ENT_QUOTES, 'UTF-8') ?>
                                            </div>
                                            <div class="rating-client-details">
                                                <h6 class="rating-client-name">
                                                    <?= htmlspecialchars($clientName, ENT_QUOTES, 'UTF-8') ?>
                                                </h6>
                                                <?php if (!empty($rating['delay_at'])): ?>
                                                    <span class="rating-date">
                                                        <?= date('d/m/Y', strtotime($rating['delay_at'])) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <form
                                            action="<?= $appBasePath ?>/html/company/ratings.php/delete"
                                            method="POST">
                                            <input type="hidden" name="professional" value="<?=$_GET['professional']?>">
                                            <input type="hidden" name="rating_id" value="<?=$rating['id']?>">
                                            <button type="submit" class="rating-delete rounded-3" title="Eliminar avaliação" aria-label="Eliminar avaliação">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M10 11v6" />
                                                    <path d="M14 11v6" />
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                                    <path d="M3 6h18" />
                                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="rating-item-score d-flex align-items-center gap-2">
                                        <div class="rating-stars">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24"
                                                    fill="<?= $i <= $ratingValue ? 'currentColor' : 'none' ?>"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 0-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
                                                </svg>
                                            <?php endfor; ?>
                                        </div>
                                        <span class="rating-score-value"><?= $ratingValue ?><span>/5</span></span>
                                    </div>

                                    <?php if (($_GET['professional'] ?? 'all') === 'all'): ?>
                                        <div class="rating-item-service d-flex flex-wrap align-items-center gap-2">
                                            <span class="rating-info-label">Profissional</span>
                                            <span class="rating-service-name">
                                                <?= htmlspecialchars($rating['professional_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <div class="rating-item-service d-flex flex-wrap align-items-center gap-2">
                                        <span class="rating-info-label">Serviço</span>
                                        <span class="rating-service-name">
                                            <?= htmlspecialchars($rating['service_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                    </div>

                                    <p class="rating-comment mt-3 mb-0 <?= empty($rating['description']) ? 'rating-comment-empty' : '' ?>">
                                        <?= !empty($rating['description'])
                                            ? nl2br(htmlspecialchars($rating['description'], ENT_QUOTES, 'UTF-8'))
                                            : 'Sem comentário.' ?>
                                    </p>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="rating-empty">
                            <div class="rating-empty-icon rounded-3 mx-auto mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 0-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 1 1.597-1.16z" />
                                </svg>
                            </div>
                            <h6>Ainda não existem avaliações</h6>
                            <p>As avaliações dos clientes aparecerão aqui após a conclusão dos serviços.</p>
                        </div>
                    <?php endif; ?>
                </section>
            </div>
        </main>
    </div>
    <!-- Scripts -->
    <script src="<?= $appBasePath ?>/resources/js/bootstrap.min.js"></script>
</body>

</html>