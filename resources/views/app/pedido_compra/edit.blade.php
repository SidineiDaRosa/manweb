@extends('app.layouts.app')
@section('content')
@method('PUT')
@foreach($empresa as $empresa_f)
@endforeach
@foreach($patrimonio_f as $patrimonio_for)
@endforeach
<form action="{{ route('pedido-compra.update', $pedido_compra->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row mb-1">
        <label for="nome" class="col-md-4 col-form-label text-md-end text-right">Patrimônio id</label>
        <div class="col-md-1">
            <input id="razao_social" type="text" class="form-control" name="equipamento_id" value="{{$patrimonio_for->id}}" required autocomplete="" readonly>
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome" class="col-md-4 col-form-label text-md-end text-right">Patrimônio</label>
        <div class="col-md-6">
            <input id="razao_social" type="text" class="form-control" name="equipamento_nome" value="{{$patrimonio_for->nome}}" required autocomplete="razao_social" readonly>
        </div>
    </div>
    </div>
    <div class="row mb-1">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">id empresa</label>
        <div class="col-md-1">
            <input id="nome_fantasia" name="empresa_id" type="text" class="form-control" value="{{$empresa_f->id}}" readonly>
            {{ $errors->has('nome_fantasia') ? $errors->first('nome_fantasia') : '' }}
        </div>

    </div>
    <div class="row mb-1">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">Rasão sicial da empresa/unidade</label>
        <div class="col-md-6">
            <input id="nome_fantasia" name="nome_fantasia" type="text" class="form-control" nome_fantasia="nome_fantasia" value="{{$empresa_f->razao_social}}" readonly>
            {{ $errors->has('nome_fantasia') ? $errors->first('nome_fantasia') : '' }}
        </div>
    </div>

    <div class="row mb-1">
        <label for="cnpj" class="col-md-4 col-form-label text-md-end text-right">CNPJ</label>
        <div class="col-md-2">
            <input id="cnpj" name="cnpj" type="text" class="form-control" value="{{ $empresa_f->cnpj }}" readonly>
            {{ $errors->has('cnpj') ? $errors->first('cnpj') : '' }}
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var cnpjInput = document.getElementById('cnpj');
                cnpjInput.value = formatarCNPJ(cnpjInput.value);
            });

            function formatarCNPJ(value) {
                return value.replace(/\D/g, '')
                    .replace(/^(\d{2})(\d)/, '$1.$2')
                    .replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3')
                    .replace(/\.(\d{3})(\d)/, '.$1/$2')
                    .replace(/(\d{4})(\d)/, '$1-$2')
                    .slice(0, 18);
            }
        </script>
        </script>
    </div>
    <!-- Exibindo o ID -->

    <div class="row mb-1">
        <label for="cnpj" class="col-md-4 col-form-label text-md-end text-right">Data emissão</label>
        <div class="col-md-2">
            <input id="d_emissao" name="data_emissao" type="text" class="form-control" value="{{$pedido_compra->data_emissao}}" readonly>
            <input id="h_emissao" name="hora_emissao" type="text" class="form-control" value="{{$pedido_compra->hora_emissao}}" readonly>
        </div>
    </div>
    <div class="row mb-1">
        <label for="cnpj" class="col-md-4 col-form-label text-md-end text-right">Data prevista para uso</label>
        <div class="col-sm-2">
            <input id="data_prevista" name="data_prevista" type="date" class="form-control" value="{{$pedido_compra->data_prevista}}" readonly>
            <input id="hora_prevista" name="hora_prevista" type="time" class="form-control" value="{{$pedido_compra->hora_prevista}}" readonly>
        </div>
    </div>
    <div class="row mb-1">
        <label for="cnpj" class="col-md-4 col-form-label text-md-end text-right">funcionario_id</label>
        <div class="col-sm-4">
            <input id="hora_prevista" name="funcionarios_id" type="text" class="form-control" value="{{auth()->user()->id}}" readonly>
            <input id="emissor_nome" name="emissor_nome" type="text" class="form-control" value="{{auth()->user()->name}}" readonly>
        </div>
    </div>
    <div class="row mb-1">
        <label for="fornecedor" class="col-md-4 col-form-label text-md-end text-right">Fornecedor</label>
        <div class="col-sm-4">
            <input id="fornecedor_id" name="fornecedor" class="form-control" value="{{ $pedido_compra->fornecedor->razao_social ?? '' }}" readonly>
        </div>
    </div>
    <div class="row mb-1">
        <label for="cnpj" class="col-md-4 col-form-label text-md-end text-right">Situação</label>
        <div class="col-sm-2">
            <input id="status" name="status" type="text" class="form-control" value="{{$pedido_compra->status}}" readonly>
        </div>
    </div>
    <div class="row mb-1">
        <label for="cnpj" class="col-md-4 col-form-label text-md-end text-right">Descrição</label>
        <div class="col-sm-4">
            <input id="descricao" name="descricao" type="text" class="form-control" value="{{$pedido_compra->descricao}}" readonly>
        </div>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @if (session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
    @endif
</form><!-- Botão para abrir a modal -->
<div class="row mb-3">
    <div class="col-sm-6 offset-md-4">
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#eventoModal">
            Registrar Evento e Atualizar Pedido
        </button>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="eventoModal" tabindex="-1" aria-labelledby="eventoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pedido-compra.update', $pedido_compra->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="eventoModalLabel">Registrar Evento e Atualizar Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <!-- Justificativa -->
                    <div class="mb-3">
                        <label for="justificativa" class="form-label">Justificativa</label>
                        <textarea class="form-control" name="justificativa" id="justificativa" rows="3" required></textarea>
                    </div>

                    <!-- Anexo -->
                    <div class="mb-3">
                        <label for="anexo" class="form-label">Anexo</label>
                        <input class="form-control" type="file" name="anexo" id="anexo">
                    </div>

                    <!-- Data e Hora Previstas -->
                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label for="data_prevista" class="form-label">Data Prevista</label>
                            <input type="date" class="form-control" name="data_prevista" id="data_prevista" value="{{$pedido_compra->data_prevista}}">
                        </div>
                        <div class="col-md-6">
                            <label for="hora_prevista" class="form-label">Hora Prevista</label>
                            <input type="time" class="form-control" name="hora_prevista" id="hora_prevista" value="{{$pedido_compra->hora_prevista}}">
                        </div>
                    </div>

                    <!-- Situação do Pedido -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Situação do Pedido</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="{{$pedido_compra->status}}" selected>{{$pedido_compra->status}}</option>
                            <option value="aberto">Aberto</option>
                            <option value="fechado">Fechado</option>
                            <option value="indefinido">Indefinido</option>
                            <option value="cancelado">Cancelado</option>
                            <option value="aceito">Aceito</option>
                            <option value="Em andamento">Em andamento</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fornecedor_id" class="form-label">Fornecedor</label>
                        <select id="fornecedor_id" name="fornecedor_id" class="form-control" required>
                            <option value="">Selecione um fornecedor</option>
                            @foreach($fornecedores as $fornecedor)
                            <option value="{{ $fornecedor->id }}" @if($pedido_compra->fornecedor_id == $fornecedor->id) selected @endif>
                                {{ $fornecedor->razao_social }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Descrição -->
                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <input type="text" class="form-control" name="descricao" id="descricao" value="{{$pedido_compra->descricao}}">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Evento e Atualizar Pedido</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>