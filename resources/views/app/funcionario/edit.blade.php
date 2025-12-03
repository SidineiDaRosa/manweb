@extends('app.layouts.app')

@section('content')
<main class="content">

    <h2 style="margin-bottom: 20px;">Editar Funcionário</h2>

    <a href="{{ route('funcionarios.index') }}"
        style="padding: 8px 14px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px;">
        ← Voltar para Lista
    </a>

    <form action="{{ route('funcionarios.update', $funcionario->id) }}" method="POST" style="margin-top:20px; max-width:600px;">
        @csrf
        @method('PUT')

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
            <label for="{{ $field }}" style="display:block; margin-bottom:5px;">{{ $label }}:</label>
            <input type="{{ $field == 'user' ? 'number' : 'text' }}" name="{{ $field }}" id="{{ $field }}"
                value="{{ old($field, $funcionario->$field) }}"
                style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            @error($field)
                <span style="color:red; font-size:0.9em;">{{ $message }}</span>
            @enderror
        </div>
        @endforeach

        <button type="submit"
            style="padding:10px 15px; background:#ffc107; color:white; border:none; border-radius:5px; cursor:pointer;">
            Atualizar
        </button>

    </form>

</main>
@endsection
