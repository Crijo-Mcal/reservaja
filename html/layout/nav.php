<?php
$User = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'client'
    ? $_SESSION['user']
    : [];

$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$isHome = $currentPath === ($appBasePath ?? '')."/html/client/home.php";
$isProfessionalSearch = $currentPath === ($appBasePath ?? '')."/html/client/professionals.php";
$isClientHistory = $currentPath === ($appBasePath ?? '')."/html/client/history.php";
$isClientProfile = $currentPath === ($appBasePath ?? '')."/html/client/profile.php";
$isClientPayment = $currentPath === ($appBasePath ?? '')."/html/client/active_payment.php";

$profileInitials = '';

if (!empty($User['name'])) {
    $nameParts = preg_split('/\s+/', trim($User['name']));
    $firstName = $nameParts[0] ?? '';
    $lastName = count($nameParts) > 1 ? $nameParts[count($nameParts) - 1] : '';
    $profileInitials =
        mb_strtoupper(mb_substr($firstName, 0, 1)) .
        mb_strtoupper(mb_substr($lastName, 0, 1));
}
?>

<nav class="navbar navbar-expand-lg cs-bg-primary border-bottom">
    <div class="container">
        <!-- Logo -->
        <a href="<?= $appBasePath ?? '' ?>/html/client/home.php" class="navbar-brand d-flex align-items-center gap-2">
            <span class="d-flex align-items-center justify-content-center bg-teal text-white rounded-3 fw-bold cs-logo">R</span>
            <span class="text-white fw-semibold cs-logo-text">ReservaJá</span>
        </a>

        <!-- Mobile toggle -->
        <button
            class="navbar-toggler border-0 p-1 text-white shadow-none"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarContent"
            aria-controls="navbarContent"
            aria-expanded="false"
            aria-label="Abrir menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 5h16" />
                <path d="M4 12h16" />
                <path d="M4 19h16" />
            </svg>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Mobile -->
            <div class="d-lg-none w-100 py-3">
                <?php if (!empty($User)): ?>
                    <div class="d-flex flex-column align-items-center gap-2 pb-3">
                        <a href="<?= $appBasePath ?? '' ?>/html/client/profile.php" class="d-flex align-items-center justify-content-center rounded-circle bg-teal text-white text-decoration-none fw-semibold cs-profile-mobile">
                            <?= htmlspecialchars($profileInitials) ?>
                        </a>

                        <?php if (!empty($User['name'])): ?>
                            <span class="text-white fw-semibold">
                                <?= htmlspecialchars($User['name']) ?>
                            </span>
                        <?php endif; ?>

                        <form action="<?= $appBasePath ?? '' ?>/auth/logout" method="POST" class="container">
                            <button type="submit" class="cs-btn-primary d-block w-100 py-2 rounded-5 text-center text-decoration-none">
                                Logout
                            </button>
                        </form>
                        
                    </div>
                <?php else: ?>
                    <div class="pb-3">
                        <a href="<?= $appBasePath ?? '' ?>/html/auth/login.php" class="cs-btn-primary d-block w-100 py-2 rounded-5 text-center text-decoration-none">
                            Log In
                        </a>
                    </div>
                <?php endif; ?>

                <hr class="border-light opacity-25 my-0">

                <ul class="navbar-nav pt-2">
                    <li class="nav-item">
                        <a
                            href="<?= $appBasePath ?? '' ?>/html/client/home.php"
                            class="nav-link rounded-2 px-3 <?= $isHome ? 'nav-active' : 'text-white' ?>">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            href="<?= $appBasePath ?? '' ?>/html/client/professionals.php"
                            class="nav-link rounded-2 px-3 <?= $isProfessionalSearch ? 'nav-active' : 'text-white' ?>">
                            Profissionais
                        </a>
                    </li>
                    <?php if ($User): ?>
                        <li class="nav-item">
                            <a
                                href="<?= $appBasePath ?? '' ?>/html/client/history.php"
                                class="nav-link rounded-2 px-3 <?= $isClientHistory ? 'nav-active' : 'text-white' ?>">
                                Histórico
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a
                                href="<?= $appBasePath ?? '' ?>/html/client/profile.php"
                                class="nav-link rounded-2 px-3 <?= $isClientProfile ? 'nav-active' : 'text-white' ?>">
                                Perfil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a
                                href="<?= $appBasePath ?? '' ?>/html/client/active_payment.php"
                                class="nav-link rounded-2 px-3 <?= $isClientPayment ? 'nav-active' : 'text-white' ?>">
                                pagamento
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Desktop -->
            <div class="d-none d-lg-flex align-items-center ms-auto">
                <ul class="navbar-nav align-items-center gap-1">
                    <li class="nav-item">
                        <a
                            href="<?= $appBasePath ?? '' ?>/html/client/home.php"
                            class="nav-link rounded-2 px-3 <?= $isHome ? 'nav-active' : 'text-white' ?>">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            href="<?= $appBasePath ?? '' ?>/html/client/professionals.php"
                            class="nav-link rounded-2 px-3 <?= $isProfessionalSearch ? 'nav-active' : 'text-white' ?>">
                            Profissionais
                        </a>
                    </li>

                    <?php if ($User): ?>
                        <li class="nav-item">
                            <a
                                href="<?= $appBasePath ?? '' ?>/html/client/history.php"
                                class="nav-link rounded-2 px-3 <?= $isClientHistory ? 'nav-active' : 'text-white' ?>">
                                Histórico
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a
                                href="<?= $appBasePath ?? '' ?>/html/client/profile.php"
                                class="nav-link rounded-2 px-3 <?= $isClientProfile ? 'nav-active' : 'text-white' ?>">
                                Perfil
                            </a>
                        </li>
                          <li class="nav-item">
                            <a
                                href="<?= $appBasePath ?? '' ?>/html/client/active_payment.php"
                                class="nav-link rounded-2 px-3 <?= $isClientPayment ? 'nav-active' : 'text-white' ?>">
                                pagamento
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <div class="d-flex align-items-center gap-3 ms-3 ps-3 border-start border-light border-opacity-10">
                    <?php if (empty($User)): ?>
                        <a
                            href="<?= $appBasePath ?? '' ?>/html/auth/login.php"
                            class="cs-btn-primary px-4 py-2 rounded-5 text-decoration-none">
                            Log In
                        </a>
                    <?php else: ?>
                        <form action="<?= $appBasePath ?? '' ?>/auth/logout" method="POST">
                            <button type="submit" class="cs-btn-primary px-4 py-2 rounded-5">
                                Logout
                            </button>
                        </form>

                        <a
                            href="<?= $appBasePath ?? '' ?>/html/client/profile.php"
                            class="d-flex align-items-center justify-content-center rounded-circle bg-teal text-white text-decoration-none fw-semibold cs-profile">
                            <?= htmlspecialchars($profileInitials) ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Navbar */
    .navbar.cs-bg-primary {
        background-color: var(--color1) !important;
    }

    .navbar {
        color: var(--color3);
    }

    .navbar.border-bottom {
        border-bottom-color: rgba(255, 255, 255, .08) !important;
    }

    /* Logo */
    .cs-logo {
        width: 35px;
        height: 35px;
        font-size: 19px;
        background-color: var(--color2) !important;
        color: var(--color3) !important;
    }

    .cs-logo-text {
        font-size: 21px;
        letter-spacing: -.4px;
        color: var(--color3) !important;
    }

    /* Navigation */
    .navbar .nav-link {
        font-size: 14px;
        font-weight: 500;
        color: var(--color3) !important;
        transition: color .2s ease, background-color .2s ease;
    }

    .navbar .nav-link:hover {
        color: var(--color2) !important;
        background-color: rgba(255, 255, 255, .05);
    }

    .navbar .nav-link.nav-active {
        color: var(--color2) !important;
        background-color: rgba(255, 255, 255, .06);
    }

    /* Login / Logout */
    .cs-btn-primary {
        background-color: var(--color2) !important;
        border: 1px solid var(--color2) !important;
        color: var(--color3) !important;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: background-color .2s ease, border-color .2s ease, opacity .2s ease;
    }

    .cs-btn-primary:hover {
        background-color: var(--color2) !important;
        border-color: var(--color2) !important;
        color: var(--color3) !important;
        opacity: .9;
    }

    .cs-btn-primary:focus,
    .cs-btn-primary:active {
        background-color: var(--color2) !important;
        border-color: var(--color2) !important;
        color: var(--color3) !important;
        box-shadow: none !important;
    }

    /* Profile */
    .bg-teal {
        background-color: var(--color2) !important;
    }

    .cs-profile {
        width: 38px;
        height: 38px;
        font-size: 12px;
        background-color: var(--color2) !important;
        color: var(--color3) !important;
    }

    .cs-profile-mobile {
        width: 62px;
        height: 62px;
        font-size: 19px;
        background-color: var(--color2) !important;
        color: var(--color3) !important;
    }

    /* Mobile */
    .navbar .navbar-toggler {
        color: var(--color3) !important;
        border: 0 !important;
        box-shadow: none !important;
    }

    .navbar .navbar-toggler:focus {
        box-shadow: none !important;
    }

    .navbar .navbar-toggler svg {
        stroke: currentColor;
    }

    .navbar hr.border-light {
        border-color: rgba(255, 255, 255, .15) !important;
    }

    .navbar .border-start {
        border-color: rgba(255, 255, 255, .10) !important;
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