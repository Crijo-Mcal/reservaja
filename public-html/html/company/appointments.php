<?php

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'professional') {
    header('Location:'.($appBasePath ?? '').'/html/auth/login.php');
    exit();
}

$User = $_SESSION['user'];
$User['subscription'] = 'free';
$error = $_SESSION['error']['appointmetnError'] ?? [];

$data = $dataBase ?? [];

$appointments_datas = $data['appointments_datas'] ?? [];
$summary = $data['summary'] ?? [];
$available_dates = $data['avaliable_Date'] ?? [];

$dataInput = [
    'appointment_id' => $_GET['appointment_id'] ?? '',
    'date' => $_GET['date'] ?? ''
];

unset($_SESSION['error']);

?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReservaJá - Appointments</title>

    <link rel="stylesheet" href="<?= $appBasePath ?? '' ?>/resources/css/company/appointment.css">
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
                <div class="d-flex justify-content-between align-items-center gap-3">
                    <div>
                        <h4 class="fw-semibold m-0">
                            Agendamentos
                        </h4>

                        <p class="cs-text-2 m-0">
                            Gerir os agendamentos dos seus clientes.
                        </p>
                    </div>

                    <div class="d-none d-sm-flex align-items-center gap-2">
                        <?php
                        $roleLabels = [
                            'owner' => 'Proprietário',
                            'employee' => 'Funcionário',
                            'technician' => 'Técnico'
                        ];
                        ?>

                        <span class="cs-tag-success">
                            <?= htmlspecialchars($roleLabels[$User['roleInCompany']] ?? $User['roleInCompany']) ?>
                        </span>

                        <span class="small fw-normal">
                            <?= htmlspecialchars($User['name']) ?>
                        </span>

                        <a href="<?= $appBasePath ?? '' ?>/html/company/profile.php">
                            <img
                                src="<?= $User['profile_image'] ?? ($appBasePath ?? '').'/asset/image/profile.webp' ?>"
                                alt="Fotografia do profissional"
                                class="rounded-circle object-fit-cover border"
                                width="36"
                                height="36">
                        </a>
                    </div>
                </div>
            </div>

            <!-- Mensagem de erro -->
            <?php if ($error): ?>
                <div class="container cs-fadeIn-y1">
                    <div
                        class="alert alert-warning d-flex align-items-center justify-content-between py-2 px-3 mb-0"
                        role="alert">

                        <div class="small">
                            <?= htmlspecialchars($error) ?>
                        </div>

                        <button
                            type="button"
                            class="btn-close ms-3"
                            data-bs-dismiss="alert"
                            aria-label="Fechar">
                        </button>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Resumo -->
            <div class="container mb-3 cs-fadeIn-y1">
                <div class="row g-3">

                    <div class="col-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100 cs-summary-card cs-summary-today">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <span class="small opacity-75">
                                            Hoje
                                        </span>
                                        <h4 class="fw-semibold mt-1 mb-1">
                                            <?= $summary['today'] ?? 0 ?>
                                        </h4>
                                        <span class="small opacity-75">
                                            15 de Setembro
                                        </span>
                                    </div>

                                    <i class="bi bi-calendar-day fs-5 opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100 cs-summary-card cs-summary-light">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <span class="small opacity-75">
                                            Agendados
                                        </span>
                                        <h4 class="fw-semibold mt-1 mb-1">
                                            <?= $summary['scheduled'] ?? 0 ?>
                                        </h4>
                                        <span class="small opacity-75">
                                            Agendamentos
                                        </span>
                                    </div>

                                    <i class="bi bi-calendar-check fs-5 opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100 cs-summary-card cs-summary-light">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <span class="small opacity-75">
                                            Concluídos
                                        </span>
                                        <h4 class="fw-semibold mt-1 mb-1">
                                            <?= $summary['completed'] ?? 0 ?>
                                        </h4>
                                        <span class="small opacity-75">
                                            Agendamentos
                                        </span>
                                    </div>

                                    <i class="bi bi-check-circle fs-5 opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-xl-3">
                        <div class="card border-0 shadow-sm h-100 cs-summary-card cs-summary-light">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <span class="small opacity-75">
                                            Total
                                        </span>
                                        <h4 class="fw-semibold mt-1 mb-1">
                                            <?= $summary['total'] ?? 0 ?>
                                        </h4>
                                        <span class="small opacity-75">
                                            Agendamentos
                                        </span>
                                    </div>

                                    <i class="bi bi-calendar2-week fs-5 opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Filtros -->
            <div class="container cs-fadeIn-y1">
                <form
                    method="GET"
                    action="<?= $appBasePath ?? '' ?>/html/company/appointments.php/search">

                    <div class="card border">
                        <div class="card-body p-3">

                            <div class="row g-2 justify-content-center">

                                <div class="col-12 col-sm-auto">
                                    <input
                                        type="number"
                                        class="form-control form-control-sm"
                                        name="appointment_id"
                                        placeholder="ID do appointment"
                                        aria-label="Pesquisar appointment por ID"
                                        value="<?= htmlspecialchars($dataInput['appointment_id'] ?? '') ?>">
                                </div>

                                <div class="col-12 col-sm-auto">
                                    <select
                                        class="form-select form-select-sm"
                                        name="date"
                                        aria-label="Selecionar data">

                                        <option value="">
                                            Hoje
                                        </option>

                                        <?php foreach ($available_dates as $date): ?>
                                            <option
                                                value="<?= htmlspecialchars($date) ?>"
                                                <?= ($dataInput['date'] ?? '') === $date ? 'selected' : '' ?>>

                                                <?= date('d/m/Y', strtotime($date)) ?>

                                            </option>
                                        <?php endforeach; ?>

                                    </select>
                                </div>

                                <div class="col-12 col-sm-auto">
                                    <button
                                        type="submit"
                                        class="btn btn-sm cs-btn-primary w-100">

                                        Pesquisar

                                    </button>
                                </div>

                            </div>

                        </div>
                    </div>
                </form>
            </div>

            <!-- Lista de agendamentos -->
            <div class="container cs-fadeIn-y1">
                <div class="card cs-shadow border-0">

                    <div class="card-header py-3 px-4 cs-bg-primary cs-text-1">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-1">
                            <h6 class="mb-0 fw-medium">Agendamentos</h6>
                            <span class="small">
                                <?= htmlspecialchars($data['string_date'] ?? '') ?>
                            </span>
                        </div>
                    </div>

                    <?php if (!empty($appointments_datas)): ?>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0 appointment-table">
                                    <thead>
                                        <tr>
                                            <th class="px-4 text-center text-md-start">Horário</th>
                                            <th class="text-center text-md-start">Cliente</th>
                                            <th class="d-none d-xl-table-cell text-start">Serviço</th>
                                            <th class="d-none d-md-table-cell text-start">Duração</th>
                                            <th class="d-none d-xl-table-cell text-start">Data</th>
                                            <th class="text-center text-md-start">Estado</th>
                                            <th class="px-4 text-center">Gerir</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($appointments_datas as $appointment): ?>
                                            <tr>

                                                <td class="px-4 text-center text-md-start">
                                                    <span class="fw-semibold">
                                                        <?= date('H:i', strtotime($appointment['appointment_time'])) ?>
                                                    </span>
                                                </td>

                                                <td class="text-center text-md-start">
                                                    <span class="fw-medium">
                                                        <?= htmlspecialchars($appointment['client_name']) ?>
                                                    </span>
                                                </td>

                                                <td class="d-none d-xl-table-cell text-start">
                                                    <span class="fw-medium">
                                                        <?= htmlspecialchars($appointment['service_name']) ?>
                                                    </span>
                                                </td>

                                                <td class="d-none d-md-table-cell text-start">
                                                    <span class="small">
                                                        <?= htmlspecialchars($appointment['service_duration']) ?> min
                                                    </span>
                                                </td>

                                                <td class="d-none d-xl-table-cell text-start">
                                                    <span class="small text-nowrap">
                                                        <?= date('d/m/Y', strtotime($appointment['appointment_date'])) ?>
                                                    </span>
                                                </td>

                                                <td class="text-center text-md-start">
                                                    <?php if ($appointment['appointment_status'] === 'scheduled'): ?>

                                                        <span class="cs-tag-warning">
                                                            Agendado
                                                        </span>

                                                    <?php elseif ($appointment['appointment_status'] === 'completed'): ?>

                                                        <span class="cs-tag-success">
                                                            Concluído
                                                        </span>

                                                    <?php elseif ($appointment['appointment_status'] === 'cancelled'): ?>

                                                        <span class="cs-tag-danger">
                                                            Cancelado
                                                        </span>

                                                    <?php elseif ($appointment['appointment_status'] === 'no_show'): ?>

                                                        <span class="cs-tag-muted">
                                                            Não compareceu
                                                        </span>

                                                    <?php endif; ?>
                                                </td>

                                                <td class="px-4 text-center text-md-end">
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm cs-btn-primary appointment-detail-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#detalhaModal"
                                                        data-appointment-id="<?= htmlspecialchars($appointment['appointment_id']) ?>"
                                                        data-booking-id="<?= htmlspecialchars($appointment['booking_id']) ?>"
                                                        data-client-name="<?= htmlspecialchars($appointment['client_name'], ENT_QUOTES) ?>"
                                                        data-client-email="<?= htmlspecialchars($appointment['client_email'], ENT_QUOTES) ?>"
                                                        data-client-mobile="<?= htmlspecialchars($appointment['client_mobile'], ENT_QUOTES) ?>"
                                                        data-service-name="<?= htmlspecialchars($appointment['service_name'], ENT_QUOTES) ?>"
                                                        data-date="<?= htmlspecialchars($appointment['appointment_date']) ?>"
                                                        data-time="<?= htmlspecialchars($appointment['appointment_time']) ?>"
                                                        data-duration="<?= htmlspecialchars($appointment['service_duration']) ?>"
                                                        data-status="<?= htmlspecialchars($appointment['appointment_status']) ?>">
                                                        Gerir
                                                    </button>
                                                </td>

                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    <?php else: ?>

                        <!-- Estado vazio -->
                        <div class="p-3">
                            <div
                                class="border rounded d-flex align-items-center justify-content-center text-center"
                                style="min-height: 160px;">
                                <p class="mb-0 text-secondary">
                                    Não existem agendamentos para hoje.
                                </p>
                            </div>
                        </div>

                    <?php endif; ?>

                </div>
            </div>

        </main>
    </div>

    <!-- Modal -->
    <div
        class="modal fade"
        id="detalhaModal"
        tabindex="-1"
        aria-labelledby="appointmentModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg">

            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                <div class="modal-header px-3 px-md-4 py-3">

                    <div class="min-w-0">

                        <h5
                            class="modal-title fw-medium mb-1"
                            id="appointmentModalLabel">

                            Gerir agendamento

                        </h5>

                        <p class="text-body-secondary small mb-0">
                            Consulte e atualize os dados do agendamento.
                        </p>

                    </div>

                    <button
                        type="button"
                        class="btn-close flex-shrink-0"
                        data-bs-dismiss="modal"
                        aria-label="Fechar">
                    </button>

                </div>

                <form
                    method="POST"
                    action="<?= $appBasePath ?? '' ?>/company/appointments/update">

                    <div class="modal-body px-3 px-md-4 py-3 py-md-4">

                        <!-- Informações do agendamento -->
                        <div class="border rounded-3 mb-3">

                            <div class="row g-0">

                                <div class="col-12 col-md-3">
                                    <div class="px-3 py-3">
                                        <span class="text-body-secondary small d-block mb-1">
                                            Appointment ID
                                        </span>

                                        <span
                                            class="fw-medium text-break"
                                            id="modalAppointmentId">
                                        </span>
                                    </div>
                                </div>

                                <div class="col-12 col-md-3">
                                    <div class="px-3 py-3">
                                        <span class="text-body-secondary small d-block mb-1">
                                            Booking ID
                                        </span>

                                        <span
                                            class="fw-medium text-break"
                                            id="modalBookingId">
                                        </span>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="px-3 py-3">
                                        <span class="text-body-secondary small d-block mb-1">
                                            Serviço
                                        </span>

                                        <span
                                            class="fw-medium text-break"
                                            id="modalServiceName">
                                        </span>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <!-- Informações do cliente -->
                        <div class="border rounded-3 mb-4">

                            <div class="row g-0">

                                <div class="col-12 col-md-4">
                                    <div class="px-3 py-3">
                                        <span class="text-body-secondary small d-block mb-1">
                                            Cliente
                                        </span>

                                        <span
                                            class="fw-medium text-break"
                                            id="modalClientName">
                                        </span>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="px-3 py-3">
                                        <span class="text-body-secondary small d-block mb-1">
                                            Email
                                        </span>

                                        <span
                                            class="small fw-medium text-break d-block"
                                            id="modalClientEmail">
                                        </span>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4">
                                    <div class="px-3 py-3">
                                        <span class="text-body-secondary small d-block mb-1">
                                            Telemóvel
                                        </span>

                                        <span
                                            class="fw-medium text-break"
                                            id="modalClientMobile">
                                        </span>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <!-- Campos editáveis -->
                        <div class="row g-3">

                            <input
                                type="hidden"
                                name="appointment_id"
                                id="modalAppointmentIdInput">

                            <input
                                type="hidden"
                                name="booking_id"
                                id="modalBookingIdInput">

                            <div class="col-12 col-md-6">

                                <label
                                    for="modalDate"
                                    class="form-label fw-medium">

                                    Data

                                </label>

                                <input
                                    type="date"
                                    class="form-control form-control-sm"
                                    id="modalDate"
                                    name="appointment_date">

                            </div>

                            <div class="col-12 col-md-6">

                                <label
                                    for="modalTime"
                                    class="form-label fw-medium">

                                    Horário

                                </label>

                                <input
                                    type="time"
                                    class="form-control form-control-sm"
                                    id="modalTime"
                                    name="appointment_time">

                            </div>

                            <div class="col-12 col-md-6">

                                <label
                                    for="modalDuration"
                                    class="form-label fw-medium">

                                    Duração

                                </label>

                                <div class="input-group input-group-sm">

                                    <input
                                        type="number"
                                        class="form-control"
                                        id="modalDuration"
                                        name="service_duration"
                                        min="1">

                                    <span class="input-group-text">
                                        min
                                    </span>

                                </div>

                            </div>

                            <div class="col-12 col-md-6">

                                <label
                                    for="modalStatus"
                                    class="form-label fw-medium">

                                    Estado

                                </label>

                                <select
                                    class="form-select form-select-sm"
                                    id="modalStatus"
                                    name="appointment_status">

                                    <option value="scheduled">
                                        Agendado
                                    </option>

                                    <option value="completed">
                                        Concluído
                                    </option>

                                    <option value="no_show">
                                        Não compareceu
                                    </option>

                                    <option value="cancelled">
                                        Cancelado
                                    </option>

                                </select>

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer px-3 px-md-4 py-3 bg-body-tertiary">

                        <button
                            type="button"
                            class="btn btn-light border btn-sm"
                            data-bs-dismiss="modal">

                            Cancelar

                        </button>

                        <button
                            type="submit"
                            class="btn cs-btn-primary btn-sm">

                            Guardar alterações

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- Scripts -->
    <script src="<?= $appBasePath ?? '' ?>/resources/js/bootstrap.min.js"></script>
    <script src="<?= $appBasePath ?? '' ?>/resources/js/company/appointment.js"></script>

</body>

</html>