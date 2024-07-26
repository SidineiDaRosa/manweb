@extends('app.layouts.app')
@section('content')
<script src="{{ asset('js/update_datatime.js') }}" defer></script>
<script src="{{ asset('js/timeline_google.js') }}" defer></script>
<main class="content">
    <div class="card">
        <div> Criar novo pedido de saída</div>
        <div class="col-md-2"> <a class="btn btn-outline-primary mb-1" href="{{route('pedido-saida.index')}}"><span class="material-symbols-outlined">
                    format_list_bulleted
                </span>
            </a>
            <a class="btn btn-outline-dark mb-1" href="{{ route('app.home') }}">
                <i class="icofont-dashboard"></i> dashboard
            </a>
        </div>
    </div>
    <div class="card-header">
        <!----**************************************************************************************--->
        <!----Grava -->
        <!---*************************************************************************************----->
        <form action="{{ route('pedido-saida.store') }}" method="POST">
            @csrf
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
                    <input type="text" class="form-control" name="ordem_servico_id" id="ordem_servico_id" value="" readonly>
                </div>
                <div class="col-md-6">
                    <label for="funcionarios_id" class="">Emissor</label>
                    <input type="text" class="form-control" id="emissor" name="emissor" placeholder="emissor" value="{{auth()->user()->name}}" readonly>
                    <input type="text" class="form-control" id="funcionarios_id" name="funcionarios_id" value="{{auth()->user()->id}}" hidden>
                </div>
                <!------------------------------------------------------------------------------------------->
                <!---equipamento-->
                <!------------------------------------------------------------------------------------------->
                <div class="col-md-6">
                    <label for="funcionarios_id" class="">Equipamento/Patrimônio</label>
                    <select name="equipamento_id" id="equipamento_id" class="form-control">
                        <option value="">Selecione um equipamento</option>
                        @foreach ($equipamentos as $equipamento)
                        <option value="{{ $equipamento->id }}">{{ $equipamento->nome }}</option>
                        @endforeach
                    </select>
                </div>

                {{---//-----------------//--}}
                {{--// Empresas         //--}}
                <div class="col-md-0">
                    <label for="empresa_id" class="">Empresa</label>

                    <input type="text" class="form-control" id="empresa_id" name="empresa_id" placeholder="empresa_id" value="{{$empresa->id}}" readonly>

                </div>
                <div class="col-md-4 mb-1">
                    <label for="cliente" class="">Empresa/Destino</label>
                    <input type="text" class="form-control" id="empresa_mnome" name="empresa_nome" value="{{$empresa->razao_social}}" readonly>
                    <input type="text" class="form-control" id="fornecedor_id" name="fornecedor_id" value="{{$empresa->id}}" hidden>
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