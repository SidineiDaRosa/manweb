@extends('app.layouts.app')
@section('content')
<script src="{{ asset('js/update_datatime.js') }}" defer></script>
<script src="{{ asset('js/timeline_google.js') }}" defer></script>
<main class="content">
    <div class="card">
        <div> Criar novo pedido de saída sem O.S.</div>
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
        <script>
            //   Apóes carregamento da DOM
            document.addEventListener('DOMContentLoaded', (event) => {
                // Seu código aqui
                document.getElementById('data_prevista').focus();
                document.getElementById('data_prevista').style.backgroundColor = '#FFCC99'; //#66FF66 green
                document.getElementById('hora_prevista').style.backgroundColor = '#FFCC99'; //#66FF66 green
                document.getElementById('equipamento_id').style.backgroundColor = '#FFCC99';
                document.getElementById('descricao').style.backgroundColor = '#FFCC99';
                document.getElementById('situacao').style.backgroundColor = '#FFCC99';
            });
            //  Executa após atualização de campos
            function ValidateDate() {
                let dateNow = new Date().toISOString().split('T')[0]; // Obtém a data atual no formato YYYY-MM-DD
                let datePrevistaElem = document.getElementById('data_prevista');
                let datePrevista = datePrevistaElem.value;

                if (datePrevista >= dateNow) {
                    datePrevistaElem.style.backgroundColor = '#66FF66'; // Verde
                    document.getElementById('hora_prevista').focus() = '#FFCC99';
                } else {
                    datePrevistaElem.focus();
                    document.getElementById('data_prevista').style.backgroundColor = '#FFCC99';
                    datePrevistaElem.value = ''; // Limpa o valor do campo
                }
            }
            // Valida hora
            function ValidateTime() {
                document.getElementById('hora_prevista').style.backgroundColor = '#66FF66'; // Verde
                let equipamento_id_Elem = document.getElementById('equipamento_id');
                equipamento_id_Elem.focus();
            }

            function ValidateSelecDestino() {
                let equipamento_id_Elem = document.getElementById('equipamento_id');
                document.getElementById('equipamento_id').style.backgroundColor = '#66FF66'; // Verde
                document.getElementById('descricao').focus() = '#FFCC99';
            }
            function ValidateObs(){
                document.getElementById('descricao').style.backgroundColor = '#66FF66'; // Verde
                document.getElementById('situacao').focus() = '#FFCC99';
            }
            function ValidateSituacao(){
                document.getElementById('situacao').style.backgroundColor = '#66FF66'; // Verde
            }
        </script>
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
                    <input type="date" class="form-control" name="data_prevista" id="data_prevista" placeholder="dataFim" value="" require onchange="ValidateDate()">
                </div>
                <div class="col-md-1">
                    <label for="horaFim">Hora Prevista:</label>
                    <input type="time" class="form-control" name="hora_prevista" id="hora_prevista" placeholder="horaFim" value="" require onchange="ValidateTime()">
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
                    <select name="equipamento_id" id="equipamento_id" class="form-control" require onchange="ValidateSelecDestino()">
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
                    <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descreva algo..." value="" onclick="ValidateObs()">
                </div>
                <div class="col-md-2 mb-0">
                    <label for="situacao" class="">Status:</label>
                    <select class="form-control" name="status" id="situacao" value="" onchange="ValidateSituacao()">
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