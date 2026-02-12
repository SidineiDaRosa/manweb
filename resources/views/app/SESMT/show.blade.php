{{-- resources/views/app/SESMT/apr_show.blade.php --}}

@extends('app.layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@include('app.SESMT.partial.modal_conf_risk')
@include('app.SESMT.partial.update_apr')

<main class="content">
    <!--Mesagem de confirmação de verificação da APR-->
    @if(session('success'))
    <div class="alert alert-success custom-alert position-relative">
        {!! session('success') !!}
        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Fechar" style="border:none; background:none; font-size:20px; font-weight:bold;">
            &times;
        </button>
    </div>
    @endif
    <script>
        function recarrega() {
            window.location.reload();
        }
    </script>

    @if(session('error'))
    <div class="alert alert-danger custom-alert d-flex align-items-start gap-2 position-relative">
        <!-- Ícone de alerta -->
        <i class="bi bi-exclamation-triangle-fill fs-4 mt-1"></i>

        <!-- Mensagem -->
        <div class="flex-fill">
            <strong>Existem pendências na análise:</strong>
            <ul class="mb-0 mt-1" style="padding-left:20px;">
                @foreach(explode('<br>➤ ', session('error')) as $item)
                @if(str_contains($item, 'Medida:'))
                <li style="color:wite;">{{ $item }}</li>
                @else
                <li style="color:red; font-weight:400;">{{ $item }}</li>
                @endif
                @endforeach
            </ul>
        </div>
        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Fechar" style="border:none; background:none; font-size:20px; font-weight:bold;"> &times; </button>
    </div>
    @endif

    <div class="container-fluid p-0">
        <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap" style="max-height: 30px!important;">
            <div>
                APR #{{ $apr->id }}
            </div>
            
            <div style="gap:10px!important;">
                <a href="{{ route('apr.pdf', $apr->id) }}"
                    class="btn btn-outline-danger"
                    target="_blank" style="height:40px;">
                    APR Pdf <i class="bi bi-filetype-pdf"></i>
                </a>

                <a href="{{ route('apr.pt_pdf', ['apr' => $apr->id]) }}"
                    class="btn btn-outline-primary"
                    style="height:40px;">
                    PT Pdf <i class="bi bi-filetype-pdf"></i>
                </a>

                <a href="{{ route('apr.modelo', ['apr_id' => $apr->id]) }}"
                    target="_blank"
                    class="btn btn-outline-secondary" style="height:40px;">
                    APR Vazia <i class="bi bi-filetype-pdf"></i>
                </a>
                <button class="btn btn-sm btn-warning"
                    onclick="editarApr({{ $apr }})" class="btn btn-secondary" style="height:40px;">
                    <i class="bi bi-pen"></i>
                </button>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card border-primary">
                    {{-- CABEÇALHO DA APR --}}

                    <div class="card-body">
                        {{-- INFORMAÇÕES BÁSICAS --}}
                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <div class="card border h-10">
                                    <div class="card-header bg-light py-1">
                                        <h5 class="mb-0">
                                            <i class="fas fa-clipboard-list me-2"></i>Informações da APR
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row g-1">

                                            <!-- COLUNA 1 -->
                                            <div class="col-12 col-md-6">
                                                <div class="row mb-0">
                                                    <div class="col-5 fw-bold">O.S. Nº:</div>
                                                    <div class="col-7">
                                                        <a href="{{ route('ordem-servico.show', ['ordem_servico'=>$apr->ordem_servico_id]) }}"
                                                            class="text-decoration-none fs-6">
                                                            #{{ $apr->ordem_servico_id }}
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="row mb-0">
                                                    <div class="col-5 fw-bold">Local:</div>
                                                    <div class="col-7 fs-6">{{ $apr->localizacao->nome }}</div>
                                                </div>

                                                <div class="row mb-0">
                                                    <div class="col-5 fw-bold">Prazo:</div>
                                                    <div class="col-7 fs-6">
                                                        {{-- \Carbon\Carbon::parse($apr->created_at)->format('d/m/Y' hh:mm) --}}
                                                        {{ \Carbon\Carbon::parse($apr->prazo)->format('d/m/Y  H:i') }}
                                                    </div>
                                                </div>

                                                <div class="row mb-0">
                                                    <div class="col-5 fw-bold">Atividade:</div>
                                                    <div class="col-7 fs-6">{{ $apr->descricao_atividade }}</div>
                                                </div>
                                            </div>

                                            <!-- COLUNA 2 -->
                                            <div class="col-12 col-md-6">
                                                <div class="row mb-0">
                                                    <div class="col-5 fw-bold">Elaborado:</div>
                                                    <div class="col-7 fs-6">
                                                        {{ $apr->responsavel->primeiro_nome }} {{ $apr->responsavel->ultimo_nome }}
                                                    </div>
                                                </div>

                                                <div class="row mb-0">
                                                    <div class="col-5 fw-bold">Assinatura:</div>
                                                    <div class="col-7">
                                                        <div class="border rounded px-2 py-1 text-center bg-light small">
                                                            {{ $apr->assinatura_responsavel ?? '____________________' }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-0">
                                                    <div class="col-5 fw-bold">Status:</div>
                                                    <div style="border-radius:4px;width:300px;padding:5px;">
                                                        @if($apr->status === 'aberta')
                                                        <div style="border-radius:4px;background:#198754;">Aberta</div>
                                                        @endif
                                                        @if($apr->status === 'Verificada')
                                                        <div style="border-radius:4px;background:#198754;">Verificada</div>
                                                        @endif
                                                        @if($apr->status === 'finalizada')
                                                        <div style="border-radius:4px;background:#0d6efd;">Finalizada</div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="row mb-0">
                                                    <div class="col-5 fw-bold">Validade:</div>
                                                    <div class="col-7 fs-6">
                                                        {{ $apr->validade
                        ? \Carbon\Carbon::parse($apr->validade)->format('d/m/Y')
                        : 'Não definida'
                    }}
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!---->
                                </div>
                            </div>

                        </div>
                        {{-- FORMULÁRIO DE EDIÇÃO DA APR --}}
                        <div class="card border-danger mb-4">
                            <div class="card-header bg-danger  text-white py-3">
                                <h5 class="mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i> ANÁLISE DE RISCOS
                                </h5>
                                <p class="mb-0 opacity-75">Marque os riscos identificados para esta atividade</p>
                            </div>

                            <div class="card-body">
                                @foreach ($riscos as $tipo => $listaRiscos)
                                {{-- CABEÇALHO DO TIPO DE RISCO --}}
                                <div class="risk-type-header" style="background-color: rgb(255, 193, 7,0.5); padding: 10px; margin-bottom: 10px; border-radius: 4px;">
                                    <strong style="font-size: 1.1rem; text-transform: uppercase;">{{ $tipo }}</strong>
                                </div>

                                @foreach ($listaRiscos as $risco)
                                @php
                                $apr_risco_salvo = collect($apr_riscos)->first(function($r) use ($risco) {
                                return $r->risco_id == $risco->id;
                                });
                                @endphp

                                <div style="border: 1px solid #dee2e6; margin-bottom: 20px; padding: 15px; border-radius: 5px;background: rgb(25, 135, 84,0.2);">

                                    {{-- CABEÇALHO DO RISCO --}}
                                    <div class="risco-container" id="container_risco_{{ $risco->id }}" style="margin-bottom: 10px;">
                                        <div style="font-weight: 700; color: #0d6efd; margin-bottom: 5px;">
                                            Risco: {{ $risco->id }} - {{ $risco->nome }}
                                            <!-- Input hidden com ID único para cada risco -->
                                            <input type="input" id="apr_risco_id_{{ $risco->id }}" value="{{ $apr_risco_salvo->id ?? 0 }}" hidden>
                                        </div>
                                        <div style="color: #33373a; background: rgb(253, 126, 20,0.3); padding:5px; border-radius:5px;">
                                            Descrição: {{ $risco->descricao }}
                                        </div>
                                    </div>

                                    {{-- CONTROLES --}}
                                    <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 15px; border: 1px solid #dee2e6; padding: 10px; border-radius: 4px;">
                                        {{-- PROBABILIDADE --}}
                                        <div style="flex: 1; min-width: 150px;">
                                            <div style="margin-bottom: 5px; font-weight: 500;">Probabilidade</div>
                                            <select name="riscos[{{ $risco->id }}][probabilidade]" class="form-select form-select-sm">
                                                <option value="baixa" {{ ($apr_risco_salvo->probabilidade ?? '') == 'Baixa' ? 'selected' : '' }}>Baixa</option>
                                                <option value="media" {{ ($apr_risco_salvo->probabilidade ?? '') == 'Media' ? 'selected' : '' }}>Média</option>
                                                <option value="alta" {{ ($apr_risco_salvo->probabilidade ?? '') == 'Alta' ? 'selected' : '' }}>Alta</option>
                                            </select>
                                        </div>

                                        {{-- SEVERIDADE --}}
                                        <div style="flex: 1; min-width: 150px;">
                                            <div style="margin-bottom: 5px; font-weight: 500;">Severidade</div>
                                            <select name="riscos[{{ $risco->id }}][severidade]" class="form-select form-select-sm">
                                                <option value="leve" {{ ($apr_risco_salvo->severidade ?? '') == 'Leve' ? 'selected' : '' }}>Leve</option>
                                                <option value="moderada" {{ ($apr_risco_salvo->severidade ?? '') == 'Moderada' ? 'selected' : '' }}>Moderada</option>
                                                <option value="grave" {{ ($apr_risco_salvo->severidade ?? '') == 'Grave' ? 'selected' : '' }}>Grave</option>
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
                                            <div class="text-center {{ $classeGrau }}"
                                                style="padding: 6px; border-radius: 4px;"
                                                id="grau_risco_{{ $risco->id }}">
                                                {{ $grauExibido }}
                                            </div>
                                        </div>

                                        {{-- IDENTIFICADO --}}
                                        <div>
                                            {{-- IDENTIFICADO --}}
                                            <input type="checkbox"
                                                id="chk_risco_{{ $risco->id }}"
                                                name="riscos[{{ $risco->id }}][identificado]"
                                                class="form-check-input risco-identificado"
                                                data-risco-id="{{ $risco->id }}"
                                                data-risco-nome="{{ $risco->nome }}"
                                                style="width:20px;height:20px;"
                                                {{ $apr_risco_salvo ? 'checked' : '' }}>

                                        </div>
                                    </div>
                                    {{--Medidas--}}
                                    @foreach($riscos_medidas_controle as $medida)
                                    @if($medida->risco_id == $risco->id)
                                    @php
                                    $medidaSalva = $apr_riscos_medidas->firstWhere('medida_id', $medida->id);
                                    $status = $medidaSalva->status ?? null; // 1 = existente, 0 = inexistente, null = não marcado ainda
                                    @endphp

                                    <div class="medidas-bloco" style="display: flex; align-items: center; margin-bottom: 8px;">

                                        <!-- Radio "Sim" -->
                                        <label style="background-color: #198754; color: white; padding: 4px 8px; border-radius: 4px; margin-right: 10px;">
                                            <input type="radio"
                                                name="medida_{{ $medida->id }}"
                                                value="existente"
                                                class="medida-radio"
                                                data-medida-id="{{ $medida->id }}"
                                                {{ $status === 1 ? 'checked' : '' }}>
                                            Sim
                                        </label>

                                        <!-- Radio "Não" -->
                                        <label style="background-color: #fdda14; padding: 4px 8px; border-radius: 4px; margin-right: 10px;">
                                            <input type="radio"
                                                name="medida_{{ $medida->id }}"
                                                value="inexistente"
                                                class="medida-radio"
                                                data-medida-id="{{ $medida->id }}"
                                                {{ $status === 0 ? 'checked' : '' }}>
                                            Não
                                        </label>

                                        <span>{{ $medida->descricao }}</span>
                                    </div>
                                    @endif
                                    @endforeach

                                    <!-- Botão por bloco de risco -->
                                    <button type="button" class="btnSalvarMedidas btn btn-primary mt-2"
                                        data-apr-risco-id="{{ $apr_risco_salvo->id ?? 0 }}">

                                        Confirmar alterações
                                    </button>
                                    {{-- MATERIAIS DE RISCO --}}
                                    <div style="margin-top: 15px;">
                                        <div style="font-weight: 600; margin-bottom: 10px;">
                                            Materiais Relacionados EPIs: <i class="bi bi-cone-striped"></i>
                                        </div>
                                        @if(isset($apr_risco_salvo) && $apr_risco_salvo->grau > 1)
                                        <form class="form-verifica-epis" data-apr-risco-id="{{ $apr_risco_salvo->id }}" style="display: flex; flex-wrap: wrap; gap: 15px;">
                                            @foreach($materiais_risco as $material_risco)
                                            @if($material_risco->risco_id == $risco->id)
                                            {{--Marca o checkbox  se epis estiver 1--}}
                                            <div style="flex: 1 1 300px; border: solid 1px rgba(33,37,41,0.3); padding: 10px; border-radius: 5px;">
                                                @php
                                                $epiConfirmado = isset($apr_risco_salvo->epis)
                                                && $apr_risco_salvo->epis == 1;
                                                @endphp

                                                <input
                                                    type="checkbox"
                                                    name="epis[]"
                                                    value="{{ $material_risco->id }}"
                                                    {{ $epiConfirmado ? 'checked disabled' : 'required' }}>
                                                <strong>{{ $material_risco->material->nome ?? 'Material não encontrado' }}</strong>
                                                <br>
                                                <small>{{ $material_risco->observacoes }}</small>
                                            </div>
                                            @endif
                                            @endforeach

                                            @if($apr_risco_salvo->epis != 1)
                                            <button type="submit" class="btn btn-success" style="margin-top: 5px;">
                                                Confirmar verificação de EPIs
                                            </button>
                                            @endif
                                        </form>
                                        @endif

                                    </div>

                                    {{-- MATERIAIS DE RISCO fim --}}
                                </div>
                                @endforeach
                                @endforeach
                            </div>
                        </div>
                        <!--Fim do corpo dos riscos-->
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
                    <div class="mt-4" hidden>
                        <label for="observacoes" class="form-label fw-bold">
                            <i class="fas fa-sticky-note me-2"></i>Observações Adicionais
                        </label>
                    </div>
                </div>
            </div>


            {{-- CAMPO DE ASSINATURA --}}
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <label for="assinatura_responsavel" class="form-label fw-bold">
                            Digite sua assinatura:
                        </label>

                        <input type="text"
                            class="form-control form-control-lg w-100"
                            id="assinatura_responsavel"
                            name="assinatura_responsavel"
                            value="{{ old('assinatura_responsavel', $apr->assinatura_responsavel ?? '') }}"
                            placeholder="Digite seu nome completo para assinar">

                        <div class="form-text">
                            Esta assinatura confirma sua responsabilidade sobre a análise de riscos.
                        </div>
                    </div>
                </div>
            </div>


            {{-- BOTÕES DE AÇÃO --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 p-3 border rounded bg-light">
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <form action="{{ route('apr.confirmar', $apr->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-exclamation-triangle-fill"></i> Confirmar Análise
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSucessoRisco" tabindex="-1" aria-labelledby="modalSucessoRiscoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-success">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="modalSucessoRiscoLabel">Sucesso</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Risco salvo com sucesso!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="recarrega()">OK</button>
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
<meta name="csrf-token" content="{{ csrf_token() }}">
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

<script>
    //  Bloco que lida com radiobox medidas de controle
    document.addEventListener('click', function(e) {
        //apr_risco_id_{{ $risco->id }}
        if (e.target && e.target.matches('.btnSalvarMedidas')) {
            const botao = e.target;
            const apr_risco_id = botao.dataset.aprRiscoId;

            // Pega todos os radios dentro do mesmo bloco de medidas
            const container = botao.closest('div');
            const medidas = {};
            container.querySelectorAll('.medida-radio:checked').forEach(input => {
                medidas[input.dataset.medidaId] = input.value;
            });

            console.log("APR Risco ID:", apr_risco_id);
            console.log("Medidas selecionadas:", medidas);
            // Fetch para enviar para Laravel
            fetch("{{ url('/apr/risco/medida/toggle') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        apr_risco_id: apr_risco_id,
                        medidas: medidas
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) alert('Alterações salvas com sucesso!');
                    else alert('Erro ao salvar alterações!');
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Ocorreu um erro inesperado. Veja o console ou o log do Laravel.');
                });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Seleciona todos os formulários de verificação
        const forms = document.querySelectorAll('.form-verifica-epis');

        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // impede o envio tradicional

                // Pega todos os checkboxes deste formulário
                const checkboxes = form.querySelectorAll('input[type="checkbox"]');

                // Verifica se todos estão marcados
                const todosMarcados = Array.from(checkboxes).every(chk => chk.checked);

                if (!todosMarcados) {
                    alert('Você precisa marcar todos os EPIs antes de confirmar!');
                    return;
                }

                // Se todos estiverem marcados, prepara os dados para enviar
                const aprRiscoId = form.dataset.aprRiscoId;
                const epis = Array.from(checkboxes).map(chk => chk.value);
                //alert(aprRiscoId+epis)
                // Envia via AJAX (fetch)
                fetch("{{url('/apr-verifica-epis')}}", { // Substitua pela sua rota
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            apr_risco_id: aprRiscoId,
                            epis: epis
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Todos os EPIs do risco foram verificados!');
                        } else {
                            alert('Ocorreu um erro ao registrar a verificação.');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        alert('Erro na requisição.');
                    });
            });
        });
    });
</script>

@endsection