@extends('app.layouts.basico')

@section('titulo', 'Operacao')

@section('conteudo')

    <div class="conteudo-pagina">

        <div class="titulo-pagina-2">
            <p>Listagem de Opercaçoes de Máquinas</p>
        </div>

        <div class="menu">
            <ul>
                <li><a href="{{ route('operacao.create') }}">Novo</a></li>
                <li><a href="">Consulta</a></li>
            </ul>
        </div>

        <div class="informacao-pagina">
            <div style="width: 90%; margin-left: auto; margin-right: auto;">
                <table border="1" width="100%">
                    <thead>
                        <tr>
                            <th>Máquina</th>
                            <th>Produto</th>
                            <th>Qtd_Produção</th>
                            <th>Data</th>
                            <th>Inicio</th>
                            <th>Fim</th>
                            <th>Visualizar</th>
                            <th>Editar</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($operacoes as $operacao)
                            <tr>
                                <td>{{ $operacao->maquina->nome }}</td>
                                <td>{{ $operacao->produto->nome }}</td>
                                <td>{{ $operacao->qtd_producao }}</td>
                                <td>{{ $operacao->data }}</td>
                                <td>{{ $operacao->hora_inicio }}</td>
                                <td>{{ $operacao->hora_fim }}</td>
                                <td><a href="{{ route('operacao.show', ['operacao' => $operacao->id]) }}">Visualizar</a></td>
                                <td><a href="{{ route('operacao.edit', ['operacao' => $operacao->id]) }}">Editar</a></td>
                                <td>
                                    <form id="form_{{ $operacao->id }}" method="post"
                                        action="{{ route('operacao.destroy', ['operacao' => $operacao->id]) }}">
                                        @method('DELETE')
                                        @csrf
                                        <a href="#"
                                            onclick="document.getElementById('form_{{ $operacao->id }}').submit()">Excluir</a>
                                    </form>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
