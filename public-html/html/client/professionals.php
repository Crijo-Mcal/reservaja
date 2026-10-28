<?php
$data = $dataBase ?? [];

$professionals = $data['professionals'] ?? [];
$professionalsSpeciality = $data['allspeciality'] ?? [];
$rating = $rating_data[0] ?? null;

$professionalName = $_GET['professional_name'] ?? '';
$professionalSpeciality = $_GET['professional_speciality'] ?? '';

$professionalCount = count($professionals);

?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReservaJá - Profissionais</title>
    <link rel="stylesheet" href="<?= $appBasePath ?? '' ?>/resources/css/client/professionals.css">
</head>

<body>

    <!-- Barra de navegação -->
    <?php require(__DIR__ . '/../layout/nav.php') ?>

    <main class="flex-grow-1">

        <!-- Pesquisa de profissionais -->
        <section class="search-section py-4">
            <div class="container">
                <form method="GET" action="<?= $appBasePath ?? '' ?>/html/client/professionals.php">
                    <div class="search-card card border-0 shadow-sm rounded-3 mx-auto">
                        <div class="card-body p-3">
                            <div class="row g-3">
                                <div class="col-12 col-md-5">
                                    <input
                                        type="text"
                                        id="professionalName"
                                        name="professional_name"
                                        value="<?= htmlspecialchars($professionalName) ?>"
                                        class="form-control"
                                        placeholder="Nome do profissional"
                                        autocomplete="off">
                                </div>

                                <div class="col-12 col-md-5">
                                    <select
                                        id="professionalSpeciality"
                                        name="professional_speciality"
                                        class="form-select">
                                        <option value="">Todas as especialidades</option>

                                        <?php foreach ($professionalsSpeciality as $professional): ?>
                                            <?php if (!empty($professional['speciality'])): ?>
                                                <option
                                                    value="<?= htmlspecialchars($professional['speciality']) ?>"
                                                    <?= $professionalSpeciality === $professional['speciality'] ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars(ucfirst($professional['speciality'])) ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-12 col-md-2">
                                    <button type="submit" class="btn cs-btn-primary w-100">
                                        Pesquisar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- Lista de profissionais -->
        <section class="results-section py-5">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="results-title mb-0">Profissionais disponíveis</h2>

                    <span class="badge rounded-pill bg-light text-secondary border">
                        <?= $professionalCount ?>
                        <?= $professionalCount === 1 ? 'profissional' : 'profissionais' ?>
                    </span>
                </div>

                <?php if (!empty($professionals)): ?>

                    <div class="row g-4 cs-fadeIn-y2">

                        <?php foreach ($professionals as $professional): ?>

                            <?php
                            $ratingAverage = (float) ($professional['rating_average'] ?? 0);
                            $ratingCount = (int) ($professional['rating_count'] ?? 0);
                            ?>

                            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                                <article class="professional-card h-100">

                                    <!-- Imagem do profissional -->
                                    <div class="professional-image">
                                        <img
                                            src="<?= htmlspecialchars(
                                                        !empty($professional['profile_image'])
                                                            ? $professional['profile_image']
                                                            : ($appBasePath ?? '') . '/asset/image/profile.webp'
                                                    ) ?>"
                                            alt="<?= htmlspecialchars($professional['name'] ?? 'Profissional') ?>"
                                            loading="lazy"
                                            decoding="async">
                                    </div>

                                    <div class="professional-content p-3">

                                        <!-- Dados principais -->
                                        <div class="professional-info">
                                            <h3>
                                                <?= !empty($professional['name'])
                                                    ? htmlspecialchars($professional['name'])
                                                    : 'Profissional'
                                                ?>
                                            </h3>

                                            <div class="professional-speciality">
                                                <?= !empty($professional['speciality'])
                                                    ? htmlspecialchars(ucfirst($professional['speciality']))
                                                    : 'Especialidade não disponível'
                                                ?>
                                            </div>

                                            <!-- Avaliação -->
                                            <div class="professional-rating">
                                                <span class="rating-star" aria-hidden="true">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="16"
                                                        height="16"
                                                        viewBox="0 0 24 24"
                                                        fill="currentColor"
                                                        stroke="currentColor"
                                                        stroke-width="2"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                                    </svg>
                                                </span>

                                                <span class="rating-value">
                                                    <?= number_format($ratingAverage, 1, ',', '') ?>
                                                </span>

                                                <span class="rating-separator">·</span>

                                                <span class="rating-count">
                                                    <?= number_format($ratingCount, 0, ',', '.') ?>
                                                    avaliações
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Acesso ao perfil -->
                                        <form
                                            action="<?= $appBasePath ?? '' ?>/html/client/professional_detail.php"
                                            method="GET"
                                            class="mt-3">
                                            <input
                                                type="hidden"
                                                name="professional_id"
                                                value="<?= htmlspecialchars($professional['id'] ?? '') ?>">

                                            <button type="submit" class="btn cs-btn-primary w-100">
                                                Ver perfil
                                            </button>
                                        </form>

                                    </div>
                                </article>
                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php else: ?>

                    <!-- Sem resultados -->
                    <div class="empty-state text-center p-4 p-md-5">
                        <h3>Nenhum profissional encontrado</h3>
                        <p>Tente alterar os filtros da pesquisa.</p>

                        <a
                            href="<?= $appBasePath ?? '' ?>/html/client/professionals.php"
                            class="btn cs-btn-primary">
                            Limpar pesquisa
                        </a>
                    </div>

                <?php endif; ?>

            </div>
        </section>

    </main>

    <!-- Modal de avaliação do profissional -->
    <?php
    $rating_data = $data['rating_data'] ?? [];
    $rating = $rating_data[0] ?? null;
    ?>

    <?php if (!empty($rating)): ?>
        <div
            class="modal fade"
            id="ratingModal"
            tabindex="-1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content rating-modal">
                    <div class="modal-body p-4">
                        <div class="text-center mb-3">
                            <h5 class="rating-professional-name mb-1">
                                <?= htmlspecialchars($rating['professional_name'] ?? 'Profissional') ?>
                            </h5>

                            <span class="rating-professional-speciality">
                                <?= htmlspecialchars($rating['professional_speciality'] ?? '') ?>
                            </span>
                        </div>

                        <form
                            action="<?= $appBasePath ?? '' ?>/company/ratings/update"
                            method="POST">
                            <input
                                type="hidden"
                                name="appointment_id"
                                value="<?= htmlspecialchars($rating['appointments_id'] ?? '') ?>">

                            <input
                                type="hidden"
                                name="rating"
                                value=""
                                data-rating-input>

                            <div class="rating-stars" data-rating-stars></div>

                            <div
                                class="rating-text text-center"
                                data-rating-text>
                                Selecione uma avaliação
                            </div>

                            <div class="mt-3">
                                <textarea
                                    name="description"
                                    class="form-control rating-description"
                                    rows="3"
                                    placeholder="Comentário (opcional)"></textarea>
                            </div>

                            <button
                                type="submit"
                                class="btn cs-btn-primary w-100 mt-3"
                                data-submit-rating
                                disabled>
                                Enviar avaliação
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Rodapé -->
    <?php require(__DIR__ . '/../layout/footer.php') ?>

    <!-- Scripts -->
    <script src="<?= $appBasePath ?? '' ?>/resources/js/bootstrap.min.js"></script>
    <script src="<?= $appBasePath ?? '' ?>/resources/js/client/professionals.js"></script>

</body>

</html>