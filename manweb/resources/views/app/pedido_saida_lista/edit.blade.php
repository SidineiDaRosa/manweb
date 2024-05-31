@extends('app.layouts.app')
@section('content')
<script src="{{ asset('js/update_datatime.js') }}" defer></script>
<script src="{{ asset('js/timeline_google.js') }}" defer></script>
<main class="content">
    <div class="card">
        
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
                    <label for="id">ID:</label>
                    <input type="number" class="form-control" id="id" name="id" value="{{$pedido_saida->id ?? old('id') }}" required autocomplete="id" autofocus readonly>
                    {{ $errors->has('id') ? $errors->first('id') : '' }}
                </div>

                <p>
                    <!--------------------------------------------------------------------------------------->
                <div class="col-md-2">
                    <label for="data_inicio">Data prevista:</label>
                    <input type="date" class="form-control" name="data_inicio" id="data_inicio" value="{{$pedido_saida->data_emissao ?? old('data_emissao') }}" required autocomplete="data_emissao" autofocus readonly>
                    {{ $errors->has('data_emissao') ? $errors->first('data_emissao') : '' }}
                </div>
                <div class="col-md-2">
                    <label for="hora_inicio">Hora prevista:</label>
                    <input type="time" class="form-control" name="hora_inicio" id="hora_inicio" value="{{$pedido_saida->hora_emissao ?? old('hora_emissao') }}" required autocomplete="hora_emissao" autofocus readonly>
                    {{ $errors->has('hora_emissao') ? $errors->first('hora_emissao') : '' }}
                </div>
                <div class="col-md-2">
                    <label for="dataFim">Data fim:</label>
                    <input type="date" class="form-control" name="data_fim" id="dataFim" value="{{$pedido_saida->data_prevista ?? old('data_prevista') }}" required autocomplete="data_prevista" autofocus>
                    {{ $errors->has('data_prevista') ? $errors->first('data_prevista') : '' }}
                </div>
                <div class="col-md-2">
                    <label for="horaFim">Hora fim:</label>
                    <input type="time" class="form-control" name="hora_fim" id="horaFim" value="{{$pedido_saida->hora_prevista ?? old('hora_prevista') }}" required autocomplete="hora_prevista" autofocus>
                    {{ $errors->has('hora_prevista') ? $errors->first('hora_prevista') : '' }}
                </div>
                <div class="col-md-2">
                    <label for="emissor">Emissor do pedido:</label>
                    <input type="text" class="form-control" name="emissor" id="emissor" value="{{$pedido_saida->funcionarios->primeiro_nome ?? old('hora_prevista') }}" required autocomplete="funcionarios_id " autofocus readonly>
                    {{ $errors->has('funcionarios_id ') ? $errors->first('funcionarios_id ') : '' }}
                </div>
                <!-----------------------------------
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
                
                -------------------------------------------------------------------------------------->
                <div class="col-md-2">
                    <label for="status">Status:</label>
                    <input type="text" class="form-control" name="status" id="status" value="{{$pedido_saida->status ?? old('status') }}" required autocomplete="status" autofocus readonly>
                    {{ $errors->has('status') ? $errors->first('status') : '' }}
                </div>
                <!---------Select empresa------------->
                <!--------------------------------------------------------------------------------------->
                <div class="col-md-2">
                    <label for="equipamento">Patrimônio/equipamento:</label>
                    <input type="text" class="form-control" name="equipamento" id="equipamento" value="{{$pedido_saida->equipamento->nome ?? old('hora_prevista') }}" required autocomplete="funcionarios_id " autofocus readonly>
                    {{ $errors->has('funcionarios_id ') ? $errors->first('funcionarios_id ') : '' }}
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
            <table class="table-template table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="th-title">Id</th>
                        <th scope="col" class="th-title">pedido_saida_id</th>
                        <th scope="col" class="th-title">Produto</th>
                        <th scope="col" class="th-title">Quantidade</th>
                        <th scope="col" class="th-title">Data</th>
                        <th scope="col" class="th-title">Patrmônio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($saidas_produto as $saida_produto)
                    <tr>
                        <th scope="row">{{$saida_produto->id }}</td>
                        <td>{{ $saida_produto->pedidos_saida_id}}</td>
                        <td>{{ $saida_produto->produto->nome }}</td>
                        <td>{{ $saida_produto->quantidade }}</td>
                        <td>{{ $saida_produto->data }}</td>
                        <td>{{ $saida_produto->equipamento->nome}}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endsection
        <footer>
        </footer>

        </html>