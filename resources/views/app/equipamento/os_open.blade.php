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
            border-radius: 5px;
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
    <a class="btn btn-bg-template btn-outline-success" href="{{ route('equipamento.show', ['equipamento' => $equipamento->id,'todas'=>'1']) }}"
        style="width:300px;">
        <i class="icofont-eye-alt"></i>
        Visualisar todas
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
            border-radius: 5px;
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