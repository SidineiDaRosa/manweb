@extends('app.layouts.app')

@section('content')

<main class="content">

    <!-- Cabeçalho -->
    <div class="card-header-template d-flex justify-content-between align-items-center bg-secondary text-white p-3 rounded-top shadow-sm">
        
        <!-- Título -->
        <h5 class="mb-0 fw-bold">Lista de Equipamentos</h5>

        <!-- Botões à esquerda -->
        <div class="d-flex gap-2">
            <a href="{{ route('equipamento.create') }}" class="btn btn-outline-light">
                <i class="icofont-plus-circle"></i>
                <span>Novo Ativo/Equipamento</span>
            </a>
            <a class="btn btn-outline-light" href="{{ route('app.home') }}">
                <i class="icofont-dashboard"></i> Dashboard
            </a>
        </div>

        <!-- Formulário de busca -->
        <div class="w-100" style="max-width: 400px;">
            <form action="{{ route('equipamento.index', ['empresa' => 2]) }}">
                <div class="input-group">
                    <input type="hidden" name="empresa" value="{{ $empresa_id }}">
                    <input type="text" class="form-control" placeholder="Digite o nome parcial..." name="searching">
                    <button class="btn btn-light" type="submit">
                        Busca
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Tabela -->
    <div class="card-body shadow-sm bg-white rounded">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Marca</th>
                    <th>Equipamento Pai</th>
                    <th>Empresa</th>
                    <th class="text-center">Operações</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($equipamentos as $equipamento)
                <tr>
                    <td><strong>{{ $equipamento->id }}</strong></td>
                    <td>{{ $equipamento->nome }}</td>
                    <td>{{ $equipamento->descricao }}</td>
                    <td>{{ $equipamento->marca->nome }}</td>
                    <td>{{ $equipamento->equip_pai->nome ?? '-' }}</td>
                    <td>{{ $equipamento->Empresa->razao_social }}</td>

                    <td class="text-center">
                        <div class="btn-group">

                            <!-- Ver -->
                            <a class="btn btn-sm btn-outline-primary" 
                               href="{{ route('equipamento.show', ['equipamento' => $equipamento->id]) }}">
                                <i class="icofont-eye-alt"></i>
                            </a>

                            <!-- Editar -->
                            <a class="btn btn-sm btn-outline-success @can('user') disabled @endcan"
                               href="{{ route('equipamento.edit', ['equipamento' => $equipamento->id]) }}">
                                <i class="icofont-ui-edit"></i>
                            </a>

                            <!-- Deletar -->
                            <form id="form_{{ $equipamento->id }}" 
                                  method="post" 
                                  action="{{ route('equipamento.destroy', ['equipamento' => $equipamento->id]) }}">
                                @method('DELETE')
                                @csrf
                            </form>
                            <a class="btn btn-sm btn-outline-danger @can('user') disabled @endcan"
                               href="#" onclick="DeletarEquipamento({{ $equipamento->id }})">
                                <i class="icofont-ui-delete"></i>
                            </a>

                            <!-- Criar OS -->
                            <a class="btn btn-sm btn-outline-primary" 
                               href="{{route('ordem-servico.create', ['equipamento'=>$equipamento->id,'empresa'=>2])}}"
                               title="Criar nova O.S.">
                                OS
                            </a>

                            <!-- Pedido de compra -->
                            <a class="btn btn-sm btn-outline-success" 
                               href="{{route('pedido-compra.create',['equipamento_id' => $equipamento->id])}}"
                               title="Criar novo Pedido de Compra">
                                Ped. Comp.
                            </a>

                            <!-- Filtro de OS fechadas -->
                            <form action="{{ 'filtro-os' }}" method="POST" class="d-inline-block">
                                @csrf
                                <input type="hidden" name="patrimonio_id" value="{{$equipamento->id}}">
                                <input type="hidden" name="empresa_id" value="2">
                                <input type="hidden" name="data_inicio" value="fechado">
                                <input type="hidden" name="data_fim" value="fechado">
                                <input type="hidden" name="situacao" value="fechado">
                                <input type="hidden" name="tipo_consulta" value="5">
                                <button type="submit" class="btn btn-sm btn-outline-success">
                                    O.S Fechadas
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</main>

<script>
    function DeletarEquipamento(id) {
        if (confirm("Deseja deletar o equipamento?")) {
            document.getElementById('form_' + id).submit();
        }
    }
</script>

@endsection
