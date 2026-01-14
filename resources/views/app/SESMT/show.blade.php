{{-- resources/views/app/SESMT/apr_show.blade.php --}}

@extends('app.layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- MODAL CONFIRMAR IDENTIFICAÇÃO DO RISCO -->
<div class="modal fade" id="modalConfirmarRisco" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('risco.store') }}" id="formConfirmarRisco">
            @csrf

            <!-- Campos ocultos -->
            <input type="hidden" name="apr_id" value="{{ $apr->id }}">
            <input type="hidden" name="risco_id" id="modal_risco_id">

            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Confirmar Identificação de Risco</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p class="mb-2">
                        Confirma a identificação do risco:
                        <input type="text" id="modalRiscoNome" name="status" nameclass="form-control text-danger fw-bold" readonly>
                    </p>

                    <ul class="list-group mt-3">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Probabilidade</span>
                            <input type="text" id="modal_probabilidade" name="probabilidade" class="form-control w-50" readonly>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Severidade</span>
                            <input type="text" id="modal_severidade" name="severidade" class="form-control w-50" readonly>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Grau de Risco</span>
                            <input type="text" id="modal_grau" name="grau" class="form-control w-25 text-center fw-bold" readonly>
                        </li>
                    </ul>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-danger">
                        Confirmar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let checkboxAtual = null;
        const modalElement = document.getElementById('modalConfirmarRisco');
        const modal = new bootstrap.Modal(modalElement);

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

        // Preenche modal e calcula grau de risco
        document.querySelectorAll('.risco-identificado').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (!this.checked) return;

                checkboxAtual = this;
                const linha = this.closest('tr');

                // Nome do risco
                document.getElementById('modalRiscoNome').value = this.dataset.riscoNome || '';
                document.getElementById('modal_risco_id').value = this.dataset.riscoId || '';

                // Probabilidade
                const probSelect = linha.querySelector('select[name*="[probabilidade]"]');
                const prob = probSelect ? probSelect.value : '';
                document.getElementById('modal_probabilidade').value = probSelect ? probSelect.options[probSelect.selectedIndex].text : '';

                // Severidade
                const sevSelect = linha.querySelector('select[name*="[severidade]"]');
                const sev = sevSelect ? sevSelect.value : '';
                document.getElementById('modal_severidade').value = sevSelect ? sevSelect.options[sevSelect.selectedIndex].text : '';

                // Grau de risco calculado
                const grauInput = document.getElementById('modal_grau');
                if (prob && sev && matrizRisco[prob] && matrizRisco[prob][sev] !== undefined) {
                    const grau = matrizRisco[prob][sev];
                    grauInput.value = grau;

                    // Alterar cor do input baseado no grau
                    grauInput.className = 'form-control w-25 text-center fw-bold';
                    if (grau <= 2) {
                        grauInput.classList.add('bg-success', 'text-white');
                    } else if (grau === 3) {
                        grauInput.classList.add('bg-warning', 'text-dark');
                    } else if (grau === 4) {
                        grauInput.classList.add('bg-orange', 'text-white');
                    } else {
                        grauInput.classList.add('bg-danger', 'text-white');
                    }
                }

                modal.show();
            });
        });

        modalElement.addEventListener('hidden.bs.modal', function() {
            if (checkboxAtual) {
                checkboxAtual.checked = false;
                checkboxAtual = null;
            }
        });
    });
</script>



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
                                                <span>Aberta</span>
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
                                                @foreach ($riscos as $tipo => $listaRiscos)

                                                {{-- CABEÇALHO DO TIPO DE RISCO --}}
                                                <tr class="table-warning">
                                                    <td colspan="8" class="fw-bold fs-5 text-uppercase">
                                                        {{ $tipo }}
                                                    </td>
                                                </tr>

                                                {{-- RISCOS --}}
                                                @foreach ($listaRiscos as $risco)
                                                <tr>
                                                    {{-- ID --}}
                                                    <td class="text-center align-middle">
                                                        <span class="badge bg-dark text-white fs-6">
                                                            {{ $risco->id }}
                                                        </span>
                                                    </td>

                                                    {{-- TIPO --}}
                                                    <td class="text-center align-middle">
                                                        <div class="fw-bold">
                                                            {{ $risco->nome }}
                                                        </div>
                                                    </td>

                                                    {{-- DESCRIÇÃO --}}
                                                    <td class="align-middle">
                                                        {{ $risco->descricao }}
                                                    </td>

                                                    {{-- PROBABILIDADE --}}
                                                    <td class="text-center align-middle">
                                                        <select name="riscos[{{ $risco->id }}][probabilidade]" class="form-select form-select-sm">
                                                            <option value="baixa">Baixa</option>
                                                            <option value="media">Média</option>
                                                            <option value="alta">Alta</option>
                                                        </select>
                                                    </td>

                                                    {{-- SEVERIDADE --}}
                                                    <td class="text-center align-middle">
                                                        <select name="riscos[{{ $risco->id }}][severidade]" class="form-select form-select-sm">
                                                            <option value="leve">Leve</option>
                                                            <option value="moderada">Moderada</option>
                                                            <option value="grave">Grave</option>
                                                        </select>
                                                    </td>

                                                    {{-- GRAU --}}
                                                    <td class="text-center align-middle">
                                                        <span class="badge bg-secondary fs-5 px-3 py-2 fw-bold grau"
                                                            data-risco="{{ $risco->id }}">
                                                            -
                                                        </span>
                                                    </td>

                                                    {{-- MEDIDAS DE CONTROLE --}}
                                                    <td class="align-middle">
                                                        <textarea
                                                            name="riscos[{{ $risco->id }}][medidas]"
                                                            class="form-control form-control-sm"
                                                            rows="2"
                                                            placeholder="Informe as medidas de controle"></textarea>
                                                    </td>

                                                    {{-- IDENTIFICADO --}}
                                                    <td class="text-center align-middle">
                                                        <input type="checkbox"
                                                            class="form-check-input risco-identificado"
                                                            data-risco-id="{{ $risco->id }}"
                                                            data-risco-nome="{{ $risco->nome }}"
                                                            style="width:20px;height:20px;">

                                                    </td>




                                                </tr>
                                                @endforeach

                                                @endforeach
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

    .table td,
    .table th {
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
    .table> :not(caption)>*>* {
        padding: 0.85rem 0.5rem !important;
    }

    /* Destaque para cabeçalhos de seção */
    tr[class*="table-"]:not(.table-danger)>td {
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

    .bg-success,
    .bg-danger,
    .bg-primary,
    .bg-secondary,
    .bg-dark,
    .bg-orange {
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