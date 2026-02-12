<!-- MODAL CONFIRMAR IDENTIFICAÇÃO DO RISCO -->
<div class="modal fade" id="modalConfirmarRisco" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('risco.store') }}" id="formConfirmarRisco">
            @csrf

            <!-- Campos ocultos -->
            <input type="hidden" name="apr_id" value="{{ $apr->id }}">
            <input type="hidden" name="risco_id" id="modal_risco_id">

            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirmar Identificação de Risco</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p class="mb-2">
                        Confirma a identificação do risco:
                        <input type="text" id="modalRiscoNome" name="status" class="form-control text-danger fw-bold" readonly>

                    </p>

                    <ul class="list-group mt-3">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Probabilidade</span>
                            <input type="text" id="modal_probabilidade" name="probabilidade" class="form-control w-50" readonly>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Severidade</span>
                            <input type="text" id="modal_severidade" name="severidade" class="form-control w-50" readonly>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Grau de Risco</span>
                            <input type="text" id="modal_grau" name="grau" class="form-control w-25 text-center fw-bold" readonly>
                        </li>
                    </ul>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-danger">
                        Confirmar
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
<script>
    // Salva ou atualiza o grau de risco e a verificação
    document.getElementById('formConfirmarRisco').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const dados = {
            apr_id: form.querySelector('[name="apr_id"]').value,
            risco_id: form.querySelector('[name="risco_id"]').value,
            probabilidade: form.querySelector('[name="probabilidade"]').value,
            severidade: form.querySelector('[name="severidade"]').value,
            grau: form.querySelector('[name="grau"]').value
        };

        fetch("{{ route('risco.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json"
                },
                body: JSON.stringify(dados)
            })
            .then(resp => resp.json())
            .then(data => {
                if (data.success) {
                    const modalConfirmar = bootstrap.Modal.getInstance(document.getElementById('modalConfirmarRisco'));
                    modalConfirmar.hide();

                    modalConfirmar._element.addEventListener('hidden.bs.modal', function onHidden() {
                        modalConfirmar._element.removeEventListener('hidden.bs.modal', onHidden);

                        document.querySelectorAll('.modal-backdrop').forEach(b => b.remove());
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';

                        // Modal de sucesso
                        const modalSucesso = new bootstrap.Modal(document.getElementById('modalSucessoRisco'));
                        modalSucesso.show();

                        // Atualiza checkbox
                        const chk = document.getElementById('chk_risco_' + data.risco_id);
                        if (chk) chk.checked = data.status == 1;


                        // 🔥 Atualiza o input hidden com o ID do APR retornado pelo backend
                        const inputAprRiscoId = document.getElementById('apr_risco_id_' + data.risco_id);
                        if (inputAprRiscoId) inputAprRiscoId.value = data.apr_risco_id;
                        // Atualiza grau
                        const grauDiv = document.getElementById('grau_risco_' + data.risco_id);
                        if (grauDiv) {
                            grauDiv.innerText = data.grau;
                            let classe = 'bg-secondary text-white';
                            if (data.grau == 2) classe = 'bg-success text-white';
                            else if (data.grau == 4) classe = 'bg-warning text-dark';
                            else if (data.grau == 5) classe = 'bg-danger text-white';
                            grauDiv.className = 'text-center ' + classe;
                        }


                    });


                } else {
                    alert("Erro ao salvar risco");
                }
            })
            .catch(err => {
                console.error(err);
                alert("Erro na comunicação com o servidor.");
            });
    });
</script>