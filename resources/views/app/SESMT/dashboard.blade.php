{{-- resources/views/app/SESMT/dashboard.blade.php --}}

@extends('app.layouts.app')

@section('content')
<main class="content">

    <h5 class="page-title">SESMT</h5>

    <!-- Menu rápido -->
    <div class="quick-menu">
        <div class="menu-item">
            <i class="fas fa-exclamation-triangle"></i>
            <a href="{{ route('riscos.medidas') }}">Riscos identificados</a>
        </div>

        <div class="menu-item">
            <i class="fas fa-user-hard-hat"></i>
            <a href="{{ route('material_epis.index') }}">Materiais EPIs</a>
        </div>
    </div>

    <!-- Main Sections -->
    <div class="main-sections">

        <!-- APRs Recentes -->
        <div class="section">
            <div class="section-header">
                <div class="section-title">APRs Recentes</div>
                <div class="section-actions">
                    <a href="{{ route('apr.index') }}" class="btn btn-outline">Ver Todas</a>
                </div>
            </div>
            <!--tabela aprs-->
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Local</th>
                            <th>Atividade</th>
                            <th>Responsável</th>
                            <th>Prazo</th>
                            <th>Prioridade</th>
                            <th>Status</th>
                            <th>Grau de Risco</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aprs as $apr)
                        <tr>
                            <td>
                                <a class="txt-link" href="{{ route('apr.show',['apr_id'=>$apr->id]) }}">
                                    <strong>#{{ $apr->id }}</strong>
                                </a>
                            </td>
                            <td>{{ $apr->localizacao->nome }}</td>
                            <td>{{ $apr->descricao_atividade }}</td>
                            <td>{{ $apr->responsavel->primeiro_nome }} {{ $apr->responsavel->ultimo_nome }}</td>
                            <td>{{ \Carbon\Carbon::parse($apr->prazo)->format('d/m/Y') }}</td>

                            <td>
                                <span class="priority {{ strtolower($apr->prioridade) }}"></span>
                                {{ ucfirst($apr->prioridade) }}
                            </td>

                            <td>
                                <span class="status {{ strtolower($apr->status) }}">
                                    {{ ucfirst($apr->status) }}
                                </span>
                            </td>

                            <td>
                                @php
                                $contagem = ['baixo'=>0,'medio'=>0,'alto'=>0,'critico'=>0];

                                foreach($riscos as $risco) {
                                if($risco->apr_id == $apr->id) {
                                if ($risco->grau <= 2) $contagem['baixo']++;
                                    elseif ($risco->grau == 3) $contagem['medio']++;
                                    elseif ($risco->grau == 4) $contagem['alto']++;
                                    else $contagem['critico']++;
                                    }
                                    }

                                    $totalRiscos = array_sum($contagem);

                                    if ($contagem['critico'] > 0) { $class='critico'; $piorGrau='Crítico'; }
                                    elseif ($contagem['alto'] > 0) { $class='alto'; $piorGrau='Alto'; }
                                    elseif ($contagem['medio'] > 0) { $class='medio'; $piorGrau='Médio'; }
                                    elseif ($contagem['baixo'] > 0) { $class='baixo'; $piorGrau='Baixo'; }
                                    else { $class=''; $piorGrau='Sem riscos'; }
                                    @endphp

                                    <div class="mini-risk {{ $class }}">
                                        @if($totalRiscos > 0)
                                        <strong>{{ $piorGrau }}</strong>
                                        <div class="risk-counts">
                                            @if($contagem['critico'] > 0) 🔴 {{ $contagem['critico'] }} @endif
                                            @if($contagem['alto'] > 0) 🟠 {{ $contagem['alto'] }} @endif
                                            @if($contagem['medio'] > 0) 🟡 {{ $contagem['medio'] }} @endif
                                            @if($contagem['baixo'] > 0) 🟢 {{ $contagem['baixo'] }} @endif
                                        </div>
                                        <small>{{ $totalRiscos }} risco(s)</small>
                                        @else
                                        <small>Sem riscos</small>
                                        @endif
                                    </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>

<style>
    /* Layout base */
    .page-title {
        margin-bottom: 20px;
        font-weight: 600;
    }

    /* Menu rápido */
    .quick-menu {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .menu-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 18px;
        background: #f5f7fa;
        border-radius: 8px;
        cursor: pointer;
        transition: 0.2s;
    }

    .menu-item:hover {
        background: #e9eef5;
    }

    .menu-item a {
        text-decoration: none;
        color: #333;
        font-weight: 500;
    }

    /* Sections */
    .main-sections {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .section {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 600;
    }

    .section-actions .btn {
        margin-left: 10px;
    }

    /* Mini risk */
    .mini-risk {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 8px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: bold;
        color: #fff;
        min-height: 70px;
    }

    .mini-risk.baixo {
        background: linear-gradient(135deg, #28a745, #20c997);
    }

    .mini-risk.medio {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        color: #000;
    }

    .mini-risk.alto {
        background: linear-gradient(135deg, #fd7e14, #dc3545);
    }

    .mini-risk.critico {
        background: linear-gradient(135deg, #dc3545, #721c24);
    }

    .risk-counts {
        font-size: 10px;
        margin: 4px 0;
    }
</style>

@endsection