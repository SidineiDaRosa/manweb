@extends('app.layouts.app')
@section('content')

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<main class="content">
    <div class="titulo-main">
        Ordem de Serviço
    </div>
    <style>
        .titulo-main {
            font-size: 20px;
            color: gray;
            text-align: center;
            margin-top: -2;
        }
    </style>
    {{-------------------------------------------------------------------------}}
    {{--início da div que contem os box--}}
    <div class="card">
        <div class="card-header-template">
            <div>
                <a class="btn btn-outline-primary" href="{{ route('ordem-servico.index') }}"><span class="material-symbols-outlined">
                        format_list_bulleted
                    </span>
                </a>
                <a class="btn btn-outline-primary" href="{{route('pedido-saida.create', ['ordem_servico'=>$ordem_servico->id])}}">
                    <i class="icofont-database-add"></i>
                    Criar novo pedido de saída
                </a>
                <a class="btn btn-outline-primary" href="{{route('pedido-saida.index',['ordem_servico'=>$ordem_servico->id,'tipofiltro'=>4])}}">
                    <i class="icofont-search"></i>
                    </i>Busca Pedidos </a>
                <a class="btn btn-outline-success" href="{{route('equipamento.show', ['equipamento' => $ordem_servico->equipamento->id]) }}">
                    <i class="icofont-tractor"></i>
                    ir para o equipamento
                </a>
                <a class="btn btn-outline-primary" href="{{route('ordem-servico.edit', ['ordem_servico'=>$ordem_servico->id])}}">
                    <i class="icofont-ui-edit"></i>Editar</a>
                <a class="btn btn-outline-dark" href="{{ route('app.home') }}">
                    <i class="icofont-dashboard"></i> dashboard
                </a>
            </div>
        </div>
        <div class="card1">
            {{-------------------------------------------------------------------------}}
            {{--Inicio do bloco que contém o continer dos gráficos---------------------}}

            <style>
                hr {
                    margin: -5px;
                }

                .box-conteudo {
                    margin-left: 2px;
                    justify-content: flex-start;
                }

                .titulo {
                    display: flex;
                    font-size: 15px;
                    font-family: 'Poppins', sans-serif;

                }

                .conteudo {
                    display: flex;
                    font-size: 20px;
                    font-weight: 400;
                    font-family: 'Poppins', sans-serif;
                    color: #007b00;
                    margin-bottom: -1px;
                    align-items: flex-end;
                }

                #patrimonio {
                    color: #2174d4;
                }

                .span-texto-sm {
                    font-family: 'Poppins', sans-serif;
                    font-weight: 300;
                    color: mediumblue;
                    font-size: 15px;
                    margin-bottom: 1px;
                }
            </style>
            <div class="container-item">
                {{--Box 1--}}
                <div class="item">
                    <div class="box-conteudo">
                        <div class="titulo"> Empresa</div>
                        <hr>
                        <div class="conteudo">{{$ordem_servico->Empresa->razao_social}}</div>

                        <div class="titulo">Patrimônio/Ativo</div>
                        <hr>
                        <div class="conteudo" id="patrimonio">{{$ordem_servico->equipamento->nome}}</div>

                        <div class="titulo">Emissor</div>
                        <hr>
                        <div class="conteudo">{{$ordem_servico->emissor}}</div>

                        <div class="titulo">Responsável</div>
                        <hr>
                        <div class="conteudo">{{$ordem_servico->responsavel}}</div>
                        <div class="titulo">Situação</div>
                        <hr>
                        <div class="conteudo">{{$ordem_servico->situacao}}</div>
                        <div id=qrCodes>
                            {!! QrCode::size(50)->backgroundColor(255,255,255)->generate( $ordem_servico->id) !!}
                            <?php
                            $protocolo = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == "on") ? "https" : "http");
                            $url = '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                            $urlPaginaAtual = $protocolo . $url
                            //echo $protocolo.$url;
                            ?>
                            &nbsp&nbsp&nbsp&nbsp{!! QrCode::size(50)->backgroundColor(255,255,255)->generate( $urlPaginaAtual ) !!}

                        </div>

                    </div>

                </div>
                {{--Box 2--}}
                <div class="item">
                    <div class="box-conteudo">
                        <div class="titulo">ID:</div>
                        <hr>
                        <div id=idOs class="conteudo" style="color:mediumblue">
                            {{$ordem_servico->id}}
                        </div>

                        @php
                        use Carbon\Carbon;

                        $data_inicio = Carbon::parse($ordem_servico->data_inicio . ' ' . $ordem_servico->hora_inicio);
                        $data_fim = Carbon::parse($ordem_servico->data_fim . ' ' . $ordem_servico->hora_fim);
                        $diff = $data_fim->diff($data_inicio);

                        // Calculando o total de horas

                        $totalHours = $diff->days * 24 + $diff->h;
                        $minutes = $diff->format('%i');
                        @endphp
                        <div class="titulo">O tempo previsto para realizar o serviço é de:</div>
                        <!-- Conteúdo com texto alinhado na parte inferior -->
                        <div class="conteudo" style="display: flex; align-items: flex-end; color: crimson; font-size: 18px;">
                            {{$totalHours}}<span class="span-texto-sm ">hs &nbsp e &nbsp </span>
                            {{$minutes}}<span class="span-texto-sm ">min.</span>

                        </div>
                        <hr>
                        <p>
                        <p>
                        <p>
                        <div class="titulo">Descrição dos serviços a serem executados</div>
                        <div class="titulo">
                            <textarea name="" id="txt-area" class="form-control" rows="6" readonly style="color:crimson">{{$ordem_servico->descricao}}</textarea>

                        </div>
                        <style>
                            #txt-area {
                                height: auto;
                                width: 100%;
                                border: 1px solid rgba(33, 116, 212, 0.3);
                                border-radius: 5px;
                                transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
                                background-color: transparent;
                                /* Transparent background */

                            }

                            #txt-area:focus {
                                border-color: rgba(33, 116, 212, 0.5);
                                /* Use the same rgba color but with a different opacity */
                                box-shadow: 0 0 0 0.1rem rgba(33, 116, 212, 0.25);
                                /* Add a shadow to match Bootstrap */
                                outline: none;
                                /* Remove the default outline */
                            }
                        </style>
                    </div>
                </div>
                {{--Box 3--}}
                <div class="item">
                    <div class="box-conteudo">
                        <div class="titulo">Emissão</div>
                        <hr>
                        <div class="conteudo"> {{ date( 'd/m/Y' , strtotime($ordem_servico['data_emissao']))}}<span class="span-texto-sm "> &nbsp as &nbsp</span> {{$ordem_servico->hora_emissao}}</div>

                        <div class="titulo"> Previsão para início</div>
                        <hr>
                        <div class="conteudo">{{ date( 'd/m/Y' , strtotime($ordem_servico['data_inicio']))}} <span class="span-texto-sm "> &nbsp as &nbsp</span>{{$ordem_servico->hora_inicio}}</div>

                        <div class="titulo">Previsão par fim</div>
                        <hr>
                        <div class="conteudo">{{ date( 'd/m/Y' , strtotime($ordem_servico['data_fim']))}}<span class="span-texto-sm "> &nbsp as &nbsp</span> {{$ordem_servico->hora_fim}}</div>
                        <div class="titulo">Natureza do serviço</div>
                        <hr>
                        <div class="conteudo">{{$ordem_servico->natureza_do_servico}}</div>
                        <div class="titulo">Área de especialidade</div>
                        <hr>
                        <div class="conteudo">{{$ordem_servico->especialidade_do_servico}}</div>

                        <!--Exemplo de progressbar com um input texto-->
                        <div class="titulo">Status do progresso do serviço está em:</div>

                        <input type="text" value="{{ $ordem_servico->status_servicos }}" id="progress-input" hidden>
                        <div class="progress">
                            <div id="progress-bar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">{{ $ordem_servico->status_servicos}}%</div>
                        </div>
                    </div>

                </div>
            </div>
            {{--fim cotiner item item--}}
            <!--Cabeçalho------------------------------------------------------------------------->

            <script>
                //document.addEventListener('DOMContentLoaded', function() {
                var progressBar = document.getElementById('progress-bar');
                var progressInput = document.getElementById('progress-input');

                // Função para atualizar a barra de progresso
                function updateProgressBar(value) {
                    progressBar.style.width = value + '%';
                    progressBar.setAttribute('aria-valuenow', value);
                }

                // Chama a função de atualização da barra de progresso com o valor inicial do input
                updateProgressBar(progressInput.value);

                // Adiciona um ouvinte de eventos para o input
                progressInput.addEventListener('input', function() {
                    var value = progressInput.value;
                    updateProgressBar(value);
                });
                //});
            </script>
            <!--Fim Exemplo de progressbar com um input texto-->

            {{--------------------------------------------------------------------------------------}}
            {{--Atualização do de os----------------------------------------------------------------}}
            Serviços executados
            @foreach($servicos_executado as $servicos_executados)
            <div class="container-item" style="border: 1px solid rgba(0, 0, 0, 0.3); border-radius: 5px;">
                <div class="item">
                    <div class="box-conteudo">
                        <div class="titulo">ID</div>
                        <hr>
                        <div class="conteudo" style="font-size:17px; color:#2174d4;font-family:system-ui, -apple-system, BlinkMacSystemFont,
                         'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
                            {{$servicos_executados->id}}
                        </div>
                        <div class="titulo">Data Inicio</div>
                        <hr>
                        <div class="conteudo" style="font-size:17px; color:dimgrey;font-family:system-ui, -apple-system, BlinkMacSystemFont,
                         'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
                            {{ \Carbon\Carbon::parse($servicos_executados->data_inicio)->format('d/m/Y') }} as {{$servicos_executados->hora_inicio}}

                        </div>
                        <div class=" titulo">Data Fim</div>
                        <hr>
                        <div class="conteudo" style="font-size:17px; color:dimgrey;font-family:system-ui, -apple-system, BlinkMacSystemFont,
                         'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
                            {{ \Carbon\Carbon::parse($servicos_executados->data_fim)->format('d/m/Y') }} as {{$servicos_executados->hora_fim}}

                        </div>
                    </div>
                </div>
                <div class="item" style="height: auto;">
                    <div class="box-conteudo">
                        <div class="titulo">Executante</div>
                        <hr>
                        <div class="conteudo" style="font-size:17px; color:dimgrey;font-family:system-ui, -apple-system, BlinkMacSystemFont,
                         'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
                            {{$servicos_executados->funcionario->primeiro_nome}} {{$servicos_executados->funcionario->ultimo_nome}}
                        </div>
                        <div class=" titulo">Descrição dos serviços</div>
                        <hr>
                        <div class="conteudo" style="font-size:17px; color:dimgrey;font-family:system-ui, -apple-system, BlinkMacSystemFont,
                         'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif"">
                            {{$servicos_executados->descricao}}
                        </div>
                    </div>
                </div>
                <div class=" item">
                            <div class="box-conteudo">
                                <div class="titulo">Subtotal de horas</div>
                                <hr>
                                <div class="conteudo" style="font-size:17px; color:dimgrey;font-family:system-ui, -apple-system, BlinkMacSystemFont,
                         'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
                                    {{$servicos_executados->subtotal}}hs
                                </div>
                                <div class="titulo">tipo de serviço</div>
                                <hr>
                                <div class="conteudo" style="font-size:17px; color:dimgrey;font-family:system-ui, -apple-system, BlinkMacSystemFont,
                         'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
                                    {{$servicos_executados->tipo_de_servico}}
                                </div>
                                <div class="titulo">estado</div>
                                <hr>
                                <div class="conteudo" style="font-size:17px; color:dimgrey;font-family:system-ui, -apple-system, BlinkMacSystemFont,
                         'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
                                    {{$servicos_executados->estado}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card text-sm-info mb-4 float-right" style="width: 18rem; text-align: right;">
                        <div class="card-header ext-sm-info">Total de horas trabalhadas</div>
                        <div class="card-body" style="height:20px;">
                            <h6 class="card-title">{{ number_format($total_hs_os, 2, ',', '.') }}hs</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-header-template">
                <div id="bt_inserir_servico" class="d-grid gap-2 d-sm-flex justify-content-sm float-left">
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <a class="btn btn-outline-primary" href="{{route('Servicos-executado.create',['ordem_servico'=>$ordem_servico->id])}}">
                                <img src="{{ asset('img/icon/add_list.png') }}" alt="" style="height:25px; width:25px;">Adicionar serviço

                            </a>
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2 d-sm-flex justify-content float-right">
                    <button id="enviar" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#confirmModal">
                        <img src="{{ asset('img/icon/finished-work.png') }}" alt="" style="height:25px; width:25px;">
                        Fechar Ordem de serviço</button>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                <div class="d-grid gap-2 d-sm-flex justify-content float-right">
                    <button id="bt_iniciar_os" class="btn btn-outline-secondary" onclick="StartOs()">
                        <img src="{{ asset('img/icon/finished-work.png') }}" alt="" style="height:25px; width:25px;">
                        Iniciar OS
                    </button>
                </div>

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
                                    url: '{{ route("start-os") }}', // URL para onde a requisição será enviada
                                    data: {
                                        valor: valor
                                    }, // Dados a serem enviados (no formato chave: valor)
                                    success: function(response) {
                                        $('#mensagem').text('Resposta do servidor: ' + response); // Exibe a resposta do servidor
                                        // $('#sucessoModal').modal('show'); // Exibe a modal de sucesso
                                    },
                                    error: function(xhr, status, error) {
                                        $('#mensagem').text('Erro ao enviar valor: ' + error); // Exibe mensagem de erro, se houver
                                        $('#erroModal').modal('show'); // Exibe a modal de erro
                                    }
                                });
                            } else if (result.isDenied) {
                                Swal.fire('Inicio de O.S Cancelado!', '', 'info');
                            }
                        });
                    }
                </script>
            </div>
        </div>
        <!-- arquivo resources/views/atualizar-registro.blade.php -->
        <style>
            .container {
                display: flex;
                justify-content: center;
                /* Alinha horizontalmente ao centro */
                align-items: center;
                /* Alinha verticalmente ao centro */
                height: 100vh;
                /* Altura do contêiner */

            }

            #imagem {
                width: 100%;
                height: 85%;
            }
        </style>
        <div class="container">
            <img src="/{{$ordem_servico->link_foto}}" alt="Imagem 1" id="imagem">

        </div>

