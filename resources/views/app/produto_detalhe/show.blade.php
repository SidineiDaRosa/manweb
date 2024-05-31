@extends('app.layouts.basico')

@section('titulo', 'Vusualizar Produtos')

@section('conteudo')

    <div class="conteudo-pagina">
        <div class="titulo-pagina-2">
            <p>Produto - Adicionar</p>
        </div>

        <div class="menu">
            <ul>
                <li><a href="{{ route('produto.index') }}">Voltar</a></li>
                <li><a href="">Consulta</a></li>
            </ul>

        </div>

        <div class="infornacao-pagina">

            <div style=" width:30%; margin-left:auto; margin-right: auto;">
                
                <table border="1" style="text-align:left;">
                    <tr>
                        <td>ID</td>
                        <td>{{$produto->id}}</td>
                    </tr>
                    <tr>
                        <td>Nome</td>
                        <td>{{$produto->nome}}</td>
                    </tr>
                    <tr>
                        <td>DESCRIÇÂO</td>
                        <td>{{$produto->descricao}}</td>
                    </tr>
                    <tr>
                        <td>PESO</td>
                        <td>{{$produto->peso}}</td>
                    </tr>
                    <tr>
                        <td>UNIDADE</td>
                        <td>{{$produto->unidade_id}}</td>
                    </tr>
                </table>
            </div>

        </div>
    </div>

@endsection
