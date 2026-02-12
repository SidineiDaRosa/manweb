<div class="modal fade" id="modalServico" tabindex="-1" aria-labelledby="modalServicoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalServicoLabel">Lançar Serviço</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="">
                @csrf

                <div class="modal-body">

                    <!-- Ordem de Serviço -->
                    <input type="hidden" name="ordem_servico_id" value="{{ $ordem_servico->id }}">

                    <!-- Descrição -->
                    <div class="mb-3">
                        <label class="form-label">Descrição do Serviço</label>
                        <textarea name="descricao" class="form-control" rows="3" required></textarea>
                    </div>

                    <!-- Funcionário -->
                    <div class="mb-3">
                        <label class="form-label">Funcionário</label>
                        <select name="funcionario_id" class="form-select" required>
                            <option value="">Selecione</option>
                            @foreach($funcionarios as $funcionario)
                                <option value="{{ $funcionario->id }}">
                                    {{ $funcionario->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Data -->
                    <div class="mb-3">
                        <label class="form-label">Data</label>
                        <input type="date" name="data" class="form-control" required>
                    </div>

                    <!-- Horas Trabalhadas -->
                    <div class="mb-3">
                        <label class="form-label">Horas Trabalhadas</label>
                        <input type="number" step="0.1" name="horas" class="form-control" required>
                    </div>

                    <!-- Valor -->
                    <div class="mb-3">
                        <label class="form-label">Valor (R$)</label>
                        <input type="number" step="0.01" name="valor" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        Salvar Serviço
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

