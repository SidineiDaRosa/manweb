@extends('app.layouts.app')

@section('titulo', 'Produtos')

@section('content')

<main class="content">
    <div class="card">
        <style>
            .card {
                background-color: rgb(211, 211, 211);
            }

            #equipamento_id {
                font-size: 20px;
            }
        </style>
        <h5>Check-List</h5>
        <hr>
        @foreach ($equipamentos as $equipamentos_f)
        @endforeach
        <div class="card-body">
            <style>
                #tblOs {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    background-color: rgb(211, 211, 211);
                }

                #tblPecas {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    background-color: rgb(211, 211, 211);
                }

                thead {
                    background-color: rgb(169, 169, 169);
                }

                td,
                th {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 8px;

                }

                tr:nth-child(even) {
                    background-color: #dddddd;
                }

                tr:hover {
                    background-color: rgb(169, 169, 169);
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                }

                th,
                td {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 8px;
                }

                th {
                    background-color: #f2f2f2;
                }

                .bg-green {
                    background-color: #a3e6a3;
                }

                .bg-yellow {
                    background-color: #ffff99;
                }

                .bg-red {
                    background-color: #f08080;
                }
            </style>
            <style>
                #tblOs {
                    flex-wrap: wrap;
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: auto;
                    background-color: rgb(211, 211, 211);
                }

                #tblPecas {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    background-color: rgb(211, 211, 211);
                }

                thead {
                    background-color: rgb(169, 169, 169);
                }

                td,
                th {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 8px;
                }

                tr:nth-child(even) {
                    background-color: #dddddd;
                }

                tr:hover {
                    background-color: rgb(169, 169, 169);

                }
            </style>
            {{------------------------------------------------}}
            {{--Tabela de peças dos equipamento---------------}}
            <table class="table table-striped table-hover" id="tblPecas">
                <thead>
                    <tr>
                        <th>ID RG</th>
                        <th>Descrição</th>
                        <th>ID Produto </th>
                        <th>Produto Nome</th>
                        <th>Quantidade</th>
                        <th>intervalo</th>
                        <th>data ultima substituação</th>
                        <th>data proxima</th>
                        <th>horas proxima</th>
                        <th>horimetro</th>
                        <th>status</th>
                        <th>Tipo de Ativo</th>
                        <th>Criticidade</th>
                        <th>Operaçoes</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($pecas_equipamento as $peca_equipamento)
                    <tr>
                        <td scope="row">{{ $peca_equipamento->id }}</td>
                        <td scope="row">{{ $peca_equipamento->descricao}}</td>
                        <td>{{ $peca_equipamento->produto->id}}
                            <a class="btn btn-sm-template btn-outline-primary" href="{{ route('produto.show', ['produto' =>$peca_equipamento->produto->id]) }}">
                                <i class="icofont-eye-alt"></i>
                            </a>
                        </td>
                        <td>{{ $peca_equipamento->produto->nome}}</td>
                        <td>{{ $peca_equipamento->quantidade}}</td>
                        <td>{{ $peca_equipamento->intervalo_manutencao}}hs</td>
                        <td>{{ date( 'd/m/Y' , strtotime($peca_equipamento['data_substituicao']))}}-{{ $peca_equipamento->hora_substituicao}}</td>
                        <td>{{ date( 'd/m/Y' , strtotime($peca_equipamento['data_proxima_manutencao']))}}</td>
                        <td class="
    @if($peca_equipamento->horas_proxima_manutencao >= 48)
        bg-success
    @elseif($peca_equipamento->horas_proxima_manutencao < 48 && $peca_equipamento->horas_proxima_manutencao > 0)
        bg-warning
    @else
        bg-danger
    @endif
