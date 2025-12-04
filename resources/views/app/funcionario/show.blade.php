@extends('app.layouts.app')

@section('content')
<main class="content" style="display:flex; justify-content:center; align-items:center; min-height:80vh; flex-direction:column;">

    <h2 style="margin-bottom: 20px;">Detalhes do Funcionário</h2>

    <a href="{{ route('funcionarios.index') }}"
        style="padding: 8px 14px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 20px;">
        ← Voltar para Lista
    </a>

    <div style="width:100%; max-width:600px; border:1px solid #ccc; padding:20px; border-radius:8px; background:#f8f9fa;">
        @php
            $fields = [
                'primeiro_nome' => 'Primeiro Nome',
                'ultimo_nome' => 'Último Nome',
                'cpf' => 'CPF',
                'rg' => 'RG',
                'endereco' => 'Endereço',
                'num_casa' => 'Número da Casa',
                'bairro' => 'Bairro',
                'cidade' => 'Cidade',
                'uf' => 'UF',
                'funcao' => 'Função',
                'user' => 'ID do Usuário',
                'status' => 'Status',
            ];
        @endphp

        @foreach ($fields as $field => $label)
        <div style="margin-bottom:15px;">
            <strong>{{ $label }}:</strong>
            <span>{{ $funcionario->$field }}</span>
        </div>
        @endforeach

        <div style="margin-top:20px; text-align:center;">
            <a href="{{ route('funcionarios.edit', $funcionario->id) }}"
                style="padding:8px 14px; background:#007bff; color:white; text-decoration:none; border-radius:5px; margin-right:10px;">
                Editar
            </a>

            <form action="{{ route('funcionarios.destroy', $funcionario->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit"
                    style="padding:8px 14px; background:#dc3545; color:white; border:none; border-radius:5px; cursor:pointer;"
                    onclick="return confirm('Tem certeza que deseja excluir este funcionário?');">
                    Excluir
                </button>
            </form>
        </div>
    </div>

</main>
@endsection
