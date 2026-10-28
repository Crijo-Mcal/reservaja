<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Página não encontrada</title>

    <link
        rel="stylesheet"
        href= "<?= $appBasePath ?? '' ?>/resources/css/404.css" >
</head>

<body class="error-404-page">

    <?php require(__DIR__ . '/layout/nav.php') ?>

    <main class="error-404-main">

        <div class="error-404-content">

            <span class="error-404-code">
                404
            </span>

            <h6 class="text-muted mb-4">
                Página não encontrada
            </h6>

        </div>

    </main>

    <?php require(__DIR__ . '/layout/footer.php') ?>

    <script src="<?= $appBasePath ?? '' ?>/resources/js/bootstrap.min.js"></script>

</body>

</html>