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
            <input id="data_prevista" name="data_prevista" type="date" class="form-control" value="{{$pedido_compra->data_prevista}}">
            <input id="hora_prevista" name="hora_prevista" type="time" class="form-control" value="{{$pedido_compra->hora_prevista}}">
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
        <label for="cnpj" class="col-md-4 col-form-label text-md-end text-right">Situação</label>
        <div class="col-sm-2">
            <select class="form-control" name="status" id="">
                <option value="{{$pedido_compra->status}}">{{$pedido_compra->status}}</option>
                <option value="aberto">Aberto</option>
                <option value="fechado">Fechado</option>
                <option value="indefinido">Indefinido</option>
                <option value="indefinido">Cancelado</option>
            </select>
        </div>
    </div>
    <div class="row mb-1">
        <label for="cnpj" class="col-md-4 col-form-label text-md-end text-right">Descrição</label>
        <div class="col-sm-4">
            <input id="descricao" name="descricao" type="text" class="form-control" value="{{$pedido_compra->descricao}}">
        </div>
    </div>
    <div class="row mb-0">
        <div class="col-sm-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                Atualizar
            </button>
        </div>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @if (session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
    @endif
</form>