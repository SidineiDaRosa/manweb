@extends('app.layouts.app')
@section('content')

<form action="{{route('pedido-compra.store')}}" method="POST">
    @csrf
    @foreach($empresa as $empresa_f)
    @endforeach
    @foreach($patrimonio_f as $patrimonio_nome)
    @endforeach
    <div class="row mb-1">
        <label for="nome" class="col-md-4 col-form-label text-md-end text-right">Patrimônio id</label>
        <div class="col-md-1">
            <input id="razao_social" type="text" class="form-control" name="equipamento_id" value="{{$patrimonio_nome->id}}" required autocomplete="razao_social" readonly>
        </div>
    </div>
    <div class="row mb-1">
        <label for="nome" class="col-md-4 col-form-label text-md-end text-right">Patrimônio</label>
        <div class="col-md-6">
            <input id="razao_social" type="text" class="form-control" name="patrimonio_id" value="{{$patrimonio_nome->nome}}" required autocomplete="razao_social" readonly>
        </div>
    </div>
    </div>
    <div class="row mb-1">
        <label for="nome_fantasia" class="col-md-4 col-form-label text-md-end text-right">id empresa</label>
        <div class="col-md-1">
            <input id="nome_fantasia" name="nome_fantasia" type="text" class="form-control" nome_fantasia="nome_fantasia" value="{{$empresa_f->id}}" readonly>
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
    <div class="row mb-1">
        <label for="cnpj" class="col-md-4 col-form-label text-md-end text-right">Data emissão</label>
        <div class="col-md-2">
            <input id="data_emissao" name="data_emissao" type="text" class="form-control" value="" readonly>
            <input id="hora_emissao" name="hora_emissao" type="text" class="form-control" value="" readonly>
        </div>
    </div>
    <div class="row mb-1">
        <label for="cnpj" class="col-md-4 col-form-label text-md-end text-right">Data prevista para uso</label>
        <div class="col-sm-2">
            <input id="data_prevista" name="data_prevista" type="date" class="form-control" value="">
            <input id="hora_prevista" name="hora_prevista" type="time" class="form-control" value="">
        </div>
    </div>
    <div class="row mb-1">
        <label for="cnpj" class="col-md-4 col-form-label text-md-end text-right">funcionario_id</label>
        <div class="col-sm-4">
            <input id="hora_prevista" name="funcionarios_id" type="text" class="form-control" value="1" readonly>
        </div>
    </div>
    <div class="row mb-1">
        <label for="cnpj" class="col-md-4 col-form-label text-md-end text-right">Situação</label>
        <div class="col-sm-2">
            <input id="hora_prevista" name="status" type="text" class="form-control" value="aberto" readonly>
        </div>
    </div>
    <div class="row mb-1">
        <label for="cnpj" class="col-md-4 col-form-label text-md-end text-right">Descrição</label>
        <div class="col-sm-4">
            <input id="descricao" name="descricao" type="text" class="form-control" value="Material para uso...">
        </div>
    </div>
    <div class="row mb-0">
        <div class="col-sm-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                {{ isset($produto) ? 'Atualizar' : 'Cadastrar' }}
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