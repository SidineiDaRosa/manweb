@extends('app.layouts.app')

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<main class="content">
    <div class="card">
        <div class="card-header-template" style="background-color: rgb(245, 246, 248);">

            <diV class="">
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
                        add_ad
                    </span>
                </a>
                <a class="btn btn-outline-success btn-bg" href="{{route('pedido-compra.create',['equipamento_id' => $equipamento->id])}}">
                    Pedido Compra <span class="material-symbols-outlined">
                        list_alt_add
                    </span>
                </a>
                <a class="btn btn-outline-dark btn-bg" href="{{ route('app.home') }}">
                    <i class="icofont-dashboard"></i> dashboard
                </a>
                <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{ route('equipamento.edit', ['equipamento' => $equipamento->id]) }}">
                    <i class="icofont-ui-edit"></i> </a>
                <span style="font-family: Arial, Helvetica, sans-serif;">Visualização do Ativo | Patrimônio</span>
            </div>
        </div>
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
                        .input-text {
                            margin-top: 5px;
                            width: 50%;
                            border: none;
                            color: #2174d4;
                        }
                    </style>

                    <input class="input-text" type="text" value="{{$equipamento->horimetro}}" readonly>
                    <div style="margin-top:10px;"><a class="btn btn-outline-primary btn-sm" href="">
                            Atualizar Horímetro
                        </a></div>

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
            </div>
            {{--fim card--}}

            {{--------------------------------------------------------------------}}
            {{--Ordens de serviço em andamento -----------------------------------}}
            <hr>
            <div class="titulo" style="color:brown">Ordem de serviço em andamento</div>

            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Tabela Modelo</title>
            </head>

            <body>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Data de Início</th>
                            <th>Hora de Início</th>
                            <th>Data de Fim</th>
                            <th>Hora de Fim</th>
                            <th>Empresa</th>
                            <th>Patrimônio</th>
                            <th>Emissor</th>
                            <th>Responsável</th>
                            <th>Descrição</th>
                            <th>Status</th>
                            <th>Valor</th>
                            <th>Operações</th>
                            <th>check</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ordens_servicos_1 as $ordem_servico)
                        @php
                        // Definir o fuso horário para America/Sao_Paulo
                        date_default_timezone_set('America/Sao_Paulo');

                        // Obter o horário atual de Brasília
                        $dataAtual = \Illuminate\Support\Carbon::now();
                        //-------------------------------------------------//
                        $dataFim = \Carbon\Carbon::parse($ordem_servico->data_fim);
                        $horaFim = \Carbon\Carbon::parse($ordem_servico->hora_fim);
                        $dataAtual = \Carbon\Carbon::now();
                        $classData = '';
                        $classHora = '';

                        // Regras para data de fim verde//
                        if ($dataFim->greaterThan($dataAtual)) {
                        $classData = 'bg-green';
                        $classHora = 'bg-green';//seta para verde
                        }
                        // Regras para data de fim amarelo
                        if ($dataFim->isSameDay($dataAtual)) {
                        $classData = 'bg-yellow';
                        // -----------Regras para hora de fim
                        $horaFimSemSegundos = $horaFim->copy()->second(0); // Define os segundos como 0
                        $horaAtualSemSegundos = $dataAtual->copy()->second(0); // Define os segundos como 0
                        if ($horaFimSemSegundos->greaterThan($horaAtualSemSegundos)) {
                        $classHora = 'bg-green'; // seta para verde
                        } elseif ($horaFimSemSegundos->equalTo($horaAtualSemSegundos)) {
                        $classHora = 'bg-yellow'; // seta para amarelo
                        } elseif ($horaFimSemSegundos->lessThan($horaAtualSemSegundos)) {
                        $classHora = 'bg-red'; // seta para vermelho
                        }
                        // Regras para data de fim vermelho//
                        } elseif ($dataFim->lessThan($dataAtual)) {
                        $classData = 'bg-red';
                        // -----------Regras para hora de fim
                        $classHora = 'bg-red';//seta para vermelho
                        }
                        @endphp

                        <tr>
                            <td>{{ $ordem_servico->id }}</td>
                            <td> {{ date( 'd/m/Y' , strtotime($ordem_servico['data_inicio']))}}</td>
                            <td>{{ $ordem_servico->hora_inicio }}</td>
                            <td class="{{ $classData }}">{{ date( 'd/m/Y' , strtotime($ordem_servico['data_fim']))}}</td>
                            <td class="{{ $classHora }}">{{ $ordem_servico->hora_fim }}</td>
                            <td>
                                {{ $ordem_servico->Empresa->razao_social}}
                            </td>
                            <td>{{ $ordem_servico->equipamento->nome}}</td>
                            <td>{{ $ordem_servico->emissor}}</td>
                            <td>{{ $ordem_servico->responsavel}}</td>
                            <td id="descricao">

                                {{ $ordem_servico->descricao}}

                            </td>
                            <td>{{ $ordem_servico->situacao}}
                                <div class="progress mb-3" role="progressbar" aria-label="Success example with label" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar text-bg-warning">{{ $ordem_servico->status_servicos}}%</div>
                                </div>
                            </td>
                            <td id="valor" value="{{ $ordem_servico->valor}}">{{ $ordem_servico->valor}}</td>
                            <!--Div operaçoes do registro da ordem des serviço-->
                            <td>
                                <div {{-- class="div-op" --}} class="btn-group btn-group-actions visible-on-hover">
                                    <a class="btn btn-sm-template btn-outline-primary" href="{{route('ordem-servico.show', ['ordem_servico'=>$ordem_servico->id])}}">
                                        <i class="icofont-eye-alt"></i>
                                    </a>

                                    <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{route('ordem-servico.edit', ['ordem_servico'=>$ordem_servico->id])}}">

                                        <i class="icofont-ui-edit"></i> </a>

                                    <!--Condoçes para deletar a os-->
                                    <form id="form_{{ $ordem_servico->id }}" method="post" action="{{route('ordem-servico.destroy', ['ordem_servico'=>$ordem_servico->id])}}">
                                        @method('DELETE')
                                        @csrf

                                    </form>
                                    <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick=" DeletarOs()">
                                        <i class="icofont-ui-delete"></i>
                                        <script>
                                            function DeletarOs() {
                                                var x;
                                                var r = confirm("Deseja deletar a ordem de serviço?");
                                                if (r == true) {

                                                    document.getElementById('form_{{$ordem_servico->id }}').submit()
                                                } else {
                                                    x = "Você pressionou Cancelar!";
                                                }
                                                document.getElementById("demo").innerHTML = x;
                                            }
                                        </script>
                                    </a>
                                    <!------------------------------>

                                </div>
                            <td>
                                <div class="col-md-2 mb-0">
                                    <input type="checkbox" name="" id="">
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
</main>

