<!-- Modal de horários -->
<div class="modal fade" id="professionalSchedulesModal" tabindex="-1" aria-labelledby="professionalSchedulesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-semibold" id="professionalSchedulesLabel">Horários de trabalho</h5>
                    <p class="small text-secondary mb-0" id="scheduleProfessionalName"></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <div id="professionalSchedulesList">
                    <p class="text-center text-secondary py-4">Nenhum horário encontrado.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Estilos do modal -->
<style>
    #professionalSchedulesModal .modal-content {
        border-radius: 10px;
    }

    #professionalSchedulesModal .schedule-card,
    #professionalSchedulesModal .card {
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    #professionalSchedulesModal .card-body {
        padding: 12px;
    }

    #professionalSchedulesModal p {
        font-size: 13px;
    }

    #professionalSchedulesModal p strong {
        color: var(--color1);
        font-weight: 600;
    }
</style>
