@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header pb-2">
            <p class="mb-0">Check-List</p>
            <h6> {{$equipamento->nome}}</h6>
            <button type="button" class="btn btn-outline-success open-modal-btn"
                onclick="window.location.href='{{ route('check-list-index') }}'"
                style="float:right;margin-left:5px;">
                Check-List índice
            </button>
            <button type="button" class="btn btn-outline-success open-modal-btn"
                onclick="window.location.href='{{ route('app.home') }}'"
                style="float:right;margin-left:5px;">
                Dashboard
            </button>

        </div>
        <div>
            @if(isset($check_list_executado))
            @foreach($check_list_executado as $check_list_executado_f)
            <div calss="div-row" style="display:flex;flex-direction:row;">
                <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;margin-right:20px;width:20%;">
                    <h6 style="font-family:Arial,sanserif;font-weight:700;color:darkgrey;">ID: </h6> {{$check_list_executado_f->id}}
                </span>
                <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;margin-right:20px;width:20%;">
                    <h6 style="font-family:Arial,sanserif;font-weight:700;color:darkgrey;">Descrição: </h6> {{ $check_list_executado_f->checkList->descricao }}
                </span>
                <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;margin-right:20px;width:20%;">
                    <h6 style="font-family:Arial,sanserif;font-weight:700;color:darkgrey;">Observação: </h6>
                    <div style="font-family: Arial, Helvetica;">{{$check_list_executado_f->observacao}}</div>
                </span>
                <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;margin-right:20px;width:20%;">
                    <h6 style="font-family:Arial,sanserif;font-weight:700;color:darkgrey;">Funcionário: </h6> {{$check_list_executado_f->funcionario}}
                </span> <br>
                <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;margin-right:20px;width:20%;">
                    <h6 style="font-family:Arial,sanserif;font-weight:700;color:darkgrey;">Temperatura: </h6> {{$check_list_executado_f->temperatura}}
                </span>
                <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;margin-right:20px;width:20%;">
                    <h6 style="font-family:Arial,sanserif;font-weight:700;color:darkgrey;">Vibração: </h6> {{$check_list_executado_f->vibracao}}
                </span>
                <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;margin-right:20px;width:20%;">
                    <h6 style="font-family:Arial,sanserif;font-weight:700;color:darkgrey;">Gravidade: </h6> {{$check_list_executado_f->gravidade}}
                </span>
                <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px; margin-right:20px; width:20%;">
                    <h6 style="font-family:Arial,sanserif;font-weight:700;color:darkgrey;">Data e hora: </h6> {{ \Carbon\Carbon::parse($check_list_executado_f->data_verificacao)->format('d/m/Y') }} às {{ $check_list_executado_f->hora_verificacao }}
                </span>

                <!-- Botão para abrir a modal -->

            </div>
            <hr>
            @endforeach
            @endif
        </div>
</main>
@endsection