@endsection
{{------------------------------teste pinta campo  tabela aberto-----------------------------}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<h6>Ordens em aberto</h6>

<body>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Data de Início</th>
                <th>Hora de Início</th>
                <th>Data de Fim</th>
                <th>Hora de Fim</th>
                <th>Empresa</th>
                <th>Patrimônio</th>
                <th>Emissor</th>
                <th>Responsável</th>
                <th>Descrição</th>
                <th>Status</th>
                <th>Operações</th>
                <th>check</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ordens_servicos as $ordem_servico)
            @php
            // Definir o fuso horário para America/Sao_Paulo
            date_default_timezone_set('America/Sao_Paulo');

            // Obter o horário atual de Brasília
            $dataAtual = \Illuminate\Support\Carbon::now();
            //-------------------------------------------------//
            $dataFim = \Carbon\Carbon::parse($ordem_servico->data_fim);
            $horaFim = \Carbon\Carbon::parse($ordem_servico->hora_fim);
            $dataAtual = \Carbon\Carbon::now();
            $classData = '';
            $classHora = '';
            // Regras para data de fim verde//
            if ($dataFim->greaterThan($dataAtual)) {
            $classData = 'bg-green';
            $classHora = 'bg-green';//seta para verde
            }
            // Regras para data de fim amarelo
            if ($dataFim->isSameDay($dataAtual)) {
            $classData = 'bg-yellow';
            // -----------Regras para hora de fim
            $horaFimSemSegundos = $horaFim->copy()->second(0); // Define os segundos como 0
            $horaAtualSemSegundos = $dataAtual->copy()->second(0); // Define os segundos como 0
            if ($horaFimSemSegundos->greaterThan($horaAtualSemSegundos)) {
            $classHora = 'bg-green'; // seta para verde
            } elseif ($horaFimSemSegundos->equalTo($horaAtualSemSegundos)) {
            $classHora = 'bg-yellow'; // seta para amarelo
            } elseif ($horaFimSemSegundos->lessThan($horaAtualSemSegundos)) {
            $classHora = 'bg-red'; // seta para vermelho
            }
            // Regras para data de fim vermelho//
            } elseif ($dataFim->lessThan($dataAtual)) {
            $classData = 'bg-red';
            // -----------Regras para hora de fim
            $classHora = 'bg-red';//seta para vermelho
            }
            @endphp
            <tr>
                <td>{{ $ordem_servico->id }}</td>
                <td> {{ date( 'd/m/Y' , strtotime($ordem_servico['data_inicio']))}}</td>
                <td>{{ $ordem_servico->hora_inicio }}</td>
                <td class="{{ $classData }}">{{ date( 'd/m/Y' , strtotime($ordem_servico['data_fim']))}}</td>
                <td class="{{ $classHora }}">{{ $ordem_servico->hora_fim }}</td>
                <td>
                    {{ $ordem_servico->Empresa->razao_social}}
                </td>
                <td>{{ $ordem_servico->equipamento->nome}}</td>
                <td>{{ $ordem_servico->emissor}}</td>
                <td>{{ $ordem_servico->responsavel}}</td>
                <td id="descricao">

                    {{ $ordem_servico->descricao}}

                </td>
                <td>{{ $ordem_servico->situacao}}
                    <div class="progress mb-3" role="progressbar" aria-label="Success example with label" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar text-bg-warning">{{ $ordem_servico->status_servicos}}%</div>
                    </div>
                </td>
                <!--Div operaçoes do registro da ordem des serviço-->
                <td>
                    <div {{-- class="div-op" --}} class="btn-group btn-group-actions visible-on-hover">
                        <a class="btn btn-sm-template btn-outline-primary" href="{{route('ordem-servico.show', ['ordem_servico'=>$ordem_servico->id])}}">
                            <i class="icofont-eye-alt"></i>
                        </a>

                        <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{route('ordem-servico.edit', ['ordem_servico'=>$ordem_servico->id])}}">

                            <i class="icofont-ui-edit"></i> </a>

                        <!--Condoçes para deletar a os-->
                        <form id="form_{{ $ordem_servico->id }}" method="post" action="{{route('ordem-servico.destroy', ['ordem_servico'=>$ordem_servico->id])}}">
                            @method('DELETE')
                            @csrf

                        </form>
                        <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick=" DeletarOs()">
                            <i class="icofont-ui-delete"></i>
                            <script>
                                function DeletarOs() {
                                    var x;
                                    var r = confirm("Deseja deletar a ordem de serviço?");
                                    if (r == true) {

                                        document.getElementById('form_{{$ordem_servico->id }}').submit()
                                    } else {
                                        x = "Você pressionou Cancelar!";
                                    }
                                    document.getElementById("demo").innerHTML = x;
                                }
                            </script>
                        </a>
                        <!------------------------------>

                    </div>
                <td>
                    <div class="col-md-2 mb-0">
                        <input type="checkbox" name="" id="">
                    </div>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>
