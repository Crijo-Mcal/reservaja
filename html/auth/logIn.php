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

    <title>ReservaJá - Iniciar Sessão</title>

    <link
        rel="stylesheet"
        href="<?= $appBasePath ?? '' ?>/resources/css/auth/logIn.css">
</head>

<body>

    <!-- NavBar -->
    <?php require __DIR__ . '/../layout/nav.php'; ?>

    <!-- Conteúdo Principal -->
    <main class="d-flex align-items-center py-5 flex-grow-1">

        <div class="container cs-fadeIn-y2">

            <div
                class="mx-auto border rounded p-4"
                style="max-width: 512px;">

                <h1 class="h3 mb-2 fw-bold">
                    Bem-vindo de volta
                </h1>

                <p class="text-muted small mb-4">
                    Inicie sessão na sua conta ReservaJá e gira facilmente as suas marcações e reservas.
                </p>

                <form
                    action="<?= $appBasePath ?? '' ?>/auth/login"
                    method="post"
                    class="row g-3 needs-validation"
                    novalidate>

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

                    <!-- Palavra-passe -->
                    <div class="col-12">

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

                    <!-- Recuperar palavra-passe -->
                    <div class="col-12">
                        <a
                            href="#"
                            class="cs-text-3 text-decoration-none small">
                            Esqueceu-se da palavra-passe?
                        </a>
                    </div>

                    <!-- Login -->
                    <div class="col-12 mt-2">

                        <button
                            type="submit"
                            class="btn cs-btn-primary w-100">
                            Iniciar sessão
                        </button>

                    </div>

                    <!-- Criar conta -->
                    <div class="col-12 text-center mt-3">

                        <p class="text-muted mb-0">
                            Ainda não tem uma conta?

                            <a
                                href="<?= $appBasePath ?? '' ?>/html/auth/client_singUp.php"
                                class="cs-text-3 fw-semibold text-decoration-none">
                                Criar uma conta de cliente
                            </a>
                        </p>

                    </div>

                </form>

            </div>

        </div>
    </main>

<script src="<?= $appBasePath ?? '' ?>/resources/bootstrap/bootstrap.min.js"></script>
</body>

</html>