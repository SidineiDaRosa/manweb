@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card-header-template">

        <diV>
            <a class="btn btn-outline-primary" href="{{ route('Peca-equipamento.index') }}">
                <span class="material-symbols-outlined">
                    format_list_bulleted
                </span>
            </a>
            <a class="btn btn-outline-dark" href="{{ route('app.home') }}">
                <i class="icofont-dashboard"></i> dashboard
            </a>
        </div>
    </div>
    </div>
    <div class="titulo-main">
        Chek-List
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
            <label for="opcoes">Categoria:</label>
            <select id="opcoes" name="categoria" placeholder="--Selecione a categoria--">
                <option value="Chek-list">Chek-list</option>
                <option value="Lubrificação">Lubrificação</option>
                <option value="Mensalidade">Mensalidade</option>
                <option value="Componente">Componente</option>
            </select>
            <label for="opcoes">Selecione Pela data ou pela hora:</label>
            <select id="opcoes" name="opcao" placeholder="--Selecione a categoria--">
                <option value="1">Data da próxima manutenção</option>
                <option value="2">Horas restante</option>
            </select>
            <label for="opcoes">Data :</label>
            <input type="date" name="data_proxima_manutencao" value="">
            <label for="opcoes">Horas restante:</label>
            <input type="number" name="horas_proxima_manutencao" value="24">
            <br><br>
            <input type="submit" value="Enviar">
        </form>
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

            {{------------------------------------------------}}
            {{--Tabela de peças dos equipamento---------------}}
            <table class="table" id="tblPecas">
                <thead>
                    <tr>
                        <th>ID</th>
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
                        <td>{{ $peca_equipamento->id}}</td>
                        <td>{{ $peca_equipamento->descricao}}</td>
                        <td>{{ $peca_equipamento->produto->nome}}
                            <hr>
                            <a class="btn btn-sm-template btn-outline-primary" href="{{ route('produto.show', ['produto' =>$peca_equipamento->produto->id]) }}">
                                <i class="icofont-eye-alt"></i>
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
            </div>
            @endforeach
            </tbody>
            </table>
</main>
@endsection