">
                            {{ $peca_equipamento->horas_proxima_manutencao }}
                        </td>
                        <td>{{ $peca_equipamento->horimetro}}</td>
                        <td>{{ $peca_equipamento->status}}</td>
                        <td>{{ $peca_equipamento->tipo_componente}}</td>
                        <td>{{ $peca_equipamento->criticidade}}</td>


        </div>
        </td>
        <!--Div operaçoes do registro da ordem des serviço-->
        <td>
            <div {{-- class="div-op" --}} class="btn-group btn-group-actions visible-on-hover">
                <a class="btn btn-sm-template btn-outline-primary" href="">
                    Concluir Tarefa
                </a>
                <!DOCTYPE html>
                <html>

                <head>
                    <title>Enviar Requisição AJAX</title>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                </head>

                <body>
                    <button id="sendAjaxRequest" class="update_chek_list">Enviar Requisição AJAX</button>
                    <div id="response"></div> <!-- Div para mostrar a resposta -->

                    <script>
                        // $.ajax({
                        // url: '{{ route("checklist.send") }}', // Rota de envio
                        // type: 'POST', // Tipo de requisição (POST, GET, etc.)
                        // data: {
                        // _token: '{{ csrf_token() }}' // Adicione o token CSRF para segurança
                        // },
                        // success: function(response) {
                        // Função que será executada se a requisição for bem-sucedida
                        //  $('#response').html('<p>Sucesso: ' + response.message + '</p>');
                        // },
                        // error: function(xhr, status, error) {
                        // // Função que será executada se a requisição falhar
                        // $('#response').html('<p>Erro: ' + error + '</p>');
                        //}
                        //});
                        $(document).ready(function() {
                            $('#tblPecas').on('click', '.update_chek_list', function() {
                                // Defina os dados específicos que deseja enviar
                                var dados = {
                                    nome: 'Sidinei',
                                    idade: 30
                                    // Adicione outros dados conforme necessário
                                };

                                $.ajax({
                                    url: '{{ route("checklist.send") }}', // Rota de envio
                                    type: 'POST', // Tipo de requisição (POST, GET, etc.)
                                    data: {
                                        _token: '{{ csrf_token() }}', // Adicione o token CSRF para segurança
                                        dados: dados // Envie os dados específicos
                                    },
                                    success: function(response) {
                                        // Função que será executada se a requisição for bem-sucedida
                                        $('#response').html('<p>Sucesso: ' + response.message + '</p>');
                                        console.log(response.data); // Exiba os dados recebidos no console
                                    },
                                    error: function(xhr, status, error) {
                                        // Função que será executada se a requisição falhar
                                        $('#response').html('<p>Erro: ' + error + '</p>');
                                    }
                                });
                            });
                        });
                        ///-----------------------------
                        $(document).ready(function() {
                            $('#myTable').on('click', '.complete-btn', function(e) {
                                e.preventDefault(); // Evita o comportamento padrão do link

                                var taskId = $(this).closest('tr').data('id'); // Obtém o ID da tarefa da linha

                                // Aqui você pode enviar a requisição AJAX para concluir a tarefa com o ID obtido
                                $.ajax({
                                    url: '{{ route("checklist.send") }}', // Rota de envio
                                    method: 'POST',
                                    data: {
                                        taskId: taskId
                                    }, // Ou qualquer outro dado que você precise enviar
                                    success: function(response) {
                                        // Lógica para atualizar a tabela ou realizar outras ações após a conclusão da tarefa
                                    },
                                    error: function(xhr, status, error) {
                                        // Tratamento de erro, se necessário
                                    }
                                });
                            });
                        });
                    </script>
                    <button class="btnAtualizar" data-id="{{$peca_equipamento->id}}">Atualizar</button>
                    <script>
                        // Função para enviar a requisição AJAX
                        function atualizarRegistro(id) {
                            // Aqui você deve substituir 'url_do_seu_endpoint' pela URL do seu endpoint que irá atualizar o registro
                            let url = '{{ route("checklist.send") }}' + id;

                            // Envio da requisição AJAX
                            $.ajax({
                                type: 'PUT',
                                url: url,
                                data: {
                                    _token: '{{ csrf_token() }}', // Se estiver usando o Laravel, adicione o token CSRF
                                    // Outros dados que você quer enviar para atualização, se necessário
                                },
                                success: function(response) {
                                    // Ação a ser executada em caso de sucesso na requisição
                                    console.log('Registro atualizado com sucesso!');
                                },
                                error: function(xhr, status, error) {
                                    // Ação a ser executada em caso de erro na requisição
                                    console.error('Erro ao atualizar registro:', error);
                                }
                            });
                        }

                        // Captura do clique no botão e chamada da função para atualizar o registro
                        $(document).ready(function() {
                            $('.btnAtualizar').click(function() {
                                let id = $(this).data('id');
                                atualizarRegistro(id);
                            });
                        });
                    </script>
                </body>

                </html>
                <a class="btn btn-sm-template btn-outline-primary" href="{{route('Peca-equipamento.index',['peca_equip_id'=>$peca_equipamento->id ,'chek_list'=>1])}}">
                    <i class="icofont-eye-alt"></i>
                </a>
                <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="">
                    <i class="icofont-ui-edit"></i> </a>
                <!--Condoçes para deletar a os-->
                <form id="" method="post" action="">
                    @method('DELETE')
                    @csrf
                </form>
                <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick=" DeletarOs()">
                    <i class="icofont-ui-delete"></i>
                    <script>
                        function DeletarOs() {
                            var x;
                            var r = confirm("Deseja deletar o chek-list?");
                            if (r == true) {

                                // document.getElementById('').submit()
                            } else {
                                x = "Você pressionou Cancelar!";
                            }
                            document.getElementById("demo").innerHTML = x;
                        }
                    </script>
                </a>
                <!------------------------------>
            </div>
            @endforeach
            </tbody>
            </table>
