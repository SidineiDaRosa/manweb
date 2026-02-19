<!-- Botão para abrir o modal -->

<!-- Modal -->
<div class="modal fade" id="modalParada" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('machine_downtime.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Iniciar Parada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <!-- Equipamento -->
                    <div class="mb-3">
                        <label class="form-label">Equipamento</label>
                        <select name="equipment_id" class="form-control" required>
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
                            <option value="">Ordem não anexada</option>
                            @foreach($ordens_servicos as $ordem)
                            <option value="{{ $ordem->id }}">
                                OS #{{ $ordem->id }} - {{ Str::limit($ordem->descricao, 40, '...') ?? 'Sem título' }} {{ $ordem->situacao}}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Início da Parada -->
                    <div class="mb-3">
                        <label class="form-label">Início da Parada</label>
                        <input type="datetime-local" name="started_at" class="form-control" required
                            value="{{ now()->setTimezone('America/Sao_Paulo')->format('Y-m-d\TH:i') }}" readonly>

                    </div>
                    <!-- Falhas -->
                    <div class="mb-3">
                        <label class="form-label">Falha</label>
                        <select name="falha_id" class="form-control" required>
                            @foreach($flaiures as $flaiure)
                            <option value="{{ $flaiure->id }}">
                                {{ $flaiure->name }} - {{ Str::limit($flaiure->description, 40, '...') }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Motivo -->
                    <div class="mb-3">
                        <label class="form-label">Motivo</label>
                        <textarea
                            name="reason"
                            class="form-control"
                            rows="3"
                            minlength="30"
                            required></textarea>
                        <div class="form-text">Mínimo de 10 caracteres.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-inf btn-inf-md btn-inf-red" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-inf btn-inf-md btn-inf-warning">Iniciar Parada</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- JS do Bootstrap (somente 1 vez) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>