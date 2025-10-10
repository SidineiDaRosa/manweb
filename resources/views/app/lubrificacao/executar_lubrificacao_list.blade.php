<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Executar Lubrificação</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Container principal */
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Título */
        h3.mb-4 {
            color: #343a40;
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* Select de funcionários */
        select.form-control {
            padding: 8px 12px;
            font-size: 16px;
            border-radius: 6px;
            border: 1px solid #ced4da;
            margin-bottom: 20px;
            width: 100%;
            transition: border-color 0.3s;
        }

        select.form-control:focus {
            border-color: #0d6efd;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .25);
        }

        /* Tabela */
        table.table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.table th,
        table.table td {
            padding: 10px;
            text-align: left;
            vertical-align: middle;
            border: 1px solid #dee2e6;
        }

        table.table th {
            background-color: #0d6efd;
            color: white;
            font-weight: 500;
            text-align: center;
        }

        table.table td {
            font-size: 14px;
        }

        table.table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        /* Status das lubrificações */
        td[style*="background-color"] {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            border-radius: 4px;
        }

        /* Botões */
        button.btn {
            font-size: 14px;
            padding: 5px 12px;
            border-radius: 6px;
            transition: background-color 0.3s;
        }

        button.btn-success {
            background-color: #198754;
            border-color: #198754;
            color: white;
        }

        button.btn-success:hover {
            background-color: #157347;
            border-color: #146c43;
        }

        button.btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }

        button.btn-secondary:hover {
            background-color: #5c636a;
            border-color: #545b62;
        }

        /* Modal */
        .modal-content {
            border-radius: 8px;
            overflow: hidden;
        }

        .modal-header {
            border-bottom: none;
        }

        .modal-body textarea {
            width: 100%;
            min-height: 80px;
            resize: vertical;
            border-radius: 6px;
            border: 1px solid #ced4da;
            padding: 8px;
            font-size: 14px;
        }

        /* Alertas */
        .alert {
            font-size: 14px;
            margin-top: 10px;
            padding: 8px 12px;
            border-radius: 6px;
        }

        /* Ícones dentro dos botões */
        button i {
            margin-right: 5px;
        }

        /* Responsividade */
        @media (max-width: 768px) {

            table.table th,
            table.table td {
                font-size: 12px;
                padding: 6px;
            }

            h3.mb-4 {
                font-size: 18px;
            }

            select.form-control {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

    <div class="container" id="container">
        <h3 class="mb-4">Executar Lubrificação — {{ $equipamento->nome ?? 'Equipamento não encontrado' }}</h3>
        <h4>{{$funcionario->primeiro_nome}}</h4>
        @if(isset($lubrificacoes) && $lubrificacoes->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Equipamento</th>
                        <th>Produto</th>
                        <th>Observações</th>
                        <th>Tag</th>
                        <th>Intervalo (h)</th>
                        <th>Status</th>
                        <th>Atualizado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lubrificacoes as $lubrificacao)
                    @php
                    $status = 'ok';
                    $icone = '✅';
                    $horasPassadas = null;
                    $corFundo = '#d4edda';
                    $ultimaData = $lubrificacao->atualizado_em ?? $lubrificacao->criado_em;
                    if ($ultimaData && $lubrificacao->intervalo) {
                    $agora = now();
                    $horasPassadas = $agora->diffInHours($ultimaData);
                    if ($horasPassadas > $lubrificacao->intervalo) {
                    $status = 'atrasado';
                    $icone = '⚠️';
                    $corFundo = '#f8d7da';
                    } elseif ($horasPassadas >= $lubrificacao->intervalo - 24) {
                    $status = 'proximo';
                    $icone = '⚠️';
                    $corFundo = '#fff3cd';
                    }
                    }
                    @endphp
                    <tr>
                        <td>{{ $lubrificacao->id }}</td>
                        <td>{{ $lubrificacao->equipamento->nome ?? '-' }}</td>
                        <td>{{ $lubrificacao->produto->nome ?? '-' }}</td>
                        <td>{{ $lubrificacao->observacoes ?? '-' }}</td>
                        <td>{{ $lubrificacao->tag ?? '-' }}</td>
                        <td>{{ $lubrificacao->intervalo ?? '-' }}</td>
                        <td class="text-center" style="background-color: {{ $corFundo }};"
                            title="{{ $horasPassadas !== null ? $horasPassadas.'h desde a última lubrificação' : 'Sem intervalo definido' }}">
                            {{ $icone }}
                        </td>
                        <td>{{ $lubrificacao->atualizado_em ? $lubrificacao->atualizado_em->format('d/m/Y H:i') : '-' }}</td>
                        <td>
                            <form class="form-executar-lubrificacao" data-id="{{ $lubrificacao->id }}" style="display:inline-block;">
                                @csrf
                                <button type="button" class="btn btn-sm btn-success btn-executar">
                                    <i class="fas fa-play"></i> Executar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-warning">Nenhuma lubrificação cadastrada para este equipamento.</div>
        @endif
    </div>

    <!-- Modal única de confirmação -->
    <div class="modal fade" id="modalConfirmarExecucao" tabindex="-1" aria-labelledby="modalConfirmarExecucaoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalConfirmarExecucaoLabel">Confirmar Execução</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div>Executante: {{$funcionario->primeiro_nome}} {{$funcionario->ultimo_nome}}</div>
                    <input type="text" id="funcionarioSelect" value="{{$funcionario->primeiro_nome}}" readonly hidden>
                    <p>Deseja realmente executar esta lubrificação?</p>
                    <textarea id="observacoesModal" class="form-control" placeholder="Adicionar observações (opcional)"></textarea>
                    <div id="alertaExecucao" class="mt-2"></div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btnConfirmarExecucao">Executar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function() {
            let idLubrificacao = null;

            // Abrir modal ao clicar em "Executar"
            $('.btn-executar').on('click', function() {
                idLubrificacao = $(this).closest('.form-executar-lubrificacao').data('id');
                $('#observacoesModal').val('');
                $('#alertaExecucao').html('');
                const modal = new bootstrap.Modal(document.getElementById('modalConfirmarExecucao'));
                modal.show();
            });

            // Confirmar execução via AJAX
            $('#btnConfirmarExecucao').on('click', function() {
                if (!idLubrificacao) return;

                // Pegando o executante selecionado na modal de autenticação
                let executanteId = $('#funcionarioSelect').val();

                if (!executanteId) {
                    $('#alertaExecucao').html(`
                <div class="alert alert-warning p-2" role="alert">
                    ⚠️ Por favor, selecione o executante!
                </div>
            `);
                    return;
                }

                $.ajax({
                    url: "{{ route('lubrificacao.executar.acao', '') }}/" + idLubrificacao,
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        observacoes: $('#observacoesModal').val() || "Lubrificação executada ",
                        executante_nome: executanteId // <--- adicionando o executante
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#alertaExecucao').html(`
                    <div class="alert alert-success p-2" role="alert">
                        ✅ ${response.message || 'Lubrificação executada com sucesso!'}
                    </div>
                `);
                        setTimeout(() => {
                            const modal = bootstrap.Modal.getInstance(document.getElementById('modalConfirmarExecucao'));
                            modal.hide();
                            location.reload();
                        }, 1500);
                    },
                    error: function(xhr) {
                        $('#alertaExecucao').html(`
                    <div class="alert alert-danger p-2" role="alert">
                        ⚠️ Ocorreu um erro: ${xhr.responseJSON?.message || 'Erro ao executar.'}
                    </div>
                `);
                    }
                });
            });
        });
    </script>


</body>

</html>