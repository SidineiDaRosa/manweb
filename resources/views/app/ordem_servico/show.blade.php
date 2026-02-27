@extends('app.layouts.app')
@section('content')

<main class="content">
    @include('app.servicos_executado.modal-servico')
    <h2 class="h2-gray">Ordem de Serviço</h2>

    <div class="header-grid">
        <a class="btn-inf btn-inf-md btn-inf-gray" href="{{ route('app.home') }}">
            <i class="bi bi-house"></i> Dashboard
        </a>
        <a class="btn-inf btn-inf-md btn-inf-blue-light" href="{{ route('ordem-servico.index') }}">
            <i class="bi bi-card-list"></i> Listar O.S.
        </a>
        @if ($ordem_servico->situacao !== 'fechado')
        <a class="btn-inf btn-inf-md btn-inf-brown"
            href="{{ route('pedido-saida.create', ['ordem_servico' => $ordem_servico->id]) }}">
            <i class="bi bi-plus-circle"></i> Novo Pedido Saída
        </a>
        @endif
        <a class="btn-inf btn-inf-md btn-inf-gray"
            href="{{ route('pedido-saida.index', ['ordem_servico' => $ordem_servico->id, 'tipofiltro' => 4]) }}">
            <i class="bi bi-search"></i> Pedidos
        </a>

        <a class="btn-inf btn-inf-md btn-inf-blue-dark"
            href="{{ route('equipamento.show', ['equipamento' => $ordem_servico->equipamento->id]) }}">
            <i class="bi bi-truck"></i> Equipamento
        </a>
        <!--APR-->
        @if (isset($aprs))
        @foreach ($aprs as $apr)
        @endforeach
        @endif
        @if ($aprs->isEmpty())
        <a class="btn-inf btn-inf-md btn-inf-gray" href="{{ route('apr.create', $ordem_servico->id) }}">
            <i class="bi bi-file-earmark-text"></i> Gerar APR
        </a>
        @else
        <a class="btn-inf btn-inf-md btn-inf-orange" href="{{ route('apr.show', ['apr_id' => $apr->id]) }}">
            <i class="bi bi-exclamation-triangle"></i> Abrir APR
        </a>
        @endif

        <a class="btn-inf btn-inf-md btn-inf-warning"
            href="{{ route('ordem-servico.edit', ['ordem_servico' => $ordem_servico->id]) }}">
            <i class="bi bi-pencil-square"></i>Editar
        </a>

    </div>
    {{-- ------------------------------- --}}
    {{-- início da div que contem os box --}}
    {{-- ------------------------------- --}}

    <div class="container-item">
        {{-- Box 1 --}}
        <div class="item">
            <div class="container-row">
                <h4 class="h4-gray">ID: </h4> &nbsp <h3 class="h3-green">#{{ $ordem_servico->id }}</h3>
            </div>
            <hr>
            <div class="container-row">
                <h4 class="h3-gray">Emissão: </h4>&nbsp
                <h4 class="h4-black">{{ date('d/m/Y', strtotime($ordem_servico['data_emissao'])) }}
                    &nbsp ás &nbsp {{ date('H:i', strtotime($ordem_servico['hora_emissao'])) }}</h4>
            </div>
            <hr>
            <h5 class="h5-gray">Empresa</h5>
            <hr>
            <h5 class="h5-black">{{ $ordem_servico->Empresa->name1}}</h5>
            <h5 class="h5-gray">Patrimônio/Ativo</h5>
            <hr>
            <div class="conteudo" id="patrimonio">{{ $ordem_servico->equipamento->nome }}</div>
            <h5 class="h5-gray">Emissor</h5>
            <hr>
            <h5 class="h5-gary">{{ $ordem_servico->emissor }}</h5>

            <div class="titulo">Responsável</div>
            <hr>
            <h5 class="h5-black">{{ $ordem_servico->responsavel }}</h5>
            <h5 class="h5-gray">Situação</h5>
            <hr>
            <h5 class="h5-black">{{ $ordem_servico->situacao }}</h5>
            <hr>

            @php
            $gravidade = $ordem_servico->gravidade ?? 0;
            $urgencia = $ordem_servico->urgencia ?? 0;
            $tendencia = $ordem_servico->tendencia ?? 0;

            $classe = '';
            $texto = 'Sem prioridade definida';

            if ($gravidade >= 5 && $urgencia >= 5 && $tendencia >= 5) {
            $classe = 'background-color: orange;';
            $texto = 'Prioridade Alta';
            } elseif ($gravidade >= 4 && $urgencia >= 4 && $tendencia >= 4) {
            $classe = 'background-color: gold;';
            $texto = 'Prioridade Média';
            } elseif ($gravidade >= 3 && $urgencia >= 3 && $tendencia >= 3) {
            $classe = 'background-color: deepskyblue;';
            $texto = 'Prioridade Baixa';
            }
            @endphp
            <div class="container-row">
                <h4 class="h5-gray">Prioridade:</h4>
                <div id="prioridade" style="{{$classe}}" class="h5-black ">
                    {{ $texto }}
                </div>
            </div>
            <hr>


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
        {{-- Box 2 --}}
        <div class="item">

            {{-- //------------------------------------------// --}}
            {{-- //Datas de inico e fim, progress bar        // --}}
            {{-- //------------------------------------------// --}}
            <h4 class="h4-gray">Datas</h4>
            <hr style="margin:1px;">
            <h4 class="h4-black">{{ date('d/m/Y', strtotime($ordem_servico['data_inicio'])) }}
                &nbsp{{date('H:i',strtotime($ordem_servico['hora_inicio'])) }}
                até &nbsp
                {{ date('d/m/Y', strtotime($ordem_servico['data_fim'])) }}
                {{date('H:i',strtotime($ordem_servico['hora_fim'])) }}
            </h4>
            <hr style="margin:1px;">
            <!--Progressbar com um input texto-->
            <div class="progress" style="height:10px" hidden>
                <div id="progress-bar" class="progress-bar" role="progressbar" aria-valuenow="0"
                    aria-valuemin="0" aria-valuemax="100">{{ $ordem_servico->status_servicos }}%</div>
            </div>
            <h5 class="h5-gray">Descrição dos serviços a serem executados</h5>
            <hr style="margin:1px;">
            <textarea id="txt-area" class="input-success" rows="6" readonly>{{ trim($ordem_servico->descricao) }}
            </textarea>
            <!---------->
            <!--Anexo-->
            <a class="txt-link" id="anexo" target="_blank" href="{{ $ordem_servico->anexo }}">
                <i class="bi bi-paperclip"></i>
                Anexo: {{ $ordem_servico->anexo }}
            </a>
        </div>
        {{-- Box 3 --}}
        <div class="item">

            <div class="container-row">
                <h4 class="h5-gray">Natureza do serviço:</h4>
            </div>
            <hr>
            <h5 class="h5-black">{{ $ordem_servico->natureza_do_servico }}</h5>

            <div class="container-row">
                <h4 class="h5-gray">Área de especialidade:</h4>
            </div>
            <hr>
            <h5 class="h5-black">{{ $ordem_servico->especialidade_do_servico }}</h5>

            <input type="text" value="{{ $ordem_servico->status_servicos }}" id="progress-input" hidden>

            <div class="container-row">
                <h4 class="h5-gray">Assinatura:</h4>
            </div>
            <hr>
            @if ($ordem_servico->signature_receptor)
            <img id="signature_receptor"
                src="{{ asset($ordem_servico->signature_receptor) }}"
                alt="Assinatura do Receptor">
            @else
            <h5 class="h5-black">Assinatura não disponível</h5>
            @endif

            <div class="container-row">
                <h4 class="h5-gray">Solicitação de Serviço:</h4>
            </div>
            <hr>
            <form action="{{ route('solicitacoes-os') }}" method="get">
                <input type="text" value="{{ $ordem_servico->ss_id }}" name="id" hidden>
                <button type="submit" class="btn-inf btn-inf-md btn-inf-blue-dark">
                    SS: {{ $ordem_servico->ss_id }}
                </button>
            </form>

            <div class="container-row">
                <h4 class="h5-gray">Projeto:</h4>
            </div>
            <hr>
            <div class="h5-black">
                @if (isset($projeto))
                ID: {{ $projeto->id }} - Nome: {{ $projeto->nome }}
                <br><br>
                <a href="{{ route('projetos.show', $projeto->id) }}"
                    class="btn btn-outline-primary mb-1">
                    Ver Projeto
                </a>
                @else
                Não anexado a um projeto
                @endif
            </div>

        </div>
    </div>
    {{-- fim container item --}}

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

        <!----------------------------------------------------------->
        <!--Divs dos dados da os-->
        <!----------------------------------------------------------->

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
        <hr>
        <h4 class="h4-gray">Serviços executados</h4>
        @foreach ($servicos_executado as $servicos_executados)
        <div class="container-item">
            <div class="item">
                <div class="container-row-1x">
                    <div class="container-row">
                        <h4 class="h4-gray">Início:</h4>
                        <h4 class="h4-black"> {{ \Carbon\Carbon::parse($servicos_executados->data_inicio)->format('d/m/Y') }} as
                            {{ $servicos_executados->hora_inicio }}
                        </h4>
                    </div>
                    <div class=" container-row">
                        <h4 class="h4-gray"> Data Fim:</h4>
                        <h4 class="h4-black"> {{ \Carbon\Carbon::parse($servicos_executados->data_fim)->format('d/m/Y') }} as
                            {{ $servicos_executados->hora_fim }}
                        </h4>
                    </div>
                </div>
                <hr>
                <div class="container-row-1x">
                    <div class="container-row">
                        <h4 class="h4-gray">Tipo</h4>
                        <h4 class="h4-black"> {{ $servicos_executados->tipo_de_servico }}</h4>
                    </div>
                    <hr>
                    <div class="container-row">
                        <h4 class="h4-gray">Avaliação</h4>
                        <h4 class="h4-black"> {{ $servicos_executados->estado }}</h4>
                    </div>
                </div>
                <div class="container-row">
                    <h4 class="h4-gray">Executante</h4>
                    <h4 class="h4-black"> {{ $servicos_executados->funcionario->primeiro_nome }}
                        {{ $servicos_executados->funcionario->ultimo_nome }}
                    </h4>
                </div>
            </div>
            <div class="item">
                <h4 class="h4-gray">Descrição dos serviços</h4>
                <hr>
                <div class="container-row-1x">
                    {{ $servicos_executados->descricao }}
                </div>
            </div>
            <div class=" item">

                <div class="titulo">Subtotal de horas</div>
                <hr>
                <div class="container-row">
                    <h4 class="h4-gray">Subtotal de horas</h4>
                    <h4 class="h4-black"> {{ $servicos_executados->subtotal }}hs</h4>
                </div>
            </div>
        </div>
        @endforeach
        <div style="display:flex;float:right;margin-right:20px;"> <span style="font-weight:700;">Total de horas
                trabalhadas: {{ number_format($total_hs_os, 2, ',', '.') }}hs</span></div>

        <!--fim seriços executados-->


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

            <a id="btn-add-task" class="btn-inf btn-inf-blue-light"
                href="{{ route('Servicos-executado.create', ['ordem_servico' => $ordem_servico->id]) }}"
                style="width: 300px;">
                <img src="{{ asset('img/icon/add_list.png') }}" alt=""
                    style="height: 25px; width: 25px;"> 🛠️ Adicionar serviço
            </a>
            <button id="enviar" class="btn-inf btn-inf-md btn-inf-green" data-bs-toggle="modal"
                data-bs-target="#confirmModal" style="width:300px;">
                <img src="{{ asset('img/icon/finished-work.png') }}" alt=""
                    style="height:25px; width:25px;">
                Fechar Ordem de serviço
            </button>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
            <!-- Bootstrap Icons -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
                rel="stylesheet">

            <button id="bt_iniciar_os" class="btn-inf btn-inf-blue-dark" onclick="StartOs()"
                style="width:300px;">
                <i class="bi bi-caret-right-fill"></i>
                Iniciar OS
            </button>
            @endif
            <button type="button" id="gerarPdfButton" class="btn-inf btn-inf-gray" style="width:300px;">Gerar PDF
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
        <div class="btn-inf btn-inf-sm btn-inf-brown" style="width:100%;">
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
                <tr >
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
    <div class="btn-inf btn-inf-sm btn-inf-orange">
        <h5>
            <i class="bi bi-exclamation-circle"></i> Nenhum pedido encontrado
        </h5>
    </div>
    @endif
    @endisset
    <!--Fim Pedidos de saídas-->
    <hr>
    </div>
    <!-- arquivo resources/views/atualizar-registro.blade.php -->

    @php
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $extension = pathinfo($ordem_servico->link_foto, PATHINFO_EXTENSION);
    @endphp

    @if (
    !empty($ordem_servico->link_foto) &&
    in_array($extension, $allowedExtensions) &&
    file_exists(public_path($ordem_servico->link_foto)))
    <div class="container" style="margin-top:20px;">
        <h6 class="h6-gray"> {{ $ordem_servico->link_foto }}</h6>
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
    <button class="btn-inf btn-inf-sm btn-inf-orange"><i class="bi bi-exclamation-circle"></i>Não há imagens
        anexadas</button>
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
@include('app.ordem_servico.partials.update_os')
@include('app.ordem_servico.partials.modal_finish_os')