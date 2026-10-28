<?php

$User = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'client'
    ? $_SESSION['user']
    : [];

$dataBase = $dataBase ?? [];
$company = $dataBase['company'] ?? [];
$companyName = $company['name'] ?? 'Nome da Empresa';
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($companyName) ?> - Reservas online</title>
    <meta name="description" content="Conheça <?= htmlspecialchars($companyName) ?>, consulte os serviços disponíveis e faça a sua reserva online através do ReservaJá.">
    <link rel="stylesheet" href="<?= $appBasePath ?? '' ?>/resources/css/client/home.css">
</head>

<body>
<?php require(__DIR__ . '/../layout/nav.php') ?>

<main>
    <!-- HERO: apresentação da empresa e acesso à reserva -->
    <section class="rj-hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-12 col-lg-6">
                    <div class="rj-hero-content">
                        <div class="rj-eyebrow cs-fadeIn-y1">
                            <span></span>
                            <?= htmlspecialchars($companyName) ?>
                        </div>

                        <h1 class="rj-hero-title cs-fadeIn-y2">
                            Escolha o serviço.
                            <br>
                            <span>Escolha o horário.</span>
                        </h1>

                        <p class="rj-hero-description cs-fadeIn-y3">
                            Consulte os serviços disponíveis, escolha o profissional e
                            encontre um horário conveniente. Faça a sua reserva online
                            de forma simples e rápida.
                        </p>

                        <div class="d-flex flex-column flex-sm-row gap-2 cs-fadeIn-y4">
                            <a href="#como-reservar" class="btn rj-btn rj-btn-lg">
                                Fazer uma reserva
                                <i class="bi bi-arrow-right"></i>
                            </a>
                            <a href="#servicos" class="btn rj-btn-outline rj-btn-lg">
                                Ver serviços
                            </a>
                        </div>

                        <div class="rj-hero-note cs-fadeIn-y5">
                            <i class="bi bi-shield-check"></i>
                            <span>Reserva online</span>
                            <span class="rj-note-separator">•</span>
                            <span>Disponibilidade atualizada</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="rj-hero-visual cs-fadeIn-y3">
                        <div class="rj-image-wrapper">
                            <img
                                src="https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&w=1200&q=85"
                                class="rj-hero-image"
                                alt="Atendimento profissional numa empresa"
                            >
                            <div class="rj-image-overlay"></div>
                        </div>

                        <div class="rj-floating-card rj-floating-card-top">
                            <div class="rj-floating-icon">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div>
                                <small>Reserva online</small>
                                <strong>Horário selecionado</strong>
                            </div>
                        </div>

                        <div class="rj-floating-card rj-floating-card-bottom">
                            <div class="rj-floating-icon">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <div>
                                <small>Estado da reserva</small>
                                <strong>Confirmada</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- INTRO: explica a experiência do cliente -->
    <section class="rj-intro">
        <div class="container">
            <div class="rj-intro-content">
                <span class="rj-section-label">Uma experiência simples</span>
                <h2>Tenha tudo o que precisa antes da sua visita.</h2>
                <p>
                    O ReservaJá permite consultar a informação da empresa, conhecer
                    os serviços disponíveis e escolher uma data e horário sem
                    necessidade de contacto manual.
                </p>
            </div>

            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="rj-benefit">
                        <div class="rj-benefit-icon">
                            <i class="bi bi-list-check"></i>
                        </div>
                        <div>
                            <h3>Consulte os serviços</h3>
                            <p>Veja os serviços disponíveis, duração e informação antes de reservar.</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="rj-benefit">
                        <div class="rj-benefit-icon">
                            <i class="bi bi-calendar3"></i>
                        </div>
                        <div>
                            <h3>Escolha o horário</h3>
                            <p>Consulte a disponibilidade e escolha o momento mais conveniente.</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="rj-benefit">
                        <div class="rj-benefit-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div>
                            <h3>Confirme a reserva</h3>
                            <p>Confirme os seus dados e receba a informação da sua marcação.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVIÇOS: área dedicada aos serviços da empresa -->
    <section id="servicos" class="rj-section rj-section-soft">
        <div class="container">
            <div class="rj-section-heading">
                <span class="rj-section-label">Serviços</span>
                <h2>Encontre o serviço que procura.</h2>
                <p>
                    Consulte os serviços disponibilizados pela <?= htmlspecialchars($companyName) ?>
                    e escolha a opção mais adequada às suas necessidades.
                </p>
            </div>

            <div class="row g-3">
                <div class="col-12 col-md-4">
                    <div class="rj-service-card">
                        <div class="rj-service-icon"><i class="bi bi-briefcase"></i></div>
                        <h3>Serviços disponíveis</h3>
                        <p>Consulte a lista de serviços e respetiva duração antes de avançar.</p>
                        <a href="#como-reservar" class="rj-text-link">Consultar e reservar <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="rj-service-card">
                        <div class="rj-service-icon"><i class="bi bi-person"></i></div>
                        <h3>Profissional</h3>
                        <p>Quando aplicável, escolha o profissional com quem pretende realizar o serviço.</p>
                        <a href="#como-reservar" class="rj-text-link">Escolher profissional <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="rj-service-card">
                        <div class="rj-service-icon"><i class="bi bi-clock"></i></div>
                        <h3>Horário</h3>
                        <p>Veja os horários disponíveis e selecione uma opção adequada para si.</p>
                        <a href="#como-reservar" class="rj-text-link">Ver disponibilidade <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- COMO RESERVAR: fluxo principal para o cliente -->
    <section id="como-reservar" class="rj-section">
        <div class="container">
            <div class="rj-section-heading">
                <span class="rj-section-label">Como reservar</span>
                <h2>Uma reserva em poucos passos.</h2>
                <p>
                    O processo foi pensado para que possa marcar o seu serviço
                    sem complicações.
                </p>
            </div>

            <div class="row g-4">
                <div class="col-12 col-md-4">
                    <div class="rj-step-card">
                        <span class="rj-step-number">01</span>
                        <div class="rj-step-icon"><i class="bi bi-list-check"></i></div>
                        <h3>Escolha o serviço</h3>
                        <p>Selecione o serviço que pretende realizar na empresa.</p>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="rj-step-card">
                        <span class="rj-step-number">02</span>
                        <div class="rj-step-icon"><i class="bi bi-calendar-week"></i></div>
                        <h3>Escolha data e horário</h3>
                        <p>Consulte a disponibilidade e escolha o horário pretendido.</p>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="rj-step-card">
                        <span class="rj-step-number">03</span>
                        <div class="rj-step-icon"><i class="bi bi-check2-circle"></i></div>
                        <h3>Confirme a reserva</h3>
                        <p>Introduza os seus dados, confirme e finalize a marcação.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- AGENDA: mostra o benefício da disponibilidade online -->
    <section class="rj-product-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-12 col-lg-6">
                    <div class="rj-product-image">
                        <img
                            src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?auto=format&fit=crop&w=1200&q=85"
                            alt="Agenda e marcação de serviços"
                        >
                        <div class="rj-product-badge">
                            <i class="bi bi-calendar-check"></i>
                            Disponibilidade online
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="rj-product-content">
                        <span class="rj-section-label">Disponibilidade</span>
                        <h2>Escolha o momento certo para si.</h2>
                        <p>
                            Consulte os horários disponíveis diretamente no processo
                            de reserva e escolha uma opção que se adapte à sua agenda.
                        </p>

                        <ul>
                            <li><i class="bi bi-check-circle-fill"></i> Disponibilidade atualizada</li>
                            <li><i class="bi bi-check-circle-fill"></i> Data e horário à sua escolha</li>
                            <li><i class="bi bi-check-circle-fill"></i> Menos trocas de mensagens</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PAGAMENTO: mantém a informação sobre pagamentos, mas focada no cliente -->
    <section class="rj-dark-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-12 col-lg-6 order-lg-2">
                    <div class="rj-product-image rj-dark-image">
                        <img
                            src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=1200&q=85"
                            alt="Pagamento online de uma reserva"
                        >
                        <div class="rj-product-badge">
                            <i class="bi bi-shield-check"></i>
                            Pagamento integrado
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6 order-lg-1">
                    <div class="rj-dark-content">
                        <span class="rj-section-label">Pagamento</span>
                        <h2>Quando necessário, pague durante a reserva.</h2>
                        <p>
                            Alguns serviços podem exigir pagamento antecipado.
                            Quando essa opção estiver disponível, o pagamento
                            faz parte do próprio processo de reserva.
                        </p>

                        <div class="rj-dark-highlight">
                            <i class="bi bi-shield-check"></i>
                            <div>
                                <strong>Processo integrado</strong>
                                <span>Reserve e, quando aplicável, conclua o pagamento no mesmo processo.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- INFORMAÇÃO DA EMPRESA: reforça que a página pertence a uma empresa -->
    <section class="rj-section">
        <div class="container">
            <div class="rj-company-card">
                <div class="rj-company-icon"><i class="bi bi-building"></i></div>
                <div>
                    <span class="rj-section-label">Sobre a empresa</span>
                    <h2><?= htmlspecialchars($companyName) ?></h2>
                    <p>
                        Consulte os serviços e horários disponíveis e faça a sua
                        reserva online. Todas as informações apresentadas nesta
                        página estão associadas à empresa.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ: dúvidas diretamente relacionadas com a reserva -->
    <section id="ajuda" class="rj-section rj-section-soft">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="rj-section-heading">
                        <span class="rj-section-label">Ajuda</span>
                        <h2>Perguntas frequentes.</h2>
                        <p>Informação rápida sobre o processo de reserva.</p>
                    </div>

                    <div class="accordion rj-faq" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne" aria-expanded="false" aria-controls="faqOne">
                                    Como faço uma reserva?
                                </button>
                            </h2>
                            <div id="faqOne" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Escolha um serviço, selecione a data e o horário disponível,
                                    introduza os seus dados e confirme a reserva.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo" aria-expanded="false" aria-controls="faqTwo">
                                    Posso escolher o profissional?
                                </button>
                            </h2>
                            <div id="faqTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Quando a empresa disponibilizar essa opção, poderá escolher
                                    o profissional durante o processo de reserva.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqThree" aria-expanded="false" aria-controls="faqThree">
                                    É necessário pagar antecipadamente?
                                </button>
                            </h2>
                            <div id="faqThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Depende do serviço e das condições definidas pela empresa.
                                    Quando for necessário, o pagamento será apresentado durante a reserva.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqFour" aria-expanded="false" aria-controls="faqFour">
                                    Posso consultar a minha reserva?
                                </button>
                            </h2>
                            <div id="faqFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Sim. Depois de efetuar a reserva, poderá consultar a informação
                                    associada à sua marcação através da área de cliente, quando disponível.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA FINAL: ação principal da homepage -->
    <section class="rj-cta-section">
        <div class="container">
            <div class="rj-cta">
                <div class="rj-cta-content">
                    <span class="rj-section-label">Reserve online</span>
                    <h2>Já sabe o que pretende marcar?</h2>
                    <p>
                        Escolha o serviço, encontre um horário disponível e faça
                        a sua reserva de forma simples.
                    </p>
                    <a href="#como-reservar" class="btn rj-btn rj-btn-lg">
                        Fazer uma reserva
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require(__DIR__ . '/../layout/footer.php') ?>
<script src="<?= $appBasePath ?? '' ?>/resources/bootstrap/bootstrap.min.js"></script>

</body>
</html>