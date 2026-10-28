document.addEventListener("DOMContentLoaded", () => {
    const showModal = (id) =>
        bootstrap.Modal.getOrCreateInstance(document.getElementById(id)).show();
    const renderCards = (items, render, message) =>
        items.length
            ? items.map(render).join("")
            : `<p class="text-center text-secondary py-4">${message}</p>`;

    // Modal de atualização
    document.querySelectorAll("[data-professional-update]").forEach((button) => {
        button.addEventListener("click", () => {
            const data = button.dataset;
            Object.entries({
                updateId: data.id,
                updateName: data.name,
                updateMobile: data.mobile,
                updateSpeciality: data.speciality,
                updateRole: data.role,
                updateStatus: data.status,
                updateDescription: data.description,
            }).forEach(([id, value]) => {
                document.getElementById(id).value = value ?? "";
            });
            showModal("professionalUpdateModal");
        });
    });

    // Modal de horários
    document
        .querySelectorAll("[data-professional-schedules]")
        .forEach((button) => {
            button.addEventListener("click", () => {
                const schedules = JSON.parse(button.dataset.schedules || "[]");

                document.getElementById("scheduleProfessionalName").textContent =
                    button.dataset.name;

                document.getElementById("professionalSchedulesList").innerHTML =
                    renderCards(
                        schedules,
                        (s) => `
                <div class="card schedule-card">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <h6 class="fw-semibold mb-2">${s.date ?? ""}</h6>
                            <span class="small text-secondary">${s.status ?? ""}</span>
                        </div>
                        <div class="d-flex flex-wrap gap-3 small">
                            <span><strong>Início:</strong> ${s.start_time ?? ""}</span>
                            <span><strong>Fim:</strong> ${s.end_time ?? ""}</span>
                        </div>
                    </div>
                </div>
            `,
                        "Nenhum horário encontrado.",
                    );

                showModal("professionalSchedulesModal");
            });
        });

    // Modal de serviços
    document
        .querySelectorAll("[data-professional-services]")
        .forEach((button) => {
            button.addEventListener("click", () => {
                const services = JSON.parse(button.dataset.services || "[]");
                document.getElementById("serviceProfessionalName").textContent =
                    button.dataset.name;
                document.getElementById("professionalServicesList").innerHTML =
                    renderCards(
                        services,
                        (s) => {
                            const active = s.status === "active";
                            return `
                        <div class="card service-card">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start gap-3">
                                    <h6 class="fw-semibold mb-2">${s.name ?? ""}</h6>
                                    <span class="badge-status ${active ? "badge-status-active" : "badge-status-inactive"}">
                                        ${active ? "Ativo" : "Inativo"}
                                    </span>
                                </div>
                                <p class="text-secondary small mb-3">${s.description || "Sem descrição"}</p>
                                <div class="d-flex flex-wrap gap-3 small">
                                    <span><strong>Preço:</strong> ${s.price ?? ""} €</span>
                                    <span><strong>Duração:</strong> ${s.duration ?? ""} min</span>
                                    <span><strong>IVA:</strong> ${s.vat ?? ""}%</span>
                                    <span><strong>Pagamento antecipado:</strong> ${s.advance_payment ?? 0}%</span>
                                </div>
                            </div>
                        </div>`;
                        },
                        "Nenhum serviço encontrado.",
                    );
                showModal("professionalServicesModal");
            });
        });

    // Estados dos agendamentos
    const appointmentStatuses = {
        scheduled: ["Agendado", "badge-status-scheduled"],
        in_progress: ["Em andamento", "badge-status-in-progress"],
        completed: ["Concluído", "badge-status-completed"],
        cancelled: ["Cancelado", "badge-status-cancelled"],
        no_show: ["Não compareceu", "badge-status-no-show"],
    };

    // Modal de agendamentos
    document
        .querySelectorAll("[data-professional-appointments]")
        .forEach((button) => {
            button.addEventListener("click", () => {
                const appointments = JSON.parse(button.dataset.appointments || "[]");
                document.getElementById("appointmentProfessionalName").textContent =
                    button.dataset.name;
                document.getElementById("professionalAppointmentsList").innerHTML =
                    renderCards(
                        appointments,
                        (a) => {
                            const [label, statusClass] = appointmentStatuses[a.status] ?? [
                                a.status ?? "",
                                "",
                            ];
                            return `
                        <div class="card border mb-2">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start gap-3">
                                    <h6 class="fw-semibold mb-2">${a.client_name || "Cliente"}</h6>
                                    <span class="badge-status ${statusClass}">${label}</span>
                                </div>
                                <p class="mb-2"><strong>Serviço:</strong> ${a.service_name ?? ""}</p>
                                <p class="small text-secondary mb-1"><strong>Data:</strong> ${a.appointment_date ?? ""}</p>
                                <p class="small text-secondary mb-0"><strong>Horário:</strong> ${a.appointment_time ?? ""} - ${a.appointment_end ?? ""}</p>
                            </div>
                        </div>`;
                        },
                        "Nenhum agendamento encontrado.",
                    );
                showModal("professionalAppointmentsModal");
            });
        });
});
