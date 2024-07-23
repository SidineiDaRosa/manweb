@extends('app.layouts.app')
@section('content')
<script src="{{ asset('js/update_datatime.js') }}" defer></script>
<script src="{{ asset('js/timeline_google.js') }}" defer></script>
<main class="content">
    <div class="card">
        Editar pedido de Saída
        <div class="card-header">
            <form action="{{ route('pedido-saida.update', ['pedido_saida' => $pedidos_saida->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-row">
                    <div class="col-md-1">
                        <label for="id">ID:</label>
                        <input type="number" class="form-control" name="id" id="id" placeholder="id" value="{{ $pedidos_saida->id }}" readonly>
                    </div>
                    <div class="col-md-1">
                        <label for="data_emissao">Data emissão:</label>
                        <input type="date" class="form-control" name="data_emissao" id="data_emissao_1" value="{{ $pedidos_saida->data_emissao}}" readonly>
                    </div>
                    <div class="col-md-1">
                        <label for="hora_emissao">Hora emissão:</label>
                        <input type="time" class="form-control" name="hora_emissao" id="hora_emissao_1" value="{{ $pedidos_saida->hora_emissao }}" readonly>
                    </div>
                    <div class="col-md-1">
                        <label for="data_prevista">Data prevista:</label>
                        <input type="date" class="form-control" name="data_prevista" id="data_prevista" value="{{ $pedidos_saida->data_prevista }}">
                    </div>
                    <div class="col-md-1">
                        <label for="hora_prevista">Hora prevista:</label>
                        <input type="time" class="form-control" name="hora_prevista" id="hora_prevista" value="{{ $pedidos_saida->hora_prevista }}">
                    </div>
                    <div class="col-md-2">
                        <label for="funcionarios_id">Emissor</label>
                        <input type="text" class="form-control" id="emissor" name="emissor" value="{{$emissor->name}}" readonly>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="situacao">Situação:</label>
                        <select class="form-control" name="status" id="situacao">
                            <option value="{{ $pedidos_saida->status }}">{{ $pedidos_saida->status }}</option>
                            <option value="aberto">aberto</option>
                            <option value="fechado">fechado</option>
                            <option value="indefinido">indefinido</option>
                            <option value="cancelada">cancelada</option>
                            <option value="em andamento">em andamento</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label for="empresa_id">ID</label>
                        <input type="text" class="form-control" id="empresa_id" name="empresa_id" value="{{ $pedidos_saida->empresa_id }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="empresa_id">Empresa</label>
                        <input type="text" class="form-control" id="empresa_id" name="empresa_id" value="{{$empresa->razao_social}}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="equipamento_id">Equipamento</label>
                        <input type="text" class="form-control" id="equipamento_id" name="equipamento_id" value="{{ $pedidos_saida->equipamento_id }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="ordem_servico_id">Ordem serviço:</label>
                        <input type="text" class="form-control" name="ordem_servico_id" id="ordem_servico_id" value="{{ $pedidos_saida->ordem_servico_id }}" readonly>
                    </div>
                      <!----------------------------------->
                      <div class="col-md-5 mb-1">
                        <label for="cliente" class="">Obs.</label>
                        <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descreva algo..." value="{{ $pedidos_saida->descricao}}">
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-outline-primary">Atualizar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endsection