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
            </style>
            <table class="table-template table-sm table-striped table-hover" id="tblPecas">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">equipamento</th>
                        <th scope="col">Produto Id</th>
                        <th scope="col">Produto</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Link</th>
                        <th scope="col">intervalo</th>
                        <th scope="col">data ultima substituação</th>
                        <th scope="col">Hora</th>
                        <th scope="col">data proxima</th>
                        <th scope="col">horas proxima</th>
                        <th scope="col">horimetro</th>
                        <th scope="col">status</th>
                        <th scope="col">Operaçoes</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($pecas_equipamento as $peca_equipamento)
                    <tr>
                        <td scope="row">{{ $peca_equipamento->id }}</td>
                        <td>{{ $equipamentos_f->nome}}</td>
                        <td>{{ $peca_equipamento->produto->id}} <a class="btn btn-sm-template btn-outline-primary" href="">

                                <i class="icofont-search-2"></i>
                            </a>
                        </td>
                        <td>{{ $peca_equipamento->produto->nome}}</td>
                        <td>{{ $peca_equipamento->quantidade}}</td>
                        <td>{{ $peca_equipamento->link_peca}}</td>
                        <td>{{ $peca_equipamento->intervalo_manutencao}}</td>
                        <td>{{ date( 'd/m/Y' , strtotime($peca_equipamento['data_substituicao']))}}</td>
                        <td>{{ $peca_equipamento->hora_substituicao}}</td>
                        <td>{{ date( 'd/m/Y' , strtotime($peca_equipamento['data_proxima_manutencao']))}}</td>
                        <td>{{ $peca_equipamento->horas_proxima_manutencao}}</td>
                        <td>{{ $peca_equipamento->horimetro}}</td>
                        <td>{{ $peca_equipamento->status}}</td>
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

                    </tr>
                    @endforeach
                </tbody>
            </table>
</main>
@endsection