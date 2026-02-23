<!-- Modal Criar Parada -->
<div class="modal fade" id="modalCreateParada" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('machine_downtime.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Nova Parada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- Equipamento -->
                    <div class="mb-3">
                        <label class="form-label">Equipamento</label>
                        <select name="equipment_id" class="form-control" required>
                            <option value="">Selecione</option>
                            @foreach($equipamentos as $equipamento)
                            <option value="{{ $equipamento->id }}">
                                {{ $equipamento->nome }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ordem de Serviço -->
                    <div class="mb-3">
                        <label class="form-label">Ordem de Serviço</label>
                        <select name="ordem_servico_id" class="form-control">
                            <option value="">Opcional</option>
                            @foreach($ordens_servicos as $ordem)
                            <option value="{{ $ordem->id }}">
                                OS #{{ $ordem->id }} -
                                {{ Str::limit($ordem->descricao, 40, '...') }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Falha -->
                    <div class="mb-3">
                        <label class="form-label">Falha</label>
                        <select name="falha_id" class="form-control" required>
                            <option value="">Selecione</option>
                            @foreach($flaiures as $flaiure)
                            <option value="{{ $flaiure->id }}">
                                {{ $flaiure->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Início -->
                    <div class="mb-3">
                        <label class="form-label">Início da Parada</label>
                        <input type="datetime-local"
                            name="started_at"
                            class="form-control"
                            value="{{ now()->format('Y-m-d\TH:i') }}"
                            required readonly>
                    </div>

                    <!-- Fim -->
                    <div class="mb-3">
                        <label class="form-label">Fim da Parada</label>
                        <input type="datetime-local"
                            name="ended_at"
                            class="form-control" disabled>
                    </div>

                    <!-- Motivo -->
                    <div class="mb-3">
                        <label class="form-label">Motivo</label>
                        <textarea name="reason"
                            class="form-control"
                            rows="3"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button"
                        class="btn-inf btn-inf-md btn-inf-red"
                        data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="submit"
                        class="btn-inf btn-inf-md btn-inf-green">
                        Salvar
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>