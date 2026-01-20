@extends('layouts.app') {{-- Se você tiver um layout padrão --}}

@section('content')
<div class="container">

    <div class="card mb-3">
        <div class="card-header text-center">
            <h2>PERMISSÃO DE TRABALHO (PT)</h2>
        </div>
        <div class="card-body">

            {{-- Informações principais --}}
            <div class="mb-3">
                <span class="badge bg-secondary">PT Nº: {{ $pt->id ?? '____' }}</span>
                <span class="badge bg-secondary">APR Nº: {{ $apr->id }}</span>
                <span class="badge bg-secondary">Data: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</span>
            </div>

            {{-- Serviço --}}
            <div class="border p-3 mb-3">
                <p><strong>Serviço a ser executado:</strong> {{ $apr->descricao_atividade }}</p>
                <p><strong>Local:</strong> {{ $apr->localizacao->nome }}</p>
                <p><strong>Responsável pelo serviço:</strong> {{ $apr->responsavel->primeiro_nome }} {{ $apr->responsavel->ultimo_nome }}</p>
                <p><strong>Status APR:</strong> {{ strtoupper($apr->status) }}</p>
            </div>

            {{-- Riscos / Medidas --}}
            <h4>Riscos / Medidas verificadas</h4>
            @foreach ($riscos as $tipo => $listaRiscos)
                @foreach ($listaRiscos as $risco)
                    @php
                        $apr_risco_salvo = collect($apr_riscos)->first(fn($r) => $r->risco_id == $risco->id);
                    @endphp
                    @if($apr_risco_salvo)
                        @php
                            $medidas_selecionadas = $riscos_medidas_controle
                                ->where('risco_id', $risco->id)
                                ->filter(fn($m) => $apr_riscos_medidas
                                    ->where('apr_risco_id', $apr_risco_salvo->id)
                                    ->where('medida_id', $m->id)
                                    ->first()
                                );
                        @endphp
                        @if($medidas_selecionadas->count())
                            <div class="border p-2 mb-2">
                                <strong>{{ $risco->nome }}:</strong>
                                <ul>
                                    @foreach($medidas_selecionadas as $medida)
                                        <li>{{ $medida->descricao }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endif
                @endforeach
            @endforeach

            {{-- Materiais --}}
            <h4>Materiais que serão usados</h4>
            @if($materiais_selecionados->count())
                <ul>
                    @foreach($materiais_selecionados as $material)
                        <li>{{ $material->nome }} @if($material->observacoes) - {{ $material->observacoes }}@endif</li>
                    @endforeach
                </ul>
            @else
                <p>Nenhum material selecionado para os riscos cadastrados.</p>
            @endif

            {{-- Datas e observações --}}
            <div class="mb-3">
                <p><strong>Data/Hora de Início:</strong> __________________________</p>
                <p><strong>Data/Hora de Término:</strong> ________________________</p>
                <p><strong>Observações / Procedimentos especiais:</strong></p>
                <div class="border p-2" style="min-height: 50px;"></div>
            </div>

            {{-- Assinaturas --}}
            <div class="d-flex justify-content-between mt-4">
                <div class="text-center" style="width:30%;">
                    <p>Solicitante:</p>
                    <span style="display:block; margin-top:60px; border-top:1px solid #000;">{{ $pt->solicitante ?? '________________' }}</span>
                </div>
                <div class="text-center" style="width:30%;">
                    <p>Responsável Técnico:</p>
                    <span style="display:block; margin-top:60px; border-top:1px solid #000;">{{ $pt->responsavel_tecnico ?? '________________' }}</span>
                </div>
                <div class="text-center" style="width:30%;">
                    <p>Liberação do Trabalho:</p>
                    <span style="display:block; margin-top:60px; border-top:1px solid #000;">{{ $pt->liberacao ?? '________________' }}</span>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
