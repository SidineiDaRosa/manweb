@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div> Pedidos de saida lista filtro</div>

            <form id="formSearchingProducts" action="{{'pedido-saida-filtro'}}" method="POST">
                @csrf
                <div class="col-md-2 mb-0">
                    <input type="date" class="form-control" name="data_inicio" id="data_inicio">
                </div>
                <div class="col-md-2 mb-0">
                    <input type="date" class="form-control" name="data_fim" id="data_fim">
                </div>
                <div class="col-md-2 mb-0">
                    <select class="form-control" name="tipofiltro" id="tipofiltro" value="" placeholder="Selecione o tipo de filtro">
                        <option value="1">Situação</option>
                        <option value="2">>= Data Emissão e <= Data Emissão </option>
                        <option value="3">>= Data Emissão e <= Data Emissão e empresa</option>
                        <option value="4">Busca pela O.S</option>
                    </select>
                </div>
                <div class="col-md-2 mb-0">
                    <select class="form-control" name="status" id="status" value="" placeholder="Selecione o estado do pedido">
                        <option value="aberto">Busca Aberto</option>
                        <option value="fechado">Busca Fechado</option>
                        <option value="indefenido">Busca Indefinido</option>
                        <option value="em andamento">Busca Em andamanto</option>
                    </select>
                </div>
                <!--input box filtro buscar produto--------->
                <input type="text" id="query" name="produto" placeholder="Digite..." aria-label="Search through site content">
                <button type="submit">
                    <i class="icofont-search icofont-2x"></i>
                </button>
            </form>
            <div>
                <a href="{{route('pedido-saida.create')}}" class="btn-sm btn-success">
                    <i class="icofont-database-add"></i>
                    </span>
                    <span class="text">Criar novo pedido de saída</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <style>
                #formSearchingProducts {
                    background-color: white;
                    width:auto;
                    height: 44px;
                    border-radius: 5px;
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                }
             
                input {
                    all: unset;
                    font: 16px system-ui;
                    color: blue;
                    height: 100%;
                    width: 100%;
                    padding: 6px 10px;
                }

                ::placeholder {
                    color: blueviolet;
                    opacity: 0.9;
                }


                button {
                    all: unset;
                    cursor: pointer;
                    width: 44px;
                    height: 44px;
                }

                #tblPedidosSaida {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    background-color: rgb(211, 211, 211);
                    font-size: 20px;
                }

                thead {
                    background-color: rgb(229, 228, 226);
                }

                td,
                th {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 8px;
                    font-size: 15px;
                }

                tr:nth-child(even) {
                    background-color: #dddddd;
                }

                tr:hover {
                    background-color: rgb(169, 169, 169);
                }
            </style>
            <table class="" id="tblPedidosSaida">
                <thead>
                    <tr>
                        <th scope="col" class="th-title">Id</th>
                        <th scope="col" class="th-title">Data emissão</th>
                        <th scope="col" class="th-title">Data prevista</th>
                        <th scope="col" class="th-title">Empresa</th>
                        <th scope="col" class="th-title">Equipamento</th>
                        <th scope="col" class="th-title">Emissor</th>
                        <th scope="col" class="th-title">status</th>
                        <th scope="col" class="th-title">Os</th>
                        <th scope="col" class="th-title">operaçoes</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos_saida as $pedido_saida)
                    <tr>
                        <th scope="row">{{ $pedido_saida->id }}</td>
                        <td>{{ $pedido_saida->data_emissao }}</td>
                        <td>{{ $pedido_saida->data_prevista}}</td>
                        <td>{{ $pedido_saida->empresa->nome_fantasia}}</td>
                        <td>{{ $pedido_saida->equipamento->nome}}</td>
                        <td>{{ $pedido_saida->funcionarios->primeiro_nome}}</td>
                        <td>{{ $pedido_saida->status}}</td>
                        <td>{{ $pedido_saida->ordem_servico_id}}</td>
                        <td>
                            <div {{-- class="div-op" --}} class="btn-group btn-group-actions visible-on-hover">


                                <a class=" btn btn-sm-template btn-outline-primary" href="{{route('pedido-saida.show', ['pedido_saida'=>$pedido_saida->id])}}">

                                    <i class="icofont-eye-alt"></i>
                                </a>

                                <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{route('pedido-saida-lista.index', ['pedido_saida'=>$pedido_saida->id])}}">
                                    <i class="icofont-list"></i></a>
                                    <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{route('pedido-saida.edit', ['pedido_saida'=>$pedido_saida->id])}}">
                                        <i class="icofont-ui-edit"></i> </a>
                                    <!--Condioçes para deletar-->
                                    <form id="form_{{$pedido_saida->id }}" method="post" action="{{route('pedido-saida.destroy', [$pedido_saida->id])}}">
                                        @method('POST')
                                        @csrf
                                    </form>
                                    <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick=" DeletarPedidoSaida()">
                                        <i class="icofont-ui-delete"></i>
                                        <script>
                                            function DeletarPedidoSaida() {
                                                var x;
                                                var r = confirm("Deseja deletar a pedido de saida?");
                                                if (r == true) {

                                                    document.getElementById('form_header{{$pedido_saida->id }}').submit()
                                                } else {
                                                    x = "Você pressionou Cancelar!";
                                                }
                                                document.getElementById("demo").innerHTML = x;
                                            }

                                            function PedidosSaidaHeader() {
                                                var x;
                                                var r = confirm(" Pedido de saida header?");
                                                if (r == true) {

                                                    document.getElementById('form_header{{$pedido_saida->id }}').submit()
                                                } else {
                                                    x = "Você pressionou Cancelar!";
                                                }
                                                document.getElementById("demo").innerHTML = x;
                                            }
                                        </script>
                                    </a>
                                    <!------------------------------>
                            </div>
                        </td>


                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>

</main>
@endsection