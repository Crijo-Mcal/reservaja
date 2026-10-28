<div class="modal fade" id="professionalAppointmentsModal" tabindex="-1" aria-labelledby="professionalAppointmentsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-semibold" id="professionalAppointmentsLabel">Agendamentos</h5>
                    <p class="text-secondary small mb-0" id="appointmentProfessionalName"></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body" id="professionalAppointmentsList">
                <p class="text-center text-secondary py-4">Nenhum agendamento encontrado.</p>
            </div>
        </div>
    </div>
</div>

<style>
    #professionalAppointmentsModal .appointment-card {
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    #professionalAppointmentsModal .badge-status {
        display: inline-block;
        padding: 2px 6px;
        border: none;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
        line-height: 1.3;
        white-space: nowrap;
    }

    #professionalAppointmentsModal .badge-status-scheduled {
        background: var(--color-warning-2);
        color: var(--color-warning-1);
    }

    #professionalAppointmentsModal .badge-status-in-progress {
        background: var(--color-succsse-2);
        color: var(--color2);
    }

    #professionalAppointmentsModal .badge-status-completed {
        background: var(--color-succsse-2);
        color: var(--color-succsse-1);
    }

    #professionalAppointmentsModal .badge-status-cancelled {
        background: var(--color-danger-2);
        color: var(--color-danger-1);
    }

    #professionalAppointmentsModal .badge-status-no-show {
        background: #E2E8F0;
        color: #475569;
    }
</style>

