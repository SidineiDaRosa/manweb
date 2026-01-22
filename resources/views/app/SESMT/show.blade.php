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
                        <input type="text" id="modalRiscoNome" name="status" class="form-control text-danger fw-bold" readonly>

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



<main class="content">
    <div class="container-fluid p-0">
        <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap">
            <div>
                APR #{{ $apr->id }}
            </div>
            <div style="gap:10px!important;">
                <a href="{{ route('apr.pdf', $apr->id) }}"
                    class="btn btn-lg btn-outline-danger"
                    target="_blank" style="height:40px;">
                    APR Pdf <i class="bi bi-filetype-pdf"></i>
                </a>

                <a href="{{ route('apr.pt_pdf', ['apr' => $apr->id]) }}"
                    target="_blank"
                    class="btn btn-outline-primary"
                    style="height:40px;">
                    PT Pdf <i class="bi bi-filetype-pdf"></i>
                </a>

                <a href="{{ route('apr.modelo', ['apr_id' => $apr->id]) }}"
                    target="_blank"
                    class="btn btn-secondary" style="height:40px;">
                    APR Vazia <i class="bi bi-filetype-pdf"></i>
                </a>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card border-primary">
                    {{-- CABEÇALHO DA APR --}}
                    <div class="card-header bg-primary bg-opacity-10 border-primary py-3">
                        <div class="row align-items-center">

                            <div class="col-md-4 text-end">
                                <div class="text-primary fw-bold">Código: APR-{{ str_pad($apr->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- INFORMAÇÕES BÁSICAS --}}
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="card border h-10">
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
                                            <div class="col-7 fs-5">{{$apr->responsavel->primeiro_nome}} {{$apr->responsavel->ultimo_nome}}</div>
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
                        <div class="card border-danger mb-4">
                            <div class="card-header bg-danger text-white py-3">
                                <h5 class="mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i> ANÁLISE DE RISCOS
                                </h5>
                                <p class="mb-0 opacity-75">Marque os riscos identificados para esta atividade</p>
                            </div>

                            <div class="card-body">
                                @foreach ($riscos as $tipo => $listaRiscos)
                                {{-- CABEÇALHO DO TIPO DE RISCO --}}
                                <div class="risk-type-header" style="background-color: #ffc107; padding: 10px; margin-bottom: 10px; border-radius: 4px;">
                                    <strong style="font-size: 1.1rem; text-transform: uppercase;">{{ $tipo }}</strong>
                                </div>

                                @foreach ($listaRiscos as $risco)
                                @php
                                $apr_risco_salvo = collect($apr_riscos)->first(function($r) use ($risco) {
                                return $r->risco_id == $risco->id;
                                });
                                @endphp

                                <div style="border: 1px solid #dee2e6; margin-bottom: 20px; padding: 15px; border-radius: 5px;background: rgb(25, 135, 84,0.3);">

                                    {{-- CABEÇALHO DO RISCO --}}
                                    <div style="margin-bottom: 10px;">
                                        <div style="font-weight: 700; color: #0d6efd; margin-bottom: 5px;">
                                            Risco: {{ $risco->id }}-{{ $risco->nome }}
                                        </div>
                                        <div style="color: #6c757d;">
                                            Descrição: {{ $risco->descricao }}
                                        </div>
                                    </div>

                                    {{-- CONTROLES --}}
                                    <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 15px; border: 1px solid #dee2e6; padding: 10px; border-radius: 4px;">
                                        {{-- PROBABILIDADE --}}
                                        <div style="flex: 1; min-width: 150px;">
                                            <div style="margin-bottom: 5px; font-weight: 500;">Probabilidade</div>
                                            <select name="riscos[{{ $risco->id }}][probabilidade]" class="form-select form-select-sm">
                                                <option value="baixa" {{ ($apr_risco_salvo->probabilidade ?? '') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                                                <option value="media" {{ ($apr_risco_salvo->probabilidade ?? '') == 'media' ? 'selected' : '' }}>Média</option>
                                                <option value="alta" {{ ($apr_risco_salvo->probabilidade ?? '') == 'alta' ? 'selected' : '' }}>Alta</option>
                                            </select>
                                        </div>

                                        {{-- SEVERIDADE --}}
                                        <div style="flex: 1; min-width: 150px;">
                                            <div style="margin-bottom: 5px; font-weight: 500;">Severidade</div>
                                            <select name="riscos[{{ $risco->id }}][severidade]" class="form-select form-select-sm">
                                                <option value="leve" {{ ($apr_risco_salvo->severidade ?? '') == 'leve' ? 'selected' : '' }}>Leve</option>
                                                <option value="moderada" {{ ($apr_risco_salvo->severidade ?? '') == 'moderada' ? 'selected' : '' }}>Moderada</option>
                                                <option value="grave" {{ ($apr_risco_salvo->severidade ?? '') == 'grave' ? 'selected' : '' }}>Grave</option>
                                            </select>
                                        </div>

                                        {{-- GRAU --}}
                                        <div style="flex: 1; min-width: 150px;">
                                            <div style="margin-bottom: 5px; font-weight: 500;">Grau</div>
                                            @php
                                            $classeGrau = 'bg-secondary text-white';
                                            $grauExibido = '-';

                                            if (!empty($apr_riscos)) {
                                            foreach ($apr_riscos as $apr_risco) {
                                            if ($apr_risco->risco_id == $risco->id) {
                                            $classeGrau = match($apr_risco->grau) {
                                            2 => 'bg-success text-white',
                                            4 => 'bg-warning text-dark',
                                            5 => 'bg-danger text-white',
                                            default => 'bg-secondary text-white'
                                            };
                                            $grauExibido = $apr_risco->grau;
                                            break;
                                            }
                                            }
                                            }
                                            @endphp
                                            <div class="text-center {{ $classeGrau }}" style="padding: 6px; border-radius: 4px;">
                                                {{ $grauExibido }}
                                            </div>
                                        </div>

                                        {{-- IDENTIFICADO --}}
                                        <div>
                                            {{-- IDENTIFICADO --}}
                                            <input type="checkbox"
                                                name="riscos[{{ $risco->id }}][identificado]"
                                                class="form-check-input risco-identificado"
                                                data-risco-id="{{ $risco->id }}"
                                                data-risco-nome="{{ $risco->nome }}"
                                                style="width:20px;height:20px;"
                                                {{ $apr_risco_salvo ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    {{-- MEDIDAS DE CONTROLE --}}
                                    <div style="border: 1px solid #dee2e6; padding: 15px; border-radius: 4px;">
                                        <div style="font-weight: 600; margin-bottom: 10px;">Medidas de Controle:</div>

                                        @foreach($riscos_medidas_controle as $medida)
                                        @if($medida->risco_id == $risco->id)
                                        @php
                                        $estado = null;
                                        $aprRiscoMedida = null;

                                        if($apr_risco_salvo && $apr_risco_salvo->medidas) {
                                        $medidaSalva = $apr_risco_salvo->medidas->firstWhere('medida_id', $medida->id);
                                        $estado = $medidaSalva->marcado ?? null;
                                        }
                                        @endphp

                                        <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                            {{-- Existente --}}
                                            <div style="background-color: #198754; padding: 4px; border-radius: 4px; margin-right: 10px;">
                                                @foreach($apr_riscos_medidas as $apr_risco_medida_controle)
                                                @if($apr_risco_salvo &&
                                                $apr_risco_medida_controle->apr_risco_id == $apr_risco_salvo->id &&
                                                $apr_risco_medida_controle->medida_id == $medida->id &&
                                                $apr_risco_medida_controle->status == 1)
                                                ✅
                                                @endif
                                                @endforeach

                                                <input type="radio"
                                                    name="medida_{{ $medida->id }}"
                                                    value="existente"
                                                    class="form-check-input medida-radio"
                                                    data-medida-id="{{ $medida->id }}"
                                                    data-apr-risco-id="{{ $apr_risco_salvo->id ?? '' }}"
                                                    id="medida-{{ $medida->id }}-existente"
                                                    {{ $estado === 'existente' ? 'checked' : '' }}
                                                    style="margin: 0 5px;">
                                                <label for="medida-{{ $medida->id }}-existente" style="color: white; margin-right: 10px;">
                                                    Sim
                                                </label>
                                            </div>

                                            {{-- Inexistente --}}
                                            <div style="background-color: #fdda14; padding: 4px; border-radius: 4px;">
                                                @foreach($apr_riscos_medidas as $apr_risco_medida_controle)
                                                @if($apr_risco_salvo &&
                                                $apr_risco_medida_controle->apr_risco_id == $apr_risco_salvo->id &&
                                                $apr_risco_medida_controle->medida_id == $medida->id &&
                                                $apr_risco_medida_controle->status == 0)
                                                ✅
                                                @endif
                                                @endforeach

                                                <input type="radio"
                                                    name="medida_{{ $medida->id }}"
                                                    value="inexistente"
                                                    class="form-check-input medida-radio"
                                                    data-medida-id="{{ $medida->id }}"
                                                    data-apr-risco-id="{{ $apr_risco_salvo->id ?? '' }}"
                                                    id="medida-{{ $medida->id }}-inexistente"
                                                    {{ $estado === 'inexistente' ? 'checked' : '' }}
                                                    style="margin: 0 5px;">
                                                <label for="medida-{{ $medida->id }}-inexistente" style="margin-right: 10px;">
                                                    Não
                                                </label>
                                            </div>

                                            <span style="margin-left: 15px;">{{ $medida->descricao }}</span>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>

                                    {{-- MATERIAIS DE RISCO --}}
                                    @if($materiais_risco->where('risco_id', $risco->id)->count() > 0)
                                    <div style="margin-top: 15px;">
                                        <div style="font-weight: 600; margin-bottom: 10px;">Materiais Relacionados:</div>
                                        <div style="display: flex; flex-wrap: wrap; gap: 15px;">
                                            @foreach($materiais_risco as $material_risco)
                                            @if($material_risco->risco_id == $risco->id)
                                            <div style="flex: 1 1 300px; border: 1px solid #ccc; padding: 10px; border-radius: 5px;">
                                                <input type="checkbox" name="" id="" style="margin-right: 8px;">
                                                <strong style="color: darkblue;">
                                                    {{ $material_risco->material->nome ?? 'Material não encontrado' }}
                                                </strong>
                                                <br>
                                                <small style="color: #6c757d;">
                                                    Observações: {{ $material_risco->observacoes }}
                                                </small>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                </div>
                                @endforeach
                                @endforeach
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

                                        // AGORA BUSCA A DIV CONTÊINER EM VEZ DE TR
                                        const container = this.closest('div[style*="border: 1px solid #dee2e6"]');

                                        if (!container) return; // Segurança

                                        // Nome do risco
                                        document.getElementById('modalRiscoNome').value = this.dataset.riscoNome || '';
                                        document.getElementById('modal_risco_id').value = this.dataset.riscoId || '';

                                        // Probabilidade - busca pelo seletor correto
                                        const probSelect = container.querySelector('select[name*="[probabilidade]"]');
                                        const prob = probSelect ? probSelect.value : '';
                                        document.getElementById('modal_probabilidade').value = probSelect ?
                                            probSelect.options[probSelect.selectedIndex].text : '';

                                        // Severidade - busca pelo seletor correto
                                        const sevSelect = container.querySelector('select[name*="[severidade]"]');
                                        const sev = sevSelect ? sevSelect.value : '';
                                        document.getElementById('modal_severidade').value = sevSelect ?
                                            sevSelect.options[sevSelect.selectedIndex].text : '';

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
                    <div class="d-flex flex-wrap justify-content-center gap-2">

                        <button type="submit" class="btn btn-lg btn-success">
                            <i class="fas fa-save me-2"></i> Confirmar Análise
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
    document.addEventListener('DOMContentLoaded', function() {
        // ========== PARTE 1: MODAL DE CONFIRMAÇÃO DO RISCO ==========
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

                // AGORA BUSCA A DIV CONTÊINER EM VEZ DE TR
                const container = this.closest('div[style*="border: 1px solid #dee2e6"]');

                if (!container) return; // Segurança

                // Nome do risco
                document.getElementById('modalRiscoNome').value = this.dataset.riscoNome || '';
                document.getElementById('modal_risco_id').value = this.dataset.riscoId || '';

                // Probabilidade - busca pelo seletor correto
                const probSelect = container.querySelector('select[name*="[probabilidade]"]');
                const prob = probSelect ? probSelect.value : '';
                document.getElementById('modal_probabilidade').value = probSelect ?
                    probSelect.options[probSelect.selectedIndex].text : '';

                // Severidade - busca pelo seletor correto
                const sevSelect = container.querySelector('select[name*="[severidade]"]');
                const sev = sevSelect ? sevSelect.value : '';
                document.getElementById('modal_severidade').value = sevSelect ?
                    sevSelect.options[sevSelect.selectedIndex].text : '';

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

        // ========== PARTE 2: AJAX PARA MEDIDAS DE CONTROLE (SIM/NÃO) ==========
        document.querySelectorAll('.medida-radio').forEach(radio => {
            radio.addEventListener('mousedown', function(e) {
                const medidaId = this.dataset.medidaId;
                const aprRiscoId = this.dataset.aprRiscoId;
                const valor = this.value; // "existente" ou "inexistente"

                // Se o radio já estava selecionado, permite continuar
                if (this.checked) return;

                // Evita que o radio seja marcado antes do confirm
                e.preventDefault();

                if (confirm(`Deseja realmente marcar esta medida como "${valor}"?`)) {
                    // Atualiza visualmente o radio
                    this.checked = true;

                    // Converte para 1 ou 0 para enviar ao backend
                    const status = valor === 'existente' ? 1 : 0;

                    // Envia via AJAX
                    fetch("{{ route('apr.risco.medida.toggle') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                medida_id: medidaId,
                                apr_risco_id: aprRiscoId,
                                status: status // 1 ou 0
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Mostra o ✅ visualmente
                                const container = this.closest('div[style*="background-color"]');
                                if (container) {
                                    // Remove todos os ✅ existentes
                                    const checks = container.querySelectorAll('span, div');
                                    checks.forEach(el => {
                                        if (el.textContent === '✅') {
                                            el.remove();
                                        }
                                    });

                                    // Adiciona o ✅ no início
                                    container.insertAdjacentHTML('afterbegin', '✅ ');
                                }

                                // Não precisa do alert, só atualiza visualmente
                                // alert('Medida salva com sucesso!');
                            } else {
                                alert('Erro ao salvar a medida.');
                                this.checked = false;
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            alert('Erro ao salvar a medida.');
                            this.checked = false;
                        });

                } else {
                    // Se cancelar, não marca nada
                    this.checked = false;
                }
            });
        });

        // ========== PARTE 3: CÁLCULO DO GRAU DE RISCO (se ainda necessário) ==========
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
                // Extrai o ID do risco do name (formato: riscos[ID][probabilidade])
                const match = name.match(/riscos\[(\d+)\]/);
                if (match && match[1]) {
                    atualizarGrauRisco(match[1]);
                }
            });
        });
    });
</script>

@endsection