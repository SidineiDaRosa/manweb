@extends('app.layouts.app')

@section('content')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var hoje = new Date();
        var amanha = new Date(hoje);
        amanha.setDate(hoje.getDate() + 1); // Adiciona 1 dia

        var dia = amanha.getDate();
        var mes = amanha.getMonth() + 1; // Mês começa do zero
        var ano = amanha.getFullYear();

        // Formata a data para o formato do input type="date" (AAAA-MM-DD)
        var dataFormatada = ano + '-' + (mes < 10 ? '0' + mes : mes) + '-' + (dia < 10 ? '0' + dia : dia);

        // Define o valor do campo data_proxima_manutencao
        document.getElementById('data_proxima_manutencao').value = dataFormatada;
    });
</script>
<main class="content">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
    @endif


    <div class="card-header-template">

        <diV>

            <a class="btn btn-outline-dark" href="{{ route('app.home') }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </div>
    </div>
    </div>
    <div class="titulo-main">
        Componentes de equipamentos
    </div>
    <style>
        .titulo-main {
            font-size: 20px;
            color: gray;
            text-align: center;
            margin-top: -2;
        }
    </style>
    <div class="card">
        <style>
            .card {
                background-color: rgb(211, 211, 211);
            }

            #equipamento_id {
                font-size: 20px;
            }
        </style>
        <h5>Componentes/categorias periódicos</h5>
        <hr>
        <form action="{{'peca-equpamento-filtro'}}" method="POST">
            @csrf
            <div class="card">
                <div class="row">
                    <div class="col-md-2">
                        <label for="opcoes">Categoria:</label>
                        <select class="form-control" id="opcoes" name="categoria">
                            <option value="all">Todas</option>
                            <option value="Componente">Componente</option>
                            <option value="Manutenção">Manutenção</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="opcoes">Selecione Pela data ou pela hora:</label>
                        <select class="form-control" id="opcoes" name="opcao">
                            <option value="1">Data da próxima manutenção</option>
                            <option value="2">Horas restante</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="opcoes">Data:</label>
                        <input class="form-control" type="date" id="data_proxima_manutencao" name="data_proxima_manutencao" value="">
                    </div>
                    <div class="col-md-2">
                        <label for="opcoes">Horas restante:</label>
                        <input class="form-control" type="number" name="horas_proxima_manutencao" value="24">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 text-center">
                        <input type="submit" class="btn btn-outline-primary" value="Enviar">
                    </div>
                </div>
            </div>
        </form>

        <div class="card-body">
            <style>
                #tblOs {
                    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    background-color: rgb(211, 211, 211);
                    font-weight: 300;
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
                    font-weight: 400;

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

            {{------------------------------------------------}}
            {{--Tabela de peças dos equipamento---------------}}


            <table class="table" id="tblPecas">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Equipamento</th>
                        <th>Descrição</th>
                        <th>Produto </th>
                        <th>Quantidade</th>
                        <th>intervalo</th>
                        <th>data ultima substituação</th>
                        <th>data proxima</th>
                        <th>Horas restante</th>
                        <th>Status</th>
                        <th>Tipo de Componente</th>
                        <th>Criticidade</th>
                        <th>Operaçoes</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($pecas_equipamento as $peca_equipamento)
                    <tr>
                        <td>{{$peca_equipamento->id}}</td>
                        @foreach ($equipamentos as $equipamento)
                        @if ($equipamento['id'] == $peca_equipamento->equipamento)
                        <td>
                            <a class="txt-link" href="{{ route('equipamento.show', ['equipamento' => $equipamento->id]) }}">{{ $equipamento['nome'] }}</a>
                        </td> <!-- Exibindo o nome do equipamento -->
                        <style>

                        </style>
                        @endif
                        @endforeach
                        <td>{{ $peca_equipamento->descricao}}</td>
                        <td>
                            <a class="txt-link" href="{{ route('produto.show', ['produto' =>$peca_equipamento->produto->id]) }}">
                                {{ $peca_equipamento->produto->nome}}
                            </a>
                        </td>
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
                        <td>{{ $peca_equipamento->status}}</td>
                        <td>{{ $peca_equipamento->tipo_componente}}</td>
                        <td>{{ $peca_equipamento->criticidade}}</td>


        </div>
        </td>
        <!--Div operaçoes do registro da ordem des serviço-->
        <td>
            <div {{-- class="div-op" --}} class="btn-group btn-group-actions visible-on-hover">
                <a class="btn btn-sm-template btn-outline-primary" href="{{route('Peca-equipamento.index',['peca_equip_id'=>$peca_equipamento->id ,'chek_list'=>1])}}">
                    <i class="icofont-eye-alt"></i>
                </a>
                <a class="btn btn-sm-template btn-outline-success" href="{{route('Peca-equipamento.index',['peca_equip_id'=>$peca_equipamento->id ,'chek_list'=>1])}}">
                    <i class="bi bi-pencil-fill"></i>
                </a>
                <form action="{{ route('peca_equipamento.destroy', $peca_equipamento->id) }}"
                    method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Tem certeza que deseja excluir esta peça?')">
                        <i class="bi bi-trash3"></i>
                    </button>
                </form>


            </div>
            @endforeach
            <!-- Bootstrap CSS no <head> -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

            <!-- ...seu conteúdo... -->

            <!-- Bootstrap JS no final do body -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</main>
@endsection