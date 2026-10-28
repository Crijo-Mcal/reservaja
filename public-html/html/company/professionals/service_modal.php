<!-- Modal de serviços -->
<div class="modal fade" id="professionalServicesModal" tabindex="-1" aria-labelledby="professionalServicesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-semibold" id="professionalServicesLabel">Serviços do profissional</h5>
                    <p class="small text-secondary mb-0" id="serviceProfessionalName"></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body">
                <div id="professionalServicesList"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Estilos do modal -->
<style>
    #professionalServicesModal .service-card {
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    #professionalServicesModal .badge-status {
        display: inline-block;
        padding: 2px 6px;
        border: none;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
        line-height: 1.3;
        white-space: nowrap;
    }

    #professionalServicesModal .badge-status-active {
        background: var(--color-succsse-2);
        color: var(--color-succsse-1);
    }

    #professionalServicesModal .badge-status-inactive {
        background: #E2E8F0;
        color: #475569;
    }
</style>
