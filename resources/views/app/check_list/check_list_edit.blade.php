@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header pb-2">
            <p class="mb-0">Check-List Edição</p>
            <button type="button" class="btn btn-outline-success open-modal-btn"
                onclick="window.location.href='{{ route('check-list-index') }}'"
                style="float:right">
                Check-List índice
            </button>
        </div>

        <!-- Gravar um novo check list para o equipamento -->
        <form id="form_store" action="{{ route('check-list-update') }}" method="GET">
            @csrf
            <div style="display: flex; flex-direction: row;">
                <input type="text" class="form-control" name="id" id="id" style="font-family: Arial, Helvetica, sans-serif; margin-top:4px;width:200px;"
                    value="{{$check_list->id}}" readonly>
                <input type="text" class="form-control" name="equipamento_id" id="equipamento_id" style="font-family: Arial, Helvetica, sans-serif; margin-top:4px;width:200px;"
                    value="{{$check_list->equipamento_id}}" readonly hidden>
                <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px;"> Descrição: </span>
                <input type="text" class="form-control" name="descricao" id="descricao" style="width: 400px;" value="{{$check_list->descricao}}">
                <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px;"> Intervalo de inspeção:</span>
                <select class="form-control" name="intervalo" id="intervalo" style="width: 250px;">
                    <option value="24">Diário</option>
                    <option value="168">Semanal</option>
                    <option value="360" selected>Quinzenal</option> <!-- Define "360" como selecionado -->
                    <option value="720">Mensal</option>
                </select>
                <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px;"> Tipo:</span>
                <select class="form-control" name="natureza" id="Natureza" style="width: 300px;">
                    <option value="Elétrico">Elétrico</option>
                    <option value="Mecânico">Mecânico</option>
                    <option value="Civíl">Civíl</option>
                </select>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Atualizar Check-List</button>
        </form>
    </div>
</main>