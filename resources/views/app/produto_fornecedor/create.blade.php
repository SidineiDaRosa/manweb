@extends('app.layouts.app')

@section('content')
    <main class="content">
        <div class="card">
            <div class="card-header pb-2">
                <p class="mb-0">Produtos Fronecidos por cada fornecedor</p>

            </div>
            <div class="card-header justify-content-left py-0">
                <a href="{{ route('produto.index') }}" class="btn">
                    Listagem
                </a>
            </div>

            <div class="card-header justify-content-left pt-4">

                <div class="row mb-3">
                    <label for="fornecedor_id" class="col-md-4 col-form-label text-md-end">Selecione o Fornecedor</label>

                    <div class="col-md-6">
                        <form action="{{ route('produto-fornecedor.show') }}" method="POST" id="form_fornecedor">

                            @csrf
                            <select name="fornecedor_id" id="" class="form-control"
                                onchange="document.getElementById('form_fornecedor').submit()">
                                <option value=""> --Selecione O fornecedor--</option>
                                @foreach ($fornecedores as $forn)
                                    <option value="{{ $forn->id }}"
                                        {{ isset($fornecedor) ? ($fornecedor == $forn->id ? 'selected' : '') : '' }}>
                                        {{ $forn->nome_fantasia }}</option>
                                @endforeach
                            </select>
                        </form>

                    </div>
                </div>
                @isset($fornecedor)
                    <form action="{{ route('produto-fornecedor.store', ['fornecedor'=>$fornecedor]) }}" method="POST">
                @else
                    <form action="" method="POST">
                @endisset
                @csrf
                        <div class="row mb-3">
                            <label for="produto_id" class="col-md-4 col-form-label text-md-end">Produto</label>

                            <div class="col-md-6">
                                <select name="produto_id" id="" class="form-control" required>
                                    <option value=""> --Selecione o Produto--</option>
                                    @foreach ($produtos as $produto)
                                        <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                                    @endforeach
                                </select>
                               
                                    {{isset($erro) ? $erro : ''}}
                               
                            </div>
                        </div>


                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Adicionar Produto</button>

                            </div>

                        </div>
                    </form>
            </div>

            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Excluir</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (isset($produtos_fornecedor))
                            @foreach ($produtos_fornecedor as $produto_fornecedor)
                                <tr>
                                    <th scope="row">{{ $produto_fornecedor->id }}</td>
                                    <td>{{ $produto_fornecedor->produto->nome }}</td>
                                    <td>{{ $produto_fornecedor->produto->marca->nome }}</td>
                                    <td>
                                        <form id="form_{{ $produto_fornecedor->id }}" method="post"
                                            action="{{ route('produto-fornecedor.destroy', [
                                                'produtoFornecedor' => $produto_fornecedor->id,
                                                'fornecedor' => $fornecedor,
                                            ]) }}">

                                            @method('DELETE')
                                            @csrf
                                            <a href="#"
                                                onclick="document.getElementById('form_{{ $produto_fornecedor->id }}').submit()">Excluir</a>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>


            </div>

        </div>

    </main>
@endsection