</main>
{{--====================================================================--}}
{{--Função que fecha a ordem de serviço--}}
<div class="d-grid gap-2 d-sm-flex justify-content float-center">
    <button id="enviar" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#confirmModal">
        <img src="{{ asset('img/icon/finished-work.png') }}" alt="" style="height:25px; width:25px;">
        Fechar Ordem de serviço</button>
</div>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JavaScript (bundle includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Modal de Confirmação -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Deseja Concluír Chek-List?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmarEnvio" data-bs-dismiss="modal">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Sucesso -->
<div class="modal fade" id="sucessoModal" tabindex="-1" aria-labelledby="sucessoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sucessoModalLabel">Sucesso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Chek-List Concluído!
            </div>
        </div>
    </div>
</div>
<!-- Modal de Erro -->
<div class="modal fade" id="erroModal" tabindex="-1" aria-labelledby="sucessoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sucessoModalLabel"><i class="icofont-warning"></i>Alerta!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Erro ao fechar Chek-List!
            </div>
        </div>
    </div>
</div>
<input type="text" id="valor" placeholder="Digite um valor" value="{{$peca_equipamento->id }}" name="peca_equip_id" readonly>
<script>
    $(document).ready(function() {
        $('#confirmarEnvio').click(function() {
            var valor = $('#valor').val(); // Obtém o valor do input

            $.ajax({
                type: 'GET', // Método HTTP da requisição
                url: '{{ route("update-chek-list") }}', // URL para onde a requisição será enviada 
                data: {
                    valor: valor
                }, // Dados a serem enviados (no formato chave: valor)
                success: function(response) {
                    if (response.mensagem) {
                        $('#mensagem').text(response.mensagem); // Exibe a mensagem retornada pelo servidor
                    } else {
                        $('#mensagem').text('Resposta do servidor: ' + response); // Exibe a resposta do servidor se a mensagem não estiver presente
                    }
                    $('#sucessoModal').modal('show'); // Exibe a modal de sucesso
                },
                error: function(xhr, status, error) {
                    $('#mensagem').text('Erro ao enviar valor: ' + error); // Exibe mensagem de erro, se houver
                    $('#erroModal').modal('show'); // Exibe a modal de sucesso
                }
            });
        });
    });
</script>
@endsection