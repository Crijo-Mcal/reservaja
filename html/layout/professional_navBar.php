<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$nav = explode('/', trim($currentPath, '/'))[3] ?? '';
?>

<!-- Barra de navegação da área profissional (apenas mobile) -->
<nav class="navbar navbar-expand-lg cs-bg-primary border-bottom d-lg-none sticky-top">
    <div class="container">
        <!-- Logótipo -->
        <a href="<?= $appBasePath ?? '' ?>/html/company/dashboard.php" class="navbar-brand d-flex align-items-center gap-2">
            <span class="d-flex align-items-center justify-content-center bg-teal text-white rounded-3 fw-bold cs-logo">
                R
            </span>
            <span class="text-white fw-semibold cs-logo-text">ReservaJá</span>
        </a>

        <!-- Botão do menu (mobile) -->
        <button
            class="navbar-toggler border-0 p-1 text-white shadow-none"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#professionalNavbarContent"
            aria-controls="professionalNavbarContent"
            aria-expanded="false"
            aria-label="Abrir menu">
            <svg xmlns="http://www.w3.org/2000/svg"
                width="25"
                height="25"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M4 5h16" />
                <path d="M4 12h16" />
                <path d="M4 19h16" />
            </svg>
        </button>

        <!-- Menu colapsável -->
        <div class="collapse navbar-collapse" id="professionalNavbarContent">
            <div class="w-100 py-3">
                <!-- Perfil -->
                <?php if (isset($User)): ?>
                    <div class="d-flex flex-column align-items-center gap-2 pb-3">
                        <a
                            href="<?= $appBasePath ?? '' ?>/html/company/profile.php"
                            class="d-flex align-items-center justify-content-center rounded-circle bg-teal text-white text-decoration-none fw-semibold cs-profile-mobile">
                            <img
                                src="<?= htmlspecialchars($User['profile_image'] ?? '') ?>"
                                alt="Fotografia de <?= htmlspecialchars($User['name'] ?? 'profissional') ?>"
                                class="rounded-circle w-100 h-100 object-fit-cover">
                        </a>

                        <?php if (!empty($User['name'])): ?>
                            <span class="text-white fw-semibold">
                                <?= htmlspecialchars($User['name']) ?>
                            </span>
                        <?php endif; ?>

                        <a href="<?= $appBasePath ?? '' ?>/company/subscription" class="text-decoration-none">
                            <span class="small cs-text-3">
                                Parceiro <?= htmlspecialchars($User['subscription'] ?? '') ?>
                            </span>
                        </a>
                    </div>
                <?php endif; ?>

                <hr class="border-light opacity-25 my-0">

                <!-- Menu -->
                <ul class="navbar-nav pt-2">
                    <li class="nav-item">
                        <a
                            href="<?= $appBasePath ?? '' ?>/html/company/dashboard.php"
                            class="nav-link rounded-2 px-3 <?= $nav === 'dashboard' ? 'nav-active' : 'text-white' ?>"
                            <?= $nav === 'dashboard' ? 'aria-current="page"' : '' ?>>
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            href="<?= $appBasePath ?? '' ?>/html/company/appointments.php"
                            class="nav-link rounded-2 px-3 <?= $nav === 'appointments' ? 'nav-active' : 'text-white' ?>"
                            <?= $nav === 'appointments' ? 'aria-current="page"' : '' ?>>
                            Agendamentos
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            href="<?= $appBasePath ?? '' ?>/html/company/schedules.php"
                            class="nav-link rounded-2 px-3 <?= $nav === 'schedules' ? 'nav-active' : 'text-white' ?>"
                            <?= $nav === 'schedules' ? 'aria-current="page"' : '' ?>>
                            Horários
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            href="<?= $appBasePath ?? '' ?>/html/company/services.php"
                            class="nav-link rounded-2 px-3 <?= $nav === 'services' ? 'nav-active' : 'text-white' ?>"
                            <?= $nav === 'services' ? 'aria-current="page"' : '' ?>>
                            Serviços
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            href="<?= $appBasePath ?? '' ?>/html/company/clients.php"
                            class="nav-link rounded-2 px-3 <?= $nav === 'clients' ? 'nav-active' : 'text-white' ?>"
                            <?= $nav === 'clients' ? 'aria-current="page"' : '' ?>>
                            Clientes
                        </a>
                    </li>

                    <?php if (($User['roleInCompany'] ?? '') === 'owner'): ?>
                        <li class="nav-item">
                            <a
                                href="<?= $appBasePath ?? '' ?>/html/company/payments.php"
                                class="nav-link rounded-2 px-3 <?= $nav === 'payments' ? 'nav-active' : 'text-white' ?>"
                                <?= $nav === 'payments' ? 'aria-current="page"' : '' ?>>
                                Pagamentos
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                href="<?= $appBasePath ?? '' ?>/html/company/professionals/professionals.php"
                                class="nav-link rounded-2 px-3 <?= $nav === 'professionals' ? 'nav-active' : 'text-white' ?>"
                                <?= $nav === 'professionals' ? 'aria-current="page"' : '' ?>>
                                professionais
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a
                            href="<?= $appBasePath ?? '' ?>/html/company/ratings.php?professional=<?= $User['id'] ?? '' ?>"
                            class="nav-link rounded-2 px-3 <?= $nav === 'ratings' ? 'nav-active' : 'text-white' ?>"
                            <?= $nav === 'ratings' ? 'aria-current="page"' : '' ?>>
                            Avaliações
                        </a>
                    </li>

                    <!-- Terminar sessão -->
                    <li class="nav-item mt-2 pt-2 border-top border-light border-opacity-25">
                        <a
                            href="<?= $appBasePath ?? '' ?>/logout"
                            class="nav-link rounded-2 px-3 text-white d-flex align-items-center">
                            <i class="bi bi-box-arrow-right"></i>
                            Terminar sessão
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Estilos da barra de navegação (mobile) -->
<style>
    /* Barra de navegação */
    nav {
        background-color: var(--color1);
    }

    /* Logótipo */
    .cs-logo {
        width: 35px;
        height: 35px;
        font-size: 19px;
    }

    .cs-logo-text {
        font-size: 21px;
        letter-spacing: -0.4px;
    }

    .cs-profile-mobile {
        width: 62px;
        height: 62px;
        overflow: hidden;
        font-size: 19px;
    }

    .navbar .nav-link {
        font-size: 14px;
        font-weight: 500;
        transition: color .2s ease, background-color .2s ease;
    }

    .navbar .nav-link:hover {
        color: var(--color2) !important;
        background-color: rgba(255, 255, 255, .05);
    }

    .nav-active {
        color: var(--color2) !important;
        background-color: rgba(255, 255, 255, .06);
    }

    .bg-teal {
        background-color: var(--color2) !important;
    }

    @media (max-width: 991.98px) {
        .cs-logo {
            width: 34px;
            height: 34px;
        }

        .cs-logo-text {
            font-size: 20px;
        }
    }
</style>