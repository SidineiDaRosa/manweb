@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header pb-2">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0">Check-List Executado por Equipamento</h6>
                <div>
                    <button type="button" class="btn btn-outline-success btn-sm"
                        onclick="window.location.href='{{ route('check-list-index') }}'"
                        style="margin-left:5px;">
                        Check-List índice
                    </button>
                    <button type="button" class="btn btn-outline-success btn-sm"
                        onclick="window.location.href='{{ route('app.home') }}'"
                        style="margin-left:5px;">
                        Dashboard
                    </button>
                </div>
            </div>

            <!-- Estatísticas (novo) -->
            @if(isset($check_list_executado) && count($check_list_executado) > 0)
            <div class="mt-2 mb-3 p-2 bg-light rounded d-flex justify-content-between text-center">
                <div>
                    <strong class="text-primary">{{ count($check_list_executado) }}</strong>
                    <div class="text-muted" style="font-size: 0.8rem">Total</div>
                </div>
                <div>
                    <strong class="text-success">{{ $check_list_executado->where('observacao', 'Normal')->count() }}</strong>
                    <div class="text-muted" style="font-size: 0.8rem">Normais</div>
                </div>
                <div>
                    <strong class="text-danger">{{ $check_list_executado->where('gravidade', 4)->count() }}</strong>
                    <div class="text-muted" style="font-size: 0.8rem">Gravíssimos</div>
                </div>
                <div>
                    <strong class="text-warning">{{ number_format($check_list_executado->avg('temperatura'), 1) }}°C</strong>
                    <div class="text-muted" style="font-size: 0.8rem">Temp. Média</div>
                </div>
            </div>
            @endif

            <!-- FILTRO -->
            <form action="{{ route('checklist.executado') }}" method="post" id="form_filter_check_list">
                @csrf
                <div style="display: flex; flex-wrap: wrap; gap: 5px; align-items: center;">
                    <input type="date" class="form-control form-control-sm" name="data_inicio"
                        value="{{ old('data_inicio') }}" style="width: 150px">

                    <input type="date" class="form-control form-control-sm" name="data_fim"
                        value="{{ old('data_fim') }}" style="width: 150px">

                    <input type="text" class="form-control form-control-sm" name="descricao"
                        value="{{ old('descricao') }}" style="width: 250px"
                        placeholder="--Digite uma descrição para busca--"
                        maxlength="100">

                    <select class="form-control form-control-sm" name="natureza" style="width: 180px;">
                        <option value="">-- ⚠️ Gravidade --</option>
                        <option value="1" {{ old('natureza') == '1' ? 'selected' : '' }}>🟢 Normal</option>
                        <option value="2" {{ old('natureza') == '2' ? 'selected' : '' }}>🟡 Médio</option>
                        <option value="3" {{ old('natureza') == '3' ? 'selected' : '' }}>🟠 Alto</option>
                        <option value="4" {{ old('natureza') == '4' ? 'selected' : '' }}>🔴 Gravíssimo</option>
                    </select>

                    <select class="form-control form-control-sm" name="equipamento" style="width: 250px;">
                        <option value="">--Selecione um equipamento 🚜--</option>
                        @foreach($equipamentos as $equipamento)
                        <option value="{{ $equipamento->id }}" {{ old('equipamento') == $equipamento->id ? 'selected' : '' }}>
                            {{ htmlspecialchars($equipamento->nome, ENT_QUOTES, 'UTF-8') }}
                        </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-outline-success btn-sm">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
        
        <!--Div conteudo-->
        <div style="margin-top:10px;">
            @if(isset($check_list_executado) && count($check_list_executado) > 0)
            @foreach($check_list_executado as $c)
            <div class="checklist-item" style="display:flex; flex-wrap:wrap; gap:10px; padding:10px; border-bottom:1px solid #eee; align-items:flex-start;">
                <!-- Dados principais -->
                <div style="flex: 1; display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px;">
                    <!-- ID Checagem -->
                    <div>
                        <strong>ID Checagem:</strong><br>
                        <span class="text-primary">{{ $c->id }}</span>
                    </div>
                   
                    <!-- Checklist -->
                    <div>
                        <strong>Checklist:</strong><br>
                        <small class="text-muted">ID: {{ $c->checkList->id ?? '—' }}</small><br>
                        <span title="{{ htmlspecialchars($c->checkList->descricao ?? 'Sem descrição', ENT_QUOTES, 'UTF-8') }}">
                            {{ htmlspecialchars(Str::limit($c->checkList->descricao ?? 'Sem descrição', 40), ENT_QUOTES, 'UTF-8') }}
                        </span>
                    </div>

                    <!-- Observação -->
                    <div>
                        <strong>Observação:</strong><br>
                        <span style="color: {{ $c->observacao === 'Normal' ? 'green' : 'orange' }};">
                            @if($c->observacao === 'Normal')
                            ✅
                            @else
                            ⚠️
                            @endif
                            {{ htmlspecialchars($c->observacao, ENT_QUOTES, 'UTF-8') }}
                        </span>
                    </div>

                    <!-- Funcionário -->
                    <div>
                        <strong>Funcionário:</strong><br>
                        {{ htmlspecialchars($c->funcionario, ENT_QUOTES, 'UTF-8') }}
                    </div>

                    <!-- Barra de temperatura -->
                    <div>
                        <strong>Temperatura <i class="bi bi-thermometer"></i>:</strong><br>
                        <div style="background:#e0e0e0; border-radius:5px; height:22px; margin-top:5px;">
                            <div style="
                                width: {{ min(100, ($c->temperatura / 200) * 100) }}%;
                                height:100%;
                                background:
                                @if($c->temperatura < 60)
                                    #88e1d9
                                @elseif($c->temperatura <= 100)
                                    #ffecb5
                                @else
                                    #f25b61
                                @endif;
                                border-radius:5px;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-size:0.8rem;
                                color: #000;
                            ">
                                {{ $c->temperatura }}°C
                            </div>
                        </div>
                    </div>

                    <!-- Vibração -->
                    <div>
                        <strong>Vibração<i class="bi bi-phone-vibrate"></i></strong><br>
                        <span style="background: {{ $c->vibracao < 50 ? '#28a745' : '#dc3545' }}; 
                              color: white; padding: 2px 8px; border-radius: 3px; font-size: 0.9rem;">
                            {{ $c->vibracao }}
                        </span>
                    </div>

                    <!-- Gravidade -->
                    <div>
                        <strong>Gravidade:</strong><br>
                        @php
                        $gravidadeConfig = [
                        1 => ['cor' => 'rgb(136,225,217)', 'label' => 'Normal', 'emoji' => '🟢'],
                        2 => ['cor' => 'rgb(255,224,157)', 'label' => 'Médio', 'emoji' => '🟡'],
                        3 => ['cor' => 'rgb(255,183,93)', 'label' => 'Alto', 'emoji' => '🟠'],
                        4 => ['cor' => 'rgb(242,91,97)', 'label' => 'Gravíssimo', 'emoji' => '🔴'],
                        ];
                        $grav = $gravidadeConfig[$c->gravidade] ?? $gravidadeConfig[1];
                        @endphp
                        <div style="padding:5px; background:{{ $grav['cor'] }}; border-radius:4px;">
                            {{ $grav['emoji'] }} {{ $grav['label'] }} ({{ $c->gravidade }})
                        </div>
                    </div>

                    <!-- Data/Hora -->
                    <div>
                        <strong>Data:</strong><br>
                        {{ \Carbon\Carbon::parse($c->data_verificacao)->format('d/m/Y') }}<br>
                        <small class="text-muted">{{ $c->hora_verificacao }}</small>
                    </div>

                    <!-- Status -->
                    <div>
                        <strong>Status:</strong><br>
                        <span style="background: {{ strtolower($c->status) === 'concluído' ? '#28a745' : '#6c757d' }}; 
                              color: white; padding: 2px 8px; border-radius: 3px; font-size: 0.9rem;">
                            {{ htmlspecialchars($c->status, ENT_QUOTES, 'UTF-8') }}
                        </span>
                    </div>
                </div>
                
                <!-- IMAGEM (agora alinhada à direita) -->
                <div style="flex-shrink: 0; width: 150px; text-align: center;">
                    <strong>Imagem:</strong><br>
                    @if($c->imagem)
                    @php
                    $imagemPath = ltrim($c->imagem, '/');
                    $caminhoCompleto = public_path($imagemPath);
                    @endphp

                    @if(file_exists($caminhoCompleto))
                    <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $c->id }}">
                        <img src="{{ asset($imagemPath) }}"
                            style="max-width:150px; max-height:100px; object-fit:cover; border-radius:4px; cursor:pointer;"
                            alt="Checklist {{ $c->id }}"
                            title="Clique para ampliar">
                    </a>

                    <!-- Modal para imagem ampliada -->
                    <div class="modal fade" id="imageModal{{ $c->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title">
                                        Imagem - Checklist #{{ $c->id }}
                                    </h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ asset($imagemPath) }}"
                                        class="img-fluid rounded"
                                        alt="Imagem completa checklist {{ $c->id }}">
                                    <div class="mt-3">
                                        <small class="text-muted">
                                            Caminho: {{ $imagemPath }}
                                        </small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="{{ asset($imagemPath) }}"
                                        download
                                        class="btn btn-sm btn-primary">
                                        📥 Baixar
                                    </a>
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                                        Fechar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <span class="text-danger" title="Arquivo não encontrado: {{ $imagemPath }}">
                        ❌ Imagem não disponível
                    </span>
                    @endif
                    @else
                    <span class="text-muted">—</span>
                    @endif
                </div>
            </div>
            @endforeach
            @else
            <p class="text-center text-muted py-4">Nenhum registro encontrado.</p>
            @endif
        </div>
    </div>
</main>

<style>
    /* Melhorias no layout */
    .checklist-item {
        transition: background-color 0.3s;
    }
    
    .checklist-item:hover {
        background-color: #f8f9fa;
    }
    
    /* Responsividade */
    @media (max-width: 1200px) {
        .card-header>div>div {
            width: 100% !important;
            margin-bottom: 5px;
        }

        .card-header>div {
            flex-direction: column;
            align-items: flex-start !important;
        }
        
        .checklist-item > div:first-child {
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .card-header form>div {
            flex-direction: column;
        }

        .card-header form>div>* {
            width: 100% !important;
            margin-bottom: 5px;
        }
        
        .checklist-item {
            flex-direction: column;
        }
        
        .checklist-item > div:first-child {
            order: 2;
        }
        
        .checklist-item > div:last-child {
            order: 1;
            width: 100% !important;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
    }

    @media (max-width: 576px) {
        .checklist-item > div:first-child {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection