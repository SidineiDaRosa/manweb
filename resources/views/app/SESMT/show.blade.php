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
                                <div class="text-primary fw-bold">Código: APR-{{ str_pad($apr->id, 5, '0', STR_PAD_LEFT) }}</div>
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
                                            <div class="col-7 fs-5"></div>
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
                                                <span >Aberta</span>
                                                @else
                                                <span class="badge bg-success text-white fs-6 px-3 py-2">Finalizada</span>
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

                        {{-- FORMULÁRIO DE EDIÇÃO DA APR --}}
                        <form action="{{ route('apr.update', $apr->id) }}" method="POST" id="aprForm">
                            @csrf
                            @method('PUT')
                            
                            {{-- ANÁLISE DE RISCO DETALHADA COM CHECKBOXES EDITÁVEIS --}}
                            <div class="card border-danger mb-4">
                                <div class="card-header bg-danger text-white py-3">
                                    <h4 class="mb-0">
                                        <i class="fas fa-exclamation-triangle me-2"></i> ANÁLISE DE RISCOS
                                    </h4>
                                    <p class="mb-0 opacity-75">Marque os riscos identificados para esta atividade</p>
                                </div>
                                <div class="card-body">
                                    
                                    {{-- TABELA DE RISCOS COM CHECKBOXES EDITÁVEIS --}}
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
                                                <tr class="table-warning">
                                                    <td colspan="8" class="fw-bold fs-5">
                                                        <i class="fas fa-bolt me-2"></i> RISCOS FÍSICOS
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="text-center align-middle">
                                                        <span class="badge bg-dark text-white fs-6">F01</span>
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
                                                        <select name="risco_f01_probabilidade" class="form-select form-select-sm">
                                                            <option value="baixa" {{ old('risco_f01_probabilidade', 'alta') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                                                            <option value="media" {{ old('risco_f01_probabilidade', 'alta') == 'media' ? 'selected' : '' }}>Média</option>
                                                            <option value="alta" {{ old('risco_f01_probabilidade', 'alta') == 'alta' ? 'selected' : '' }}>Alta</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <select name="risco_f01_severidade" class="form-select form-select-sm">
                                                            <option value="leve" {{ old('risco_f01_severidade', 'grave') == 'leve' ? 'selected' : '' }}>Leve</option>
                                                            <option value="moderada" {{ old('risco_f01_severidade', 'grave') == 'moderada' ? 'selected' : '' }}>Moderada</option>
                                                            <option value="grave" {{ old('risco_f01_severidade', 'grave') == 'grave' ? 'selected' : '' }}>Grave</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <span class="badge bg-danger text-white fs-5 px-3 py-2 fw-bold" id="grau_f01">4</span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="medida_f01_1" value="LOTO" {{ old('medida_f01_1', true) ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-bold">Bloqueio e etiquetagem (LOTO)</label>
                                                        </div>
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="medida_f01_2" value="EPIs" {{ old('medida_f01_2', true) ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-bold">Uso de EPIs dielétricos</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="medida_f01_3" value="sinalizacao" {{ old('medida_f01_3') ? 'checked' : '' }}>
                                                            <label class="form-check-label">Sinalização adequada</label>
                                                        </div>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <input type="checkbox" class="form-check-input risco-checkbox" name="risco_f01_identificado" value="1" {{ old('risco_f01_identificado', true) ? 'checked' : '' }} data-risco="f01" style="width: 20px; height: 20px;">
                                                    </td>
                                                </tr>

                                                {{-- Riscos de Queda --}}
                                                <tr class="table-info">
                                                    <td colspan="8" class="fw-bold fs-5">
                                                        <i class="fas fa-ladder me-2"></i> RISCOS DE QUEDA
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="text-center align-middle">
                                                        <span class="badge bg-dark text-white fs-6">Q01</span>
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
                                                        <select name="risco_q01_probabilidade" class="form-select form-select-sm">
                                                            <option value="baixa" {{ old('risco_q01_probabilidade', 'media') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                                                            <option value="media" {{ old('risco_q01_probabilidade', 'media') == 'media' ? 'selected' : '' }}>Média</option>
                                                            <option value="alta" {{ old('risco_q01_probabilidade', 'media') == 'alta' ? 'selected' : '' }}>Alta</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <select name="risco_q01_severidade" class="form-select form-select-sm">
                                                            <option value="leve" {{ old('risco_q01_severidade', 'grave') == 'leve' ? 'selected' : '' }}>Leve</option>
                                                            <option value="moderada" {{ old('risco_q01_severidade', 'grave') == 'moderada' ? 'selected' : '' }}>Moderada</option>
                                                            <option value="grave" {{ old('risco_q01_severidade', 'grave') == 'grave' ? 'selected' : '' }}>Grave</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <span class="badge bg-warning text-dark fs-5 px-3 py-2 fw-bold" id="grau_q01">3</span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="medida_q01_1" value="protecao_queda" {{ old('medida_q01_1', true) ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-bold">Sistema de proteção contra quedas</label>
                                                        </div>
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="medida_q01_2" value="inspecao" {{ old('medida_q01_2', true) ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-bold">Inspeção dos equipamentos</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="medida_q01_3" value="treinamento" {{ old('medida_q01_3') ? 'checked' : '' }}>
                                                            <label class="form-check-label">Treinamento NR35</label>
                                                        </div>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <input type="checkbox" class="form-check-input risco-checkbox" name="risco_q01_identificado" value="1" {{ old('risco_q01_identificado', true) ? 'checked' : '' }} data-risco="q01" style="width: 20px; height: 20px;">
                                                    </td>
                                                </tr>

                                                {{-- Riscos Químicos --}}
                                                <tr class="table-success">
                                                    <td colspan="8" class="fw-bold fs-5">
                                                        <i class="fas fa-flask me-2"></i> RISCOS QUÍMICOS
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="text-center align-middle">
                                                        <span class="badge bg-dark text-white fs-6">C01</span>
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
                                                        <select name="risco_c01_probabilidade" class="form-select form-select-sm">
                                                            <option value="baixa" {{ old('risco_c01_probabilidade', 'baixa') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                                                            <option value="media" {{ old('risco_c01_probabilidade', 'baixa') == 'media' ? 'selected' : '' }}>Média</option>
                                                            <option value="alta" {{ old('risco_c01_probabilidade', 'baixa') == 'alta' ? 'selected' : '' }}>Alta</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <select name="risco_c01_severidade" class="form-select form-select-sm">
                                                            <option value="leve" {{ old('risco_c01_severidade', 'moderada') == 'leve' ? 'selected' : '' }}>Leve</option>
                                                            <option value="moderada" {{ old('risco_c01_severidade', 'moderada') == 'moderada' ? 'selected' : '' }}>Moderada</option>
                                                            <option value="grave" {{ old('risco_c01_severidade', 'moderada') == 'grave' ? 'selected' : '' }}>Grave</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <span class="badge bg-success text-white fs-5 px-3 py-2 fw-bold" id="grau_c01">2</span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="medida_c01_1" value="mascara" {{ old('medida_c01_1', true) ? 'checked' : '' }}>
                                                            <label class="form-check-label fw-bold">Uso de máscara adequada</label>
                                                        </div>
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="checkbox" name="medida_c01_2" value="ventilacao" {{ old('medida_c01_2') ? 'checked' : '' }}>
                                                            <label class="form-check-label">Ventilação do local</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="medida_c01_3" value="ficha_emergencia" {{ old('medida_c01_3') ? 'checked' : '' }}>
                                                            <label class="form-check-label">Ficha de emergência</label>
                                                        </div>
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <input type="checkbox" class="form-check-input risco-checkbox" name="risco_c01_identificado" value="1" {{ old('risco_c01_identificado') ? 'checked' : '' }} data-risco="c01" style="width: 20px; height: 20px;">
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
                                                                    <th width="16%" class="bg-success text-white align-middle">Leve</th>
                                                                    <th width="16%" class="bg-warning text-dark align-middle">Moderada</th>
                                                                    <th width="16%" class="bg-orange text-white align-middle">Significativa</th>
                                                                    <th width="16%" class="bg-danger text-white align-middle">Grave</th>
                                                                    <th width="16%" class="bg-dark text-white align-middle">Catastrófica</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="fw-bold bg-danger text-white align-middle py-3">Alta</td>
                                                                    <td class="bg-warning text-dark align-middle">
                                                                        <div class="fs-5 fw-bold">3</div>
                                                                        <small>Moderado</small>
                                                                    </td>
                                                                    <td class="bg-orange text-white align-middle">
                                                                        <div class="fs-5 fw-bold">4</div>
                                                                        <small>Significativo</small>
                                                                    </td>
                                                                    <td class="bg-danger text-white align-middle">
                                                                        <div class="fs-5 fw-bold">5</div>
                                                                        <small>Alto</small>
                                                                    </td>
                                                                    <td class="bg-danger text-white align-middle">
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
                                                                    <td class="bg-success text-white align-middle">
                                                                        <div class="fs-5 fw-bold">2</div>
                                                                        <small>Baixo</small>
                                                                    </td>
                                                                    <td class="bg-warning text-dark align-middle">
                                                                        <div class="fs-5 fw-bold">3</div>
                                                                        <small>Moderado</small>
                                                                    </td>
                                                                    <td class="bg-orange text-white align-middle">
                                                                        <div class="fs-5 fw-bold">4</div>
                                                                        <small>Significativo</small>
                                                                    </td>
                                                                    <td class="bg-danger text-white align-middle">
                                                                        <div class="fs-5 fw-bold">5</div>
                                                                        <small>Alto</small>
                                                                    </td>
                                                                    <td class="bg-danger text-white align-middle">
                                                                        <div class="fs-5 fw-bold">6</div>
                                                                        <small>Alto</small>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="fw-bold bg-success text-white align-middle py-3">Baixa</td>
                                                                    <td class="bg-success text-white align-middle">
                                                                        <div class="fs-5 fw-bold">1</div>
                                                                        <small>Baixo</small>
                                                                    </td>
                                                                    <td class="bg-success text-white align-middle">
                                                                        <div class="fs-5 fw-bold">2</div>
                                                                        <small>Baixo</small>
                                                                    </td>
                                                                    <td class="bg-warning text-dark align-middle">
                                                                        <div class="fs-5 fw-bold">3</div>
                                                                        <small>Moderado</small>
                                                                    </td>
                                                                    <td class="bg-orange text-white align-middle">
                                                                        <div class="fs-5 fw-bold">4</div>
                                                                        <small>Significativo</small>
                                                                    </td>
                                                                    <td class="bg-danger text-white align-middle">
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
                                                                <span class="badge bg-success text-white fs-6 px-3 py-2 me-3">1-2</span>
                                                                <div>
                                                                    <div class="fw-bold">BAIXO</div>
                                                                    <small class="text-muted">Aceitável com controle básico</small>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center mb-3 p-2 border rounded">
                                                                <span class="badge bg-warning text-dark fs-6 px-3 py-2 me-3">3</span>
                                                                <div>
                                                                    <div class="fw-bold">MODERADO</div>
                                                                    <small class="text-muted">Necessita controle adicional</small>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center mb-3 p-2 border rounded">
                                                                <span class="badge bg-orange text-white fs-6 px-3 py-2 me-3">4</span>
                                                                <div>
                                                                    <div class="fw-bold">SIGNIFICATIVO</div>
                                                                    <small class="text-muted">Exige atenção imediata</small>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center p-2 border rounded">
                                                                <span class="badge bg-danger text-white fs-6 px-3 py-2 me-3">5-7</span>
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

                                    {{-- CAMPO PARA OBSERVAÇÕES ADICIONAIS --}}
                                    <div class="mt-4">
                                        <label for="observacoes" class="form-label fw-bold">
                                            <i class="fas fa-sticky-note me-2"></i>Observações Adicionais
                                        </label>
                                        <textarea class="form-control" id="observacoes" name="observacoes" rows="3" placeholder="Adicione observações relevantes sobre os riscos ou medidas de controle...">{{ old('observacoes', $apr->observacoes ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- EPIs NECESSÁRIOS EDITÁVEIS --}}
                            <div class="card border-primary mb-4 shadow-sm">
                                <div class="card-header bg-primary text-white py-3">
                                    <h4 class="mb-0">
                                        <i class="fas fa-hard-hat me-2"></i> EQUIPAMENTOS DE PROTEÇÃO INDIVIDUAL (EPIs)
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row g-4">
                                        @php
                                            $epis = [
                                                ['icon' => 'hard-hat', 'name' => 'Capacete', 'color' => 'warning', 'id' => 'epi_capacete', 'ca' => '12345-6789'],
                                                ['icon' => 'glasses', 'name' => 'Óculos', 'color' => 'info', 'id' => 'epi_oculos', 'ca' => '23456-7890'],
                                                ['icon' => 'hand-paper', 'name' => 'Luva', 'color' => 'success', 'id' => 'epi_luva', 'ca' => '34567-8901'],
                                                ['icon' => 'shoe-prints', 'name' => 'Botina', 'color' => 'dark', 'id' => 'epi_botina', 'ca' => '45678-9012']
                                            ];
                                        @endphp
                                        
                                        @foreach($epis as $epi)
                                        <div class="col-md-3 col-sm-6">
                                            <div class="card border h-100 shadow">
                                                <div class="card-body text-center p-4">
                                                    <div class="mb-3">
                                                        <i class="fas fa-{{ $epi['icon'] }} fa-3x text-{{ $epi['color'] }}"></i>
                                                    </div>
                                                    <h5 class="fw-bold mb-2">{{ $epi['name'] }} de Segurança</h5>
                                                    <div class="form-check form-switch d-inline-block mb-2">
                                                        <input class="form-check-input" type="checkbox" 
                                                               name="{{ $epi['id'] }}" 
                                                               id="{{ $epi['id'] }}"
                                                               {{ old($epi['id'], true) ? 'checked' : '' }}>
                                                        <label class="form-check-label fw-bold ms-2" for="{{ $epi['id'] }}">
                                                            Obrigatório
                                                        </label>
                                                    </div>
                                                    <div class="mt-3">
                                                        <input type="text" class="form-control form-control-sm text-center" 
                                                               name="{{ $epi['id'] }}_ca" 
                                                               value="{{ old($epi['id'].'_ca', $epi['ca']) }}"
                                                               placeholder="Nº do CA">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- CAMPO DE ASSINATURA --}}
                            <div class="card border-secondary mb-4 shadow-sm">
                                <div class="card-header bg-secondary text-white py-3">
                                    <h5 class="mb-0">
                                        <i class="fas fa-signature me-2"></i> Assinatura do Responsável
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <label for="assinatura_responsavel" class="form-label fw-bold">Digite sua assinatura:</label>
                                            <input type="text" class="form-control form-control-lg" 
                                                   id="assinatura_responsavel" 
                                                   name="assinatura_responsavel"
                                                   value="{{ old('assinatura_responsavel', $apr->assinatura_responsavel ?? '') }}"
                                                   placeholder="Digite seu nome completo para assinar">
                                            <div class="form-text">Esta assinatura confirma sua responsabilidade sobre a análise de riscos.</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Status da APR:</label>
                                            <select class="form-select form-select-lg" name="status">
                                                <option value="aberta" {{ old('status', $apr->status) == 'aberta' ? 'selected' : '' }}>Aberta</option>
                                                <option value="finalizada" {{ old('status', $apr->status) == 'finalizada' ? 'selected' : '' }}>Finalizada</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- BOTÕES DE AÇÃO --}}
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 p-3 border rounded bg-light">
                                <a href="{{ route('apr.index') }}" class="btn btn-lg btn-outline-secondary mb-2 mb-md-0">
                                    <i class="fas fa-arrow-left me-2"></i> Voltar para Lista
                                </a>
                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                    <button type="button" class="btn btn-lg btn-outline-primary" onclick="window.print()">
                                        <i class="fas fa-print me-2"></i> Imprimir APR
                                    </button>
                                    <button type="submit" class="btn btn-lg btn-success">
                                        <i class="fas fa-save me-2"></i> Salvar Alterações
                                    </button>
                                    <a href="{{ route('apr.edit', $apr->id) }}" class="btn btn-lg btn-warning">
                                        <i class="fas fa-redo me-2"></i> Recarregar
                                    </a>
                                </div>
                            </div>
                        </form>
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
    border-radius: 0.375rem !important;
}

.table td, .table th {
    vertical-align: middle !important;
}

/* Definir cor laranja personalizada */
.bg-orange {
    background-color: #fd7e14 !important;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05) !important;
}

.card {
    border-width: 2px !important;
}

.form-check-input {
    margin-right: 8px;
    cursor: pointer;
}

.form-select-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
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
tr[class*="table-"]:not(.table-danger) > td {
    padding: 1rem !important;
}

/* Estilo para checkboxes de risco */
.risco-checkbox {
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.risco-checkbox:checked {
    background-color: #198754;
    border-color: #198754;
}

/* Ajustes para badges na matriz */
.table-bordered .badge {
    min-width: 50px;
}

/* Contraste melhorado para texto */
.bg-warning {
    color: #212529 !important;
}

.bg-success, .bg-danger, .bg-primary, .bg-secondary, .bg-dark, .bg-orange {
    color: white !important;
}

/* Ajuste para badges de status */
.badge.bg-warning {
    color: #212529 !important;
}

.badge.bg-success {
    color: white !important;
}
</style>

<script>
// Script para calcular grau de risco baseado na matriz
document.addEventListener('DOMContentLoaded', function() {
    // Matriz de risco (Probabilidade x Severidade)
    const matrizRisco = {
        'baixa': {
            'leve': 1,
            'moderada': 2,
            'grave': 3
        },
        'media': {
            'leve': 2,
            'moderada': 3,
            'grave': 4
        },
        'alta': {
            'leve': 3,
            'moderada': 4,
            'grave': 5
        }
    };

    // Função para atualizar o grau de risco
    function atualizarGrauRisco(riscoId) {
        const probabilidade = document.querySelector(`select[name="risco_${riscoId}_probabilidade"]`).value;
        const severidade = document.querySelector(`select[name="risco_${riscoId}_severidade"]`).value;
        const grauElement = document.getElementById(`grau_${riscoId}`);
        
        if (probabilidade && severidade) {
            const grau = matrizRisco[probabilidade][severidade];
            grauElement.textContent = grau;
            
            // Atualizar cor do badge baseado no grau
            grauElement.className = 'badge fs-5 px-3 py-2 fw-bold';
            if (grau <= 2) {
                grauElement.classList.add('bg-success', 'text-white');
            } else if (grau === 3) {
                grauElement.classList.add('bg-warning', 'text-dark');
            } else if (grau === 4) {
                grauElement.classList.add('bg-orange', 'text-white');
            } else {
                grauElement.classList.add('bg-danger', 'text-white');
            }
        }
    }

    // Adicionar event listeners para os selects
    document.querySelectorAll('select[name$="_probabilidade"], select[name$="_severidade"]').forEach(select => {
        select.addEventListener('change', function() {
            const name = this.name;
            const riscoId = name.replace('risco_', '').replace('_probabilidade', '').replace('_severidade', '');
            atualizarGrauRisco(riscoId);
        });
    });

    // Adicionar event listener para checkboxes de risco
    document.querySelectorAll('.risco-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const riscoId = this.dataset.risco;
            const linha = this.closest('tr');
            const inputs = linha.querySelectorAll('select, input[type="checkbox"]:not(.risco-checkbox)');
            
            // Habilitar/desabilitar todos os inputs da linha exceto o checkbox principal
            inputs.forEach(input => {
                input.disabled = !this.checked;
            });
        });
    });

    // Inicializar graus de risco
    ['f01', 'q01', 'c01'].forEach(riscoId => {
        atualizarGrauRisco(riscoId);
    });
});

// Validação do formulário
document.getElementById('aprForm').addEventListener('submit', function(e) {
    const assinatura = document.getElementById('assinatura_responsavel').value.trim();
    
    if (!assinatura) {
        e.preventDefault();
        alert('Por favor, insira sua assinatura para continuar.');
        document.getElementById('assinatura_responsavel').focus();
        return false;
    }
    
    // Confirmação se estiver finalizando a APR
    const status = document.querySelector('select[name="status"]').value;
    if (status === 'finalizada') {
        if (!confirm('Tem certeza que deseja finalizar esta APR? Após finalizada, não será mais possível editar.')) {
            e.preventDefault();
            return false;
        }
    }
});
</script>

@endsection