<style>

    body,
    html {
        height: 100%;
        margin: 0;
        padding: 0;
        width: auto;
    }

    .container-box {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        align-items: flex-start;
        background-color: white;

    }
    .item {
        width: calc(33% - 20px);
        height: auto;
        margin: 5px;
        padding: 10px;
        background-color: white;
        overflow: auto;
        /* Impede que o conteúdo transborde */
        font-weight: 500;
        border-radius:5px;
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
</style>
<style>
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
<a class="btn btn-sm-template btn-outline-primary" href="{{ route('equipamento.show', ['equipamento' => $equipamento->id,'todas'=>'1']) }}">
    <i class="icofont-eye-alt">Visualisar todas</i>
</a>


<script>
    function DeletarPecaEquip(id) {
        if (confirm('Você tem certeza que deseja deletar este registro?')) {
            // Envia uma requisição DELETE para deletar o item
            fetch(`/peca-equipamento/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    console.log('Resposta recebida:', response);
                    return response.json();
                })
                .then(data => {
                    console.log('Dados da resposta:', data);
                    if (data.success) {
                        alert('Registro deletado com sucesso!');
                        location.reload();
                    } else {
                        alert('Ocorreu um erro ao tentar deletar o registro: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro na requisição:', error);
                    alert('Erro ao tentar deletar o registro.');
                });
        }
    }
</script>

<!------------------------------------------------------------->
<!----Bloco que mostra componentes com periodicidade----------->
<!------------------------------------------------------------->
<div class="container-box">
    {{--Box 1--}}
    <div class="item-25">
        <h4>Componentes</h4>
        @foreach ($pecas_equipamento as $peca_equipamento)
        {{ $peca_equipamento->id }} <br>
        <h6>{{ $peca_equipamento->descricao}} </h6>
        @if(isset($peca_equipamento->produto))
        <a class="txt-link" href="{{ route('produto.show', ['produto' => $peca_equipamento->produto->id]) }}">
            {{ $peca_equipamento->produto->nome }}
        </a>
        @else
        Produto não encontrado
        @endif
        {{ $peca_equipamento->quantidade}} <br>
        Intervalo entre as trocas é de : {{ $peca_equipamento->intervalo_manutencao}}hs <br>
        Última substituaição foi em: {{ date( 'd/m/Y' , strtotime($peca_equipamento['data_substituicao']))}} às {{ $peca_equipamento->hora_substituicao}} <br>
        Próxima troca programada para: {{ date( 'd/m/Y' , strtotime($peca_equipamento['data_proxima_manutencao']))}} <br>
        Horas restante: <div class="
    @if($peca_equipamento->horas_proxima_manutencao >= 48)
        bg-success
    @elseif($peca_equipamento->horas_proxima_manutencao < 48 && $peca_equipamento->horas_proxima_manutencao > 0)
        bg-warning
    @else
        bg-danger
    @endif
" style="margin-bottom:5px;">{{$peca_equipamento->horas_proxima_manutencao}} hs</div>
        <a class="btn btn-sm-template btn-outline-primary" href="{{route('Peca-equipamento.index',['peca_equip_id'=>$peca_equipamento->id ,'chek_list'=>1])}}">
            <i class="icofont-eye-alt"></i>
        </a>
        {{--roquei @can por @cannot porque você deseja desativar o botão se o usuário não tiver a permissão 'user'.--}}
        <a class="btn btn-sm-template btn-outline-success @can('user') disabled @endcannot" href="{{ route('Peca-equipamento-editar.edit', ['peca_equipamento_id' => $peca_equipamento->id,'tipofiltro'=>1,'produto'=>0]) }}">
            <i class="icofont-ui-edit"></i>
        </a>

        <!--Condoçes para deletar a os-->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <a class="btn btn-sm-template btn-outline-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="DeletarPecaEquip({{ $peca_equipamento->id }})">
            <i class="icofont-ui-delete"></i>
        </a>
        <hr style="margin-top:10px;">
        @endforeach
    </div>
    {{--Box 2--}}
    <div class="item-25">
        <h4>Manutenção</h4>
        @foreach ($manutencao as $manutencao_f)
        {{$manutencao_f->id}} <br>
        <h6> {{$manutencao_f->descricao}} </h6>
        Intervalo entre os serviços é de : {{ $manutencao_f->intervalo_manutencao}}hs <br>
        Última manutenção : {{ date( 'd/m/Y' , strtotime($manutencao_f['data_substituicao']))}} às {{ $manutencao_f->hora_substituicao}} <br>
        Próxima manutenção está programada para:{{ date( 'd/m/Y' , strtotime($manutencao_f['data_proxima_manutencao']))}} <br>
        Horas restante: <div class="
    @if($manutencao_f->horas_proxima_manutencao >= 48)
        bg-success
    @elseif($manutencao_f->horas_proxima_manutencao < 48 && $manutencao_f->horas_proxima_manutencao > 0)
        bg-warning
    @else
        bg-danger
    @endif
" style="margin-bottom:5px;">{{$manutencao_f->horas_proxima_manutencao}} hs</div>
        <a class="btn btn-sm-template btn-outline-primary" href="{{route('Peca-equipamento.index',['peca_equip_id'=>$manutencao_f->id ,'chek_list'=>1])}}">
            <i class="icofont-eye-alt"></i>
        </a>
        <a class="btn btn-sm-template btn-outline-success @can('user') disabled @endcannot" href="{{ route('Peca-equipamento-editar.edit', ['peca_equipamento_id' => $manutencao_f->id,'tipofiltro'=>1,'produto'=>0]) }}">
            <i class="icofont-ui-edit"></i>
        </a>
        <!--Condoçes para deletar a os-->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <a class="btn btn-sm-template btn-outline-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="DeletarPecaEquip({{ $manutencao_f->id }})">
            <i class="icofont-ui-delete"></i>
        </a>
        <hr style="margin-top:10px;">
        @endforeach
    </div>
    {{--Box 3--}}
    <div class="item-25">
        <h4>Check-list</h4>
        @foreach ($chek_list as $chek_list_f)
        {{ $chek_list_f->id }} <br>
        <h6>{{ $chek_list_f->descricao}} </h6>
        Intervalo entre a inspeção é de: {{ $chek_list_f->intervalo_manutencao}}hs <br>
        A última verificação foi em: {{ date( 'd/m/Y' , strtotime($chek_list_f['data_substituicao']))}} às {{ $chek_list_f->hora_substituicao}} <br>
        A próxima será em: {{ date( 'd/m/Y' , strtotime($chek_list_f['data_proxima_manutencao']))}} <br>
        Horas restante: <div class="
    @if($chek_list_f->horas_proxima_manutencao >= 48)
        bg-success
    @elseif($chek_list_f->horas_proxima_manutencao < 48 && $chek_list_f->horas_proxima_manutencao > 0)
        bg-warning
    @else
        bg-danger
    @endif
" style="margin-bottom:5px;">{{$chek_list_f->horas_proxima_manutencao}} hs</div>
        <a class="btn btn-sm-template btn-outline-primary" href="{{route('Peca-equipamento.index',['peca_equip_id'=>$chek_list_f->id ,'chek_list'=>1])}}">
            <i class="icofont-eye-alt"></i>
        </a>
        {{--roquei @can por @cannot porque você deseja desativar o botão se o usuário não tiver a permissão 'user'.--}}
        <a class="btn btn-sm-template btn-outline-success @can('user') disabled @endcannot" href="{{ route('Peca-equipamento-editar.edit', ['peca_equipamento_id' => $chek_list_f->id,'tipofiltro'=>1,'produto'=>0]) }}">
            <i class="icofont-ui-edit"></i>
        </a>

        <!--Condoçes para deletar a os-->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <a class="btn btn-sm-template btn-outline-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="DeletarPecaEquip({{ $chek_list_f->id }})">
            <i class="icofont-ui-delete"></i>
        </a>
        <hr style="margin-top:5px;">
        @endforeach
    </div>
    {{--Box 4--}}
    <div class="item-25">
        <h4>Lubrificação</h4>
        @foreach ($lubrificacao as $lubrificacao_f)
        {{$lubrificacao_f->id}} <br>
        <h6>{{$lubrificacao_f->descricao}}</h6>
        O intervalo entre a lubrificação é de: {{ $lubrificacao_f->intervalo_manutencao}}hs <br>
        A última lubrificação foi em: {{ date( 'd/m/Y' , strtotime($lubrificacao_f['data_substituicao']))}} às {{ $lubrificacao_f->hora_substituicao}} <br>
        A próxima está programada para: {{ date( 'd/m/Y' , strtotime($lubrificacao_f['data_proxima_manutencao']))}} <br>
        Horas restante: <div class="
    @if($lubrificacao_f->horas_proxima_manutencao >= 48)
        bg-success
    @elseif($lubrificacao_f->horas_proxima_manutencao < 48 && $lubrificacao_f->horas_proxima_manutencao > 0)
        bg-warning
    @else
        bg-danger
    @endif
" style="margin-bottom:5px;">{{$lubrificacao_f->horas_proxima_manutencao}} hs</div>
        <a class="btn btn-sm-template btn-outline-primary" href="{{route('Peca-equipamento.index',['peca_equip_id'=>$lubrificacao_f->id ,'chek_list'=>1])}}">
            <i class="icofont-eye-alt"></i>
        </a>
        {{--roquei @can por @cannot porque você deseja desativar o botão se o usuário não tiver a permissão 'user'.--}}
        <a class="btn btn-sm-template btn-outline-success @can('user') disabled @endcannot" href="{{ route('Peca-equipamento-editar.edit', ['peca_equipamento_id' => $lubrificacao_f->id,'tipofiltro'=>1,'produto'=>0]) }}">
            <i class="icofont-ui-edit"></i>
        </a>

        <!--Condoçes para deletar a os-->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <a class="btn btn-sm-template btn-outline-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="DeletarPecaEquip({{ $lubrificacao_f->id }})">
            <i class="icofont-ui-delete"></i>
        </a>
        <hr style="margin-top:10px;">
        @endforeach
    </div>
    {{--fim card--}}
</div>
<style>
    .container-box {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        align-items: flex-start;
        background-color: white;
    }

    .item-25 {
        width: calc(25% - 20px);
        height: auto;
        margin: 10px;
        padding: 15px;
        background-color: white;
        overflow: auto;
        /* Impede que o conteúdo transborde */
        font-size: 15px;
        border-radius:5px;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        font-weight: 100;
    }

    .div-text-input {
        font-size: 15px;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        font-weight: 100;
    }

    .item-week {
        width: calc(33% - 20px);
        height: 300px;
        margin: 10px;
        padding: 15px;
        background-color: aliceblue;
        overflow: auto;
        /* Impede que o conteúdo transborde */
    }

    .span-title-sm {
        font-size: 15px;
        font-family: Arial, sans-serif;
        font-weight: 100;
    }

    @media (max-width: 900px) {
        .item-25 {
            width: 100%;
            margin: 0px -80;
        }
    }
</style>