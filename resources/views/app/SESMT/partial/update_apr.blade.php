<!--Modal update APR-->
<div class="modal fade" id="modalEditarApr" tabindex="-1" aria-labelledby="modalEditarAprLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="formAprUpdate" method="POST" action="{{ route('apr.update') }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="apr_id">

            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalEditarAprLabel">
                        <i class="fas fa-edit me-2"></i> Editar APR
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Ordem de Serviço -->
                    <div class="mb-3">
                        <label class="form-label">Ordem de Serviço</label>
                        <input type="number" class="form-control" name="ordem_servico_id" id="ordem_servico_id" required readonly>
                    </div>
                    <!-- Localização -->
                    <div class="mb-3">
                        <label class="form-label">Localização</label>
                        <select name="localizacao_id" id="localizacao_id" class="form-control">
                            <option value="">Selecione...</option>
                            @foreach($localizacao as $local)
                            <option value="{{ $local->id }}">{{ $local->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Descrição da Atividade -->
                    <div class="mb-3">
                        <label class="form-label">Descrição da Atividade</label>
                        <textarea name="descricao_atividade" id="descricao_atividade" class="form-control" rows="3" required></textarea>
                    </div>
                    <!-- Responsável -->
                    <div class="mb-3">
                        <label class="form-label">Responsável</label>
                        <select name="responsavel_id" id="responsavel_id" class="form-control">
                            <option value="">Selecione...</option>
                            @foreach($responsaveis as $resp)
                            <option value="{{ $resp->id }}">{{ $resp->primeiro_nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Prazo de validade -->

                    <div class="mb-3">
                        <label class="form-label">Prazo de Validade</label>
                        <input
                            type="datetime-local"
                            class="form-control"
                            name="prazo"
                            id="prazo"
                            value="{{ \Carbon\Carbon::parse($apr->prazo)->format('Y-m-d\TH:i') }}">
                    </div>
                    <!-- Assinatura -->
                    <div class="mb-3">
                        <label class="form-label">Assinatura do Responsável</label>
                        <input type="text" class="form-control" name="assinatura_responsavel" id="assinatura_responsavel">
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="aberta">Aberta</option>
                            <option value="finalizada">Finalizada</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Salvar Alterações</button>
                </div>
            </div>
        </form>

    </div>
</div>
<script>
    function editarApr(apr) {
        document.getElementById('apr_id').value = apr.id;
        document.getElementById('ordem_servico_id').value = apr.ordem_servico_id;
        document.getElementById('localizacao_id').value = apr.localizacao_id;
        document.getElementById('descricao_atividade').value = apr.descricao_atividade;
        document.getElementById('responsavel_id').value = apr.responsavel_id;
        document.getElementById('assinatura_responsavel').value = apr.assinatura_responsavel;
        document.getElementById('status').value = apr.status;

        let modal = new bootstrap.Modal(document.getElementById('modalEditarApr'));
        modal.show();
    }
</script>