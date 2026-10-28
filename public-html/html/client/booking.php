<?php

$User = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'client'
    ? $_SESSION['user']
    : [];

$dataBase = $dataBase ?? [];
$service = $dataBase['service'] ?? [];

?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <link
        rel="stylesheet"
        href="<?= $appBasePath ?? '' ?>/resources/css/client/booking.css">

    <title>Fazer marcação</title>
</head>

<body class="d-flex flex-column min-vh-100">

    <!-- Barra de navegação -->
    <?php require(__DIR__ . '/../layout/nav.php') ?>

    <!-- Conteúdo principal: reserva -->
    <main class="flex-grow-1 d-flex flex-column justify-content-center align-items-center">

        <div class="container py-4 py-md-5">

            <div class="booking-container mx-auto">

                <!-- Informação do serviço -->
                <div class="row g-3 mb-4">

                    <div class="col-12 col-md-6">
                        <div class="border rounded-3 p-3 h-100">

                            <div class="text-secondary small mb-1">
                                Serviço
                            </div>

                            <div class="fw-semibold">
                                <?= htmlspecialchars($service['name'] ?? '') ?>
                            </div>

                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="border rounded-3 p-3 h-100">

                            <div class="text-secondary small mb-1">
                                Duração
                            </div>

                            <div class="fw-semibold">
                                <?= htmlspecialchars($service['duration'] ?? '') ?> min
                            </div>

                        </div>
                    </div>

                </div>

                <!-- Reserva -->
                <div class="border rounded-3">

                    <form
                        id="bookingForm"
                        action="<?= $appBasePath ?? '' ?>/client/booking/add_new_booking"
                        method="post">

                        <!-- Dados da reserva -->
                        <input
                            type="hidden"
                            name="professional_id"
                            value="<?= htmlspecialchars($dataBase['professional_id'] ?? '') ?>">

                        <input
                            type="hidden"
                            name="service_id"
                            value="<?= htmlspecialchars($dataBase['service_id'] ?? '') ?>">

                        <input
                            type="hidden"
                            name="service_name"
                            value="<?= htmlspecialchars($service['name'] ?? '') ?>">

                        <input
                            type="hidden"
                            name="service_duration"
                            value="<?= htmlspecialchars($service['duration'] ?? '') ?>">

                        <input
                            type="hidden"
                            name="service_price"
                            value="<?= htmlspecialchars($service['price'] ?? '') ?>">

                        <input
                            type="hidden"
                            name="service_vat"
                            value="<?= htmlspecialchars($service['vat'] ?? '') ?>">

                        <input
                            type="hidden"
                            name="service_advance_payment"
                            value="<?= htmlspecialchars($service['advance_payment'] ?? '') ?>">

                        <input
                            type="hidden"
                            name="client_id"
                            value="<?= htmlspecialchars($User['id'] ?? '') ?>">

                        <input
                            type="hidden"
                            id="appointmentTime"
                            name="appointment_time"
                            value="">

                        <div class="p-3 p-md-4">

                            <div class="mb-4">

                                <h5 class="mb-1 fw-semibold">
                                    Escolher data e hora
                                </h5>

                                <p class="small text-secondary mb-0">
                                    Escolha uma data e hora disponíveis para a sua marcação.
                                </p>

                            </div>

                            <!-- Data -->
                            <div class="mb-4">

                                <label
                                    for="bookingDate"
                                    class="form-label small fw-medium">
                                    Data
                                </label>

                                <select
                                    id="bookingDate"
                                    name="appointment_date"
                                    class="form-select"
                                    required>

                                    <option value="">
                                        Selecionar data
                                    </option>

                                </select>

                            </div>

                            <!-- Horas -->
                            <div>

                                <div class="small fw-medium mb-2">
                                    Hora
                                </div>

                                <div
                                    id="bookingHours"
                                    class="booking-hours">

                                    <div class="text-secondary small">
                                        Selecione primeiro uma data.
                                    </div>

                                </div>

                            </div>

                            <div class="d-flex justify-content-end mt-4">

                                <button
                                    type="submit"
                                    class="cs-btn-primary py-2 px-4 rounded-2">

                                    Continuar

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </main>

    <!-- Scripts (dados da página e lógica da reserva) -->
    <script>
        const dataBase = <?= json_encode($dataBase) ?>;
    </script>

    <script src="<?= $appBasePath ?? '' ?>/resources/js/client/booking/index.js"></script>

</body>

</html>