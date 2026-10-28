<?php

$data = $dataBase ?? [];

?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1">

    <title>ReservaJá - Histórico</title>

    <link
        rel="stylesheet"
        href="<?= $appBasePath ?? '' ?>/resources/css/client/history.css">

</head>

<body>

    <?php require(__DIR__ . '/../layout/nav.php') ?>

    <main class="container py-5">

        <h1 class="history-title mb-4">
            Histórico
        </h1>

        <?php if (!empty($data)): ?>

            <div class="d-flex flex-column gap-2 cs-fadeIn-y2">

                <?php foreach ($data as $appointment): ?>

                    <article class="history-card">

                        <div class="history-item">
                            <span>Data</span>
                            <strong>
                                <?= htmlspecialchars(
                                    date('d/m/Y', strtotime($appointment['appointment_date']))
                                ) ?>
                            </strong>
                        </div>

                        <div class="history-item">
                            <span>Hora</span>
                            <strong>
                                <?= htmlspecialchars(
                                    date('H:i', strtotime($appointment['appointment_time']))
                                ) ?>
                            </strong>
                        </div>

                        <div class="history-item history-service">
                            <span>Serviço</span>
                            <strong>
                                <?= htmlspecialchars($appointment['service_name']) ?>
                            </strong>
                        </div>

                        <div class="history-item">
                            <span>Duração</span>
                            <strong>
                                <?= htmlspecialchars($appointment['service_duration']) ?> min
                            </strong>
                        </div>

                        <div class="history-item history-professional">
                            <span>Profissional</span>
                            <strong>
                                <?= htmlspecialchars($appointment['professional_name']) ?>
                            </strong>
                        </div>

                        <div class="history-item history-id">
                            <span>Agendamento</span>
                            <strong
                                title="<?= htmlspecialchars($appointment['appointment_id']) ?>">
                                #<?= htmlspecialchars($appointment['appointment_id']) ?>
                            </strong>
                        </div>

                    </article>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div class="text-center py-5 px-3 border rounded-3">
                <i class="bi bi-credit-card text-secondary fs-1"></i>

                <p class="text-secondary small mb-0">
                    Os seus agendamentos aparecerão aqui.
                </p>
            </div>

        <?php endif; ?>

    </main>



    <script src="<?= $appBasePath ?? '' ?>/resources/js/bootstrap.min.js"></script>

</body>

</html>