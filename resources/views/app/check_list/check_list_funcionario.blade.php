<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/comum.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/template.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="{{ asset('js/date_time.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Check-List</title>
</head>

<body class="d-flex flex-column align-items-center justify-content-center vh-100">

    <!-- Modal para solicitar senha -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Autenticação</h5>
                    <!-- Remover o botão de fechar -->
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body">
                    <form id="passwordForm">
                        <div class="mb-3">
                            <label for="password" class="form-label">Digite sua senha:</label>
                            <input type="password" class="form-control" id="password" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Confirmar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- JS do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <h4 class="text-center">Iniciar Check-List</h4>
    <form action="{{ route('check-list-cheked-index') }}" method="get">
        @csrf
        <div class="mb-3">
            <input type="hidden" name="equipamento_id" value="{{ $equipamento->id }}">
            <select class="form-control" name="funcionario" id="funcionario_id" style="width: 300px;" onchange="toggleEnviarButton()">
                <option value="">Selecione um funcionário</option> <!-- Opção padrão -->
                @foreach ($funcionarios as $funcionario_f)
                <option value="{{ $funcionario_f->primeiro_nome}} {{ $funcionario_f->ultimo_nome }}">
                    {{ $funcionario_f->primeiro_nome }} {{ $funcionario_f->ultimo_nome }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Botão para enviar os dados (inicialmente escondido) -->
        <div class="mb-3" id="divEnviar" style="display: none;">
            <div class="mb-3" id="divIniciarCheckList" style="display: none;">
              <button class="btn btn-dark" style="height:200px;width:300px" type="submit">Iniciar</button>
            </div>
        </div>
    </form>

    <script>
        function toggleEnviarButton() {
            const funcionarioSelect = document.getElementById('funcionario_id');
            const divEnviar = document.getElementById('divEnviar');
            const divIniciarCheckList = document.getElementById('divIniciarCheckList');

            if (funcionarioSelect.value) {
                divEnviar.style.display = 'block';
                divIniciarCheckList.style.display = 'block';
            } else {
                divEnviar.style.display = 'none';
                divIniciarCheckList.style.display = 'none';
            }
        }
    </script>
  
    <script>
        $(document).ready(function() {
            // Exibir o modal ao carregar a página
            $('#passwordModal').modal({
                backdrop: 'static', // Impede que o modal seja fechado ao clicar fora
                keyboard: false // Desativa o fechamento ao pressionar a tecla Esc
            }).modal('show');

            // Validar senha ao enviar o formulário
            $('#passwordForm').on('submit', function(event) {
                event.preventDefault();
                const password = $('#password').val();

                // Verifica se a senha está correta
                if (password === '123456') { // Senha correta
                    $('#passwordModal').modal('hide'); // Fecha o modal
                } else {
                    alert('Senha incorreta! Tente novamente.'); // Alerta para senha incorreta
                    $('#password').val(''); // Limpa o campo de senha
                }
            });
        });
    </script>
</body>

</html>