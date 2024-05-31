@extends('app.layouts.app')
@section('content')

<main class="content">
    <div class="card">
        Atualizar pedido de saida
        <div class="col-md-0">

            <a href="{{route('pedido-saida.index')}}" class="btn btn-info btn-icon-split" type="submit">
                <span class="icon text-white-50">
                    <i class="icofont-list"></i>
                </span>
                <span class="text">Voltar para pedidos de saída</span>
            </a>
        </div>
        <style>
            .card-header {
                background-color: rgb(211, 211, 211);
                opacity: 0.95;
            }
        </style>
        <div class="card-header">
            <!----**************************************************************************************--->
            <!----Grava -->
            <!---*************************************************************************************----->
            @if (isset($pedidos_saida->id))
            <form action="{{route('pedido-saida-lista.store',['pedidos_saida' => $pedidos_saida->id]) }}" method="POST">
                @csrf
                @method('PUT')
                @else
                <form action="{{ route('pedido-saida-lista.store') }}" method="POST">
                    @csrf
                    @endif
                    <div class="form-row">
                        <div class="col-md-1">
                            <label for="id">ID:</label>
                            <input type="number" class="form-control" name="id" id="id" placeholder="id" value="{{$pedidos_saida->id}}" readonly>
                        </div>
                        <div class="col-md-1">
                            <label for="data_emissao">Data emissão:</label>
                            <input type="date" class="form-control" name="data_emissao" id="data_emissao_1" placeholder="dataPrevista" value="{{$pedidos_saida->data_emissao}}" readonly>
                        </div>
                        <div class="col-md-1">
                            <label for="hora_inicio">Hora emissão:</label>
                            <input type="time" class="form-control" name="hora_emissao" id="hora_emissao_1" placeholder="horaPrevista" value="{{$pedidos_saida->hora_emissao}}" readonly>
                        </div>
                        <div class="col-md-1">
                            <label for="dataFim">Data prevista:</label>
                            <input type="date" class="form-control" name="data_prevista" id="dataFim" placeholder="dataFim" value="{{$pedidos_saida->data_prevista}}">
                        </div>
                        <div class="col-md-1">
                            <label for="horaFim">Hora Prevista:</label>
                            <input type="time" class="form-control" name="hora_prevista" id="horaFim" placeholder="horaFim" value="{{$pedidos_saida->hora_prevista}}">
                        </div>
                        <div class="col-md-6">
                            <label for="funcionarios_id" class="">Emissor</label>
                            <input type="text" class="form-control" id="emissor" name="emissor" placeholder="emissor" value="{{$pedidos_saida->funcionarios_id}}" readonly>
                            <input type="text" class="form-control" id="funcionarios_id" name="funcionarios_id" value="{{$pedidos_saida->funcionarios_id}}" hidden>
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="">Status</label>
                            <input type="text" class="form-control" id="status" name="status" placeholder="emissor" value="{{$pedidos_saida->status}}" readonly>
                        </div>
                        <div class="col-md-2 mb-0">
                            <label for="situacao" class="">Status:</label>
                            <select class="form-control" name="status" id="situacao" value="{{$pedidos_saida->funcionarios_id}}">
                                <option value="aberto">aberto</option>
                                <option value="fechado">fechado</option>
                                <option value="indefinido">indefinido</option>
                                <option value="cancelada">cancelada</option>
                                <option value="em andamento">em andamento</option>
                            </select>
                        </div>
                        <!--------------------------------------------------------------------------------------->
                        <!---------Select empresa------------->
                        <!--------------------------------------------------------------------------------------->

                        <div class="col-md-6">
                            <label for="empresa_id" class="">Empresa</label>

                            <input type="text" class="form-control" id="empresa_id" name="empresa_id" placeholder="empresa_id" value="{{$pedidos_saida->empresa_id}}" readonly>

                        </div>
                        <!------------------------------------------------------------------------------------------->
                        <!---equipamento-->
                        <!------------------------------------------------------------------------------------------->

                        <div class="col-md-6">
                            <label for="equipamento_id" class="">Equipamento</label>

                            <input type="text" class="form-control" id="equipamento_id" name="equipamento_id" placeholder="equipamento_id" value="{{$pedidos_saida->equipamento_id}}" readonly>

                        </div>
                        <!------------------------------------------------------------------------------------------->
                        <!---cliente-->
                        <!------------------------------------------------------------------------------------------->
                </form>
                <div class="col-md-1">
                    <label for="ordem_serviço_id">Ordem serviço:</label>
                    <input type="text" class="form-control" name="ordem_servico_id" id="ordem_servico_id" placeholder="ordem_serviço_id" value="{{$pedidos_saida->ordem_servico_id}}" readonly>
                </div>
                <div class="row mb-0">
                    <div class="col-md-12">
                        <label for="btFiltrar" class="">Atualizar pedido de saída'</label>
                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                            {{ isset($equipamento) ? 'Atualizar' : 'Atualizar pedido de saída' }}
                        </button>
                    </div>
                </div>
        </div>
        <div class="card-body">

            @endsection
            <footer>
            </footer>

            </html>