@extends('app.layouts.app')

@section('titulo', 'Empresas')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div class="d-flex justify-content-between align-items-center w-100">
                <h5 class="mb-0"><i class="icofont-company me-2"></i>Listagem de Empresas</h5>

                <div class="d-flex gap-3 align-items-center">
                    <!-- Formulário de Busca -->
                    <!-- Formulário de Busca -->
                    <form action="{{ route('empresas.filtro') }}" method="POST" class="search-form">
                        @csrf
                        <div class="input-group">
                            <input type="text"
                                class="form-control form-control-sm"
                                name="empresa1"
                                placeholder="Buscar empresa..."
                                aria-label="Buscar empresa"
                                style="min-width: 250px;">
                            <button class="btn btn-template btn-sm" type="submit">
                                <i class="icofont-search"></i>
                            </button>
                        </div>
                    </form>


                    <!-- Botão Nova Empresa -->
                    <a class="btn btn-bg-template btn-outline-primary btn-sm d-flex align-items-center"
                        href="{{ route('empresas.create') }}">
                        <i class="icofont-plus me-1"></i>
                        Nova Empresa
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if($empresas->isEmpty())
            <div class="text-center py-5">
                <i class="icofont-company icofont-3x text-muted mb-3"></i>
                <p class="text-muted">Nenhuma empresa encontrada</p>
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered">
                    <thead class="bg-template text-white">
                        <tr>
                            <th width="50">ID</th>
                            <th>Razão Social</th>
                            <th>Nome Fantasia</th>
                            <th>CNPJ</th>
                            <th>Insc. Estadual</th>
                            <th>Cidade</th>
                            <th width="150" class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($empresas as $empresa)
                        <tr>
                            <td class="text-center">{{ $empresa->id }}</td>
                            <td>{{ $empresa->razao_social }}</td>
                            <td>{{ $empresa->nome_fantasia }}</td>
                            <td>{{ $empresa->cnpj }}</td>
                            <td>{{ $empresa->insc_estadual }}</td>
                            <td>{{ $empresa->cidade }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('equipamento.index', ['empresa' => $empresa->id]) }}"
                                        class="btn btn-sm btn-success d-flex align-items-center"
                                        title="Ver equipamentos">
                                        <i class="icofont-search me-1"></i>
                                        Equipamentos
                                    </a>

                                    <!-- Adicione mais ações se necessário -->
                                    <!--
                                        <a href="{{ route('empresas.edit', $empresa->id) }}" 
                                           class="btn btn-sm btn-primary" 
                                           title="Editar">
                                            <i class="icofont-edit"></i>
                                        </a>
                                        -->
                                    <a href="{{ route('empresas.show', $empresa->id) }}"
                                        class="btn btn-sm btn-primary"
                                        title="Editar">
                                        <i class="icofont-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @endif
        </div>
    </div>
</main>

<style>
    .search-form .input-group {
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .search-form input {
        border-right: none;
        border-color: #dee2e6;
    }

    .search-form input:focus {
        box-shadow: none;
        border-color: #dee2e6;
    }

    .search-form button {
        background-color: #f8f9fa;
        border-left: none;
        transition: all 0.3s ease;
    }

    .search-form button:hover {
        background-color: #e9ecef;
    }

    .table th {
        font-weight: 600;
        font-size: 0.9rem;
        padding: 12px 8px;
    }

    .table td {
        padding: 10px 8px;
        vertical-align: middle;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    /* Responsividade */
    @media (max-width: 768px) {
        .card-header-template .d-flex {
            flex-direction: column;
            gap: 15px;
        }

        .search-form .input-group {
            width: 100%;
        }

        .search-form input {
            min-width: unset !important;
        }

        .table-responsive {
            font-size: 0.85rem;
        }

        .btn-sm {
            font-size: 0.8rem;
            padding: 0.2rem 0.4rem;
        }
    }
</style>
@endsection