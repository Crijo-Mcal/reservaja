<?php
$User = $_SESSION['user'] ?? null;
$User['subscription'] = 'free';
$error = $_SESSION['error'] ?? null;

unset($_SESSION['error']);

if (!isset($User) || $User['role'] !== 'professional') {
    header('Location: '.($appBasePath ?? '').'/html/auth/login.php');
    exit();
}

$databaseSchedules = $dataBase ?? [];
?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReservaJá - Schedule</title>

    <!-- Estilos -->
    <link rel="stylesheet" href="<?= $appBasePath ?? '' ?>/resources/css/company/schedule.css">

</head>

<body>
    <!-- Barra de navegação -->
    <?php require __DIR__ . "/../layout/professional_navBar.php"; ?>

    <div class="d-flex">
        <!-- Barra lateral -->
        <?php require __DIR__ . "/../layout/professional_sideBar.php"; ?>

        <main class="flex-grow-1 d-flex flex-column align-items-center gap-3 bg-body py-3">

            <!-- Cabeçalho -->
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="fw-semibold m-0">
                            Schedule
                        </h4>

                        <p class="cs-text-2 m-0">
                            Escolha os dias em que pretende trabalhar.
                        </p>
                    </div>

                    <!-- Perfil do profissional -->
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
                                alt="Fotografia"
                                class="rounded-circle object-fit-cover border-2"
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
                        class="alert alert-danger d-flex align-items-center justify-content-between py-2 px-3 mb-0"
                        role="alert">

                        <div class="small">
                            <?= htmlspecialchars(
                                $error['updateSchedule']
                                    ?? $error['scheduleInput']
                                    ?? ''
                            ) ?>
                        </div>

                        <button
                            type="button"
                            class="btn-close ms-3"
                            data-bs-dismiss="alert"
                            aria-label="Close">
                        </button>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Calendário -->
            <div class="container cs-fadeIn-y1">
                <section class="bg-white border rounded-4 shadow-sm overflow-hidden">

                    <!-- Cabeçalho do calendário -->
                    <div class="calendar-header p-3">
                        <div class="d-flex justify-content-between align-items-center gap-3">

                            <div>
                                <h6
                                    id="calendarMonth"
                                    class="fw-semibold mb-1">
                                </h6>

                                <span
                                    id="calendarYear"
                                    class="text-secondary small">
                                </span>
                            </div>

                            <!-- Navegação do calendário -->
                            <div class="d-flex align-items-center gap-2">
                                <button
                                    type="button"
                                    class="btn btn-light border h6 m-0"
                                    id="todayButton">
                                    Hoje
                                </button>

                                <div class="btn-group">
                                    <button
                                        type="button"
                                        class="btn btn-light border"
                                        id="previousMonth">
                                        &lsaquo;
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-light border"
                                        id="nextMonth">
                                        &rsaquo;
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dias do calendário -->
                    <div class="calendar-body p-2">
                        <div class="calendar-weekdays">
                            <div>Seg</div>
                            <div>Ter</div>
                            <div>Qua</div>
                            <div>Qui</div>
                            <div>Sex</div>
                            <div>Sáb</div>
                            <div>Dom</div>
                        </div>

                        <div
                            id="calendarDays"
                            class="calendar-days">
                        </div>
                    </div>
                </section>
            </div>

            <!-- Dias selecionados -->
            <div class="container cs-fadeIn-y1">
                <section class="bg-white border rounded-4 shadow-sm">

                    <form
                        action="<?= $appBasePath ?? '' ?>/company/schedules/addNewSchedule"
                        method="POST">

                        <input
                            type="hidden"
                            name="querry"
                            value="querry">

                        <div class="p-3">

                            <!-- Título -->
                            <div class="mb-3">
                                <h6 class="fw-medium mb-1">
                                    Dias selecionados
                                </h6>

                                <p class="text-secondary small mb-0">
                                    Selecione os dias em que pretende trabalhar.
                                </p>
                            </div>

                            <!-- Lista de horários selecionados -->
                            <div
                                id="selectedSchedules"
                                class="d-flex flex-column gap-2">
                            </div>

                            <!-- Guardar horários -->
                            <div class="d-flex justify-content-end mt-3">
                                <button
                                    type="submit"
                                    class="btn cs-btn-primary">
                                    Guardar horários
                                </button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </main>
    </div>

    <!-- Modal para editar horário -->
    <div
        class="modal fade"
        id="editScheduleModal"
        tabindex="-1"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Cabeçalho do modal -->
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">
                        Editar horário
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                <!-- Formulário de edição -->
                <form
                    method="POST"
                    action="<?= $appBasePath ?? '' ?>/company/schedules/updateSchedule"
                    id="editScheduleForm">

                    <div class="modal-body">

                        <input
                            type="hidden"
                            name="professional_id"
                            value="<?= $User['id'] ?>">

                        <input
                            type="hidden"
                            name="schedule_id"
                            id="editScheduleId">

                        <!-- Data -->
                        <div class="mb-3">
                            <label
                                for="editScheduleDate"
                                class="form-label small fw-medium">
                                Data
                            </label>

                            <input
                                type="date"
                                id="editScheduleDate"
                                name="date"
                                class="form-control"
                                required>
                        </div>

                        <div class="row g-3">

                            <!-- Hora de início -->
                            <div class="col-12 col-md-6">
                                <label
                                    for="editScheduleStart"
                                    class="form-label small fw-medium">
                                    Hora de início
                                </label>

                                <input
                                    type="time"
                                    id="editScheduleStart"
                                    name="start_time"
                                    class="form-control"
                                    required>
                            </div>

                            <!-- Hora de fim -->
                            <div class="col-12 col-md-6">
                                <label
                                    for="editScheduleEnd"
                                    class="form-label small fw-medium">
                                    Hora de fim
                                </label>

                                <input
                                    type="time"
                                    id="editScheduleEnd"
                                    name="end_time"
                                    class="form-control"
                                    required>
                            </div>

                            <!-- Pausa para almoço -->
                            <div class="col-12">
                                <div class="border rounded-3 p-3">

                                    <div class="small fw-medium mb-3">
                                        Pausa para almoço
                                    </div>

                                    <div class="row g-3">

                                        <!-- Início da pausa -->
                                        <div class="col-12 col-md-6">
                                            <label
                                                for="editScheduleLunchStart"
                                                class="form-label small">
                                                Início
                                            </label>

                                            <input
                                                type="time"
                                                id="editScheduleLunchStart"
                                                name="start_lunch"
                                                class="form-control">
                                        </div>

                                        <!-- Fim da pausa -->
                                        <div class="col-12 col-md-6">
                                            <label
                                                for="editScheduleLunchEnd"
                                                class="form-label small">
                                                Fim
                                            </label>

                                            <input
                                                type="time"
                                                id="editScheduleLunchEnd"
                                                name="end_lunch"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Ações do modal -->
                <div class="modal-footer">

                    <!-- Eliminar horário -->
                    <form
                        method="POST"
                        action="<?= $appBasePath ?? '' ?>/company/schedules/deleteSchedule">

                        <input
                            type="hidden"
                            name="deleteschedule_id"
                            id="deleteScheduleId">

                        <button
                            type="submit"
                            class="btn btn-outline-danger">
                            Eliminar
                        </button>
                    </form>

                    <!-- Guardar alterações -->
                    <button
                        type="submit"
                        form="editScheduleForm"
                        class="btn cs-btn-primary">
                        Guardar alterações
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?= $appBasePath ?? '' ?>/resources/js/bootstrap.min.js"></script>

    <script>
        const databaseSchedules = <?= json_encode($databaseSchedules) ?>;
        const professional_id = <?= $User['id'] ?? null ?>;
    </script>

    <script src="<?= $appBasePath ?? '' ?>/resources/js/company/schedule.js"></script>
</body>

</html>