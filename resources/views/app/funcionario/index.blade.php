@extends('app.layouts.app')

@section('content')
<main class="content">

    <h2 style="margin-bottom: 20px;">Lista de Funcionários</h2>

    <a href="{{ route('funcionarios.create') }}"
        style="padding: 8px 14px; background: #28a745; color: white; text-decoration: none; border-radius: 5px;">
        + Novo Funcionário
    </a>

    <table style="width:100%; margin-top:20px; border-collapse: collapse;">
        <thead>
            <tr style="background:#f0f0f0;">
                <th style="padding:10px; border:1px solid #ccc;">#</th>
                <th style="padding:10px; border:1px solid #ccc;">Primeiro Nome</th>
                <th style="padding:10px; border:1px solid #ccc;">Último Nome</th>
                <th style="padding:10px; border:1px solid #ccc;">CPF</th>
                <th style="padding:10px; border:1px solid #ccc;">Função</th>
                <th style="padding:10px; border:1px solid #ccc; width:180px;">Ações</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($funcionarios as $func)
            <tr>
                <td style="padding:10px; border:1px solid #ccc;">{{ $loop->iteration }}</td>
                <td style="padding:10px; border:1px solid #ccc;">{{ $func->primeiro_nome }}</td>
                <td style="padding:10px; border:1px solid #ccc;">{{ $func->ultimo_nome }}</td>
                <td style="padding:10px; border:1px solid #ccc;">{{ $func->cpf }}</td>
                <td style="padding:10px; border:1px solid #ccc;">{{ $func->funcao }}</td>

                <td style="padding:10px; border:1px solid #ccc; text-align:center;">

                    {{-- VISUALIZAR --}}
                    <a href="{{ route('funcionarios.show', $func->id) }}"
                        style="padding:6px 10px; background:#17a2b8; color:white; border-radius:4px; text-decoration:none;">
                        Ver
                    </a>

                    {{-- EDITAR --}}
                    <a href="{{ route('funcionarios.edit', $func->id) }}"
                        style="padding:6px 10px; background:#ffc107; color:white; border-radius:4px; text-decoration:none;">
                        Editar
                    </a>

                    {{-- EXCLUIR --}}
                    <form action="{{ route('funcionarios.destroy', $func->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            onclick="return confirm('Deseja excluir este funcionário?')"
                            style="padding:6px 10px; background:#dc3545; color:white; border:none; border-radius:4px; cursor:pointer;">
                            Excluir
                        </button>
                    </form>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</main>
@endsection