</main>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{--====================================================================--}}
{{--Função que fecha a ordem de serviço--}}

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
                Deseja realmente fechar a Ordem de serviço?
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
                Ordem de serviço fechado com sucesso!
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
                Ordem de serviço erro ao fechar!
            </div>
        </div>
    </div>
</div>
<input type="text" id="valor" placeholder="Digite um valor" value="{{$ordem_servico->id}}" hidden readonly>
<script>
    $(document).ready(function() {
        $('#confirmarEnvio').click(function() {
            var valor = $('#valor').val(); // Obtém o valor do input

            $.ajax({
                type: 'GET', // Método HTTP da requisição
                url: '{{ route("updateos") }}', // URL para onde a requisição será enviada
                data: {
                    valor: valor
                }, // Dados a serem enviados (no formato chave: valor)
                success: function(response) {
                    $('#mensagem').text('Resposta do servidor: ' + response); // Exibe a resposta do servidor
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
<style>
    body,
    html {
        height: 100%;
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
    }


    .container-item {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        align-items: flex-start;
        background-color: white;
        margin: -1;

    }

    .card-header:first-child {
        background-color: #007b00;
        border: none;

    }

    /*borda total de horas trabalhadas*/
    .mb-3,
    .my-3 {
        border-bottom: none;
    }


    .item {
        width: calc(33% - 20px);
        height: auto;
        margin: 5px;
        padding: 15px;
        background-color: white;
        overflow: auto;
        /* Impede que o conteúdo transborde */
        font-weight: 500;
    }

    .box {
        display: flex;
        width: 100%;
        height: auto;
        margin-bottom: 1px;
        background-color: #ccc;
        border-radius: 5px;
        padding: 5px;


    }

    @media (max-width: 900px) {
        .item {
            width: 100%;
            margin: 0px -80;
        }
    }

    .btn-outline-primary {
        padding: 10px 30px;
        background: #2174d4;
        color: #fff;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.5s;

    }

    .card-header-template {
        background-color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        margin-bottom: 20px;


    }

    .card-header-template h1 {
        font-size: 2rem;
        margin-bottom: 1rem;
        line-height: 3rem;
        color: #2C2A2A;



    }

    .container-chart img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 20px auto;
    }

    .progress {
        height: 20px;
        background-color: #e9ecef;
        border-radius: 5px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        color: #fff;
        text-align: center;
        line-height: 20px;
        background-color: #2174d4;
        transition: width 0.5s ease-in-out;
    }

    div.card-header-template {
        background-color: white;


    }

    .card-header {
        color: white;
        font-family: 'Poppins', sans-serif;
        font-size: 15px;
        font-weight: 500;
        background-color: #2C2A2A;

    }

    rect {
        margin: 2%;

    }

    h5.card-title {
        color: #007b00;
        font-family: 'Poppins', sans-serif;
        font-size: 20px;
        font-weight: 500;


    }

    .card-body {
        background-color: #e9ecef;



    }

    #div-total-horas.card.text-bg-info.mb-3.float-right {
        border: 2px solid gray;
        text-align: center;
        margin-left: 100px;
        margin-top: 1%;
    }

    .table thead th {
        color: #2C2A2A;
        font-family: 'Poppins', sans-serif;
        font-size: 17px;
        font-weight: 500;
    }

    .table-striped>tbody>tr:nth-of-type(odd)>* {
        color: #2174d4;
        font-family: 'Poppins', sans-serif;
        font-size: 13px;
        font-weight: 500;
    }
</style>