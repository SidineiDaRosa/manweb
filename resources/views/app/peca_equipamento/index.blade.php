@extends('app.layouts.app')

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
        <h5>Componentes deste equipamento</h5>
        <hr>
        <form>
            <label for="opcoes">Categoria:</label>
            <select id="opcoes" name="categoria" placeholder="--Selecione a categoria--" >
                <option value="Mensalidade">Mensalidade</option>
                <option value="Chek-list">Chek-list</option>
                <option value="Lubrificação">Lubrificação</option>
            </select>
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
                            var r = confirm("Deseja deletar a ordem de serviço?");
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
@endsection