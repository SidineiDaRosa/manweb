@extends('app.layouts.app')

@section('content')
<main class="content" style="display:flex; justify-content:center; align-items:center; min-height:80vh; flex-direction:column;">

    <h2 style="margin-bottom: 20px;">Cadastrar Novo Funcionário</h2>

    <a href="{{ route('funcionarios.index') }}"
        style="padding: 8px 14px; background: #6c757d; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 20px;">
        ← Voltar para Lista
    </a>

    <form action="{{ route('funcionarios.store') }}" method="POST" style="width:100%; max-width:600px; background:#f8f9fa; padding:20px; border-radius:8px; border:1px solid #ccc;">
        @csrf

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
                value="{{ old($field) }}"
                style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
            @error($field)
                <span style="color:red; font-size:0.9em;">{{ $message }}</span>
            @enderror
        </div>
        @endforeach

        <div style="text-align:center; margin-top:15px;">
            <button type="submit"
                style="padding:10px 15px; background:#28a745; color:white; border:none; border-radius:5px; cursor:pointer;">
                Salvar
            </button>
        </div>

    </form>

</main>
@endsection
