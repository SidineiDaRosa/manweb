@extends('app.layouts.app')
@section('content')
<script src="{{ asset('js/update_datatime.js') }}" defer></script>
<script src="{{ asset('js/timeline_google.js') }}" defer></script>
<main class="content">
    <div class="card">
        novo pedido de saida
        <style>
            .card-header {
                background-color: rgb(211, 211, 211);
                opacity: 0.95;
            }
        </style>
        <div class="card-header">
            <script>
                function Funcao() {
                    alert('teste');
                    document.getElementById("t1").value = "{{$funcionarios}}"
                }
            </script>
            <!------------------------------------->
            <!----teste de url--------------------->
            <div class="form-row">
                <form action="{{'filtro-os'}}" method="POST">
                    @csrf

            </div>
            <!------------------------------------------------------------------------------------------->
            <!----datas---------------------------------------------------------------------------------->
            <!------------------------------------------------------------------------------------------->
            <div class="form-row">
                <div class="col-md-2">
                    <label for="id">ID:</label><input type="checkbox" name="" id="">
                    <input type="number" class="form-control" id="id" name="id" placeholder="ID Os" value="">
                </div>
                <p>
                    <!--------------------------------------------------------------------------------------->
                <div class="col-md-2">
                    <label for="data_inicio">Data prevista:</label><input type="checkbox" name="" id="">
                    <input type="date" class="form-control" name="data_inicio" id="data_inicio" placeholder="dataPrevista" value="">
                </div>
                <div class="col-md-2">
                    <label for="hora_inicio">Hora prevista:</label><input type="checkbox" name="" id="">
                    <input type="time" class="form-control" name="hora_inicio" id="hora_inicio" placeholder="horaPrevista" value="">
                </div>
                <div class="col-md-2">
                    <label for="dataFim">Data fim:</label><input type="checkbox" name="" id="">
                    <input type="date" class="form-control" name="data_fim" id="dataFim" placeholder="dataFim" value="">
                </div>
                <div class="col-md-2">
                    <label for="horaFim">Hora fim:</label><input type="checkbox" name="" id="">
                    <input type="time" class="form-control" name="hora_fim" id="horaFim" placeholder="horaFim" value="">
                </div>
                <div class="col-md-6 mb-0">
                    <label for="responsavel" class="">Responsável:</label><input type="checkbox" name="" id="">
                    <select name="responsavel" id="responsavel" class="form-control-template">
                        <option value="todos">
                        </option>

                    </select>

                </div>
                <!----------------------------------->
                <div class="col-md-2 mb-0">
                    <label for="situacao" class="">Situação:</label><input type="checkbox" name="" id="">
                    <select class="form-control" name="situacao" id="situacao" value="">
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
                <div class="col-md-6 mb-0">
                    <label for="funcionario_id" class="">funcionario:</label><input type="checkbox" name="" id="">
                    <select name="funcionario_id" id="funcionario" class="form-control-template">
                        <option value=""> --Selecione a funcionario--</option>
                        <option value="todos">
                        </option>
                    </select>

                </div>
                <!------------------------------------------------------------------------------------------->
                <div class="col-md-0">
                    <label for="btFiltrar" class="">Filtrar:</label>
                    <p>
                        <input type="submit" class="btn btn-info btn-icon-split" value="Filtrar">

                        <span class="icon text-white-50">
                            <i class="icofont-filter"></i>
                        </span>
                        <span class="text"></span>

                        </input>
                </div>
                </form>
                <!--------------------------------------->
                <div class="col-md-0">
                    <label for="btFiltrar" class="">Nova os</label>
                    <p>
                        <a href="" class="btn btn-info btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="icofont-plus-circle"></i>
                            </span>
                            <span class="text">Nova ordem</span>
                        </a>
                </div>
            </div>
        </div>
        <div class="card-body">

            @endsection
            <footer>
            </footer>

            </html>