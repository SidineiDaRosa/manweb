<!-- Botão para abrir o modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEventModal">
    Criar Evento
</button>

<!-- Modal -->
<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('machine-downtime-events.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createEventModalLabel">Novo Evento de Parada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <!-- downtime_id oculto -->
                    
                    <input type="hidden" name="downtime_id" value="">

                    <!-- Tipo de evento -->
                    <div class="mb-3">
                        <label for="event_type" class="form-label">Tipo de Evento</label>
                        <select class="form-select" name="event_type" id="event_type" required>
                            <option value="">Selecione</option>
                            <option value="INICIO">INÍCIO</option>
                            <option value="PAUSA">PAUSA</option>
                            <option value="RETOMADA">RETOMADA</option>
                            <option value="FIM">FIM</option>
                        </select>
                    </div>

                    <!-- Detalhe do motivo -->
                    <div class="mb-3">
                        <label for="reason_detail" class="form-label">Detalhes / Motivo</label>
                        <textarea class="form-control" name="reason_detail" id="reason_detail" rows="3"></textarea>
                    </div>

                    <!-- user_id oculto -->
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Evento</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var createModal = document.getElementById('createEventModal')
    createModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget
        var downtimeId = button.getAttribute('data-downtime')
        var inputDowntime = createModal.querySelector('input[name="downtime_id"]')
        inputDowntime.value = downtimeId
    })
</script>