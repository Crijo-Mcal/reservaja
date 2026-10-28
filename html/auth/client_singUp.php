<?php

$errors = $_SESSION['error'] ?? [];
$oldData = $_SESSION['oldData'] ?? [];

unset($_SESSION['error'], $_SESSION['oldData']);

?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ReservaJá - Criar Conta</title>

    <link
        rel="stylesheet"
        href="<?= $appBasePath ?? '' ?>/resources/css/auth/client_singUp.css">
</head>

<body>

    <!-- Barra de navegação -->
    <?php require __DIR__ . '/../layout/nav.php'; ?>

    <!-- Conteúdo principal: registo de cliente -->
    <main class="py-5 cs-fadeIn-y1 cs-fadeIn-y2 flex-grow-1">

        <div class="container ">

            <div class="mx-auto border rounded p-4" style="max-width: 512px;">

                <h1 class="h3 mb-2 fw-bolder">
                    Crie a sua conta
                </h1>

                <p class="text-muted mb-4">
                    Crie a sua conta ReservaJá e gira facilmente as suas marcações e reservas.
                </p>

                <form
                    action="<?= $appBasePath ?? '' ?>/auth/client_register"
                    method="post"
                    class="row g-3 needs-validation"
                    novalidate>

                    <!-- Nome -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Nome
                        </label>

                        <input
                            type="text"
                            name="first_name"
                            class="form-control cs-input <?= isset($errors['first_name']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($oldData['first_name'] ?? '') ?>"
                            required>

                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['first_name'] ?? '') ?>
                        </div>

                    </div>

                    <!-- Apelido -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Apelido
                        </label>

                        <input
                            type="text"
                            name="last_name"
                            class="form-control cs-input <?= isset($errors['last_name']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($oldData['last_name'] ?? '') ?>"
                            required>

                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['last_name'] ?? '') ?>
                        </div>

                    </div>

                    <!-- E-mail -->
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Endereço de e-mail
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control cs-input <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($oldData['email'] ?? '') ?>"
                            required>

                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['email'] ?? '') ?>
                        </div>

                    </div>

                    <!-- Data de nascimento -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Data de nascimento
                        </label>

                        <input
                            type="date"
                            name="date_of_birth"
                            class="form-control cs-input-date <?= isset($errors['date_of_birth']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($oldData['date_of_birth'] ?? '') ?>">

                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['date_of_birth'] ?? '') ?>
                        </div>

                    </div>

                    <!-- Telemóvel -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Número de telemóvel
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                +351
                            </span>

                            <input
                                type="tel"
                                name="mobile_number"
                                class="form-control cs-input <?= isset($errors['mobile_number']) ? 'is-invalid' : '' ?>"
                                value="<?= htmlspecialchars($oldData['mobile_number'] ?? '') ?>"
                                required>

                        </div>

                        <?php if (isset($errors['mobile_number'])): ?>
                            <div class="invalid-feedback d-block">
                                <?= htmlspecialchars($errors['mobile_number']) ?>
                            </div>
                        <?php endif; ?>

                    </div>

                    <!-- NIF -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            Número de contribuinte
                            <span class="text-muted fw-normal">(opcional)</span>
                        </label>

                        <input
                            type="text"
                            name="tax_number"
                            inputmode="numeric"
                            maxlength="9"
                            class="form-control cs-input <?= isset($errors['tax_number']) ? 'is-invalid' : '' ?>"
                            value="<?= htmlspecialchars($oldData['tax_number'] ?? '') ?>">

                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['tax_number'] ?? '') ?>
                        </div>
                    </div>

                    <!-- Palavra-passe -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Palavra-passe
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control cs-input <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                            required>

                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['password'] ?? '') ?>
                        </div>

                    </div>

                    <!-- Confirmar palavra-passe -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Confirmar palavra-passe
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control cs-input <?= isset($errors['password_confirmation']) ? 'is-invalid' : '' ?>"
                            required>

                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['password_confirmation'] ?? '') ?>
                        </div>

                    </div>

                    <!-- Criar conta -->
                    <div class="col-12 mt-2">

                        <button
                            type="submit"
                            class="btn cs-btn-primary w-100">
                            Criar conta
                        </button>

                    </div>

                    <!-- Iniciar sessão -->
                    <div class="col-12 text-center">

                        <p class="text-muted mb-0">
                            Já tem uma conta?

                            <a
                                href="<?= $appBasePath ?? '' ?>/html/auth/login.php"
                                class="cs-text-3 fw-semibold text-decoration-none">
                                Iniciar sessão
                            </a>
                        </p>

                    </div>

                    <!-- Conta profissional -->
                    <div class="col-12 text-center mt-3 pt-3 border-top">

                        <p class="text-muted mb-2">
                            É um profissional?
                        </p>

                        <a
                            href="<?= $appBasePath ?? '' ?>/html/auth/employee_singUp.php"
                            class="btn btn-outline-secondary btn-sm">
                            Criar uma conta profissional
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </main>
    <!-- Scripts -->
    <script src="<?= $appBasePath ?? '' ?>/resources/bootstrap/bootstrap.min.js"></script>
</body>

</html>