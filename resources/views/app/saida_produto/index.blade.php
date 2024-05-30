@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div> Lista saída de produtos</div>
            <div>
                <a href="{{ route('produto.index') }}" class="btn btn-sm btn-primary">
                    Lista de produtos
                </a>

            </div>
            <div class="card-body">

            </div>
        </div>
        <table class="table-template table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th scope="col" class="th-title">Id</th>
                    <th scope="col" class="th-title">pedido_saida_id</th>
                    <th scope="col" class="th-title">Produto</th>
                    <th scope="col" class="th-title">Quantidade</th>
                    <th scope="col" class="th-title">Data</th>
                    <th scope="col" class="th-title">Patrmônio</th>
                    <th class="th-title"></th>
                    <th class="th-title"></th>
                    <th class="th-title"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($saidas_produtos as $saida_produto)
                <tr>
                    <th scope="row">{{$saida_produto->id }}</td>
                    <td>{{ $saida_produto->pedidos_saida_id}}</td>
                    <td>{{ $saida_produto->produto->nome }}</td>
                    <td>{{ $saida_produto->unidade_medida }}</td>
                    <td>{{ $saida_produto->quantidade }}</td>
                    <td>{{ $saida_produto->data }}</td>
                    <td>{{ $saida_produto->equipamento->nome}}</td>
                    <td>
                        <div {{-- class="div-op" --}} class="btn-group btn-group-actions visible-on-hover">
                            <a class="btn btn-sm-template btn-outline-primary" href="{{ route('mostra-produto.show',[1]) }}">                          
                            <i class="icofont-eye-alt"></i>
                            </a>

                        </div>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>

</main>
@endsection