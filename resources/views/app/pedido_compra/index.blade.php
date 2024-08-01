@extends('app.layouts.app')

@section('content')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<main class="content">
    <div class="card">
        <div class="card-header-template" id="frm-cabecalho">
            <style>
                #frm-cabecalho {
                    display: flex;
                    justify-content: center;
                }
            </style>

            <form action="{{route('pedido-compra.index')}}">

                <div class="form-row">
                    <div class="col-md-4">
                        <label for="situacao">Situação:</label>
                        <select class="form-control" name="situacao" id="situacao" value="">
                            <option value="aberto">aberto</option>
                            <option value="fechado">fechado</option>
                            <option value="indefinido">indefinido</option>
                            <option value="cancelado">cancelado</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="data_inicio">Data inicial:</label>
                        <input type="date" class="form-control" name="data_inicio" id="data_inicio" >
                    </div>
                    <div class="col-md-4">
                        <label for="data_inicio">Data final:</label>
                        <input type="date" class="form-control" name="data_fim" id="data_fim">
                    </div>
                    <div class="col-md-4">
                        <label for="data_inicio">Buscar:</label>
                        <input type="submit" value="buscar">
                    </div>

                </div>
            </form>

        </div>
        <div class="card-body">
            <table class="table-template table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="th-title">Id</th>
                        <th scope="col" class="th-title">Data emissão</th>
                        <th scope="col" class="th-title">Data prevista</th>
                        <th scope="col" class="th-title">Data Fechamento</th>
                        <th scope="col" class="th-title">Equipamento</th>
                        <th scope="col" class="th-title">Emissor_id</th>
                        <th scope="col" class="th-title">status</th>
                        <th scope="col" class="th-title">operações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos_compra as $pedido_compra)
                    <tr>
                        <th scope="row">{{ $pedido_compra->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($pedido_compra->data_emissao)->format('d/m/Y') }} {{ $pedido_compra->hora_emissao }}</td>
                        <td>{{ \Carbon\Carbon::parse($pedido_compra->data_prevista)->format('d/m/Y') }} {{ $pedido_compra->hora_prevista}}</td>
                        <td>{{ \Carbon\Carbon::parse($pedido_compra->data_fechamento)->format('d/m/Y') }}</td>
                        <td>{{ $pedido_compra->equipamento->nome}}</td>
                        <td>{{ $pedido_compra->funcionarios->id}}</td>
                        <td>{{ $pedido_compra->status}}</td>
                        <td>
                            <div {{-- class="div-op" --}} class="btn-group btn-group-actions visible-on-hover">
                                <a class="btn btn-sm-template btn-outline-primary" href="{{route('pedido-compra-lista.index', ['numpedidocompra'=>$pedido_compra->id ])}}">
                                    <i class="icofont-eye-alt"></i>
                                </a>
                                <a class="btn btn-sm-template btn-outline-primary" href="{{ route('pedido-compra.edit', ['pedido_compra' => $pedido_compra->id]) }}">
                                    <i class="icofont-ui-edit"></i>
                                </a>
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