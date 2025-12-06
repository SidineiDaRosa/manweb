@extends('app.layouts.app')

@section('content')
<div class="container">

    <h2 class="mb-4">Análise Preliminar de Risco (APR) – Simples</h2>

    <form method="POST" action="{{ route('apr.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- DADOS DA APR -->
        <div class="card mb-4">
            <div class="card-header">Dados da APR</div>
            <div class="card-body">

                <input type="hidden" name="os_id" value="{{ $ordem->id }}">

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Ordem de Serviço</label>
                        <input type="text" class="form-control" value="{{ $ordem->id }}" disabled>
                    </div>

                    <div class="col-md-4">
                        <label>Solicitante</label>
                        <input type="text" class="form-control" value="{{ $ordem->solicitante ?? '---' }}" disabled>
                    </div>

                    <div class="col-md-4">
                        <label>Data</label>
                        <input type="date" name="data" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                </div>

                <label>Ativo</label>
                <select class="form-control" name="ativo_id">
                    @foreach($ativos as $a)
                        <option value="{{ $a->id }}" 
                            @if($ordem->ativo_id == $a->id) selected @endif>
                            {{ $a->nome }}
                        </option>
                    @endforeach
                </select>

            </div>
        </div>

        <!-- ITENS SIMPLES -->
        <div class="card mb-4">
            <div class="card-header">Itens de Análise</div>
            <div class="card-body">

                @php
                    $itensSimples = [
                        "Descrição da atividade",
                        "Perigo / risco identificado",
                        "Medida de controle sugerida",
                    ];
                @endphp

                @foreach($itensSimples as $item)
                <div class="mb-3 p-2 border rounded">
                    
                    <label class="fw-bold">{{ $item }}</label>
                    <input type="text" 
                           name="geral[{{ $item }}][obs]" 
                           class="form-control" 
                           placeholder="Insira aqui...">

                    <label class="mt-2">Foto (opcional)</label>
                    <input type="file" name="geral[{{ $item }}][foto]" class="form-control">

                </div>
                @endforeach

            </div>
        </div>

        <!-- EPIs -->
        <div class="card mb-4">
            <div class="card-header">EPI Obrigatório</div>
            <div class="card-body">

                <div class="d-flex flex-wrap gap-3">
                    @foreach(["Capacete","Óculos","Luva","Bota","Colete","Protetor auricular"] as $epi)
                        <label><input type="checkbox" name="epi[]" value="{{ $epi }}"> {{ $epi }}</label>
                    @endforeach
                </div>

            </div>
        </div>

        <!-- OBSERVAÇÕES -->
        <div class="card mb-4">
            <div class="card-header">Observações Gerais</div>
            <div class="card-body">
                <textarea name="observacoes" class="form-control" rows="3"></textarea>
            </div>
        </div>

        <!-- STATUS -->
        <div class="card mb-4">
            <div class="card-header">Liberação</div>
            <div class="card-body">

                <label>Status</label>
                <select class="form-control mb-3" name="status">
                    <option value="liberado">Liberado</option>
                    <option value="restricao">Liberado com restrição</option>
                    <option value="bloqueado">Não liberado</option>
                </select>

                <label>Responsável</label>
                <input class="form-control" name="responsavel" value="{{ Auth::user()->name }}">

            </div>
        </div>

        <!-- BOTÃO -->
        <button class="btn btn-primary w-100">Salvar APR</button>

    </form>
</div>
@endsection
