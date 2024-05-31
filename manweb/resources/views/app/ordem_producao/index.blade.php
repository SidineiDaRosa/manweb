@extends('app.layouts.app')

@section('content')
    <main class="content">
        <div class="card">
            <div class="card-header-template">
                <div>
                    LISTAGEM DE ORDEM DE PRODUÇÃO
                </div>
                <div>
                    <a class="btn btn-primary btn-sm" href="{{ route('ordem-producao.create') }}">NOVO</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table-template table-striped table-hover table-bordered mt-1">
                    <thead>
                        <tr>
                            <th scope="col" class="th-title-main">Id</th>
                            <th scope="col" class="th-title-main">equipamento</th>
                            <th scope="col" class="th-title-main">Produto</th>
                            <th scope="col" class="th-title-main">Quantidade de Produção</th>
                            <th scope="col" class="th-title-main">Data Inicial</th>
                            <th scope="col" class="th-title-main">Horímetro Final</th>
                            <th scope="col" class="th-title-main">Visualizar</th>
                            <th scope="col" class="th-title-main">Editar</th>
                            <th scope="col" class="th-title-main">Excluir</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($ordens_producoes as $ordem_producao)
                            <tr>
                                <th scope="row">{{ $ordem_producao->id }}</td>
                                <td>{{ $ordem_producao->equipamento->nome }}</td>
                                <td>{{ $ordem_producao->produto->nome }}</td>
                                <td>{{ $ordem_producao->quantidade_producao }}</td>
                                <td>{{ $ordem_producao->data_inicio }}</td>
                                <td>{{ $ordem_producao->horimetro_final }}</td>
                                <td><a href="{{ route('ordem-producao.show', ['ordem_producao' => $ordem_producao->id]) }}">Visualizar</a></td>
                                <td>
                                    <form id="form_{{ $ordem_producao->id }}" method="post"
                                        action="{{ route('ordem-producao.destroy', ['ordem_producao' => $ordem_producao->id]) }}">
                                        @method('DELETE')
                                        @csrf
                                        <a href="#"
                                            onclick="document.getElementById('form_{{ $ordem_producao->id }}').submit()">Excluir</a>
                                    </form>
                                </td>
                                <td><a href="{{ route('ordem-producao.edit', ['ordem_producao' => $ordem_producao->id]) }}">Editar</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


            </div>


        </div>


    </main>
@endsection
