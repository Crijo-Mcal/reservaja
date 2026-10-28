<?php
$data = $dataBase ?? [];

$professional = $data['professional_data'] ?? [];
$company = $data['company_data'] ?? [];
$schedules = $data['schedule_data'] ?? [];
$services = $data['service_data'] ?? [];

$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);

$professionalId = (int) ($professional['id'] ?? 0);
$professionalName = $professional['name'] ?? 'Profissional';
$professionalEmail = $professional['email'] ?? '';
$professionalPhone = $professional['mobile_number'] ?? '';
$professionalTaxNumber = $professional['tax_number'] ?? '';
$professionalSpeciality = $professional['speciality'] ?? 'Especialidade não disponível';
$professionalImage = $professional['profile_image'] ?? ($appBasePath ?? '')."/asset/image/profile.webp";
$professionalDescription = $professional['description'] ?? '';

$companyName = $company['name'] ?? 'Empresa';
$companyEmail = $company['email'] ?? '';
$companyPhone = $company['phone'] ?? '';
$companyTaxNumber = $company['tax_number'] ?? '';
$companyLogo = $company['logo'] ?? ($appBasePath ?? '').'/asset/image/logo.webp';
$companyLocation = $company['location'] ?? '';
$companyDescription = $company['description'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReservaJá - <?= htmlspecialchars($professionalName) ?></title>
    <link rel="stylesheet" href="<?= $appBasePath ?? '' ?>/resources/css/client/professional_detail.css">
</head>

<body>

    <!-- Barra de navegação -->
    <?php require(__DIR__ . '/../layout/nav.php') ?>

    <main>
        <!-- Profissional -->
        <section class="professional-section py-4 py-md-5">
            <div class="container">
                <div class="hero p-3 p-md-4">
                    <div class="professional-header">
                        <div class="professional-main">
                            <div class="professional-photo flex-shrink-0">
                                <img
                                    src="<?= htmlspecialchars($professionalImage) ?>"
                                    alt="<?= htmlspecialchars($professionalName) ?>">
                            </div>

                            <div class="professional-info">

                                <h1 class="mb-1">
                                    <?= htmlspecialchars($professionalName) ?>
                                </h1>

                                <p class="speciality mb-2">
                                    <?= htmlspecialchars($professionalSpeciality) ?>
                                </p>

                                <!-- Avaliação -->
                                <div class="professional-rating">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="rating-star"
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

                                    <strong class="rating-average">
                                        <?= htmlspecialchars($professional['rating_average'] ?? '0') ?>
                                    </strong>

                                    <span class="rating-count">
                                        (<?= (int) ($professional['rating_count'] ?? 0) ?> avaliações)
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Contacto do profissional -->
                        <div class="professional-contact">
                            <?php if ($professionalEmail): ?>
                                <div class="professional-contact-item">
                                    <span>Email</span>
                                    <strong class="text-break">
                                        <?= htmlspecialchars($professionalEmail) ?>
                                    </strong>
                                </div>
                            <?php endif; ?>

                            <?php if ($professionalPhone): ?>
                                <div class="professional-contact-item">
                                    <span>Telefone</span>
                                    <strong>
                                        <?= htmlspecialchars($professionalPhone) ?>
                                    </strong>
                                </div>
                            <?php endif; ?>

                            <?php if ($professionalTaxNumber): ?>
                                <div class="professional-contact-item">
                                    <span>NIF</span>
                                    <strong>
                                        <?= htmlspecialchars($professionalTaxNumber) ?>
                                    </strong>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($professionalDescription): ?>
                        <p class="hero-description mt-4 pt-3 mb-0">
                            <?= nl2br(htmlspecialchars($professionalDescription)) ?>
                        </p>
                    <?php endif; ?>

                    <!-- Navegação rápida -->
                    <nav class="professional-navigation" aria-label="Navegação da página">
                        <a href="#empresa" class="professional-nav-link">
                            Empresa
                        </a>

                        <a href="#servicos" class="professional-nav-link">
                            Serviços
                        </a>

                        <a href="#horarios" class="professional-nav-link">
                            Horários
                        </a>
                    </nav>
                </div>
            </div>
        </section>

        <!-- Alerta -->
        <?php if ($error): ?>
            <div class="container p-3">
                <div class="alert rj-alert alert-dismissible fade show mb-0" role="alert">
                    <p class="mb-0">
                        <?= htmlspecialchars($error['noSchedule'] ?? '') ?>
                        <?= htmlspecialchars($error['invalidBooking'] ?? '') ?>
                        <?= htmlspecialchars($error['invalidPayment'] ?? '') ?>
                    </p>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Fechar">
                    </button>
                </div>
            </div>
        <?php endif; ?>

        <!-- Conteúdo da página: empresa, serviços e horários -->
        <div class="container page-content py-5 cs-fadeIn-y2">

            <!-- Empresa -->
            <section class="content-section company-section" id="empresa">
                <div class="section-header mb-4">
                    <div class="section-step">
                        <span class="step-number">1</span>
                        <div>
                            <h2 class="mb-0">Sobre a empresa</h2>
                        </div>
                    </div>
                </div>

                <div class="company-layout row g-0">
                    <div class="company-main col-12 col-lg-7 p-3 p-md-4">
                        <div class="company-heading">
                            <div class="company-logo flex-shrink-0">
                                <img
                                    src="<?= htmlspecialchars($companyLogo) ?>"
                                    alt="<?= htmlspecialchars($companyName) ?>">
                            </div>

                            <div class="company-title">

                                <h3 class="company-name mb-0 text-break">
                                    <?= htmlspecialchars($companyName) ?>
                                </h3>
                            </div>
                        </div>

                        <?php if ($companyDescription): ?>
                            <p class="company-description mt-3 mb-0">
                                <?= nl2br(htmlspecialchars($companyDescription)) ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="company-contact col-12 col-lg-5 p-3 p-md-4">
                        <?php if ($companyLocation): ?>
                            <div class="contact-item">
                                <span class="contact-label">Localização</span>
                                <strong class="contact-value">
                                    <?= htmlspecialchars($companyLocation) ?>
                                </strong>
                            </div>
                        <?php endif; ?>

                        <?php if ($companyPhone): ?>
                            <div class="contact-item">
                                <span class="contact-label">Telefone</span>
                                <strong class="contact-value">
                                    <?= htmlspecialchars($companyPhone) ?>
                                </strong>
                            </div>
                        <?php endif; ?>

                        <?php if ($companyEmail): ?>
                            <div class="contact-item">
                                <span class="contact-label">Email</span>
                                <strong class="contact-value text-break">
                                    <?= htmlspecialchars($companyEmail) ?>
                                </strong>
                            </div>
                        <?php endif; ?>

                        <?php if ($companyTaxNumber): ?>
                            <div class="contact-item">
                                <span class="contact-label">NIF</span>
                                <strong class="contact-value">
                                    <?= htmlspecialchars($companyTaxNumber) ?>
                                </strong>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>

            <!-- Serviços -->
            <section class="content-section services-section" id="servicos">
                <div class="section-header mb-4">
                    <div class="section-step">
                        <span class="step-number">2</span>
                        <div>
                            <h2 class="mb-0">Serviços disponíveis</h2>
                        </div>
                    </div>
                </div>

                <?php if (!empty($services)): ?>
                    <div class="row g-4">
                        <?php foreach ($services as $service): ?>
                            <?php
                            $serviceId = (int) ($service['id'] ?? 0);
                            $serviceName = $service['name'] ?? 'Serviço';
                            $serviceDescription = $service['description'] ?? '';
                            $duration = (int) ($service['duration'] ?? 0);
                            $price = (float) ($service['price'] ?? 0);
                            $vat = (float) ($service['vat'] ?? 0);
                            $advance = (float) ($service['advance_payment'] ?? 0);
                            ?>

                            <div class="col-12 col-md-6 col-xl-4">
                                <article class="service-card h-100 p-4">
                                    <div>
                                        <h3 class="service-name mb-2">
                                            <?= htmlspecialchars($serviceName) ?>
                                        </h3>

                                        <?php if ($serviceDescription): ?>
                                            <p class="service-description mb-0">
                                                <?= nl2br(htmlspecialchars($serviceDescription)) ?>
                                            </p>
                                        <?php else: ?>
                                            <p class="service-description service-description-empty mb-0">
                                                Sem descrição disponível.
                                            </p>
                                        <?php endif; ?>
                                    </div>

                                    <div class="service-summary">
                                        <div class="service-summary-content">
                                            <div class="service-summary-item">
                                                <span>Preço</span>
                                                <strong>
                                                    €<?= number_format($price, 2, ',', '.') ?>
                                                </strong>
                                            </div>

                                            <div class="service-summary-divider"></div>

                                            <div class="service-summary-item">
                                                <span>Duração</span>
                                                <strong>
                                                    <?= $duration ?> min
                                                </strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2 mt-3">
                                        <button
                                            type="button"
                                            class="btn service-details flex-fill"
                                            data-bs-toggle="modal"
                                            data-bs-target="#serviceModal"
                                            data-professional-id="<?= $professionalId ?>"
                                            data-service-id="<?= $serviceId ?>"
                                            data-service-name="<?= htmlspecialchars($serviceName, ENT_QUOTES, 'UTF-8') ?>"
                                            data-service-description="<?= htmlspecialchars($serviceDescription, ENT_QUOTES, 'UTF-8') ?>"
                                            data-service-duration="<?= $duration ?>"
                                            data-service-price="<?= number_format($price, 2, '.', '') ?>"
                                            data-service-vat="<?= number_format($vat, 2, '.', '') ?>"
                                            data-service-advance="<?= number_format($advance, 2, '.', '') ?>">
                                            Detalhes
                                        </button>

                                        <a
                                            href="<?= $appBasePath ?? '' ?>/html/client/booking.php?service_id=<?= $serviceId ?>&professional_id=<?= $professionalId ?>"
                                            class="btn service-select flex-fill">
                                            Reservar
                                        </a>
                                    </div>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state p-4">
                        <p class="mb-0">
                            Não existem serviços disponíveis.
                        </p>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Disponibilidade -->
            <section class="content-section availability-section" id="horarios">
                <div class="section-header mb-4">
                    <div class="section-step">
                        <span class="step-number">3</span>
                        <div>
                            <h2 class="mb-0">Horários disponíveis</h2>
                        </div>
                    </div>
                </div>

                <?php if (!empty($schedules)): ?>
                    <div class="row g-3">
                        <?php foreach ($schedules as $schedule): ?>
                            <?php
                            $timestamp = strtotime($schedule['date']);

                            $days = [
                                'Mon' => 'Segunda-feira',
                                'Tue' => 'Terça-feira',
                                'Wed' => 'Quarta-feira',
                                'Thu' => 'Quinta-feira',
                                'Fri' => 'Sexta-feira',
                                'Sat' => 'Sábado',
                                'Sun' => 'Domingo'
                            ];

                            $dayName = $days[date('D', $timestamp)] ?? date('D', $timestamp);
                            ?>

                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="schedule-item d-flex align-items-center justify-content-between gap-3 p-3 h-100">
                                    <div class="schedule-date">
                                        <span><?= htmlspecialchars($dayName) ?></span>
                                        <strong><?= date('d', $timestamp) ?></strong>
                                        <small><?= date('m/Y', $timestamp) ?></small>
                                    </div>

                                    <div class="schedule-time d-flex align-items-center justify-content-end gap-3">
                                        <div class="d-flex flex-column">
                                            <span>Entrada</span>
                                            <strong>
                                                <?= date('H:i', strtotime($schedule['start_time'])) ?>
                                            </strong>
                                        </div>

                                        <div class="schedule-separator"></div>

                                        <div class="d-flex flex-column">
                                            <span>Saída</span>
                                            <strong>
                                                <?= date('H:i', strtotime($schedule['end_time'])) ?>
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state p-4">
                        <p class="mb-0">
                            Não existem horários disponíveis.
                        </p>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <!-- Rodapé -->
    <?php require(__DIR__ . '/../layout/footer.php') ?>

    <!-- Modal de detalhes do serviço -->
    <div
        class="modal fade"
        id="serviceModal"
        tabindex="-1"
        aria-labelledby="serviceModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content service-modal">
                <div class="modal-header">
                    <div>
                        <span class="modal-label">SERVIÇO</span>

                        <h2 class="modal-title" id="serviceModalLabel">
                            Serviço
                        </h2>
                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Fechar">
                    </button>
                </div>

                <div class="modal-body">
                    <p class="modal-description" id="serviceModalDescription"></p>

                    <div class="modal-information">
                        <div class="modal-info-item d-flex justify-content-between align-items-center gap-3">
                            <span>Duração</span>
                            <strong id="serviceModalDuration"></strong>
                        </div>

                        <div class="modal-info-item d-flex justify-content-between align-items-center gap-3">
                            <span>Preço</span>
                            <strong id="serviceModalPrice"></strong>
                        </div>

                        <div class="modal-info-item d-flex justify-content-between align-items-center gap-3">
                            <span>IVA</span>
                            <strong id="serviceModalVat"></strong>
                        </div>

                        <div class="modal-info-item d-flex justify-content-between align-items-center gap-3">
                            <span>Pagamento antecipado</span>
                            <strong id="serviceModalAdvance"></strong>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <a
                        href="#"
                        id="serviceModalSelect"
                        class="modal-select w-100">
                        Continuar para reserva
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?= $appBasePath ?? '' ?>/resources/bootstrap/bootstrap.min.js"></script>
    <script src="<?= $appBasePath ?? '' ?>/resources/js/client/professional_detail.js"></script>

</body>

</html>