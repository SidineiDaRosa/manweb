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
    {{-----------------------------------}}
    {{--início da div que contem os box--}}
    {{-----------------------------------}}
    <div class="card">
        <div class="card-header-template">
            <div>
                <a class="btn btn-outline-primary mb-1" href="{{ route('ordem-servico.index') }}"><span class="material-symbols-outlined">
                        format_list_bulleted
                    </span>
                </a>
                @if($ordem_servico->situacao !== 'fechado')
                <a id="Btn_novo_ped_compra" class="btn btn-outline-primary mb-1" href="{{route('pedido-saida.create', ['ordem_servico'=>$ordem_servico->id])}}">
                    <i class="icofont-plus-circle"></i>
                    Pedido saída
                </a>
                @endif
                <a class="btn btn-outline-primary mb-1" href="{{route('pedido-saida.index',['ordem_servico'=>$ordem_servico->id,'tipofiltro'=>4])}}">
                    <i class="icofont-search"></i>
                    </i>Pedidos </a>
                <a class="btn btn-outline-success mb-1" href="{{route('equipamento.show', ['equipamento' => $ordem_servico->equipamento->id]) }}">
                    <i class="icofont-tractor"></i>
                    Equipamento
                </a>
                <a id="btn-edit" class="btn btn-outline-primary mb-1" href="{{route('ordem-servico.edit', ['ordem_servico'=>$ordem_servico->id])}}">
                    <i class="icofont-ui-edit"></i>Editar</a>
                @if($aprs->isEmpty())
                <a class="btn btn-warning mb-1" href="{{ route('apr.create', $ordem_servico->id) }}">
                    Gerar APR
                </a>
                @endif
                <a class="btn btn-outline-dark mb-1" href="{{ route('app.home') }}">
                    <i class="icofont-dashboard"></i> Dashboard
                </a>
            </div>
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

                .span-texto-sm {
                    font-family: 'Poppins', sans-serif;
                    font-weight: 300;
                    color: mediumblue;
                    font-size: 15px;
                    margin-bottom: 1px;
                }
            </style>
            <!----------------------------------------------------------->
            <!--Divs dos dados da os-->
            <!----------------------------------------------------------->

            <div class="container-item">
                {{--Box 1--}}
                <div class="item">
                    <div class="box-conteudo">
                        <div class="titulo">ID:</div>
                        <hr>
                        <div id=idOs class="conteudo" style="color:mediumblue;font-size:20px;font:bold;">
                            {{$ordem_servico->id}}
                        </div>
                        <div class="titulo">Emissão</div>
                        <hr>
                        <div class="conteudo" style="color: #2174d4;"> {{ date( 'd/m/Y' , strtotime($ordem_servico['data_emissao']))}}<span class="span-texto-sm "> &nbsp às &nbsp</span> {{$ordem_servico->hora_emissao}}</div>
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
                        <!--QR code hidden-->
                        <div id=qrCodes hidden>
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

                        {{--//------------------------------------------//--}}
                        {{--//Datas de inico e fim, progress bar        //--}}
                        {{--//------------------------------------------//--}}
                        <div style="display: flex;flex-direction:row;">
                            <div style="width:50%;">
                                <div class="titulo"> Previsão para início</div>
                                <hr>
                                <div class="conteudo">{{ date( 'd/m/Y' , strtotime($ordem_servico['data_inicio']))}}
                                    <span class="span-texto-sm "> &nbsp às &nbsp</span>{{$ordem_servico->hora_inicio}}
                                </div>
                            </div>
                            <div style="width:50%;">
                                <div class="titulo">Previsão para fim</div>
                                <hr>
                                <div class="conteudo" style="color:brown;float:right;display:flex;">{{ date( 'd/m/Y' , strtotime($ordem_servico['data_fim']))}}
                                    <span class="span-texto-sm "> &nbsp às &nbsp</span> {{$ordem_servico->hora_fim}}
                                </div>
                            </div>
                        </div>
                        <!--Progressbar com um input texto-->
                        <div class="titulo" style="font-size:15px;font-weight:300;">Progresso:</div>
                        <div class="progress">
                            <div id="progress-bar" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">{{ $ordem_servico->status_servicos}}%</div>
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
                        <div class="titulo" style="font-size:15px;font-weight:300;">O tempo previsto para realizar o serviço é de:</div>
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
                            <textarea id="txt-area"
                                class="form-control"
                                rows="6"
                                readonly
                                style="color:#333333; 
               font-weight:500; 
               font-family:Arial, Helvetica, sans-serif; 
               border:1px dashed #333;
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

                            <a class="txt-link" id="anexo" target="_blank" href="{{$ordem_servico->anexo}}">
                                <i class="bi bi-paperclip"></i>
                                Anexo: {{$ordem_servico->anexo}}
                            </a>
                        </div>

                    </div>
                </div>
                {{--Box 3--}}
                <div class="item">
                    <div class="box-conteudo">

                        <div class="titulo">Natureza do serviço</div>
                        <hr>
                        <div class="conteudo">{{$ordem_servico->natureza_do_servico}}</div>
                        <div class="titulo">Área de especialidade</div>
                        <hr>
                        <div class="conteudo">{{$ordem_servico->especialidade_do_servico}}</div>

                        <input type="text" value="{{ $ordem_servico->status_servicos }}" id="progress-input" hidden>

                        <div class="titulo">Assinatura:</div>
                        <hr>
                        @if ($ordem_servico->signature_receptor)
                        <img id="signature_receptor" src="{{ asset($ordem_servico->signature_receptor) }}" alt="Assinatura do Receptor">
                        @else
                        <p>Assinatura não disponível</p>
                        @endif

                        <form action="{{ route('solicitacoes-os') }}" method="get" style="font-family: Arial,sans-serif;">
                            <input type="text" value="{{$ordem_servico->ss_id}}" name="id" hidden>
                            <button type="submit" class="btn btn-outline-primary mb-1">
                                SS: {{$ordem_servico->ss_id}}
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

                        <div id="prioridade"
                            style="{{ $classe }}">
                            {{ $texto }}
                        </div>

                    </div>
                    <br>
                    <div class="titulo">Projeto</div>
                    <div class="conteudo">
                        @if((isset($projeto)))
                        ID: {{$projeto->id}} -Nome: {{$projeto->nome}};
                        <a href="{{ route('projetos.show', $projeto->id) }}" class="btn btn-outline-primary mb-1">Ver Projeto</a>
                        @else
                        Não anexado a um projeto
                        @endif
                    </div>
                </div>
            </div>
            {{--fim container item--}}
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

            {{----------------------------------------------------------}}
            {{--------------------//Serviços executados//---------------}}
            <hr style="margin-top:1px;">
            <span>Serviços executados</span>
            @foreach($servicos_executado as $servicos_executados)
            <div class="container-item" style="border: 1px solid rgba(20, 19, 19, 0.3); border-radius: 5px;">
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
                         'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
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
                        <div class="titulo">Estado de avaliação</div>
                        <hr>
                        <div class="conteudo" style="font-size:17px; color:dimgrey;font-family:system-ui, -apple-system, BlinkMacSystemFont,
                         'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
                            {{$servicos_executados->estado}}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <div style="display:flex;float:right;margin-right:20px;"> <span style="font-weight:700;">Total de horas trabalhadas: {{ number_format($total_hs_os, 2, ',', '.') }}hs</span></div>

            <!--fim seriços executados-->
        </div>

    </div>
    <!--Botoes inferior-->
    <div class="card-header-template  text-center">
        <div>
            {{--//--------------------------------------//--}}
            {{--//--Critério se a os já fechada----------//--}}
            {{--//--------------------------------------//--}}
            @if($ordem_servico->situacao !== 'fechado')
            <a id="btn-add-task" class="btn btn-outline-primary mb-1" href="{{ route('Servicos-executado.create', ['ordem_servico' => $ordem_servico->id]) }}" style="width: 300px;">
                <img src="{{ asset('img/icon/add_list.png') }}" alt="" style="height: 25px; width: 25px;"> 🛠️ Adicionar serviço
            </a>
            <button id="enviar" class="btn btn-outline-secondary mb-1" data-bs-toggle="modal" data-bs-target="#confirmModal" style="width:300px;">
                <img src="{{ asset('img/icon/finished-work.png') }}" alt="" style="height:25px; width:25px;">
                Fechar Ordem de serviço
            </button>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
            <!-- Bootstrap Icons -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

            <button id="bt_iniciar_os" class="btn btn-outline-success mb-1" onclick="StartOs()" style="width:300px;">
                <i class="bi bi-caret-right-fill"></i>
                Iniciar OS
            </button>
            @endif
            <button type="button" id="gerarPdfButton" class="btn btn-outline-primary mb-1" style="width:300px;">Gerar PDF
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
        <input type="number" class="form-control" id="ordem_servico_id" name="ordem_servico_id" required value="{{$ordem_servico->id}}" hidden>
    </form>
    <!--Pedidos de sáidas-->
    @isset($ped_saidas)
    @if($ped_saidas->isNotEmpty())

    @isset($produtos)
    @if($produtos->isNotEmpty())

    @foreach($ped_saidas as $ped_saida)
    <div>
        <div style="background-color: #2174d4;">
            <h5>Pedido: {{ $ped_saida->id }}</h5>
        </div>


        <h6>Produtos usados:</h6>

        @php
        $produtosDoPedido = $produtos->where('pedidos_saida_id', $ped_saida->id);
        @endphp

        @if($produtosDoPedido->isNotEmpty())
        @if($produtosDoPedido->isNotEmpty())
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
                @foreach($produtosDoPedido as $produto)
                <tr>
                    <td>
                        <a class="txt-link"
                            href="{{ route('produto.show', ['produto' => $produto->produto->id]) }}"
                            target="_blank">
                            {{ $produto->id }}
                        </a>
                    </td>
                    <td>
                        {{$produto->produto->nome }}
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
    <!-- arquivo resources/views/atualizar-registro.blade.php -->
    {{$ordem_servico->link_foto}}
    @php
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $extension = pathinfo($ordem_servico->link_foto, PATHINFO_EXTENSION);
    @endphp

    @if (!empty($ordem_servico->link_foto) && in_array($extension, $allowedExtensions) && file_exists(public_path($ordem_servico->link_foto)))
    <div class="container" style="margin-top:20px;">
        <img src="/{{$ordem_servico->link_foto}}" alt="Imagem da Ordem de Serviço" id="imagem">
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
    <!--APR-->
    @if(isset($aprs))
    @foreach($aprs as $apr)
    <div style="
    display: flex;
    flex-direction: row;
    gap: 20px;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    margin-bottom: 15px;
    background: #f9f9f9;
    align-items: flex-start;
    overflow-x: auto;
">

        <div>
            <a class="txt-link" href="{{route('apr.show',['apr_id'=>$apr->id])}}"><strong>ID APR:</strong> {{ $apr->id }}</a>
        </div>
        <div><strong>Local:</strong> {{ $apr->local_trabalho }}</div>
        <div><strong>Atividade:</strong> {{ $apr->descricao_atividade }}</div>
        <div><strong>Riscos:</strong> {{ $apr->riscos_identificados }}</div>
        <div><strong>Controle:</strong> {{ $apr->medidas_controle }}</div>
        <div><strong>EPI:</strong> {{ $apr->epi_obrigatorio }}</div>
        <div><strong>Status:</strong> {{ $apr->status }}</div>

    </div>

    @endforeach
    @endif
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
                    <div style="font-size:15px;color:black;">Se clicar em confirmar, todos os pedidos de saída ligados a esta O.S., tmabém serão fechados!</div>
                </div>
                <div class="modal-body">
                    <button type="button" class="btn btn-danger" id="confirmarEnvioPendente" data-bs-dismiss="modal">
                        Ficou algo pendente? <br>
                        Emitir Cópia com a pendência, e Finalizar</button> 
                        <br>
                    <input type="textarea" id="pendencia" class="form-control" style="margin:5px;">
                  
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmarEnvio" data-bs-dismiss="modal">Apenas Finalizar a O.S.</button>

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

</main>
<script>
    //Fechar ordem de serviço pelo botão finalizar
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
        margin: 1px;
        margin-bottom: 1px;
        padding: 1px;


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

    /*-----------------------------------------------------------/
/* Box responsivos warp 
/*---------------------------------------------------------*/
    .item {
        width: calc(33% - 20px);
        height: auto;
        margin: -1px;
        padding: 10px;
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