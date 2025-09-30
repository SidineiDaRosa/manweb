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

    <!-- Lista de Equipamentos em Cards Responsivos -->
    <div class="row mt-4" id="equipamentos-container">
        @foreach ($equipamentos as $equipamento)
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100 equipamento-card">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">#{{ $equipamento->id }} - {{ $equipamento->nome }}</h6>
                        <span>{{ $equipamento->Empresa->razao_social }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="equipamento-info">
                        <p class="card-text"><strong>Descrição:</strong> {{ $equipamento->descricao }}</p>
                        <p class="card-text"><strong>Marca:</strong> {{ $equipamento->marca->nome }}</p>
                        <p class="card-text"><strong>Equipamento Pai:</strong> {{ $equipamento->equip_pai->nome ?? '-' }}</p>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="btn-group w-100" role="group">
                        <!-- Ver -->
                        <a class="btn btn-sm btn-outline-primary flex-fill"
                            href="{{ route('equipamento.show', ['equipamento' => $equipamento->id]) }}"
                            data-bs-toggle="tooltip" title="Visualizar">
                            <i class="icofont-eye-alt"></i>
                            <span class="d-none d-md-inline">Ver</span>
                        </a>

                        <!-- Editar -->
                        <a class="btn btn-sm btn-outline-success flex-fill @can('user') disabled @endcan"
                            href="{{ route('equipamento.edit', ['equipamento' => $equipamento->id]) }}"
                            data-bs-toggle="tooltip" title="Editar">
                            <i class="icofont-ui-edit"></i>
                            <span class="d-none d-md-inline">Editar</span>
                        </a>

                        <!-- Deletar -->
                        <form id="form_{{ $equipamento->id }}"
                            method="post"
                            action="{{ route('equipamento.destroy', ['equipamento' => $equipamento->id]) }}">
                            @method('DELETE')
                            @csrf
                        </form>
                        <a class="btn btn-sm btn-outline-danger flex-fill @can('user') disabled @endcan"
                            href="#" onclick="DeletarEquipamento({{ $equipamento->id }})"
                            data-bs-toggle="tooltip" title="Excluir">
                            <i class="icofont-ui-delete"></i>
                            <span class="d-none d-md-inline">Excluir</span>
                        </a>
                    </div>

                    <div class="btn-group w-100 mt-2" role="group">
                        <!-- Criar OS -->
                        <a class="btn btn-sm btn-outline-primary flex-fill"
                            href="{{route('ordem-servico.create', ['equipamento'=>$equipamento->id,'empresa'=>2])}}"
                            data-bs-toggle="tooltip" title="Criar Ordem de Serviço">
                            <i class="bi bi-plus-circle"></i>
                            Criar O. S.</span>
                            <span class="d-md-none">OS</span>
                        </a>

                        <!-- Pedido de compra -->
                        <a class="btn btn-sm btn-outline-success flex-fill"
                            href="{{route('pedido-compra.create',['equipamento_id' => $equipamento->id])}}"
                            data-bs-toggle="tooltip" title="Criar Pedido de Compra">
                            <span class="d-none d-md-inline">
                            <i class="bi bi-plus-circle"></i>    
                            Ped. Compra</span>
                            <span class="d-md-none">PC</span>
                        </a>

                        <!-- Filtro de OS fechadas -->
                        <form action="{{ 'filtro-os' }}" method="POST" class="d-inline-flex flex-fill">
                            @csrf
                            <input type="hidden" name="patrimonio_id" value="{{$equipamento->id}}">
                            <input type="hidden" name="empresa_id" value="2">
                            <input type="hidden" name="data_inicio" value="fechado">
                            <input type="hidden" name="data_fim" value="fechado">
                            <input type="hidden" name="situacao" value="fechado">
                            <input type="hidden" name="tipo_consulta" value="5">
                            <button type="submit" class="btn btn-sm btn-outline-success w-100"
                                data-bs-toggle="tooltip" title="OS Fechadas">
                                <span class="d-none d-md-inline">
                                <i class="bi bi-list-check"></i>    
                                O.S Concluídas.</span>
                                <span class="d-md-none">Fech.</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Visualização em Lista (alternativa) -->
    <div class="d-none" id="list-view-container">
        @foreach ($equipamentos as $equipamento)
        <div class="card mb-3 equipamento-list-item">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-12 col-md-3">
                        <h6 class="card-title">#{{ $equipamento->id }} - {{ $equipamento->nome }}</h6>
                        <span class="badge bg-secondary">{{ $equipamento->Empresa->razao_social }}</span>
                    </div>
                    <div class="col-12 col-md-4">
                        <p class="mb-1"><strong>Marca:</strong> {{ $equipamento->marca->nome }}</p>
                        <p class="mb-1"><strong>Equip. Pai:</strong> {{ $equipamento->equip_pai->nome ?? '-' }}</p>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="btn-group btn-group-sm flex-wrap" role="group">
                            <a class="btn btn-outline-primary" href="{{ route('equipamento.show', ['equipamento' => $equipamento->id]) }}">
                                <i class="icofont-eye-alt"></i>
                            </a>
                            <a class="btn btn-outline-success @can('user') disabled @endcan" href="{{ route('equipamento.edit', ['equipamento' => $equipamento->id]) }}">
                                <i class="icofont-ui-edit"></i>
                            </a>
                            <a class="btn btn-outline-danger @can('user') disabled @endcan" href="#" onclick="DeletarEquipamento({{ $equipamento->id }})">
                                <i class="icofont-ui-delete"></i>
                            </a>
                            <a class="btn btn-outline-primary" href="{{route('ordem-servico.create', ['equipamento'=>$equipamento->id,'empresa'=>2])}}">
                                <i class="bi bi-plus-circle"></i>
                                OS
                            </a>
                            <a class="btn btn-outline-success" href="{{route('pedido-compra.create',['equipamento_id' => $equipamento->id])}}">
                                PC
                            </a>
                            <form action="{{ 'filtro-os' }}" method="POST" class="d-inline-block">
                                @csrf
                                <input type="hidden" name="patrimonio_id" value="{{$equipamento->id}}">
                                <input type="hidden" name="empresa_id" value="2">
                                <input type="hidden" name="data_inicio" value="fechado">
                                <input type="hidden" name="data_fim" value="fechado">
                                <input type="hidden" name="situacao" value="fechado">
                                <input type="hidden" name="tipo_consulta" value="5">
                                <button type="submit" class="btn btn-outline-success">
                                    Fech.
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Controles de Visualização -->
    <div class="d-flex justify-content-end mt-3">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-secondary active" id="card-view-btn">
                <i class="icofont-card"></i> Visualização em Cards
            </button>
            <button type="button" class="btn btn-outline-secondary" id="list-view-btn">
                <i class="icofont-list"></i> Visualização em Lista
            </button>
        </div>
    </div>
</main>

<script>
    function DeletarEquipamento(id) {
        if (confirm("Deseja deletar o equipamento?")) {
            document.getElementById('form_' + id).submit();
        }
    }

    // Controle de visualização (cards vs lista)
    document.addEventListener('DOMContentLoaded', function() {
        const cardViewBtn = document.getElementById('card-view-btn');
        const listViewBtn = document.getElementById('list-view-btn');
        const cardContainer = document.getElementById('equipamentos-container');
        const listContainer = document.getElementById('list-view-container');

        cardViewBtn.addEventListener('click', function() {
            cardContainer.classList.remove('d-none');
            listContainer.classList.add('d-none');
            cardViewBtn.classList.add('active');
            listViewBtn.classList.remove('active');
        });

        listViewBtn.addEventListener('click', function() {
            cardContainer.classList.add('d-none');
            listContainer.classList.remove('d-none');
            cardViewBtn.classList.remove('active');
            listViewBtn.classList.add('active');
        });

        // Inicializar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>

<style>
    .equipamento-card {
        transition: transform 0.2s;
    }

    .equipamento-card:hover {
        transform: translateY(-5px);
    }

    .equipamento-info {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    @media (max-width: 768px) {
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .card-header-template {
            flex-direction: column;
            gap: 15px;
        }

        .card-header-template>div {
            width: 100%;
            justify-content: center;
        }
    }
</style>

@endsection