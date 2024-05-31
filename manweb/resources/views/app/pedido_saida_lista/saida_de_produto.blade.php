@extends('app.layouts.app')
@section('content')
<!DOCTYPE html>
<html>

<head>
    <title>Tabela Responsiva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @foreach($equipamentos as $equipamento_for)
    @endforeach
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Produto</th>
                        <th scope="col" class="th-title">Id da Saída</th>
                        <th scope="col" class="th-title">Produto ID</th>
                        <th scope="col" class="th-title">Pedido Saída ID</th>
                        <th scope="col" class="th-title">Data</th>
                        <th scope="col" class="th-title">Patrimônio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produto as $produto_f)
                    @foreach($saidas_do_produto as $index => $saidas_do_produto_f)
                    @if($produto_f->id === $saidas_do_produto_f->produto_id)
                    <tr class="{{ $index % 2 === 0 ? 'table-light' : 'table-dark' }}">
                        <td>{{$produto_f->nome}}</td>
                        <td>{{$saidas_do_produto_f->id}}</td>
                        <td>{{$saidas_do_produto_f->produto_id}}
                            <a title="Clicar para visualisar o produto" class="btn btn-sm-template btn-outline-primary" href="{{ route('produto.show', ['produto' => $saidas_do_produto_f->produto_id]) }}">
                                <i class="icofont-eye-alt"></i>
                            </a>
                        </td>
                        <td>{{$saidas_do_produto_f->pedidos_saida_id}}
                            <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{route('pedido-saida-lista.index', ['pedido_saida'=>$saidas_do_produto_f->pedidos_saida_id])}}">
                                <i class="icofont-list"></i></a>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($saidas_do_produto_f->data)->format('d/m/Y') }}</td>
                        <td>{{$saidas_do_produto_f->equipamento->nome}}</td>
                    </tr>
                    @endif
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>