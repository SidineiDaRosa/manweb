@extends('app.layouts.app')

@section('titulo', 'Empresa')

@section('content')

<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>
                <i class="icofont-building-alt mr-2"></i>
                Visualizar Empresa
            </div>
            <div>
                <a href="{{ route('empresas.index') }}" class="btn btn-primary btn-sm">
                    <i class="icofont-list mr-1"></i>
                    LISTAGEM
                </a>
                <a href="{{ route('empresas.edit', $empresa->id) }}" class="btn btn-warning btn-sm ml-1">
                    <i class="icofont-edit mr-1"></i>
                    EDITAR
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Cabeçalho da Empresa -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <div class="company-icon bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="icofont-building-alt text-white" style="font-size: 28px;"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="mb-0">{{ $empresa->nome_fantasia }}</h2>
                            <p class="text-muted mb-0">{{ $empresa->razao_social }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <div class="badge badge-secondary p-2">
                        <i class="icofont-id mr-1"></i>
                        ID: {{ $empresa->id }}
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Informações Principais -->
                <div class="col-md-6">
                    <div class="card border-light mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="icofont-info-circle mr-2"></i>
                                Informações Principais
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="info-item mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="icofont-id-card text-primary mr-3 mt-1"></i>
                                    <div>
                                        <small class="text-muted">CNPJ</small>
                                        <p class="mb-0 font-weight-bold">{{ $empresa->cnpj }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="info-item mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="icofont-paper text-primary mr-3 mt-1"></i>
                                    <div>
                                        <small class="text-muted">Inscrição Estadual</small>
                                        <p class="mb-0">{{ $empresa->insc_estadual ?: 'Não informado' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="info-item mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="icofont-ui-call text-primary mr-3 mt-1"></i>
                                    <div>
                                        <small class="text-muted">Telefone</small>
                                        <p class="mb-0">{{ $empresa->telefone ?: 'Não informado' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="info-item mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="icofont-email text-primary mr-3 mt-1"></i>
                                    <div>
                                        <small class="text-muted">E-mail</small>
                                        <p class="mb-0">{{ $empresa->email ?: 'Não informado' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="d-flex align-items-start">
                                    <i class="icofont-web text-primary mr-3 mt-1"></i>
                                    <div>
                                        <small class="text-muted">Site</small>
                                        @if($empresa->site)
                                            @php
                                                $site = $empresa->site;
                                                if ($site && !Str::startsWith($site, ['http://', 'https://'])) {
                                                    $site = 'https://' . $site;
                                                }
                                            @endphp
                                            <p class="mb-0">
                                                <a href="{{ $site }}" target="_blank" rel="noopener noreferrer" class="text-primary">
                                                    {{ $empresa->site }}
                                                    <i class="icofont-external-link ml-1" style="font-size: 12px;"></i>
                                                </a>
                                            </p>
                                        @else
                                            <p class="mb-0 text-muted">Não informado</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Endereço -->
                <div class="col-md-6">
                    <div class="card border-light">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">
                                <i class="icofont-location-pin mr-2"></i>
                                Endereço
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="info-item mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="icofont-address-book text-primary mr-3 mt-1"></i>
                                    <div>
                                        <small class="text-muted">Endereço</small>
                                        <p class="mb-0">{{ $empresa->endereco ?: 'Não informado' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="info-item mb-3">
                                <div class="d-flex align-items-start">
                                    <i class="icofont-ui-home text-primary mr-3 mt-1"></i>
                                    <div>
                                        <small class="text-muted">Bairro</small>
                                        <p class="mb-0">{{ $empresa->bairro ?: 'Não informado' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="info-item mb-3">
                                <div class="d-flex">
                                    <div class="mr-4">
                                        <div class="d-flex align-items-start mb-2">
                                            <i class="icofont-city text-primary mr-2 mt-1"></i>
                                            <div>
                                                <small class="text-muted">Cidade</small>
                                                <p class="mb-0">{{ $empresa->cidade ?: 'Não informado' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-start mb-2">
                                            <i class="icofont-map-pins text-primary mr-2 mt-1"></i>
                                            <div>
                                                <small class="text-muted">Estado</small>
                                                <p class="mb-0">{{ $empresa->estado ?: 'Não informado' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Observações ou Informações Adicionais -->
                            @if($empresa->observacoes)
                            <div class="info-item mt-4">
                                <div class="d-flex align-items-start">
                                    <i class="icofont-note text-primary mr-3 mt-1"></i>
                                    <div>
                                        <small class="text-muted">Observações</small>
                                        <p class="mb-0">{{ $empresa->observacoes }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ações -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between border-top pt-3">
                        <div>
                            <small class="text-muted">
                                <i class="icofont-calendar mr-1"></i>
                                Cadastrado em: {{ $empresa->created_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                        <div>
                            <a href="{{ route('empresas.edit', $empresa->id) }}" class="btn btn-warning btn-sm">
                                <i class="icofont-edit mr-1"></i>
                                Editar Empresa
                            </a>
                            <a href="{{ route('empresas.index') }}" class="btn btn-outline-secondary btn-sm ml-2">
                                <i class="icofont-arrow-left mr-1"></i>
                                Voltar para Listagem
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.info-item {
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #f1f1f1;
}
.info-item:last-child {
    border-bottom: none;
}
.company-icon {
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
.badge-secondary {
    background-color: #6c757d;
    color: white;
}
.card-header.bg-light {
    background-color: #f8f9fa !important;
}
</style>

@endsection