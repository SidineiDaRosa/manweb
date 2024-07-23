@extends('app.layouts.app')
@section('content')
<script src="{{ asset('js/update_datatime.js') }}" defer></script>
<script src="{{ asset('js/timeline_google.js') }}" defer></script>
<main class="content">
    <div class="card">
        <div> Criar novo pedido de saída</div>
        <div class="col-md-2"> <a href="{{route('pedido-saida.index')}}" class="btn btn-info btn-icon-split">
                <span class="icon text-white-20">
                    <i class="icofont-list"></i>
                </span>
                <span class="text">Voltar para pedidos de saída</span>
            </a></div>

    </div>
    <div class="card-header">
        <script>
            function Funcao() {
                alert('teste');
                document.getElementById("t1").value = "{{$funcionarios}}"
            }
        </script>
        <!----**************************************************************************************--->
        <!----Grava -->
        <!---*************************************************************************************----->
        @if (isset($ordem_servico->id))
        <form action="{{route('pedido-saida.store',['pedidos_saida' => $pedidos_saida->id]) }}" method="POST">
            @csrf
            @method('PUT')
            @else
            <form action="{{ route('pedido-saida.store') }}" method="POST">
                @csrf
                @endif
                @foreach ($ordem_servico as $ordem_servico_f)
                @endforeach
                <div class="form-row">
                    <div class="col-md-1">
                        <label for="data_inicio">Data emissão:</label>
                        <input type="date" class="form-control -lg" name="data_emissao" id="data_emissao" placeholder="dataPrevista" value="" readonly>
                    </div>
                    <div class="col-md-1">
                        <label for="hora_inicio">Hora emissão:</label>
                        <input type="time" class="form-control" name="hora_emissao" id="hora_emissao" placeholder="horaPrevista" value="" readonly>
                    </div>
                    <div class="col-md-1">
                        <label for="dataFim">Data prevista:</label>
                        <input type="date" class="form-control" name="data_prevista" id="dataFim" placeholder="dataFim" value="">
                    </div>
                    <div class="col-md-1">
                        <label for="horaFim">Hora Prevista:</label>
                        <input type="time" class="form-control" name="hora_prevista" id="horaFim" placeholder="horaFim" value="">
                    </div>
                    <!------------------------------------------------------------------------------------------->
                    <!---os-->
                    <div class="col-md-1">
                        <label for="ordem_serviço_id">Ordem serviço:</label>
                        <input type="text" class="form-control" name="ordem_servico_id" id="ordem_servico_id" placeholder="ordem_serviço_id" value="{{$ordem_servico_f->id}}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="funcionarios_id" class="">Emissor</label>
                        <input type="text" class="form-control" id="emissor" name="emissor" placeholder="emissor" value="{{auth()->user()->name}}" readonly>
                        <input type="text" class="form-control" id="funcionarios_id" name="funcionarios_id" value="{{auth()->user()->id}}" hidden>
                    </div>
                    <!------------------------------------------------------------------------------------------->
                    <!---equipamento-->
                    <!------------------------------------------------------------------------------------------->

                    <div class="col-md-1">
                        <label for="equipamento_id" class="">ID Equipamento</label>

                        <input type="text" class="form-control" id="equipamento_id" name="equipamento_id" placeholder="equipamento_id" value="{{$ordem_servico_f->equipamento->id}}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="equipamento_id" class="">Nome do Equipamento</label>

                        <input type="text" class="form-control" id="equipamento_nome" name="equipamento_nome" placeholder="equipamento_id" value="{{$ordem_servico_f->equipamento->nome}}" readonly>

                    </div>
                    <!---------Select empresa------------->
                    <!--------------------------------------------------------------------------------------->

                    <div class="col-md-0">
                        <label for="empresa_id" class="">Empresa</label>

                        <input type="text" class="form-control" id="empresa_id" name="empresa_id" placeholder="empresa_id" value="{{$ordem_servico_f->empresa->id}}" readonly>

                    </div>
                    <div class="col-md-4 mb-1">
                        <label for="cliente" class="">Empresa/Destino</label>
                        <input type="text" class="form-control" id="empresa_mnome" name="empresa_nome" value="{{$ordem_servico_f->empresa->razao_social}}" readonly>
                        <input type="text" class="form-control" id="fornecedor_id" name="fornecedor_id" value="{{$ordem_servico_f->empresa->id}}" hidden>
                    </div>
                    <!----------------------------------->
                    <div class="col-md-5 mb-1">
                        <label for="cliente" class="">Obs.</label>
                        <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descreva algo..." value="">
                    </div>
                    <div class="col-md-2 mb-0">
                        <label for="situacao" class="">Status:</label>
                        <select class="form-control" name="status" id="situacao" value="">
                            <option value="aberto">aberto</option>
                            <option value="fechado">fechado</option>
                            <option value="indefinido">indefinido</option>
                            <option value="cancelada">cancelada</option>
                            <option value="em andamento">em andamento</option>
                        </select>
                    </div>
                    <!------------------------------------------------------------------------------------------->
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-outline-primary">Salvar</button>
                    </div>
            </form>
    </div>
    </div>
    </div>
    <div class="card-body">

        @endsection
        <footer>
        </footer>

        </html>