
<!-- Update Modal -->
<div class="modal fade" id="professionalUpdateModal" tabindex="-1" aria-labelledby="professionalUpdateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="<?= $appBasePath ?? '' ?>/html/company/professionals/professionals.php/update">
                <div class="modal-header">
                    <h5 class="modal-title fw-semibold" id="professionalUpdateLabel">
                        Atualizar profissional
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="updateId">

                    <div class="mb-3">
                        <label for="updateName" class="form-label small">Nome</label>
                        <input type="text" class="form-control form-control-sm" name="name" id="updateName" maxlength="100" required>
                    </div>

                    <div class="mb-3">
                        <label for="updateMobile" class="form-label small">Telemóvel</label>
                        <input type="tel" class="form-control form-control-sm" name="mobile_number" id="updateMobile" pattern="[0-9]{9}" maxlength="9" required>
                    </div>

                    <div class="mb-3">
                        <label for="updateSpeciality" class="form-label small">Especialidade</label>
                        <input type="text" class="form-control form-control-sm" name="speciality" id="updateSpeciality" maxlength="100">
                    </div>

                    <div class="mb-3">
                        <label for="updateStatus" class="form-label small">Estado</label>
                        <select class="form-select form-select-sm" name="status" id="updateStatus" required>
                            <option value="active">Ativo</option>
                            <option value="inactive">Inativo</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="updateDescription" class="form-label small">Descrição</label>
                        <textarea class="form-control form-control-sm" name="description" id="updateDescription" rows="3" maxlength="1000"></textarea>
                    </div>

                    <!-- Sensitive Role Setting -->
                    <div class="p-3 rounded border border-success bg-success-subtle">
                        <label for="updateRole" class="form-label small fw-semibold text-success">
                            Função — Definição sensível
                        </label>
                        <select class="form-select form-select-sm border-success" name="role_company" id="updateRole" required>
                            <option value="employee">Funcionário</option>
                            <option value="technician">Técnico</option>
                            <option value="owner">Proprietário</option>
                        </select>
                        <small class="text-success d-block mt-2">
                            Atenção: alterar esta opção pode modificar as permissões do profissional.
                        </small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-sm cs-btn-primary">
                        Guardar alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

