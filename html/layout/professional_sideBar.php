<?php
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$nav = basename($currentPath, '.php');

?>

<!-- Barra lateral (desktop) -->
<aside class="cs-bg-primary text-white d-none d-sm-flex flex-column align-items-center cs-prof-sidebar">
    <!-- Logótipo -->
    <div class="w-90 d-flex align-items-center" style="height: 66px;">
        <div class="logo">
            <h1>R</h1>
            <h1>ReservaJá</h1>
        </div>
    </div>

    <!-- Navegação -->
    <nav class="w-90 d-flex flex-column gap-1 mt-3">
        <!-- Painel -->
        <div class="cs-sidebar-item <?= $nav === 'dashboard' ? 'cs-sidebar-item-active' : '' ?>">
            <a href="<?= $appBasePath ?? '' ?>/html/company/dashboard.php"
                class="cs-text-decoration-none d-flex align-items-center gap-2">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.5 1H1.75C1.33579 1 1 1.33579 1 1.75V7C1 7.41421 1.33579 7.75 1.75 7.75H5.5C5.91421 7.75 6.25 7.41421 6.25 7V1.75C6.25 1.33579 5.91421 1 5.5 1Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    <path d="M13.75 1H10C9.58579 1 9.25 1.33579 9.25 1.75V4C9.25 4.41421 9.58579 4.75 10 4.75H13.75C14.1642 4.75 14.5 4.41421 14.5 4V1.75C14.5 1.33579 14.1642 1 13.75 1Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    <path d="M13.75 7.75H10C9.58579 7.75 9.25 8.08579 9.25 8.5V13.75C9.25 14.1642 9.58579 14.5 10 14.5H13.75C14.1642 14.5 14.5 14.1642 14.5 13.75V8.5C14.5 8.08579 14.1642 7.75 13.75 7.75Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    <path d="M5.5 10.75H1.75C1.33579 10.75 1 11.0858 1 11.5V13.75C1 14.1642 1.33579 14.5 1.75 14.5H5.5C5.91421 14.5 6.25 14.1642 6.25 13.75V11.5C6.25 11.0858 5.91421 10.75 5.5 10.75Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
                <span>Dashboard</span>
            </a>
        </div>

        <!-- Agendamentos -->
        <div class="cs-sidebar-item <?= $nav === 'appointments' ? 'cs-sidebar-item-active' : '' ?>">
            <a href="<?= $appBasePath ?? '' ?>/html/company/appointments.php"
                class="cs-text-decoration-none d-flex align-items-center gap-2">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 14v2.2l1.6 1" />
                    <path d="M16 4h2a2 2 0 0 1 2 2v.832" />
                    <path d="M8 4H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h2" />
                    <circle cx="16" cy="16" r="6" />
                    <rect x="8" y="2" width="8" height="4" rx="1" />
                </svg>
                <span>Agendamentos</span>
            </a>
        </div>

        <!-- Horários -->
        <div class="cs-sidebar-item <?= $nav === 'schedules' ? 'cs-sidebar-item-active' : '' ?>">
            <a href="<?= $appBasePath ?? '' ?>/html/company/schedules.php"
                class="cs-text-decoration-none d-flex align-items-center gap-2">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_84_19)">
                        <path d="M9 4.49963V8.99999L12.0002 10.5001M16.5006 8.99999C16.5006 13.1425 13.1425 16.5006 9 16.5006C4.85754 16.5006 1.4994 13.1425 1.4994 8.99999C1.4994 4.85752 4.85754 1.49939 9 1.49939C13.1425 1.49939 16.5006 4.85752 16.5006 8.99999Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </g>
                    <defs>
                        <clipPath id="clip0_84_19">
                            <rect width="18" height="18" fill="white" />
                        </clipPath>
                    </defs>
                </svg>
                <span>Horários</span>
            </a>
        </div>

        <!-- Serviços -->
        <div class="cs-sidebar-item <?= $nav === 'services' ? 'cs-sidebar-item-active' : '' ?>">
            <a href="<?= $appBasePath ?? '' ?>/html/company/services.php"
                class="cs-text-decoration-none d-flex align-items-center gap-2">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.0002 14.9994V2.9994C12.0002 2.60158 11.8422 2.22005 11.5609 1.93874C11.2795 1.65744 10.898 1.4994 10.5001 1.4994H7.49987C7.10201 1.4994 6.72045 1.65744 6.43912 1.93874C6.1578 2.22005 5.99975 2.60158 5.99975 2.9994V14.9994M2.99951 4.4994H15.0005C15.829 4.4994 16.5006 5.17098 16.5006 5.9994V13.4994C16.5006 14.3278 15.829 14.9994 15.0005 14.9994H2.99951C2.17102 14.9994 1.49939 14.3278 1.49939 13.4994V5.9994C1.49939 5.17098 2.17102 4.4994 2.99951 4.4994Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
                <span>Serviços</span>
            </a>
        </div>

        <!-- Clientes -->
        <div class="cs-sidebar-item <?= $nav === 'clients' ? 'cs-sidebar-item-active' : '' ?>">
            <a href="<?= $appBasePath ?? '' ?>/html/company/clients.php"
                class="cs-text-decoration-none d-flex align-items-center gap-2">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.0002 15.75V14.25C12.0002 13.4544 11.6841 12.6913 11.1215 12.1287C10.5588 11.5661 9.79572 11.25 9 11.25H4.49964C3.70393 11.25 2.94081 11.5661 2.37815 12.1287C1.8155 12.6913 1.4994 13.4544 1.4994 14.25V15.75M12.0002 2.34595C12.6436 2.51272 13.2134 2.8884 13.6201 3.41399C14.0269 3.93959 14.2476 4.58536 14.2476 5.24995C14.2476 5.91453 14.0269 6.5603 13.6201 7.0859C13.2134 7.6115 12.6436 7.98717 12.0002 8.15395M16.5006 15.7499V14.2499C16.5001 13.5852 16.2789 12.9395 15.8716 12.4141C15.4643 11.8888 14.8941 11.5136 14.2504 11.3474M9.75006 5.25C9.75006 6.90685 8.40681 8.25 6.74982 8.25C5.09284 8.25 3.74958 6.90685 3.74958 5.25C3.74958 3.59315 5.09284 2.25 6.74982 2.25C8.40681 2.25 9.75006 3.59315 9.75006 5.25Z"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
                <span>Clientes</span>
            </a>
        </div>

        <!-- Pagamentos -->
        <?php if (($User['roleInCompany'] ?? '') === 'owner'): ?>
            <div class="cs-sidebar-item <?= $nav === 'payments' ? 'cs-sidebar-item-active' : '' ?>">
                <a href="<?= $appBasePath ?? '' ?>/html/company/payments.php"
                    class="cs-text-decoration-none d-flex align-items-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.4994 7.49982H16.5006M2.99952 3.74939H15.0005C15.829 3.74939 16.5006 4.42104 16.5006 5.24956V12.7504C16.5006 13.5789 15.829 14.2506 15.0005 14.2506H2.99952C2.17103 14.2506 1.4994 13.5789 1.4994 12.7504V5.24956C1.4994 4.42104 2.17103 3.74939 2.99952 3.74939Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    <span>Pagamentos</span>
                </a>
            </div>

            <!-- Profissionais -->
            <div class="cs-sidebar-item <?= $nav === 'professionals' ? 'cs-sidebar-item-active' : '' ?>">
                <a href="<?= $appBasePath ?? '' ?>/html/company/professionals/professionals.php"
                    class="cs-text-decoration-none d-flex align-items-center gap-2">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16.051 12.616a1 1 0 0 1 1.909.024l.737 1.452a1 1 0 0 0 .737.535l1.634.256a1 1 0 0 1 .588 1.806l-1.172 1.168a1 1 0 0 0-.282.866l.259 1.613a1 1 0 0 1-1.541 1.134l-1.465-.75a1 1 0 0 0-.912 0l-1.465.75a1 1 0 0 1-1.539-1.133l.258-1.613a1 1 0 0 0-.282-.866l-1.156-1.153a1 1 0 0 1 .572-1.822l1.633-.256a1 1 0 0 0 .737-.535z" />
                        <path d="M8 15H7a4 4 0 0 0-4 4v2" />
                        <circle cx="10" cy="7" r="4" />
                    </svg>
                    <span>Profissionais</span>
                </a>
            </div>
        <?php endif; ?>

        <!-- Avaliações -->
        <div class="cs-sidebar-item <?= $nav === 'ratings' ? 'cs-sidebar-item-active' : '' ?>">
            <a href="<?= $appBasePath ?? '' ?>/html/company/ratings.php?professional=<?= $User['id'] ?? '' ?>"
                class="cs-text-decoration-none d-flex align-items-center gap-2">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 0-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 0 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <span>Avaliações</span>
            </a>
        </div>
    </nav>

    <!-- Terminar sessão -->
    <section class="d-flex flex-column w-90 position-absolute bottom-0 mb-3">
        <button
            type="button"
            class="w-100 d-flex align-items-center gap-2 border-0 bg-transparent log-out"
            data-bs-toggle="modal"
            data-bs-target="#logoutModal">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12 5.25L15.75 9L12 12.75M15.75 9H6.75M6.75 15.75H3.75C3.35218 15.75 2.97064 15.592 2.68934 15.3107 2.40804 15.0294 2.25 14.6478 2.25 14.25V3.75C2.25 3.35218 2.40804 2.97064 2.68934 2.68934 2.97064 2.25 3.75 2.25H6.75"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round" />
            </svg>
            <span>Terminar sessão</span>
        </button>
    </section>
