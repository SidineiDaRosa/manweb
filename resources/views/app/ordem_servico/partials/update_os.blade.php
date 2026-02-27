
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