<!-- Modal de Confirmação -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-primary">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="confirmModalLabel">Confirmação</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
                <p>Deseja realmente fechar a Ordem de Serviço?</p>
                <p class="text-muted" style="font-size: 14px;">
                    Se clicar em confirmar, todos os pedidos de saída ligados a esta O.S. também serão fechados!
                </p>
                <div class="mb-3">
                    <label for="pendencia" class="form-label">Pendência (opcional):</label>
                    <textarea id="pendencia" class="form-control" rows="2" placeholder="Descreva algo que ficou pendente..."></textarea>
                </div>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-danger" id="confirmarEnvioPendente" data-bs-dismiss="modal">
                        Emitir Cópia com Pendência e Finalizar
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmarEnvio" data-bs-dismiss="modal">Finalizar
                    O.S.</button>
            </div>
        </div>
    </div>
</div>
<script>
    //Fechar ordem de serviço pelo botão finalizar
    $(document).ready(function() {
        $('#confirmarEnvio').click(function() {
            var valor = $('#valor').val(); // Obtém o valor do input

            $.ajax({
                type: 'GET', // Método HTTP da requisição
                url: '{{ route('updateos') }}', // URL para onde a requisição será enviada
                data: {
                    valor: valor
                }, // Dados a serem enviados (no formato chave: valor)
                success: function(response) {
                    $('#mensagem').text('Resposta do servidor: ' +
                        response); // Exibe a resposta do servidor
                    $('#sucessoModal').modal('show'); // Exibe a modal de sucesso
                },
                error: function(xhr, status, error) {
                    $('#mensagem').text('Erro ao enviar valor: ' +
                        error); // Exibe mensagem de erro, se houver
                    $('#erroModal').modal('show'); // Exibe a modal de sucesso
                }
            });
        });
    });
</script>
