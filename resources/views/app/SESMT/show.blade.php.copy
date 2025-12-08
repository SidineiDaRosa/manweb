@extends('app.layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">Análise Preliminar de Risco (APR)</h2>

    <form method="POST" action="{{ route('apr.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- DADOS INICIAIS -->
        <div class="card mb-4">
            <div class="card-header">Dados da APR</div>
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Ordem de Serviço</label>
                        <select class="form-control" name="os_id">
                            @foreach($ordens as $os)
                                <option value="{{ $os->id }}">{{ $os->id }} - {{ $os->titulo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Ativo</label>
                        <select class="form-control" name="ativo_id">
                            @foreach($ativos as $a)
                                <option value="{{ $a->id }}">{{ $a->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Data</label>
                        <input type="date" name="data" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                </div>

            </div>
        </div>

        <!-- NR12 -->
        <div class="card mb-4">
            <div class="card-header">NR-12 – Máquinas e Equipamentos</div>
            <div class="card-body">

                @php
                    $nr12Itens = [
                        "Partes móveis expostas",
                        "Falta de proteções fixas ou móveis",
                        "Risco de esmagamento",
                        "Risco de corte ou cisalhamento",
                        "Risco de impacto ou projeção",
                        "Sistema de parada de emergência inoperante",
                        "Intertravamento com defeito",
                    ];
                @endphp

                @foreach($nr12Itens as $item)
                <div class="mb-3 p-2 border rounded">
                    <label class="fw-bold">{{ $item }}</label>

                    <div class="d-flex gap-4 mt-2">
                        <label><input type="checkbox" name="nr12[{{ $item }}][ok]"> Está seguro</label>
                        <label><input type="checkbox" name="nr12[{{ $item }}][risco]"> Risco identificado</label>
                    </div>

                    <label class="mt-2">Medidas / Observações</label>
                    <textarea class="form-control" name="nr12[{{ $item }}][obs]" rows="2"></textarea>

                    <label class="mt-2">Foto (se houver risco)</label>
                    <input type="file" name="nr12[{{ $item }}][foto]" class="form-control">
                </div>
                @endforeach

            </div>
        </div>

        <!-- NR10 -->
        <div class="card mb-4">
            <div class="card-header">NR-10 – Riscos Elétricos</div>
            <div class="card-body">

                @php
                    $nr10Itens = [
                        "Trabalho energizado",
                        "Painel com partes vivas expostas",
                        "Aterramento inadequado",
                        "LOTO aplicado corretamente",
                        "Ferramentas isoladas",
                        "Distância segura respeitada",
                        "Equipamento desligado e testado",
                    ];
                @endphp

                @foreach($nr10Itens as $item)
                <div class="mb-3 p-2 border rounded">
                    <label class="fw-bold">{{ $item }}</label>

                    <div class="d-flex gap-4 mt-2">
                        <label><input type="checkbox" name="nr10[{{ $item }}][ok]"> Está seguro</label>
                        <label><input type="checkbox" name="nr10[{{ $item }}][risco]"> Risco identificado</label>
                    </div>

                    <label class="mt-2">Medidas / Observações</label>
                    <textarea class="form-control" name="nr10[{{ $item }}][obs]" rows="2"></textarea>

                    <label class="mt-2">Foto (se houver risco)</label>
                    <input type="file" name="nr10[{{ $item }}][foto]" class="form-control">
                </div>
                @endforeach

            </div>
        </div>

        <!-- RISCOS GERAIS -->
        <div class="card mb-4">
            <div class="card-header">Riscos Gerais</div>
            <div class="card-body">

                @php
                    $riscosGerais = [
                        "Químicos (óleos, solventes, poeiras)",
                        "Ruído excessivo",
                        "Altura acima de 2 metros",
                        "Espaço confinado",
                        "Calor / solda / chama aberta",
                        "Movimentação de cargas",
                        "Escorregamento e queda",
                        "Animais peçonhentos",
                    ];
                @endphp

                @foreach($riscosGerais as $item)
                <div class="mb-3 p-2 border rounded">
                    <label class="fw-bold">{{ $item }}</label>

                    <div class="d-flex gap-4 mt-2">
                        <label><input type="checkbox" name="geral[{{ $item }}][ok]"> Está seguro</label>
                        <label><input type="checkbox" name="geral[{{ $item }}][risco]"> Risco identificado</label>
                    </div>

                    <label class="mt-2">Medidas / Observações</label>
                    <textarea class="form-control" name="geral[{{ $item }}][obs]" rows="2"></textarea>

                    <label class="mt-2">Foto (se houver risco)</label>
                    <input type="file" name="geral[{{ $item }}][foto]" class="form-control">
                </div>
                @endforeach

            </div>
        </div>

        <!-- MEDIDAS DE CONTROLE -->
        <div class="card mb-4">
            <div class="card-header">Medidas de Controle</div>
            <div class="card-body">

                <label class="fw-bold">EPI Obrigatório</label>
                <div class="d-flex flex-wrap gap-4 mb-3 mt-2">
                    @foreach(["Capacete","Óculos","Luva","Bota","Protetor auricular","Avental","Máscara"] as $epi)
                        <label><input type="checkbox" name="epi[]" value="{{ $epi }}"> {{ $epi }}</label>
                    @endforeach
                </div>

                <label class="fw-bold">EPC Implementado</label>
                <div class="d-flex flex-wrap gap-4 mb-3 mt-2">
                    @foreach(["Cone","Fita zebrada","Barreira física","Trava elétrica","Sinalização"] as $epc)
                        <label><input type="checkbox" name="epc[]" value="{{ $epc }}"> {{ $epc }}</label>
                    @endforeach
                </div>

                <label class="fw-bold">Observações gerais / medidas adicionais</label>
                <textarea class="form-control" name="observacoes" rows="3"></textarea>
            </div>
        </div>

        <!-- LIBERAÇÃO -->
        <div class="card mb-4">
            <div class="card-header">Liberação Final</div>
            <div class="card-body">
                
                <label class="fw-bold">Status da APR</label>
                <select class="form-control mb-3" name="status">
                    <option value="liberado">Liberado</option>
                    <option value="restricao">Liberado com restrição</option>
                    <option value="bloqueado">Não liberado</option>
                </select>

                <label>Responsável pela Liberação</label>
                <input class="form-control" name="responsavel" value="{{ Auth::user()->name }}">
            </div>
        </div>

        <!-- BOTÃO -->
        <button class="btn btn-primary w-100">Salvar APR</button>

    </form>
</div>
@endsection
