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
                        <select name="ordem_servico_id" class="form-control" id="edit_ordem" disabled>
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

                    <!-- Subcategoria -->
                    <div class="mb-3">
                        <label class="form-label">Falha</label>
                        <select name="falha_id" class="form-control" required id="edit_falha" disabled>
                            @foreach($flaiures as $flaiure)
                            <option value="{{ $flaiure->id }}">{{ $flaiure->name }} - {{ Str::limit($flaiure->description, 40, '...') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Subcategoria</label>
                        <select name="subcategoria_id" class="form-control" id="edit_subcategoria" disabled>
                            <!-- Opções carregadas via JS -->
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

        const modal = document.getElementById('modalEditParada');
        const form = document.getElementById('formEditParada');

        const subcategories = @json($MachineFailureSubcategories);

        const falhaSelect = document.getElementById('edit_falha');
        const subcategoriaSelect = document.getElementById('edit_subcategoria');
        const equipmentSelect = document.getElementById('edit_equipment');
        const ordemSelect = document.getElementById('edit_ordem');
        const reasonField = document.getElementById('edit_reason');
        const startedField = document.getElementById('edit_started');
        const endedField = document.getElementById('edit_ended');

        // Função para formatar datas para datetime-local
        function formatDateTimeLocal(dateStr) {
            const date = new Date(dateStr);
            const offset = date.getTimezoneOffset() * 60000;
            return new Date(date.getTime() - offset).toISOString().slice(0, 16);
        }

        // Função para carregar subcategorias filtradas
        function carregarSubcategorias(falhaId, subcategoriaSelecionada = null) {
            subcategoriaSelect.innerHTML = '';

            if (!falhaId) {
                subcategoriaSelect.innerHTML = '<option value="">Selecione uma falha primeiro</option>';
                subcategoriaSelect.disabled = true;
                return;
            }

            const filtered = subcategories.filter(sub => sub.machine_failure_id == parseInt(falhaId));

            if (filtered.length > 0) {
                filtered.forEach(sub => {
                    const option = document.createElement('option');
                    option.value = sub.id;
                    option.textContent = sub.name;

                    if (subcategoriaSelecionada && sub.id == parseInt(subcategoriaSelecionada)) {
                        option.selected = true;
                    }

                    subcategoriaSelect.appendChild(option);
                });
                subcategoriaSelect.disabled = false;
            } else {
                subcategoriaSelect.innerHTML = '<option value="">Nenhuma subcategoria encontrada</option>';
                subcategoriaSelect.disabled = true;
            }
        }

        // Abrir modal ao clicar no botão
        document.querySelectorAll('.btn-edit-parada').forEach(button => {
            button.addEventListener('click', function() {

                const id = this.dataset.id;
                const equipment = this.dataset.equipment;
                const ordem = this.dataset.ordem;
                const failure = this.dataset.failure;
                const subcategoria = this.dataset.subcategoria;
                const reason = this.dataset.reason;
                const started = this.dataset.started;
                const ended = this.dataset.ended;

                // Define a action do formulário
                form.action = `/machine-downtime/${id}`;

                // Preenche os campos
                equipmentSelect.value = equipment;
                ordemSelect.value = ordem;
                falhaSelect.value = failure;
                reasonField.value = reason || '';
                startedField.value = started ? formatDateTimeLocal(started) : formatDateTimeLocal(new Date());
                endedField.value = ended ? formatDateTimeLocal(ended) : formatDateTimeLocal(new Date());

                // Carrega subcategorias e seleciona a atual
                carregarSubcategorias(failure, subcategoria);

                // Reseta campos para leitura
                modal.querySelectorAll(' select, textarea').forEach(c => c.setAttribute('disabled', true));
                form.querySelector('button[type="submit"]').setAttribute('disabled', true);

                // Mostra o modal
                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
            });
        });

        // Atualiza subcategoria se o usuário mudar a falha
        falhaSelect.addEventListener('change', function() {
            carregarSubcategorias(this.value);
        });

    });

    // Função para validar senha e liberar edição
    function validarSenha() {
        const senha = document.getElementById('senhaLiberacao').value;
        const mensagem = document.getElementById('msgSenha');
        const modal = document.getElementById('modalEditParada');

        if (senha !== '1234' && senha !== '12345') { // 🔐 trocar para backend depois
            mensagem.classList.remove('d-none');
            return;
        }

        mensagem.classList.add('d-none');

        // Habilita todos os campos da modal
        modal.querySelectorAll('input, textarea, select').forEach(campo => {
            if (campo.id !== 'senhaLiberacao') {
                campo.removeAttribute('disabled');
            }
        });

        // Habilita botão salvar
        modal.querySelector('button[type="submit"]').removeAttribute('disabled');

        alert('Edição liberada!');
    }
</script>