<!-- Modal Editar Parada -->
<div class="modal fade" id="modalEditParada" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="formEditParada" method="POST">
                @csrf
                @method('PUT') <!-- método PUT para atualizar -->

                <div class="modal-header">
                    <h5 class="modal-title">Editar Parada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Senha para liberar edição</label>
                        <div class="input-group">
                            <input type="password" id="senhaLiberacao" name="password" class="form-control">
                            <button type="button" class="btn-inf btn-inf-md btn-inf-orange" onclick="validarSenha()">
                                Validar
                            </button>
                        </div>
                        <small id="msgSenha" class="text-danger d-none">Senha incorreta</small>
                    </div>

                    <!-- Equipamento -->
                    <div class="mb-3">
                        <label class="form-label">Equipamento</label>
                        <select name="equipment_id" class="form-control" required id="edit_equipment" disabled>
                            @foreach($equipamentos as $equipamento)
                            <option value="{{ $equipamento->id }}">{{ $equipamento->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ordem de Serviço -->
                    <div class="mb-3">
                        <label class="form-label">Ordem de Serviço</label>
                        <select name="ordem_servico_id" class="form-control" required id="edit_ordem" disabled>
                            @foreach($ordens_servicos as $ordem)
                            <option value="{{ $ordem->id }}">
                                OS #{{ $ordem->id }} - {{ Str::limit($ordem->descricao, 40, '...') ?? 'Sem título' }} {{ $ordem->situacao }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Início da Parada -->
                    <div class="mb-3">
                        <label class="form-label">Início da Parada</label>
                        <input type="datetime-local" name="started_at" class="form-control" required id="edit_started" readonly>
                    </div>

                    <!-- Fim da Parada -->
                    <div class="mb-3">
                        <label class="form-label">Fim da Parada</label>
                        <input type="datetime-local" name="ended_at" class="form-control" id="edit_ended" required readonly>
                    </div>

                    <!-- Falhas -->
                    <div class="mb-3">
                        <label class="form-label">Falha</label>
                        <option value=""></option>
                        <select name="falha_id" class="form-control" required id="edit_falha" disabled >
                            @foreach($flaiures as $flaiure)
                            <option value="{{ $flaiure->id }}">{{ $flaiure->name }} - {{ Str::limit($flaiure->description, 40, '...') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Motivo -->
                    <div class="mb-3">
                        <label class="form-label">Motivo</label>
                        <textarea name="reason" class="form-control" rows="3" id="edit_reason" disabled></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-inf btn-inf-md btn-inf-red" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn-inf btn-inf-md btn-inf-blue-dark" disabled>Salvar Alterações</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = new bootstrap.Modal(document.getElementById('modalEditParada'));
        const form = document.getElementById('formEditParada');

        function formatDateTimeLocal(dateStr) {
            const date = new Date(dateStr);
            // Ajusta o fuso horário local
            const offset = date.getTimezoneOffset() * 60000;
            return new Date(date.getTime() - offset).toISOString().slice(0, 16);
        }

        document.querySelectorAll('.btn-edit-parada').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const equipment = this.dataset.equipment;
                const ordem = this.dataset.ordem;
                const failure = this.dataset.failure;
                const reason = this.dataset.reason;
                const started = this.dataset.started;
                const ended = this.dataset.ended;

                // Atualiza a action do form para o ID correto
                form.action = `/machine-downtime/${id}`; // ajuste se a rota for diferente

                // Popula os campos
                document.getElementById('edit_equipment').value = equipment;
                document.getElementById('edit_ordem').value = ordem;
                document.getElementById('edit_falha').value = failure;

                document.getElementById('edit_reason').value = reason || '';

                // Início da parada (readonly) com fuso ajustado
                document.getElementById('edit_started').value = started ?
                    formatDateTimeLocal(started) :
                    formatDateTimeLocal(new Date());

                // Fim da parada (se vazio, hora atual) com fuso ajustado
                document.getElementById('edit_ended').value = ended ?
                    formatDateTimeLocal(ended) :
                    formatDateTimeLocal(new Date());

                // Abre o modal
                modal.show();
            });
        });
    });
</script>
<script>
    function validarSenha() {

        let senha = document.getElementById('senhaLiberacao').value;
        let mensagem = document.getElementById('msgSenha');
        let modal = document.getElementById('modalEditParada');

        if (senha !== '1234' && senha !== '12345') { // 🔐 depois troque por validação backend
            mensagem.classList.remove('d-none');
            return;
        }

        mensagem.classList.add('d-none');

        // Habilita todos os campos da modal
        modal.querySelectorAll('input, textarea, select').forEach(campo => {
            if (campo.id !== 'senhaLiberacao') {
                campo.removeAttribute('disabled');
                // campo.removeAttribute('readonly');
                // Habilita botão salvar
                  modal.querySelector('button[type="submit"]').removeAttribute('disabled');

            }
        });

        alert('Edição liberada!');
       
    }

</script>