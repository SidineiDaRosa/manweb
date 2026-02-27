 <div id="mensagem"></div>
    <script>
        function StartOs() {

            Swal.fire({
                title: 'Quer iniciar a O.S ?',
                showDenyButton: true,
                confirmButtonText: 'Sim',
                denyButtonText: 'Não',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('O.S sendo iniciada', '', 'success');

                    // Iniciar ordem de serviço
                    var valor = $('#valor').val(); // Obtém o valor do input

                    $.ajax({
                        type: 'GET', // Método HTTP da requisição
                        url: '{{ route('start-os') }}', // URL para onde a requisição será enviada
                        data: {
                            valor: valor
                        }, // Dados a serem enviados (no formato chave: valor)
                        success: function(response) {
                            $('#mensagem').text('Resposta do servidor: ' +
                                response); // Exibe a resposta do servidor
                            // $('#sucessoModal').modal('show'); // Exibe a modal de sucesso
                        },
                        error: function(xhr, status, error) {
                            $('#mensagem').text('Erro ao enviar valor: ' +
                                error); // Exibe mensagem de erro, se houver
                            $('#erroModal').modal('show'); // Exibe a modal de erro
                        }
                    });
                } else if (result.isDenied) {
                    Swal.fire('Inicio de O.S Cancelado!', '', 'info');
                }
            });
        }
    </script>