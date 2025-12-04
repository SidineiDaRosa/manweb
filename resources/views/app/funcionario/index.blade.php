@extends('app.layouts.app')

@section('content')
<main class="content">
    <div style="margin-bottom: 30px;">
        <h2 style="margin-bottom: 20px;">Lista de Funcionários</h2>
        
        <a href="{{ route('funcionarios.create') }}"
           style="padding: 10px 16px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; display: inline-block;">
            + Novo Funcionário
        </a>
    </div>

    {{-- Cabeçalho --}}
    <div style="display: grid; grid-template-columns: 50px 1fr 1fr 1fr 1fr 180px; 
                background: #f0f0f0; padding: 12px; border: 1px solid #ccc; font-weight: bold;">
        <div>#</div>
        <div>Primeiro Nome</div>
        <div>Último Nome</div>
        <div>CPF</div>
        <div>Função</div>
        <div style="text-align: center;">Ações</div>
    </div>

    {{-- Lista de Funcionários --}}
    @foreach ($funcionarios as $func)
    <div style="display: grid; grid-template-columns: 50px 1fr 1fr 1fr 1fr 180px;
                padding: 12px; border: 1px solid #ccc; border-top: none;
                align-items: center;">
        
        <div>{{ $loop->iteration }}</div>
        <div>{{ $func->primeiro_nome }}</div>
        <div>{{ $func->ultimo_nome }}</div>
        <div>{{ $func->cpf }}</div>
        <div>{{ $func->funcao }}</div>
        
        {{-- Ações --}}
        <div style="display: flex; gap: 8px; justify-content: center;">
            {{-- VISUALIZAR --}}
            <a href="{{ route('funcionarios.show', $func->id) }}"
               style="padding: 6px 12px; background: #17a2b8; color: white; 
                      border-radius: 4px; text-decoration: none; font-size: 14px;">
                Ver
            </a>

            {{-- EDITAR --}}
            <a href="{{ route('funcionarios.edit', $func->id) }}"
               style="padding: 6px 12px; background: #ffc107; color: white; 
                      border-radius: 4px; text-decoration: none; font-size: 14px;">
                Editar
            </a>

            {{-- EXCLUIR --}}
            <form action="{{ route('funcionarios.destroy', $func->id) }}" method="POST" 
                  style="display: inline; margin: 0;">
                @csrf
                @method('DELETE')
                <button type="submit"
                        onclick="return confirm('Deseja excluir este funcionário?')"
                        style="padding: 6px 12px; background: #dc3545; color: white; 
                               border: none; border-radius: 4px; cursor: pointer; font-size: 14px;">
                    Excluir
                </button>
            </form>
        </div>
    </div>
    @endforeach

    {{-- Mensagem caso não haja funcionários --}}
    @if($funcionarios->isEmpty())
    <div style="text-align: center; padding: 40px; border: 1px solid #ccc; border-top: none;">
        Nenhum funcionário cadastrado.
    </div>
    @endif
</main>
@endsection