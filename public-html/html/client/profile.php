<?php
$User = $_SESSION['user'] ?? [];
$errors = $_SESSION['error'] ?? [];
$oldData = $_SESSION['oldData'] ?? [];

$client = !empty($oldData) ? $oldData : $User;

unset($_SESSION['error'], $_SESSION['oldData']);
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReservaJá - Perfil</title>
    <link rel="stylesheet" href="<?= $appBasePath ?? '' ?>/resources/css/client/profile.css">
</head>
<body>

    <!-- Barra de navegação -->
    <?php require(__DIR__ . '/../layout/nav.php') ?>

    <!-- Conteúdo principal: perfil do cliente -->
    <main class="container py-5 flex-grow-1">

        <!-- Cabeçalho -->
        <div class="mb-4">
            <h1 class="profile-title mb-1">Perfil</h1>
            <p class="text-secondary mb-0">Atualize os seus dados pessoais.</p>
        </div>

        <!-- Formulário de dados pessoais -->
        <div class="card border rounded-3 shadow-sm cs-fadeIn-y2">
            <div class="card-body p-4">

                <form action="<?= $appBasePath ?? '' ?>/client/profile/update" method="POST">

                    <div class="row g-4">

                        <!-- Nome -->
                        <div class="col-12 col-md-6">
                            <label for="name" class="form-label fw-bold">
                                Nome
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                                value="<?= htmlspecialchars($client['name'] ?? '') ?>"
                            >

                            <?php if (isset($errors['name'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($errors['name']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Email -->
                        <div class="col-12 col-md-6">
                            <label for="email" class="form-label fw-bold">
                                Email
                            </label>

                            <input
                                type="email"
                                id="email"
                                class="form-control"
                                value="<?= htmlspecialchars($User['email'] ?? '') ?>"
                                readonly
                            >
                        </div>

                        <!-- NIF -->
                        <div class="col-12 col-md-4">
                            <label for="tax_number" class="form-label fw-bold">
                                NIF / Número de Contribuinte
                            </label>

                            <input
                                type="text"
                                id="tax_number"
                                name="tax_number"
                                class="form-control <?= isset($errors['tax_number']) ? 'is-invalid' : '' ?>"
                                value="<?= htmlspecialchars($client['tax_number'] ?? '') ?>"
                            >

                            <?php if (isset($errors['tax_number'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($errors['tax_number']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Telefone -->
                        <div class="col-12 col-md-4">
                            <label for="mobile_number" class="form-label fw-bold">
                                Telefone
                            </label>

                            <input
                                type="tel"
                                id="mobile_number"
                                name="mobile_number"
                                class="form-control <?= isset($errors['mobile_number']) ? 'is-invalid' : '' ?>"
                                value="<?= htmlspecialchars($client['mobile_number'] ?? '') ?>"
                            >

                            <?php if (isset($errors['mobile_number'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($errors['mobile_number']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Data de nascimento -->
                        <div class="col-12 col-md-4">
                            <label for="birth_date" class="form-label fw-bold">
                                Data de nascimento
                            </label>

                            <input
                                type="date"
                                id="birth_date"
                                name="birth_date"
                                class="form-control <?= isset($errors['birth_date']) ? 'is-invalid' : '' ?>"
                                value="<?= htmlspecialchars($client['birth_date'] ?? '') ?>"
                            >

                            <?php if (isset($errors['birth_date'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($errors['birth_date']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Morada -->
                        <div class="col-12">
                            <div class="row g-4">

                                <div class="col-12 col-md-6">
                                    <label for="address" class="form-label fw-bold">
                                        Morada
                                        <span class="text-secondary fw-normal">(Opcional)</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="address"
                                        name="address"
                                        class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>"
                                        value="<?= htmlspecialchars($client['address'] ?? '') ?>"
                                    >

                                    <?php if (isset($errors['address'])): ?>
                                        <div class="invalid-feedback">
                                            <?= htmlspecialchars($errors['address']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Código Postal -->
                                <div class="col-12 col-md-2">
                                    <label for="postal_code" class="form-label fw-bold">
                                        Código Postal
                                        <span class="text-secondary fw-normal">(Opcional)</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="postal_code"
                                        name="postal_code"
                                        class="form-control <?= isset($errors['postal_code']) ? 'is-invalid' : '' ?>"
                                        value="<?= htmlspecialchars($client['postal_code'] ?? '') ?>"
                                    >

                                    <?php if (isset($errors['postal_code'])): ?>
                                        <div class="invalid-feedback">
                                            <?= htmlspecialchars($errors['postal_code']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Localidade -->
                                <div class="col-12 col-md-4">
                                    <label for="city" class="form-label fw-bold">
                                        Localidade
                                        <span class="text-secondary fw-normal">(Opcional)</span>
                                    </label>

                                    <input
                                        type="text"
                                        id="city"
                                        name="city"
                                        class="form-control <?= isset($errors['city']) ? 'is-invalid' : '' ?>"
                                        value="<?= htmlspecialchars($client['city'] ?? '') ?>"
                                    >

                                    <?php if (isset($errors['city'])): ?>
                                        <div class="invalid-feedback">
                                            <?= htmlspecialchars($errors['city']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- Guardar alterações -->
                    <div class="d-flex justify-content-end mt-5">
                        <button type="submit" class="btn cs-btn-primary px-3">
                            Guardar alterações
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </main>

    <!-- Scripts -->
    <script src="<?= $appBasePath ?? '' ?>/resources/bootstrap/bootstrap.min.js"></script>

</body>
</html>