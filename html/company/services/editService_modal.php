<!-- Modal para editar serviço -->
<div
    class="modal fade"
    id="editServiceModal"
    tabindex="-1"
    aria-labelledby="editServiceModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

            <!-- Cabeçalho -->
            <div class="modal-header px-4 py-3 border-bottom">

                <div>
                    <h5
                        class="modal-title fw-medium mb-1"
                        id="editServiceModalLabel">
                        Editar serviço
                    </h5>

                    <p class="text-body-secondary small mb-0">
                        Atualize os dados do serviço.
                    </p>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Fechar">
                </button>

            </div>

            <!-- Formulário -->
            <form
                method="POST"
                action="<?= $appBasePath ?? '' ?>/company/services/update_service">

                <!-- ID do serviço -->
                <input
                    type="hidden"
                    id="serviceId"
                    name="service_id"
                    required>

                <!-- Corpo -->
                <div class="modal-body px-4 py-3">

                    <!-- Nome -->
                    <div class="mb-3">

                        <label
                            for="serviceName"
                            class="form-label fw-medium">
                            Nome do serviço
                        </label>

                        <input
                            type="text"
                            class="form-control form-control-sm"
                            id="serviceName"
                            name="name"
                            placeholder="Ex.: Instalação de equipamento">

                    </div>

                    <!-- Estado + Duração -->
                    <div class="row g-3 mb-3">

                        <!-- Estado -->
                        <div class="col-6">

                            <label
                                for="serviceStatus"
                                class="form-label fw-medium">
                                Estado
                            </label>

                            <select
                                class="form-select form-select-sm"
                                id="serviceStatus"
                                name="status">

                                <option value="active">
                                    Ativo
                                </option>

                                <option value="inactive">
                                    Inativo
                                </option>

                            </select>

                        </div>

                        <!-- Duração -->
                        <div class="col-6">

                            <label
                                for="serviceDuration"
                                class="form-label fw-medium">
                                Duração
                            </label>

                            <div class="input-group input-group-sm">

                                <input
                                    type="number"
                                    class="form-control"
                                    id="serviceDuration"
                                    name="duration"
                                    min="1"
                                    placeholder="Ex.: 60">

                                <span class="input-group-text">
                                    min
                                </span>

                            </div>

                        </div>

                    </div>

                    <!-- Preço -->
                        <div class="col-6">

                            <label
                                for="servicePrice"
                                class="form-label fw-medium">
                                Preço
                            </label>

                            <div class="input-group input-group-sm">

                                <input
                                    type="number"
                                    class="form-control"
                                    id="servicePrice"
                                    name="price"
                                    min="0"
                                    step="0.01"
                                    placeholder="Ex.: 50.00">

                                <span class="input-group-text">
                                    €
                                </span>

                            </div>

                        </div>

                    <!-- Pagamento antecipado + IVA -->
                    <div class="row g-3 mb-3">

                        <!-- IVA -->
                        <div class="col-6">

                            <label
                                for="serviceVat"
                                class="form-label fw-medium">
                                IVA
                            </label>

                            <div class="input-group input-group-sm">

                                <input
                                    type="number"
                                    class="form-control"
                                    id="serviceVat"
                                    name="vat"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    placeholder="Ex.: 23">

                                <span class="input-group-text">
                                    %
                                </span>

                            </div>

                        </div>

                        <!-- Pagamento antecipado -->
                        <div class="col-6">

                            <label
                                for="serviceAdvancePayment"
                                class="form-label fw-medium">
                                Pagamento antecipado
                            </label>

                            <div class="input-group input-group-sm">

                                <input
                                    type="number"
                                    class="form-control"
                                    id="serviceAdvancePayment"
                                    name="advance_payment"
                                    min="0"
                                    step="0.01"
                                    placeholder="Ex.: 10.00">

                                <span class="input-group-text">
                                    €
                                </span>

                            </div>

                        </div>

                    </div>

                    <!-- Descrição -->
                    <div>

                        <label
                            for="serviceDescription"
                            class="form-label fw-medium">
                            Descrição
                        </label>

                        <textarea
                            class="form-control form-control-sm"
                            id="serviceDescription"
                            name="description"
                            rows="3"
                            placeholder="Descreva os detalhes do serviço..."></textarea>

                    </div>

                </div>

                <!-- Rodapé -->
                <div class="modal-footer px-4 py-3 bg-body-tertiary border-top">

                    <button
                        type="button"
                        class="btn btn-light border btn-sm"
                        data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="btn cs-btn-primary btn-sm">
                        Atualizar serviço
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>