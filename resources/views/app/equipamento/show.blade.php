@extends('app.layouts.app')

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<main class="content">
    <style>
        .container-toolbar {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: flex-start;
        }
    </style>

    <a class="btn btn-outline-primary btn-bg" href="{{ route('equipamento.index', ['empresa'=>2]) }}">
        <span class="material-symbols-outlined">
            format_list_bulleted
        </span>
    </a>

    <a class="btn btn-outline-primary btn-bg" href="{{route('equipamento.create')}}">
        Novo Ativo/Equipamento
    </a>
    <a class="btn btn-outline-primary btn-bg" href="{{ route('Peca-equipamento.create',['equipamento' => $equipamento->id]) }}">
        Novo Componente<span class="material-symbols-outlined">
            create_new_folder
        </span>
    </a>
    <a class="btn btn-outline-primary btn-bg" href="{{route('ordem-servico.create', ['equipamento'=>$equipamento->id,'empresa'=>2])}}">
        <span class="icon text-white-50">
        </span>
        <span class="text">Nova O.S</span>
        <span class="material-symbols-outlined">
            assignment_add
        </span>
    </a>
    <a class="btn btn-outline-success btn-bg" href="{{route('pedido-compra.create',['equipamento_id' => $equipamento->id])}}">
        Pedido Compra <span class="material-symbols-outlined">
            list_alt_add
        </span>
    </a>
    <a class="btn btn-outline-dark btn-bg" href="{{ route('app.home') }}">
        <i class="icofont-dashboard"></i> Dashboard
    </a>
    <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{ route('equipamento.edit', ['equipamento' => $equipamento->id]) }}">
        <i class="icofont-ui-edit"></i> </a>
    <span style="font-family: Arial, Helvetica, sans-serif;">Visualização do Ativo | Patrimônio</span>

    {{-------------------------------------------------------------------------}}
    {{--Inicio do bloco que contém o continer dos gráficos---------------------}}
    <style>
        /* estilizção do conteudo a pagina cabeçalho*/
        hr {
            margin: -5px;
            color: #ccc;
        }

        .box-conteudo {
            margin-left: 50px;
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
            font-family: 'Poppins', sans-serif;
            color: #007b00;
            margin-bottom: 5px;
            width: 300px;
        }
    </style>
    <link rel="stylesheet" href="myProjects/webProject/icofont/css/icofont.min.css">
    <hr style="margin-top:1px;">
    <div class="container-box" style="background-color: rgb(245, 246, 248);">
        {{--Box 1--}}
        <div class="item">
            <div id=idOs class="conteudo" style="color:mediumblue">
                ID:&nbsp&nbsp{{$equipamento->id}}
            </div>
            <div class="titulo">Ativo | Patrimônio<span class="material-symbols-outlined">
                    sell
                </span></div>
            <hr>
            <div class="conteudo">{{$equipamento->nome}}</div>
            <div class="titulo">Descrição do ativo</div>
            <hr>
            <div class="conteudo"> {{$equipamento->descricao}}</div>
            <div class="titulo">Valor estimado</div>
            <hr>
            <div class="conteudo">R${{$equipamento->valor_estimado}}</div>
            <div class="titulo">Localização<span class="material-symbols-outlined">
                    pin_drop
                </span></div>
            <hr>
            <div class="conteudo">
                {{$equipamento->localizacao}}

            </div>
            <div class="card-body">
                <?php
                $protocolo = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == "on") ? "https" : "http");
                $url = '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $urlPaginaAtual = $protocolo . $url;
                ?>
                {!! QrCode::size(50)->backgroundColor(255,255,255)->generate($urlPaginaAtual) !!}
            </div>
            <form id="generateQRForm" action="{{ route('generate-qrcode') }}" method="POST">
                @csrf
                <input type="text" hidden name="equipamento_id" value="{{$equipamento->id}}">
                <input type="hidden" name="url" value="{{ $urlPaginaAtual }}">
                <a href="#" onclick="event.preventDefault(); document.getElementById('generateQRForm').submit();" style="font-family:system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">Clique aqui para gerar o QR Code</a>
        </div>
        {{--Box 2--}}
        <div class="item">

            <div class="titulo">Fabricante | Marca</div>
            <hr>
            <div class="conteudo"> {{$equipamento->marca->nome}}</div>
            <div class="titulo">Empresa</div>
            <hr>
            <div class="conteudo"> {{$equipamento->Empresa->razao_social}}</div>
            <div class="titulo">Data de fabricação<span class="material-symbols-outlined">
                    calendar_month
                </span></div>
            <hr>
            <div class="conteudo"> {{ \Carbon\Carbon::parse($equipamento->data_fabricacao)->format('d/m/Y') }}</div>
            <div class="titulo">Data de instalação<span class="material-symbols-outlined">
                    calendar_month
                </span></div>
            <hr>
            <div class="conteudo"> {{ \Carbon\Carbon::parse($equipamento->data_instalacao)->format('d/m/Y') }}</div>
            <div class="titulo">Data da desativação do ativo<span class="material-symbols-outlined">
                    calendar_month
                </span></div>
            <hr>
            @if ($equipamento->data_desativacao)
            <div class="conteudo">{{ \Carbon\Carbon::parse($equipamento->data_desativacao)->format('d/m/Y') }}</div>
            @else
            <div class="conteudo">Data não disponível</div>
            @endif

        </div>
        {{--Box 3--}}
        <div class="item">
            <div class="titulo">Estado do ativo</div>
            <hr>
            <div class="conteudo">
                {{$equipamento->estado_do_ativo}}
            </div>
            <div class="titulo">Criticidade</div>
            <hr>
            <div class="conteudo">
                {{$equipamento->criticidade}}
            </div>
            <div class="titulo">Tipo/categoria</div>
            <hr>
            <div class="conteudo">
                {{$equipamento->tipo_de_ativo}}
            </div>
            <div class="titulo">Horímetro</div>
            <hr>
            <div class="conteudo">
                <style>
                    #input-text {
                        margin-top: 5px;
                        width: 95%;
                        height: 30px;
                    }
                </style>
                <div style="margin-top:2px;">
                    <input id="input-text" class="form-control" type="number" value="{{$equipamento->horimetro}}">
                </div>
                <div style="margin-top:2px;">
                    <a class="btn btn-outline-primary btn-sm" href="javascript:void(0);" id="update-btn">
                        Atualizar Horímetro
                    </a>
                </div>

                <script>
                    document.getElementById('update-btn').addEventListener('click', function() {
                        // Pega o valor do ID do equipamento diretamente da div com id="idOs"
                        var equipamentoId = document.getElementById('idOs').innerText.replace('ID:', '').trim();

                        // Pega o valor do horímetro
                        var horimetro = document.getElementById('input-text').value;

                        // Exibe um alert com os valores para verificação
                        alert('Equipamento ID: ' + equipamentoId + '\nHorímetro: ' + horimetro);

                        // Cria um objeto JSON com os dados para enviar
                        var data = {
                            id: equipamentoId,
                            horimetro: horimetro
                        };

                        // Envia os dados via AJAX
                        fetch('/update-horimetro', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token CSRF para segurança
                                },
                                body: JSON.stringify(data)
                            })
                            .then(response => response.json())
                            .then(result => {
                                if (result.success) {
                                    alert('Horímetro atualizado com sucesso!');
                                } else {
                                    alert('Erro ao atualizar o horímetro');
                                }
                            })
                            .catch(error => {
                                console.error('Erro:', error);
                                alert('Erro ao tentar atualizar o horímetro');
                            });
                    });
                </script>


            </div>
            <div class="titulo">Arquivos anexados</div>
            <hr>
            <a class="txt-link" href="{{$equipamento->anexo_1}}" target="_blank">
                Documentos anexados link 1
            </a>
            <p></p>
            <a class="txt-link" href="{{$equipamento->anexo_2}}" target="_blank">
                Documentos anexados link 2
            </a>
            <p></p>
            <a class="txt-link" href="{{$equipamento->anexo_3}}" target="_blank">
                Procedimento de manutenção
            </a>
        </div>
        {{--fim card--}}
        @include('app.equipamento.os_open')
    </div>
    
</main>