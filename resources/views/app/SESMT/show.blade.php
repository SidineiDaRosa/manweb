{{-- resources/views/app/SESMT/apr_show.blade.php --}}

@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Visualizar APR</h1>
            <div class="text-muted mt-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('apr.index') }}">APRs</a></li>
                        <li class="breadcrumb-item active">APR #{{ $apr->id }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-primary">
                    {{-- CABEÇALHO DA APR --}}
                    <div class="card-header bg-primary bg-opacity-10 border-primary py-3">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <img src="{{ asset('images/logo-empresa.png') }}" alt="Logo" height="70" class="img-fluid">
                            </div>
                            <div class="col-md-4 text-center">
                                <h3 class="text-primary mb-0 fw-bold">ANÁLISE PRELIMINAR DE RISCO</h3>
                                <small class="text-muted">Documento de Segurança do Trabalho</small>
                            </div>
                            <div class="col-md-4 text-end">
                                <div >Código: APR-{{ str_pad($apr->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- INFORMAÇÕES BÁSICAS --}}
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="card border h-100">
                                    <div class="card-header bg-light py-2">
                                        <h5 class="mb-0">
                                            <i class="fas fa-clipboard-list me-2"></i>Informações da Atividade
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-5 fw-bold">O.S. Nº:</div>
                                            <div class="col-7">
                                                <a href="{{route('ordem-servico.show', ['ordem_servico'=>$apr->ordem_servico_id ])}}" 
                                                   class="text-decoration-none fs-5">
                                                    #{{ $apr->ordem_servico_id }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-5 fw-bold">Local:</div>
                                            <div class="col-7 fs-5">{{ $apr->local_trabalho }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-5 fw-bold">Data:</div>
                                            <div class="col-7 fs-5">{{ \Carbon\Carbon::parse($apr->created_at)->format('d/m/Y') }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-5 fw-bold">Atividade:</div>
                                            <div class="col-7 fs-5">{{ $apr->descricao_atividade }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <div class="card border h-100">
                                    <div class="card-header bg-light py-2">
                                        <h5 class="mb-0">
                                            <i class="fas fa-user-tie me-2"></i>Responsáveis
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-5 fw-bold">Elaborado por:</div>
                                            <div class="col-7 fs-5">{{ $apr->responsavel }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-5 fw-bold">Assinatura:</div>
                                            <div class="col-7">
                                                @if($apr->assinatura_responsavel)
                                                <div class="border rounded p-2 text-center bg-light">
                                                    {{ $apr->assinatura_responsavel }}
                                                </div>
                                                @else
                                                <div class="text-muted border rounded p-2 text-center bg-light">
                                                    ________________________
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-5 fw-bold">Status:</div>
                                            <div class="col-7">
                                                @if($apr->status === 'aberta')
                                                <span>Aberta</span>
                                                @else
                                                <span>Finalizada</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-5 fw-bold">Validade:</div>
                                            <div class="col-7">
                                                @if($apr->validade)
                                                <span class="fs-5">{{ \Carbon\Carbon::parse($apr->validade)->format('d/m/Y') }}</span>
                                                @else
                                                <span class="text-muted fs-5">Não definida</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ANÁLISE DE RISCO DETALHADA COM CHECKBOXES --}}
                        <div class="card border-danger mb-4">
                            <div class="card-header bg-danger text-white py-3">
                                <h4 class="mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i> ANÁLISE DE RISCOS
                                </h4>
                                <p class="mb-0 opacity-75">Marque os riscos identificados para esta atividade</p>
                            </div>
                            <div class="card-body">
                                
                                {{-- EXEMPLO VISUAL DE COMO PREENCHER --}}
                                <div class="alert alert-info mb-4 border-0 shadow-sm">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-info-circle fa-3x"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-4">
                                            <h4 class="alert-heading">Como realizar a análise?</h4>
                                            <p class="mb-3">Para cada risco potencial, marque a coluna correspondente e preencha as medidas de controle necessárias.</p>
                                            <div class="row g-3">
                                                <div class="col-md-3 text-center">
                                                    <div class="p-3 border rounded bg-white">
                                                        <img src="{{ asset('images/exemplo-risco-eletrico.png') }}" 
                                                             alt="Risco Elétrico" 
                                                             class="img-fluid mb-2" 
                                                             style="max-height: 60px">
                                                        <div class="fw-bold text-danger">Risco Elétrico</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 text-center">
                                                    <div class="p-3 border rounded bg-white">
                                                        <img src="{{ asset('images/exemplo-queda.png') }}" 
                                                             alt="Queda de Altura" 
                                                             class="img-fluid mb-2" 
                                                             style="max-height: 60px">
                                                        <div class="fw-bold text-warning">Queda de Altura</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 text-center">
                                                    <div class="p-3 border rounded bg-white">
                                                        <img src="{{ asset('images/exemplo-incendio.png') }}" 
                                                             alt="Incêndio" 
                                                             class="img-fluid mb-2" 
                                                             style="max-height: 60px">
                                                        <div class="fw-bold text-danger">Incêndio</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 text-center">
                                                    <div class="p-3 border rounded bg-white">
                                                        <img src="{{ asset('images/exemplo-produto-quimico.png') }}" 
                                                             alt="Produto Químico" 
                                                             class="img-fluid mb-2" 
                                                             style="max-height: 60px">
                                                        <div class="fw-bold text-success">Produtos Químicos</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- TABELA DE RISCOS COM CHECKBOXES --}}
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="table-danger">
                                            <tr>
                                                <th width="5%" class="text-center align-middle">ID</th>
                                                <th width="10%" class="text-center align-middle">Tipo de Risco</th>
                                                <th width="25%" class="align-middle">Descrição do Risco</th>
                                                <th width="10%" class="text-center align-middle">Probabilidade</th>
                                                <th width="10%" class="text-center align-middle">Severidade</th>
                                                <th width="8%" class="text-center align-middle">Grau</th>
                                                <th width="27%" class="align-middle">Medidas de Controle</th>
                                                <th width="5%" class="text-center align-middle">Identificado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Riscos Físicos --}}
                                            <tr class="bg-warning bg-opacity-10">
                                                <td colspan="8" class="fw-bold fs-5">
                                                    <i class="fas fa-bolt me-2"></i> RISCOS FÍSICOS
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="text-center align-middle">
                                                    <div >F01</div>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <div class="text-warning mb-1">
                                                        <i class="fas fa-bolt fa-2x"></i>
                                                    </div>
                                                    <div class="fw-bold">Elétrico</div>
                                                </td>
                                                <td class="align-middle">
                                                    <strong>Choque elétrico</strong><br>
                                                    <small class="text-muted">Por contato com partes energizadas ou equipamentos sem isolamento adequado</small>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <span class="badge bg-danger fs-6 px-3 py-2">Alta</span>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <span class="badge bg-danger fs-6 px-3 py-2">Grave</span>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <span class="badge bg-danger fs-5 px-3 py-2 fw-bold">4</span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" checked disabled style="transform: scale(1.2)">
                                                        <label class="form-check-label fw-bold">Bloqueio e etiquetagem (LOTO)</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" checked disabled style="transform: scale(1.2)">
                                                        <label class="form-check-label fw-bold">Uso de EPIs dielétricos</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" disabled style="transform: scale(1.2)">
                                                        <label class="form-check-label">Sinalização adequada</label>
                                                    </div>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <input type="checkbox" class="form-check-input" checked disabled style="width: 25px; height: 25px; transform: scale(1.2)">
                                                </td>
                                            </tr>

                                            {{-- Riscos de Queda --}}
                                            <tr class="bg-info bg-opacity-10">
                                                <td colspan="8" class="fw-bold fs-5">
                                                    <i class="fas fa-ladder me-2"></i> RISCOS DE QUEDA
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="text-center align-middle">
                                                    <div class="badge bg-dark fs-6">Q01</div>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <div class="text-info mb-1">
                                                        <i class="fas fa-ladder fa-2x"></i>
                                                    </div>
                                                    <div class="fw-bold">Queda Altura</div>
                                                </td>
                                                <td class="align-middle">
                                                    <strong>Queda durante trabalho em altura</strong><br>
                                                    <small class="text-muted">Acima de 2 metros sem proteção adequada</small>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <span class="badge bg-warning fs-6 px-3 py-2">Média</span>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <span class="badge bg-danger fs-6 px-3 py-2">Grave</span>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <span class="badge bg-warning fs-5 px-3 py-2 fw-bold">3</span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" checked disabled style="transform: scale(1.2)">
                                                        <label class="form-check-label fw-bold">Sistema de proteção contra quedas</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" checked disabled style="transform: scale(1.2)">
                                                        <label class="form-check-label fw-bold">Inspeção dos equipamentos</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" disabled style="transform: scale(1.2)">
                                                        <label class="form-check-label">Treinamento NR35</label>
                                                    </div>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <input type="checkbox" class="form-check-input" checked disabled style="width: 25px; height: 25px; transform: scale(1.2)">
                                                </td>
                                            </tr>

                                            {{-- Riscos Químicos --}}
                                            <tr class="bg-success bg-opacity-10">
                                                <td colspan="8" class="fw-bold fs-5">
                                                    <i class="fas fa-flask me-2"></i> RISCOS QUÍMICOS
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="text-center align-middle">
                                                    <div class="badge bg-dark fs-6">C01</div>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <div class="text-success mb-1">
                                                        <i class="fas fa-flask fa-2x"></i>
                                                    </div>
                                                    <div class="fw-bold">Químico</div>
                                                </td>
                                                <td class="align-middle">
                                                    <strong>Exposição a produtos químicos</strong><br>
                                                    <small class="text-muted">Substâncias nocivas à saúde por inalação ou contato</small>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <span class="badge bg-success fs-6 px-3 py-2">Baixa</span>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <span class="badge bg-warning fs-6 px-3 py-2">Moderada</span>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <span class="badge bg-success fs-5 px-3 py-2 fw-bold">2</span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" checked disabled style="transform: scale(1.2)">
                                                        <label class="form-check-label fw-bold">Uso de máscara adequada</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" disabled style="transform: scale(1.2)">
                                                        <label class="form-check-label">Ventilação do local</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" disabled style="transform: scale(1.2)">
                                                        <label class="form-check-label">Ficha de emergência</label>
                                                    </div>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <input type="checkbox" class="form-check-input" disabled style="width: 25px; height: 25px; transform: scale(1.2)">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                {{-- MATRIZ DE RISCO --}}
                                <div class="card border-secondary mt-4 shadow-sm">
                                    <div class="card-header bg-secondary text-white py-3">
                                        <h5 class="mb-0">
                                            <i class="fas fa-table me-2"></i> Matriz de Risco Aplicada
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered text-center mb-0">
                                                        <thead>
                                                            <tr class="table-light">
                                                                <th colspan="6" class="fs-5">MATRIZ DE PROBABILIDADE x SEVERIDADE</th>
                                                            </tr>
                                                            <tr>
                                                                <th width="20%" class="align-middle">Probabilidade \ Severidade</th>
                                                                <th width="16%" class="bg-success align-middle">Leve</th>
                                                                <th width="16%" class="bg-warning align-middle">Moderada</th>
                                                                <th width="16%" class="bg-orange align-middle">Significativa</th>
                                                                <th width="16%" class="bg-danger align-middle">Grave</th>
                                                                <th width="16%" class="bg-dark text-white align-middle">Catastrófica</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="fw-bold bg-danger text-white align-middle py-3">Alta</td>
                                                                <td class="bg-warning align-middle">
                                                                    <div class="fs-5 fw-bold">3</div>
                                                                    <small>Moderado</small>
                                                                </td>
                                                                <td class="bg-orange align-middle">
                                                                    <div class="fs-5 fw-bold">4</div>
                                                                    <small>Significativo</small>
                                                                </td>
                                                                <td class="bg-danger align-middle">
                                                                    <div class="fs-5 fw-bold">5</div>
                                                                    <small>Alto</small>
                                                                </td>
                                                                <td class="bg-danger align-middle">
                                                                    <div class="fs-5 fw-bold">6</div>
                                                                    <small>Alto</small>
                                                                </td>
                                                                <td class="bg-dark text-white align-middle">
                                                                    <div class="fs-5 fw-bold">7</div>
                                                                    <small>Crítico</small>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold bg-warning text-dark align-middle py-3">Média</td>
                                                                <td class="bg-success align-middle">
                                                                    <div class="fs-5 fw-bold">2</div>
                                                                    <small>Baixo</small>
                                                                </td>
                                                                <td class="bg-warning align-middle">
                                                                    <div class="fs-5 fw-bold">3</div>
                                                                    <small>Moderado</small>
                                                                </td>
                                                                <td class="bg-orange align-middle">
                                                                    <div class="fs-5 fw-bold">4</div>
                                                                    <small>Significativo</small>
                                                                </td>
                                                                <td class="bg-danger align-middle">
                                                                    <div class="fs-5 fw-bold">5</div>
                                                                    <small>Alto</small>
                                                                </td>
                                                                <td class="bg-danger align-middle">
                                                                    <div class="fs-5 fw-bold">6</div>
                                                                    <small>Alto</small>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold bg-success text-dark align-middle py-3">Baixa</td>
                                                                <td class="bg-success align-middle">
                                                                    <div class="fs-5 fw-bold">1</div>
                                                                    <small>Baixo</small>
                                                                </td>
                                                                <td class="bg-success align-middle">
                                                                    <div class="fs-5 fw-bold">2</div>
                                                                    <small>Baixo</small>
                                                                </td>
                                                                <td class="bg-warning align-middle">
                                                                    <div class="fs-5 fw-bold">3</div>
                                                                    <small>Moderado</small>
                                                                </td>
                                                                <td class="bg-orange align-middle">
                                                                    <div class="fs-5 fw-bold">4</div>
                                                                    <small>Significativo</small>
                                                                </td>
                                                                <td class="bg-danger align-middle">
                                                                    <div class="fs-5 fw-bold">5</div>
                                                                    <small>Alto</small>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 mt-4 mt-lg-0">
                                                <div class="card border-0 shadow-sm h-100">
                                                    <div class="card-header bg-primary text-white">
                                                        <h6 class="mb-0">Legenda do Grau de Risco</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center mb-3 p-2 border rounded">
                                                            <span class="badge bg-success fs-6 px-3 py-2 me-3">1-2</span>
                                                            <div>
                                                                <div class="fw-bold">BAIXO</div>
                                                                <small class="text-muted">Aceitável com controle básico</small>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center mb-3 p-2 border rounded">
                                                            <span class="badge bg-warning fs-6 px-3 py-2 me-3">3</span>
                                                            <div>
                                                                <div class="fw-bold">MODERADO</div>
                                                                <small class="text-muted">Necessita controle adicional</small>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center mb-3 p-2 border rounded">
                                                            <span class="badge bg-orange fs-6 px-3 py-2 me-3">4</span>
                                                            <div>
                                                                <div class="fw-bold">SIGNIFICATIVO</div>
                                                                <small class="text-muted">Exige atenção imediata</small>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center p-2 border rounded">
                                                            <span class="badge bg-danger fs-6 px-3 py-2 me-3">5-7</span>
                                                            <div>
                                                                <div class="fw-bold">ALTO</div>
                                                                <small class="text-muted">Inaceitável - Parar atividade</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- EPIs NECESSÁRIOS --}}
                        <div class="card border-primary mb-4 shadow-sm">
                            <div class="card-header bg-primary text-white py-3">
                                <h4 class="mb-0">
                                    <i class="fas fa-hard-hat me-2"></i> EQUIPAMENTOS DE PROTEÇÃO INDIVIDUAL (EPIs)
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    @foreach([
                                        ['icon' => 'hard-hat', 'name' => 'Capacete', 'color' => 'warning'],
                                        ['icon' => 'glasses', 'name' => 'Óculos', 'color' => 'info'],
                                        ['icon' => 'hand-paper', 'name' => 'Luva', 'color' => 'success'],
                                        ['icon' => 'shoe-prints', 'name' => 'Botina', 'color' => 'dark']
                                    ] as $epi)
                                    <div class="col-md-3 col-sm-6">
                                        <div class="card border h-100 shadow">
                                            <div class="card-body text-center p-4">
                                                <div class="mb-3">
                                                    <i class="fas fa-{{ $epi['icon'] }} fa-3x text-{{ $epi['color'] }}"></i>
                                                </div>
                                                <h5 class="fw-bold mb-2">{{ $epi['name'] }} de Segurança</h5>
                                                <div class="form-check form-switch d-inline-block">
                                                    <input class="form-check-input" type="checkbox" checked disabled style="transform: scale(1.5)">
                                                    <label class="form-check-label fw-bold ms-2">Obrigatório</label>
                                                </div>
                                                <div class="mt-3">
                                                    <small class="text-muted">CA: 12345-6789</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- BOTÕES DE AÇÃO --}}
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 p-3 border rounded bg-light">
                            <a href="{{ route('apr.index') }}" class="btn btn-lg btn-outline-secondary mb-2 mb-md-0">
                                <i class="fas fa-arrow-left me-2"></i> Voltar para Lista
                            </a>
                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                <button class="btn btn-lg btn-outline-primary">
                                    <i class="fas fa-print me-2"></i> Imprimir APR
                                </button>
                                <button class="btn btn-lg btn-success">
                                    <i class="fas fa-check-circle me-2"></i> Finalizar APR
                                </button>
                                <button class="btn btn-lg btn-warning">
                                    <i class="fas fa-edit me-2"></i> Editar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
/* Estilos customizados para melhorar a visualização */
.badge {
    font-size: 0.95em !important;
    padding: 0.5em 0.8em !important;
}

.table td, .table th {
    vertical-align: middle !important;
}

.bg-orange {
    background-color: #ff9800 !important;
    color: white !important;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05) !important;
}

.card {
    border-width: 2px !important;
}

.form-check-input {
    margin-right: 8px;
}

/* Ajustes para tornar elementos mais visíveis */
.fs-5 {
    font-size: 1.1rem !important;
}

.fs-6 {
    font-size: 1rem !important;
}

/* Melhor espaçamento na tabela */
.table > :not(caption) > * > * {
    padding: 0.85rem 0.5rem !important;
}

/* Destaque para cabeçalhos de seção */
tr[class*="bg-"]:not(.table-danger) > td {
    padding: 1rem !important;
}
</style>

@endsection