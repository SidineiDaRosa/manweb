{{-- resources/views/app/SESMT/apr_create.blade.php --}}

@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Cadastrar Análise Preliminar de Riscos (APR)</h1>
            <div class="text-muted mt-1">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('apr.index') }}">APRs</a></li>
                        <li class="breadcrumb-item active">Nova APR</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="align-middle me-2" data-feather="file-text"></i>
                            Ordem de Serviço: <span>#{{ $ordem->id }}</span>
                        </h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('apr.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="ordem_servico_id" value="{{ $ordem->id }}">

                            <div class="row">
                                {{-- Local de Trabalho --}}
                                <div class="col-md-6 mb-3">
                                    <label for="local_trabalho" class="form-label fw-bold">
                                        <i class="align-middle me-1" data-feather="map-pin"></i>
                                        Local de Trabalho <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-lg @error('local_trabalho') is-invalid @enderror"
                                        id="local_trabalho"
                                        name="local_trabalho"
                                        value="{{ old('local_trabalho') }}"
                                        placeholder="Ex: Área de Manutenção Predial"
                                        required>
                                    @error('local_trabalho')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <label for="localizacao">Local / Área:</label>
                                    <select name="localizacao_id" id="localizacao" required class="form-control form-control-lg @error('local_trabalho') is-invalid @enderror">
                                        <option value="">Selecione o local</option>
                                        @foreach($localizacao as $local)
                                        <option value="{{ $local->id }}">{{ $local->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Status --}}
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label fw-bold">
                                        <i class="align-middle me-1" data-feather="activity"></i>
                                        Status da APR
                                    </label>
                                    <input class="form-control"
                                        id="status"
                                        name="status" value="Aberta" readonly>
                                </div>
                            </div>

                            {{-- Descrição da Atividade --}}
                            <div class="mb-4">
                                <label for="descricao_atividade" class="form-label fw-bold">
                                    <i class="align-middle me-1" data-feather="clipboard"></i>
                                    Descrição da Atividade <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('descricao_atividade') is-invalid @enderror"
                                    id="descricao_atividade"
                                    name="descricao_atividade"
                                    rows="4"
                                    placeholder="Descreva detalhadamente a atividade a ser realizada..."
                                    required>{{ old('descricao_atividade') }}</textarea>
                                @error('descricao_atividade')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Descreva passo a passo as tarefas a serem executadas.</div>
                            </div>

                            {{-- Card de Análise de Riscos --}}
                            <div class="card mb-4 border-warning">
                                <div class="card-header bg-warning bg-opacity-10 border-warning">
                                    <h6 class="card-title mb-0 text-warning">
                                        <i class="align-middle me-1" data-feather="alert-triangle"></i>
                                        Análise de Riscos
                                    </h6>
                                </div>
                                <div class="card-body">




                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="responsavel" class="form-label fw-bold">
                                    <i class="align-middle me-1" data-feather="user-check"></i>
                                    Responsável pela APR <span class="text-danger">*</span>
                                </label>
                                <select class="form-control form-select-lg @error('responsavel') is-invalid @enderror"
                                    id="responsavel"
                                    name="responsavel"
                                    required>
                                    <option value="" disabled selected>Selecione o responsável</option>
                                    @foreach($funcionarios as $funcionario)
                                    <option value="{{ $funcionario->id }}" {{ old('responsavel') == $funcionario->id ? 'selected' : '' }}>
                                        {{ $funcionario->primeiro_nome }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('responsavel')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Assinatura do Responsável --}}
                            <div class="col-md-6 mb-3">
                                <label for="assinatura_responsavel" class="form-label fw-bold">
                                    <i class="align-middle me-1" data-feather="edit-3"></i>
                                    Assinatura do Responsável
                                </label>
                                <input type="text"
                                    class="form-control form-control-lg @error('assinatura_responsavel') is-invalid @enderror"
                                    id="assinatura_responsavel"
                                    name="assinatura_responsavel"
                                    value="{{ old('assinatura_responsavel') }}"
                                    placeholder="Código ou identificação da assinatura">
                                @error('assinatura_responsavel')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Código ou identificação da assinatura digital.</div>
                            </div>
                    </div>

                    {{-- Botões de Ação --}}
                    <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                        <a href="{{ route('apr.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="align-middle me-1" data-feather="arrow-left"></i>
                            Voltar
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="align-middle me-1" data-feather="save"></i>
                            Salvar APR
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</main>

{{-- Inicializar Feather Icons --}}
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar feather icons
        if (feather) {
            feather.replace({
                width: 18,
                height: 18
            });
        }

        // Validação em tempo real para campos obrigatórios
        const requiredFields = ['local_trabalho', 'descricao_atividade', 'responsavel'];
        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.addEventListener('blur', function() {
                    if (!this.value.trim()) {
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                    }
                });
            }
        });

        // Estilizar select de status
        const statusSelect = document.getElementById('status');
        if (statusSelect) {
            statusSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value === 'aberta') {
                    this.classList.remove('border-success', 'text-success');
                    this.classList.add('border-warning', 'text-warning');
                } else {
                    this.classList.remove('border-warning', 'text-warning');
                    this.classList.add('border-success', 'text-success');
                }
            });
        }
    });
</script>
@endsection
@endsection