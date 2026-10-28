<?php

$User = $_SESSION['user'] ?? null;

if (!$User || ($User['role'] ?? '') !== 'professional') {
    header('Location: '.($appBasePath ?? '').'/html/auth/login.php');
    exit();
}

$error = $_SESSION['error'] ?? [];
$oldData = $_SESSION['oldData'] ?? [];

unset($_SESSION['error'], $_SESSION['oldData']);

$data = $dataBase ?? [];
$professional = $data['profesional_data'] ?? [];
$company = $data['company_data'] ?? [];

$roleInCompany = $User['roleInCompany'] ?? '';
$isOwner = $roleInCompany === 'owner';

$roleLabels = [
    'owner' => 'Proprietário',
    'employee' => 'Funcionário',
    'technician' => 'Técnico'
];

$profileImage = $professional['profile_image']
    ?? ($appBasePath ?? '').'/asset/image/profile.webp';

$companyLogo = $company['logo']
    ?? ($appBasePath ?? '').'/asset/image/logo.webp';

?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReservaJá - Meu Perfil</title>

    <link rel="stylesheet" href="<?= $appBasePath ?? '' ?>/resources/css/company/profile.css">
</head>

<body>

    <!-- Barra de navegação (mobile) -->
    <?php require __DIR__ . "/../layout/professional_navBar.php"; ?>

    <div class="d-flex">

        <!-- Barra lateral -->
        <?php require __DIR__ . "/../layout/professional_sideBar.php"; ?>

        <main class="flex-grow-1 d-flex flex-column align-items-center gap-3 bg-body py-3">

            <!-- Cabeçalho -->
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h4 class="fw-semibold m-0">Meu Perfil</h4>

                        <p class="cs-text-2 m-0">
                            Gerencie as suas informações pessoais<?= $isOwner ? ' e os dados da sua empresa' : '' ?>.
                        </p>
                    </div>

                    <div class="d-none d-sm-flex align-items-center gap-2">

                        <span class="cs-tag-success">
                            <?= htmlspecialchars($roleLabels[$roleInCompany] ?? $roleInCompany) ?>
                        </span>

                        <span class="small fw-normal">
                            <?= htmlspecialchars($professional['name'] ?? $User['name'] ?? '') ?>
                        </span>

                        <a href="<?= $appBasePath ?? '' ?>/html/company/profile.php">
                            <img
                                src="<?= htmlspecialchars($profileImage) ?>"
                                alt="Fotografia do profissional"
                                class="rounded-circle object-fit-cover border"
                                width="36"
                                height="36">
                        </a>

                    </div>
                </div>
            </div>

            <!-- Dados do perfil -->
            <div class="container cs-fadeIn-y1">

                <div class="row g-4">

                    <!-- Fotografia e logo -->
                    <div class="<?= $isOwner ? 'col-12 col-md-6' : 'col-12' ?>">

                        <div class="card shadow-sm h-100 profile-card">

                            <div class="card-body p-4">

                                <h6 class="fs-5 fw-semibold mb-4">
                                    Fotografia de perfil
                                </h6>

                                <form
                                    action="<?= $appBasePath ?? '' ?>/company/profile/profileImage"
                                    method="POST"
                                    enctype="multipart/form-data"
                                    class="upload-image-form">

                                    <div class="d-flex flex-column align-items-center gap-4">

                                        <img
                                            src="<?= htmlspecialchars($profileImage) ?>"
                                            alt="Fotografia do profissional"
                                            class="rounded-circle object-fit-cover border"
                                            width="120"
                                            height="120">

                                        <div class="w-100">

                                            <!-- Carregamento da fotografia -->
                                            <input
                                                type="file"
                                                name="profile_image"
                                                accept="image/jpeg,image/png,image/webp"
                                                class="form-control profile-file-input <?= !empty($error['profile_image']) ? 'is-invalid' : '' ?>">

                                            <?php if (!empty($error['profile_image'])): ?>
                                                <div class="invalid-feedback profile-error">
                                                    <?= htmlspecialchars($error['profile_image']) ?>
                                                </div>
                                            <?php endif; ?>

                                        </div>

                                        <p class="text-body-secondary small mb-0">
                                            Formatos aceites: JPG, PNG ou WEBP.
                                        </p>

                                        <button
                                            type="submit"
                                            class="btn cs-btn-primary w-100 profile-button">
                                            Guardar fotografia
                                        </button>

                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <?php if ($isOwner): ?>

                        <!-- Logo da empresa -->
                        <div class="col-12 col-md-6">

                            <div class="card shadow-sm h-100 profile-card">

                                <div class="card-body p-4">

                                    <h6 class="fs-5 fw-semibold mb-4">
                                        Logo da empresa
                                    </h6>

                                    <form
                                        action="<?= $appBasePath ?? '' ?>/company/profile/companyLogo"
                                        method="POST"
                                        enctype="multipart/form-data"
                                        class="upload-image-form">

                                        <div class="d-flex flex-column align-items-center gap-4">

                                            <img
                                                src="<?= htmlspecialchars($companyLogo) ?>"
                                                alt="Logo da empresa"
                                                class="object-fit-cover rounded"
                                                width="120"
                                                height="120">

                                            <div class="w-100">

                                                <!-- Carregamento do logótipo -->
                                                <input
                                                    type="file"
                                                    name="company_logo"
                                                    accept="image/jpeg,image/png,image/webp"
                                                    class="form-control profile-file-input <?= !empty($error['company_logo']) ? 'is-invalid' : '' ?>">

                                                <?php if (!empty($error['company_logo'])): ?>
                                                    <div class="invalid-feedback profile-error">
                                                        <?= htmlspecialchars($error['company_logo']) ?>
                                                    </div>
                                                <?php endif; ?>

                                            </div>

                                            <p class="text-body-secondary small mb-0">
                                                Formatos aceites: JPG, PNG ou WEBP.
                                            </p>

                                            <button
                                                type="submit"
                                                class="btn cs-btn-primary w-100 profile-button">
                                                Guardar logo
                                            </button>

                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                    <?php endif; ?>

                    <!-- Dados profissionais -->
                    <div class="col-12">

                        <div class="card shadow-sm profile-card">

                            <div class="card-body p-4">

                                <div class="mb-4">
                                    <h6 class="fs-5 fw-semibold mb-1">
                                        Informações do perfil
                                    </h6>

                                    <p class="profile-section-text mb-0">
                                        Estas informações serão apresentadas aos clientes no seu perfil profissional.
                                    </p>
                                </div>

                                <form
                                    action="<?= $appBasePath ?? '' ?>/company/profile/updateDataProfessional"
                                    method="POST">

                                    <div class="row g-4">

                                        <!-- Nome profissional -->
                                        <div class="col-12 col-md-6">
                                            <label for="professional_name" class="profile-label">
                                                Nome
                                            </label>

                                            <input
                                                type="text"
                                                id="professional_name"
                                                name="professional_name"
                                                value="<?= htmlspecialchars(
                                                    array_key_exists('professional_name', $oldData)
                                                        ? $oldData['professional_name']
                                                        : ($professional['name'] ?? '')
                                                ) ?>"
                                                class="form-control profile-input <?= isset($error['professional_name']) ? 'is-invalid' : '' ?>">

                                            <?php if (isset($error['professional_name'])): ?>
                                                <div class="invalid-feedback profile-error">
                                                    <?= htmlspecialchars($error['professional_name']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Especialidade -->
                                        <div class="col-12 col-md-6">
                                            <label for="speciality" class="profile-label">
                                                Especialidade
                                            </label>

                                            <input
                                                type="text"
                                                id="speciality"
                                                name="speciality"
                                                value="<?= htmlspecialchars(
                                                    array_key_exists('speciality', $oldData)
                                                        ? $oldData['speciality']
                                                        : ($professional['speciality'] ?? '')
                                                ) ?>"
                                                class="form-control profile-input <?= isset($error['speciality']) ? 'is-invalid' : '' ?>">

                                            <?php if (isset($error['speciality'])): ?>
                                                <div class="invalid-feedback profile-error">
                                                    <?= htmlspecialchars($error['speciality']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Email não editável -->
                                        <div class="col-12 col-md-6">
                                            <label for="email" class="profile-label">
                                                Email
                                            </label>

                                            <input
                                                type="email"
                                                id="email"
                                                value="<?= htmlspecialchars($User['email'] ?? '') ?>"
                                                class="form-control profile-input profile-readonly"
                                                disabled>
                                        </div>

                                        <!-- Telemóvel -->
                                        <div class="col-12 col-md-6">
                                            <label for="professional_number" class="profile-label">
                                                Telemóvel
                                            </label>

                                            <div class="input-group">

                                                <span class="input-group-text profile-input">
                                                    +351
                                                </span>

                                                <input
                                                    type="text"
                                                    id="professional_number"
                                                    name="professional_number"
                                                    value="<?= htmlspecialchars(
                                                        array_key_exists('professional_number', $oldData)
                                                            ? $oldData['professional_number']
                                                            : ($professional['mobile_number'] ?? '')
                                                    ) ?>"
                                                    class="form-control profile-input <?= isset($error['professional_number']) ? 'is-invalid' : '' ?>">

                                            </div>

                                            <?php if (isset($error['professional_number'])): ?>
                                                <div class="invalid-feedback profile-error d-block">
                                                    <?= htmlspecialchars($error['professional_number']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- NIF não editável -->
                                        <div class="col-12 col-md-6">
                                            <label for="tax_number" class="profile-label">
                                                NIF
                                            </label>

                                            <input
                                                type="text"
                                                id="tax_number"
                                                value="<?= htmlspecialchars($professional['tax_number'] ?? '') ?>"
                                                class="form-control profile-input profile-readonly"
                                                disabled>
                                        </div>

                                        <!-- Descrição profissional -->
                                        <div class="col-12">
                                            <label for="description" class="profile-label">
                                                Descrição
                                            </label>

                                            <textarea
                                                id="description"
                                                name="description"
                                                rows="4"
                                                class="form-control profile-textarea <?= isset($error['description']) ? 'is-invalid' : '' ?>"><?= htmlspecialchars(
                                                    array_key_exists('description', $oldData)
                                                        ? $oldData['description']
                                                        : ($professional['description'] ?? '')
                                                ) ?></textarea>

                                            <?php if (isset($error['description'])): ?>
                                                <div class="invalid-feedback profile-error">
                                                    <?= htmlspecialchars($error['description']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="col-12">
                                            <button
                                                type="submit"
                                                class="btn cs-btn-primary w-100 profile-save-button">
                                                Guardar alterações
                                            </button>
                                        </div>

                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <?php if ($isOwner): ?>

                        <!-- Dados da empresa -->
                        <div class="col-12">

                            <div class="card shadow-sm profile-card">

                                <div class="card-body p-4">

                                    <div class="mb-4">
                                        <h6 class="fs-5 fw-semibold mb-1">
                                            Informações da empresa
                                        </h6>

                                        <p class="profile-section-text mb-0">
                                            Estas informações correspondem à empresa associada ao seu perfil.
                                        </p>
                                    </div>

                                    <form
                                        action="<?= $appBasePath ?? '' ?>/company/profile/updateDataCompany"
                                        method="POST">

                                        <div class="row g-4">

                                            <!-- Nome da empresa -->
                                            <div class="col-12 col-md-6">
                                                <label for="company_name" class="profile-label">
                                                    Nome da empresa
                                                </label>

                                                <input
                                                    type="text"
                                                    id="company_name"
                                                    name="company_name"
                                                    value="<?= htmlspecialchars(
                                                        array_key_exists('company_name', $oldData)
                                                            ? $oldData['company_name']
                                                            : ($company['name'] ?? '')
                                                    ) ?>"
                                                    class="form-control profile-input <?= isset($error['company_name']) ? 'is-invalid' : '' ?>">

                                                <?php if (isset($error['company_name'])): ?>
                                                    <div class="invalid-feedback profile-error">
                                                        <?= htmlspecialchars($error['company_name']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Telefone da empresa -->
                                            <div class="col-12 col-md-6">
                                                <label for="company_phone" class="profile-label">
                                                    Telefone
                                                </label>

                                                <div class="input-group">

                                                    <span class="input-group-text profile-input">
                                                        +351
                                                    </span>

                                                    <input
                                                        type="text"
                                                        id="company_phone"
                                                        name="company_phone"
                                                        value="<?= htmlspecialchars(
                                                            array_key_exists('company_phone', $oldData)
                                                                ? $oldData['company_phone']
                                                                : ($company['phone'] ?? '')
                                                        ) ?>"
                                                        class="form-control profile-input <?= isset($error['company_phone']) ? 'is-invalid' : '' ?>">

                                                </div>

                                                <?php if (isset($error['company_phone'])): ?>
                                                    <div class="invalid-feedback profile-error d-block">
                                                        <?= htmlspecialchars($error['company_phone']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Email da empresa -->
                                            <div class="col-12 col-md-6">
                                                <label for="company_email" class="profile-label">
                                                    Email
                                                </label>

                                                <input
                                                    type="email"
                                                    id="company_email"
                                                    name="company_email"
                                                    value="<?= htmlspecialchars(
                                                        array_key_exists('company_email', $oldData)
                                                            ? $oldData['company_email']
                                                            : ($company['email'] ?? '')
                                                    ) ?>"
                                                    class="form-control profile-input <?= isset($error['company_email']) ? 'is-invalid' : '' ?>">

                                                <?php if (isset($error['company_email'])): ?>
                                                    <div class="invalid-feedback profile-error">
                                                        <?= htmlspecialchars($error['company_email']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Localização -->
                                            <div class="col-12 col-md-6">
                                                <label for="company_location" class="profile-label">
                                                    Localização
                                                </label>

                                                <input
                                                    type="text"
                                                    id="company_location"
                                                    name="company_location"
                                                    value="<?= htmlspecialchars(
                                                        array_key_exists('company_location', $oldData)
                                                            ? $oldData['company_location']
                                                            : ($company['location'] ?? '')
                                                    ) ?>"
                                                    class="form-control profile-input <?= isset($error['company_location']) ? 'is-invalid' : '' ?>">

                                                <?php if (isset($error['company_location'])): ?>
                                                    <div class="invalid-feedback profile-error">
                                                        <?= htmlspecialchars($error['company_location']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Descrição da empresa -->
                                            <div class="col-12">
                                                <label for="company_description" class="profile-label">
                                                    Descrição
                                                </label>

                                                <textarea
                                                    id="company_description"
                                                    name="company_description"
                                                    rows="4"
                                                    class="form-control profile-textarea <?= isset($error['company_description']) ? 'is-invalid' : '' ?>"><?= htmlspecialchars(
                                                        array_key_exists('company_description', $oldData)
                                                            ? $oldData['company_description']
                                                            : ($company['description'] ?? '')
                                                    ) ?></textarea>

                                                <?php if (isset($error['company_description'])): ?>
                                                    <div class="invalid-feedback profile-error">
                                                        <?= htmlspecialchars($error['company_description']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Dados sensíveis e não editáveis -->
                                            <div class="col-12">

                                                <div class="border rounded-3 p-4 bg-light-subtle">

                                                    <div class="mb-4">
                                                        <h6 class="fs-5 fw-semibold mb-1">
                                                            Dados sensíveis
                                                        </h6>

                                                        <p class="profile-section-text mb-0">
                                                            Estes dados são utilizados internamente e não podem ser alterados nesta área.
                                                        </p>
                                                    </div>

                                                    <div class="row g-4">

                                                        <!-- NIF da empresa -->
                                                        <div class="col-12">
                                                            <label for="company_tax_number" class="profile-label">
                                                                NIF
                                                            </label>

                                                            <input
                                                                type="text"
                                                                id="company_tax_number"
                                                                value="<?= htmlspecialchars($company['tax_number'] ?? '') ?>"
                                                                class="form-control profile-input profile-readonly"
                                                                disabled>
                                                        </div>

                                                        <!-- IBAN -->
                                                        <div class="col-12">

                                                            <label for="company_iban" class="profile-label">
                                                                IBAN
                                                            </label>

                                                            <div class="input-group sensitive-field">

                                                                <input
                                                                    type="password"
                                                                    id="company_iban"
                                                                    value="<?= htmlspecialchars($company['iban'] ?? '') ?>"
                                                                    class="form-control profile-input profile-readonly"
                                                                    disabled>

                                                                <button
                                                                    type="button"
                                                                    class="btn toggle-sensitive"
                                                                    aria-label="Mostrar IBAN">
                                                                    <i class="bi bi-eye"></i>
                                                                    <span>Ver</span>
                                                                </button>

                                                            </div>
                                                        </div>

                                                        <!-- Chave de acesso -->
                                                        <div class="col-12">

                                                            <label for="company_access_key" class="profile-label">
                                                                Access Key
                                                            </label>

                                                            <div class="input-group sensitive-field">

                                                                <input
                                                                    type="password"
                                                                    id="company_access_key"
                                                                    value="<?= htmlspecialchars($company['access_key'] ?? '') ?>"
                                                                    class="form-control profile-input profile-readonly"
                                                                    disabled>

                                                                <button
                                                                    type="button"
                                                                    class="btn toggle-sensitive"
                                                                    aria-label="Mostrar Access Key">
                                                                    <i class="bi bi-eye"></i>
                                                                    <span>Ver</span>
                                                                </button>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button
                                                    type="submit"
                                                    class="btn cs-btn-primary w-100 profile-save-button">
                                                    Guardar alterações
                                                </button>
                                            </div>

                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                    <?php endif; ?>

                </div>
            </div>
        </main>

        <!-- Modal de carregamento -->
        <div
            class="modal fade"
            id="uploadImageModal"
            tabindex="-1"
            aria-hidden="true"
            data-bs-backdrop="static"
            data-bs-keyboard="false">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content border-0">

                    <div class="modal-body text-center py-5">

                        <div
                            class="spinner-border mb-3"
                            role="status"
                            style="width: 3rem; height: 3rem;">
                            <span class="visually-hidden">
                                A carregar...
                            </span>
                        </div>

                        <h6 class="fw-semibold mb-2">
                            A guardar fotografia...
                        </h6>

                        <p class="text-body-secondary small mb-0">
                            Por favor, aguarde.
                        </p>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="<?= $appBasePath ?? '' ?>/resources/js/bootstrap.min.js"></script>

    <script>
        // Mostra o modal enquanto a imagem está a ser enviada.
        document.querySelectorAll('.upload-image-form').forEach(form => {
            form.addEventListener('submit', () => {
                const modal = bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('uploadImageModal')
                );

                modal.show();
            });
        });

        // Mostra ou oculta os dados sensíveis.
        document.querySelectorAll('.toggle-sensitive').forEach(button => {
            button.addEventListener('click', () => {
                const input = button.previousElementSibling;
                const icon = button.querySelector('i');
                const text = button.querySelector('span');
                const visible = input.type === 'text';

                input.type = visible ? 'password' : 'text';

                icon.className = visible
                    ? 'bi bi-eye'
                    : 'bi bi-eye-slash';

                text.textContent = visible
                    ? 'Ver'
                    : 'Ocultar';

                button.setAttribute(
                    'aria-label',
                    visible
                        ? 'Mostrar dado'
                        : 'Ocultar dado'
                );
            });
        });
    </script>

</body>
</html>