</aside>

<!-- Modal de terminar sessão -->
<div class="modal fade"
    id="logoutModal"
    tabindex="-1"
    aria-labelledby="logoutModalLabel"
    aria-hidden="true">
    <!-- Janela do modal -->
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">
                    Terminar sessão
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Fechar">
                </button>
            </div>

            <div class="modal-body">
                Tem a certeza de que pretende terminar a sessão?
            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Cancelar
                </button>

                <form action="<?= $appBasePath ?? '' ?>/auth/logout" method="POST" class="m-0">
                    <button type="submit" class="btn btn-danger">
                        Terminar sessão
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Estilos da barra lateral -->
<style>
    /* Barra lateral */
    .cs-prof-sidebar {
        width: 220px;
        min-width: 220px;
        height: 100vh;
        position: sticky;
        top: 0;
        background-color: var(--color1) !important;
        color: var(--color3);
        overflow: hidden;
    }

    /* Conteúdo da barra lateral */
    .cs-prof-sidebar .w-90 {
        width: 90%;
    }

    /* Logótipo */
    .cs-prof-sidebar .logo {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--color3);
    }

    .cs-prof-sidebar .logo h1 {
        margin: 0;
        font-family: var(--font);
        font-size: 22px;
        font-weight: 700;
        line-height: 1;
    }

    .cs-prof-sidebar .logo h1:first-child {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background-color: var(--color2);
        color: var(--color3);
        font-size: 18px;
    }

    /* Navegação */
    .cs-prof-sidebar nav {
        width: 90%;
    }

    /* Item de navegação */
    .cs-sidebar-item {
        width: 100%;
        height: 42px;
        padding: 0 7px;
        border-radius: 6px;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    /* Ligação */
    .cs-sidebar-item>a {
        width: 100%;
        height: 100%;
        color: var(--color4);
        font-family: var(--font);
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    /* Ícone */
    .cs-sidebar-item>a svg {
        flex-shrink: 0;
    }

    /* Ao passar o rato */
    .cs-sidebar-item:hover {
        background-color: rgba(255, 255, 255, 0.06);
    }

    .cs-sidebar-item>a:hover {
        color: var(--color3);
    }

    /* Item ativo */
    .cs-sidebar-item-active {
        background-color: var(--color2);
    }

    .cs-sidebar-item-active:hover {
        background-color: var(--color2);
    }

    /* Ligação ativa */
    .cs-sidebar-item-active>a {
        color: var(--color3);
    }

    /* Terminar sessão */
    .log-out {
        color: var(--color4);
        height: 42px;
        padding: 9px 7px;
        text-align: left;
        font-family: var(--font);
        font-size: 14px;
        font-weight: 500;
        border-radius: 6px;
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .log-out:hover {
        color: var(--color3);
        background-color: rgba(255, 255, 255, 0.06);
    }

    /* Modal */
    #logoutModal .modal-content {
        border: 0;
        border-radius: 10px;
    }

    #logoutModal .modal-header {
        border-bottom: 1px solid #E2E8F0;
    }

    #logoutModal .modal-footer {
        border-top: 1px solid #E2E8F0;
    }
</style>