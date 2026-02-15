@extends('app.layouts.app')
@include('app.ordem_servico.partials.modal_finish_os')
@section('content')

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <main class="content">
        @include('app.servicos_executado.modal-servico')
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

            /* Cores individuais dos ícones */



            .btn-lista i {
                color: #0d6efd;
                /* Azul */
            }

            .btn-novo i {
                color: #198754;
                /* Verde */
            }

            .btn-pedidos i {
                color: #ac2615;
                /* Cinza */
            }

            .btn-equipamento i {
                color: #148cfd;
                /* Laranja */
            }

            .btn-apr i {
                color: #dc3545;
                /* Vermelho */
            }

            .btn-dashboard i {
                color: #f2d010;
                /* Roxo */
            }

            .btn-editar i {
                color: #176b1e;
                /* Verde água */
            }



            .card-header-template .btn i {
                margin-right: 6px;
                font-size: 16px;
            }
        </style>
        {{-- ------------------------------- --}}
        {{-- início da div que contem os box --}}
        {{-- ------------------------------- --}}
        <div class="card">
            <div class="card-header-template">

                <a class="btn btn-lista" href="{{ route('ordem-servico.index') }}">
                    <i class="bi bi-card-list"></i> Listar O.S.
                </a>

                @if ($ordem_servico->situacao !== 'fechado')
                    <a class="btn btn-novo"
                        href="{{ route('pedido-saida.create', ['ordem_servico' => $ordem_servico->id]) }}">
                        <i class="bi bi-plus-circle"></i> Novo Pedido Saída
                    </a>
                @endif

                <a class="btn btn-pedidos"
                    href="{{ route('pedido-saida.index', ['ordem_servico' => $ordem_servico->id, 'tipofiltro' => 4]) }}">
                    <i class="bi bi-search"></i> Pedidos
                </a>

                <a class="btn btn-equipamento"
                    href="{{ route('equipamento.show', ['equipamento' => $ordem_servico->equipamento->id]) }}">
                    <i class="bi bi-truck"></i> Equipamento
                </a>
                <!--APR-->
                @if (isset($aprs))
                    @foreach ($aprs as $apr)
                    @endforeach
                @endif
                @if ($aprs->isEmpty())
                    <a class="btn btn-apr" href="{{ route('apr.create', $ordem_servico->id) }}">
                        <i class="bi bi-file-earmark-text"></i> Gerar APR
                    </a>
                @else
                    <a class="btn btn-apr" href="{{ route('apr.show', ['apr_id' => $apr->id]) }}">
                        <i class="bi bi-exclamation-triangle"></i> Abrir APR
                    </a>
                @endif

                <a class="btn btn-dashboard" href="{{ route('app.home') }}">
                    <i class="bi bi-house"></i> Dashboard
                </a>

                <a class="btn btn-editar" href="{{ route('ordem-servico.edit', ['ordem_servico' => $ordem_servico->id]) }}">
                    <i class="bi bi-pencil-square"></i> Editar O.S.
                </a>

            </div>


            <!--!Ao abrir verifica algumas status-->
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Verifica se a assinatura está presente
                    var signatureImage = document.getElementById("signature_receptor");
                    let situacao = document.getElementById("situacao");
                    if (signatureImage) {
                        // Oculta o link adicionando um estilo inline que esconde visualmente
                        document.getElementById("btn-add-task").style.display = 'none';
                        document.getElementById("btn-edit").style.display = 'none';
                        document.getElementById("bt_iniciar_os").style.display = 'none';
                        document.getElementById("Btn_novo_ped_compra").style.display = 'none';
                    }
                    if (situacao.value === 'fechado') {
                        document.getElementById("btn-add-task").style.display = 'none';
                        document.getElementById("btn-edit").style.display = 'none';
                        document.getElementById("bt_iniciar_os").style.display = 'none';
                        document.getElementById("Btn_novo_ped_compra").style.display = 'none';
                    }
                });
            </script>
            <div class="card1">
                {{-- --------------------------------------------------------------------- --}}
                {{-- Inicio do bloco que contém o continer dos gráficos------------------- --}}
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
                        font-family: Arial, Helvetica, sans-serif;
                        font-weight: 500;
                        color: #4F4F4F;
                    }

                    .conteudo {
                        display: flex;
                        font-size: 17px;
                        font-weight: 400;
                        font-family: Arial, Helvetica, sans-serif;
                        color: #999999;
                        margin-bottom: -1px;
                        align-items: flex-end;
                    }

                    #patrimonio {
                        color: #2174d4;
                    }

                    .card-header-template {
                        display: flex;
                        gap: 10px;
                        flex-wrap: wrap;
                        padding-left: 40px;
                    }

                    /* Botão padrão estilo da imagem */
                    .card-header-template .btn {
                        display: inline-flex;
                        align-items: center;
                        gap: 6px;
                        padding: 8px 14px;
                        font-size: 14px;
                        font-weight: 500;
                        border-radius: 8px;
                        border: 1px solid #dcdcdc;
                        background-color: #f5f6f8;
                        color: #444;
                        text-decoration: none;
                        transition: all 0.2s ease;
                    }



                    /* Hover */
                    .card-header-template .btn:hover {
                        background-color: #e9ecef;
                        border-color: #cfcfcf;
                    }

                    /* Botão ativo (igual o azul da imagem) */
                    .card-header-template .btn.active {
                        background-color: #e7f1ff;
                        border-color: #0d6efd;
                        color: #0d6efd;
                    }

                    /* Ícone */
                    .card-header-template .icon {
                        font-size: 15px;
                    }

                    .span-texto-sm {
                        font-family: 'Poppins', sans-serif;
                        font-weight: 300;
                        color: rgb(0, 113, 205);
                        font-size: 15px;
                        margin-bottom: 1px;
                    }
                </style>
                <!----------------------------------------------------------->
                <!--Divs dos dados da os-->
                <!----------------------------------------------------------->

                <div class="container-item">
                    {{-- Box 1 --}}
                    <div class="item">
                        <div class="box-conteudo">
                            <div class="titulo">ID:</div>
                            <hr>
                            <div id=idOs class="conteudo" style="color:rgb(53, 77, 156);font-size:20px;font:bold;">
                                {{ $ordem_servico->id }}
                            </div>
                            <div class="titulo">Emissão</div>
                            <hr>
                            <div class="conteudo" style="color: #2174d4;">
                                {{ date('d/m/Y', strtotime($ordem_servico['data_emissao'])) }}<span class="span-texto-sm ">
                                    &nbsp às &nbsp</span> {{ $ordem_servico->hora_emissao }}</div>
                            <div class="titulo"> Empresa</div>
                            <hr>
                            <div class="conteudo">{{ $ordem_servico->Empresa->razao_social }}</div>

                            <div class="titulo">Patrimônio/Ativo</div>
                            <hr>
                            <div class="conteudo" id="patrimonio">{{ $ordem_servico->equipamento->nome }}</div>

                            <div class="titulo">Emissor</div>
                            <hr>
                            <div class="conteudo">{{ $ordem_servico->emissor }}</div>

                            <div class="titulo">Responsável</div>
                            <hr>
                            <div class="conteudo">{{ $ordem_servico->responsavel }}</div>
                            <div class="titulo">Situação</div>
                            <hr>
                            <div class="conteudo">{{ $ordem_servico->situacao }}</div>
                            <!--QR code hidden-->
                            <div id=qrCodes hidden>
                                {!! QrCode::size(50)->backgroundColor(255, 255, 255)->generate($ordem_servico->id) !!}
                                <?php
                                $protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
                                $url = '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                                $urlPaginaAtual = $protocolo . $url;
                                //echo $protocolo.$url;
                                ?>
                                &nbsp&nbsp&nbsp&nbsp{!! QrCode::size(50)->backgroundColor(255, 255, 255)->generate($urlPaginaAtual) !!}
                            </div>
                        </div>
                    </div>
                    {{-- Box 2 --}}
                    <div class="item">
                        <div class="box-conteudo">

                            {{-- //------------------------------------------// --}}
                            {{-- //Datas de inico e fim, progress bar        // --}}
                            {{-- //------------------------------------------// --}}
                            <div style="display: flex;flex-direction:row;">
                                <div style="width:50%;">
                                    <div class="titulo"> Previsão para início</div>
                                    <hr>
                                    <div class="conteudo">{{ date('d/m/Y', strtotime($ordem_servico['data_inicio'])) }}
                                        <span class="span-texto-sm "> &nbsp às
                                            &nbsp</span>{{ $ordem_servico->hora_inicio }}
                                    </div>
                                </div>
                                <div style="width:50%;">
                                    <div class="titulo">Previsão para fim</div>
                                    <hr>
                                    <div class="conteudo" style="color:brown;float:right;display:flex;">
                                        {{ date('d/m/Y', strtotime($ordem_servico['data_fim'])) }}
                                        <span class="span-texto-sm "> &nbsp às &nbsp</span> {{ $ordem_servico->hora_fim }}
                                    </div>
                                </div>
                            </div>

                            @php
                                use Carbon\Carbon;

                                $data_inicio = Carbon::parse(
                                    $ordem_servico->data_inicio . ' ' . $ordem_servico->hora_inicio,
                                );
                                $data_fim = Carbon::parse($ordem_servico->data_fim . ' ' . $ordem_servico->hora_fim);
                                $diff = $data_fim->diff($data_inicio);

                                // Calculando o total de horas

                                $totalHours = $diff->days * 24 + $diff->h;
                                $minutes = $diff->format('%i');
                            @endphp
                            <div class="titulo" style="font-size:15px;font-weight:300;">O tempo previsto para realizar o
                                serviço é de:</div>
                            <!-- Conteúdo com texto alinhado na parte inferior -->
                            <div class="conteudo"
                                style="display: flex; align-items: flex-end; color: crimson; font-size: 18px;">
                                {{ $totalHours }}<span class="span-texto-sm ">hs &nbsp e &nbsp </span>
                                {{ $minutes }}<span class="span-texto-sm ">min.</span>

                            </div>
                            <hr>
                            <!--Progressbar com um input texto-->
                            <div class="titulo" style="font-size:15px;font-weight:300;">Progresso:</div>
                            <div class="progress" style="height: 5px">
                                <div id="progress-bar" class="progress-bar" role="progressbar" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="100">{{ $ordem_servico->status_servicos }}%</div>
                            </div>
                            <div class="titulo">Descrição dos serviços a serem executados</div>
                            <div class="titulo">
                                <textarea id="txt-area" class="form-control" rows="6" readonly
                                    style="color:#333333; 
               font-weight:500; 
               font-family:Arial, Helvetica, sans-serif; 
               border:1px dashed rgb(51, 51, 51,0.5);
               text-align:left;    /* força alinhamento à esquerda */
               padding:5px;        /* padding padrão */
               margin:0;">{{ trim($ordem_servico->descricao) }}</textarea>
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
                            <!---------->
                            <!--Anexo-->

                            <div class="conteudo">

                                <a class="txt-link" id="anexo" target="_blank" href="{{ $ordem_servico->anexo }}">
                                    <i class="bi bi-paperclip"></i>
                                    Anexo: {{ $ordem_servico->anexo }}
                                </a>
                            </div>

                        </div>
                    </div>
                    {{-- Box 3 --}}
                    <div class="item">
                        <div class="box-conteudo">

                            <div class="titulo">Natureza do serviço</div>
                            <hr>
                            <div class="conteudo">{{ $ordem_servico->natureza_do_servico }}</div>
                            <div class="titulo">Área de especialidade</div>
                            <hr>
                            <div class="conteudo">{{ $ordem_servico->especialidade_do_servico }}</div>

                            <input type="text" value="{{ $ordem_servico->status_servicos }}" id="progress-input"
                                hidden>

                            <div class="titulo">Assinatura:</div>
                            <hr>
                            @if ($ordem_servico->signature_receptor)
                                <img id="signature_receptor" src="{{ asset($ordem_servico->signature_receptor) }}"
                                    alt="Assinatura do Receptor">
                            @else
                                <p>Assinatura não disponível</p>
                            @endif

                            <form action="{{ route('solicitacoes-os') }}" method="get"
                                style="font-family: Arial,sans-serif;">
                                <input type="text" value="{{ $ordem_servico->ss_id }}" name="id" hidden>
                                <button type="submit" class="btn btn-outline-primary mb-1">
                                    SS: {{ $ordem_servico->ss_id }}
                                </button>

                            </form>
                            <style>
                                #prioridade {
                                    width: 150px;
                                    height: 30px;
                                    text-align: center;
                                    border-radius: 10px;
                                    font-size: 15px;
                                    color: #656769ff;
                                }

                                .box-conteudo {
                                    margin-left: 2px;
                                    display: flex;
                                    flex-direction: column;
                                    justify-content: flex-start;
                                    gap: 5px;
                                }

                                .titulo {
                                    font-size: 15px;
                                    font-family: Arial, Helvetica, sans-serif;
                                    font-weight: 500;
                                    color: #4F4F4F;
                                }

                                .conteudo {
                                    font-size: 17px;
                                    font-weight: 400;
                                    font-family: Arial, Helvetica, sans-serif;
                                    color: #999999;
                                    display: flex;
                                    align-items: flex-end;
                                    margin-bottom: 2px;
                                }

                                #patrimonio {
                                    color: #2174d4;
                                    font-weight: 600;
                                }

                                .span-texto-sm {
                                    font-family: 'Poppins', sans-serif;
                                    font-weight: 300;
                                    color: mediumblue;
                                    font-size: 15px;
                                    margin-bottom: 1px;
                                }

                                #txt-area {
                                    width: 100%;
                                    min-height: 120px;
                                    /* ajuste automático */
                                    resize: vertical;
                                    border: 1px solid rgba(33, 116, 212, 0.3);
                                    border-radius: 5px;
                                    background-color: transparent;
                                    font-family: Arial, Helvetica, sans-serif;
                                    font-weight: 500;
                                    font-size: 15px;
                                    padding: 5px;
                                    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
                                }

                                #txt-area:focus {
                                    border-color: rgba(33, 116, 212, 0.5);
                                    box-shadow: 0 0 0 0.1rem rgba(33, 116, 212, 0.25);
                                    outline: none;
                                }

                                #progress-input {
                                    display: none;
                                    /* melhor que hidden type */
                                }

                                #prioridade {
                                    width: 150px;
                                    height: 30px;
                                    text-align: center;
                                    border-radius: 10px;
                                    font-size: 15px;
                                    color: #656769;
                                    /* removi "ff" extra */
                                    background-color: #f1f1f1;
                                    border: 1px solid #ccc;
                                }
                            </style>

                            @php
                                $gravidade = $ordem_servico->gravidade ?? 0;
                                $urgencia = $ordem_servico->urgencia ?? 0;
                                $tendencia = $ordem_servico->tendencia ?? 0;

                                $prioridade = 'nenhuma';
                                $classe = '';
                                $texto = 'Selecione a prioridade';

                                if ($gravidade >= 5 && $urgencia >= 5 && $tendencia >= 5) {
                                    $prioridade = 'alta';
                                    $classe = 'background-color: orange;';
                                    $texto = 'Prioridade Alta';
                                } elseif ($gravidade >= 4 && $urgencia >= 4 && $tendencia >= 4) {
                                    $prioridade = 'media';
                                    $classe = 'background-color: gold';
                                    $texto = 'Prioridade Média';
                                } elseif ($gravidade >= 3 && $urgencia >= 3 && $tendencia >= 3) {
                                    $prioridade = 'baixa';
                                    $classe = 'background-color: deepskyblue;';
                                    $texto = 'Prioridade Baixa';
                                }
                            @endphp

                            <div id="prioridade" style="{{ $classe }}">
                                {{ $texto }}
                            </div>

                        </div>
                        <br>
                        <div class="titulo">Projeto</div>
                        <div class="conteudo">
                            @if (isset($projeto))
                                ID: {{ $projeto->id }} -Nome: {{ $projeto->nome }};
                                <a href="{{ route('projetos.show', $projeto->id) }}"
                                    class="btn btn-outline-primary mb-1">Ver Projeto</a>
                            @else
                                Não anexado a um projeto
                            @endif
                        </div>
                    </div>
                </div>
                {{-- fim container item --}}
                <script>
                    //--------------------------------------------------//
                    //          Progress BAR                            //
                    //--------------------------------------------------//
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

                {{-- ------------------------------------------------------ --}}
                {{-- ------------------//Serviços executados//------------- --}}
                <hr style="margin-top:1px;">
                <span>Serviços executados</span>
                @foreach ($servicos_executado as $servicos_executados)
                    <div class="container-item" style="border: 1px solid rgba(20, 19, 19, 0.3); border-radius: 5px;">
                        <div class="item">
                            <div class="box-conteudo">
                                <div class="titulo">ID</div>
                                <hr>
                                <div class="conteudo"
                                    style="font-size:17px; color:#2174d4;font-family:system-ui, -apple-system, BlinkMacSystemFont,
                         'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
                                    {{ $servicos_executados->id }}
                                </div>
                                <div class="titulo">Data Inicio</div>
                                <hr>
                                <div class="conteudo"
                                    style="font-size:17px; color:dimgrey;font-family:system-ui, -apple-system, BlinkMacSystemFont,
                         'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
                                    {{ \Carbon\Carbon::parse($servicos_executados->data_inicio)->format('d/m/Y') }} as
                                    {{ $servicos_executados->hora_inicio }}

                                </div>
                                <div class=" titulo">Data Fim</div>
                                <hr>
                                <div class="conteudo"
                                    style="font-size:17px; color:dimgrey;font-family:system-ui, -apple-system, BlinkMacSystemFont,
                         'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
                                    {{ \Carbon\Carbon::parse($servicos_executados->data_fim)->format('d/m/Y') }} as
                                    {{ $servicos_executados->hora_fim }}

                                </div>
                            </div>
                        </div>
                        <div class="item" style="height: auto;">
                            <div class="box-conteudo">
                                <div class="titulo">Executante</div>
                                <hr>
                                <div class="conteudo"
                                    style="font-size:17px; color:dimgrey;font-family:system-ui, -apple-system, BlinkMacSystemFont,
                         'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
                                    {{ $servicos_executados->funcionario->primeiro_nome }}
                                    {{ $servicos_executados->funcionario->ultimo_nome }}
                                </div>
                                <div class=" titulo">Descrição dos serviços</div>
                                <hr>
                                <div class="conteudo"
                                    style="font-size:17px; color:dimgrey;font-family:system-ui, -apple-system, BlinkMacSystemFont,
                         'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
                                    {{ $servicos_executados->descricao }}
                                </div>
                            </div>
                        </div>
                        <div class=" item">
                            <div class="box-conteudo">
                                <div class="titulo">Subtotal de horas</div>
                                <hr>
                                <div class="conteudo"
                                    style="font-size:17px; color:dimgrey;font-family:system-ui, -apple-system, BlinkMacSystemFont,
                         'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
                                    {{ $servicos_executados->subtotal }}hs
                                </div>
                                <div class="titulo">tipo de serviço</div>
                                <hr>
                                <div class="conteudo"
                                    style="font-size:17px; color:dimgrey;font-family:system-ui, -apple-system, BlinkMacSystemFont,
                         'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
                                    {{ $servicos_executados->tipo_de_servico }}
                                </div>
                                <div class="titulo">Estado de avaliação</div>
                                <hr>
                                <div class="conteudo"
                                    style="font-size:17px; color:dimgrey;font-family:system-ui, -apple-system, BlinkMacSystemFont,
                         'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
                                    {{ $servicos_executados->estado }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div style="display:flex;float:right;margin-right:20px;"> <span style="font-weight:700;">Total de horas
                        trabalhadas: {{ number_format($total_hs_os, 2, ',', '.') }}hs</span></div>

                <!--fim seriços executados-->
            </div>

        </div>
        <!--Botoes inferior-->
        <div class="card-header-template  text-center">
            <div>
                {{-- //--------------------------------------// --}}
                {{-- //--Critério se a os já fechada----------// --}}
                {{-- //--------------------------------------// --}}
                <!--btns-->
                @if ($ordem_servico->situacao !== 'fechado')
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalServico" hidden>
                        + Lançar Serviço
                    </button>

                    <a id="btn-add-task" class="btn btn-outline-primary mb-1"
                        href="{{ route('Servicos-executado.create', ['ordem_servico' => $ordem_servico->id]) }}"
                        style="width: 300px;">
                        <img src="{{ asset('img/icon/add_list.png') }}" alt=""
                            style="height: 25px; width: 25px;"> 🛠️ Adicionar serviço
                    </a>
                    <button id="enviar" class="btn btn-outline-secondary mb-1" data-bs-toggle="modal"
                        data-bs-target="#confirmModal" style="width:300px;">
                        <img src="{{ asset('img/icon/finished-work.png') }}" alt=""
                            style="height:25px; width:25px;">
                        Fechar Ordem de serviço
                    </button>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                    <!-- Bootstrap Icons -->
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
                        rel="stylesheet">

                    <button id="bt_iniciar_os" class="btn btn-outline-success mb-1" onclick="StartOs()"
                        style="width:300px;">
                        <i class="bi bi-caret-right-fill"></i>
                        Iniciar OS
                    </button>
                @endif
                <button type="button" id="gerarPdfButton" class="btn btn-outline-primary mb-1"
                    style="width:300px;">Gerar PDF
                    <i class="bi bi-filetype-pdf"></i>
                </button>
                <script>
                    document.getElementById('gerarPdfButton').addEventListener('click', function() {
                        document.getElementById('frm-pdf').submit();
                    });
                </script>
            </div>
        </div>
        <!--Botoes inferior fim-->
        <!--Imprimir os PDF-->
        <form id="frm-pdf" action="{{ route('gerar.pdf') }}" method="POST" target="_blank">
            @csrf
            <input type="number" class="form-control" id="ordem_servico_id" name="ordem_servico_id" required
                value="{{ $ordem_servico->id }}" hidden>
        </form>
        <!--Pedidos de sáidas-->
        @isset($ped_saidas)
            @if ($ped_saidas->isNotEmpty())
                @isset($produtos)
                    @if ($produtos->isNotEmpty())
                        @foreach ($ped_saidas as $ped_saida)
                            <div>
                                <div style="background-color: #2174d4;">
                                    <h5>Pedido: {{ $ped_saida->id }}</h5>
                                </div>


                                <h6>Produtos usados:</h6>

                                @php
                                    $produtosDoPedido = $produtos->where('pedidos_saida_id', $ped_saida->id);
                                @endphp

                                @if ($produtosDoPedido->isNotEmpty())
                                    @if ($produtosDoPedido->isNotEmpty())
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Produto</th>
                                                    <th>Unidade</th>
                                                    <th>Quantidade</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($produtosDoPedido as $produto)
                                                    <tr>
                                                        <td>
                                                            <a class="txt-link"
                                                                href="{{ route('produto.show', ['produto' => $produto->produto->id]) }}"
                                                                target="_blank">
                                                                {{ $produto->id }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            {{ $produto->produto->nome }}
                                                        </td>
                                                        <td>{{ $produto->unidade_medida }}</td>
                                                        <td>{{ $produto->quantidade }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <p>Nenhum produto encontrado para este pedido.</p>
                                    @endif
                                @else
                                    <p>Nenhum produto para este pedido.</p>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div style="background-color: #78c799ff;">
                            <h5>
                                <p>Nenhum produto usado.</p>
                            </h5>
                        </div>
                    @endif
                @endisset
            @else
                <div style="background-color: #78c799ff;">
                    <h5>
                        <p>Nenhum pedido encontrado.</p>
                    </h5>
                </div>
            @endif
        @endisset
        <!--Fim Pedidos de saídas-->

        <hr>
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
        </div>
        <!-- arquivo resources/views/atualizar-registro.blade.php -->
        {{ $ordem_servico->link_foto }}
        @php
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = pathinfo($ordem_servico->link_foto, PATHINFO_EXTENSION);
        @endphp

        @if (
            !empty($ordem_servico->link_foto) &&
                in_array($extension, $allowedExtensions) &&
                file_exists(public_path($ordem_servico->link_foto)))
            <div class="container" style="margin-top:20px;">
                <img src="/{{ $ordem_servico->link_foto }}" alt="Imagem da Ordem de Serviço" id="imagem">
            </div>
            <style>
                .container {
                    text-align: center;
                    /* Centraliza a imagem na div */
                }

                #imagem {
                    max-width: 100%;
                    /* Ajusta a largura máxima para 60% da largura da div pai */
                    max-height: 100vh;
                    /* Ajusta a altura máxima para 60% da altura da viewport */
                    height: auto;
                    /* Ajusta a altura para manter a proporção da imagem */
                    width: auto;
                    /* Ajusta a largura para manter a proporção da imagem */
                    display: inline-block;
                    /* Opcional: evita que a imagem se expanda para toda a largura disponível */
                }
            </style>
        @else
            <p>Imagem não disponível</p>
        @endif

    @endsection
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- ==================================================================== --}}
    {{-- Função que fecha a ordem de serviço --}}

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JavaScript (bundle includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Modal de Sucesso -->
    <div class="modal fade" id="sucessoModal" tabindex="-1" aria-labelledby="sucessoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-success">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="sucessoModalLabel">Sucesso</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    Ordem de Serviço fechada com sucesso!
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Erro -->
    <div class="modal fade" id="erroModal" tabindex="-1" aria-labelledby="erroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="erroModalLabel"><i class="icofont-warning"></i> Alerta!</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    Erro ao fechar a Ordem de Serviço!
                </div>
            </div>
        </div>
    </div>

    <!-- Input oculto -->
    <input type="hidden" id="valor" value="{{ $ordem_servico->id }}">

</main>


<style>
    <style>

    /* ===================== BASE ===================== */
    body,
    html {
        font-family: 'Poppins', sans-serif;
        color: #333;
        background-color: #f5f6fa;
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica, sans-serif;
    }

    a.txt-link {
        text-decoration: none;
        color: #2174d4;
    }

    a.txt-link:hover {
        text-decoration: underline;
    }

    /* ===================== TITULOS ===================== */
    .titulo-main {
        font-size: 22px;
        font-weight: 600;
        color: #555;
        text-align: center;
        margin: 20px 0;
    }

    .titulo {
        font-size: 15px;
        font-weight: 500;
        color: #4F4F4F;
        margin-bottom: 5px;
    }

    .conteudo {
        font-size: 15px;
        font-weight: 400;
        color: #666;
        margin-bottom: 10px;
        display: flex;
        align-items: flex-end;
    }

    .span-texto-sm {
        font-size: 13px;
        color: #555;
    }

    /* ===================== BOXES ===================== */
    .card,
    .card1 {
        background-color: #fff;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .container-item {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        font-family: Arial, Helvetica, sans-serif
    }

    .item {
        flex: 1;
        min-width: 250px;
        background-color: #fafafa;
        padding: 15px;
        border-radius: 6px;
        border: 1px solid rgba(33, 116, 212, 0.2);
    }

    /* ===================== PROGRESS BAR ===================== */
    .progress {
        height: 25px;
        background-color: rgba(194, 212, 33, 0.1);
        border-radius: 6px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .progress-bar {
        background-color: #d49b21;
        font-weight: 600;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: width 0.5s ease-in-out;
        color: #fff;
    }

    /* ===================== TEXTAREA ===================== */
    #txt-area {
        width: 100%;
        border: 1px dashed rgba(33, 116, 212, 0.3);
        border-radius: 5px;
        padding: 10px;
        font-size: 14px;
        resize: none;
        background-color: transparent;
        color: #333;
    }

    #txt-area:focus {
        border-color: rgba(33, 116, 212, 0.5);
        box-shadow: 0 0 0 0.1rem rgba(33, 116, 212, 0.25);
        outline: none;
    }

    /* ===================== PRIORIDADE ===================== */
    #prioridade {
        display: inline-block;
        width: 150px;
        height: 30px;
        text-align: center;
        border-radius: 10px;
        font-size: 15px;
        line-height: 30px;
        color: #fff;
        font-weight: 500;
    }

    /* ===================== IMAGENS ===================== */
    .container img {
        max-width: 100%;
        height: auto;
        border-radius: 6px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }

    /* ===================== MODAIS ===================== */
    .modal-body {
        font-size: 14px;
    }

    .btn {
        font-weight: 500;
        border-radius: 6px;
    }

    /* ===================== CORES ===================== */
    .text-blue {
        color: #2174d4;
    }

    .text-red {
        color: crimson;
    }

    .text-brown {
        color: brown;
    }

    /* ===================== OUTROS ===================== */
    hr {
        border: none;
        border-bottom: 1px solid rgba(33, 116, 212, 0.2);
        margin: 5px 0;
    }

    #patrimonio {
        color: #2174d4;
        font-weight: 600;
    }

    .conteudo strong {
        font-weight: 600;
    }
</style>
