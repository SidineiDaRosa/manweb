@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header pb-2">
            <p class="mb-0">Check-List</p>
            <h6> {{$equipamento->nome}}</h6>
            <button type="button" class="btn btn-outline-success open-modal-btn"
                onclick="window.location.href='{{ route('check-list-index') }}'"
                style="float:right">
                Check-List índice
            </button>
        </div>
        <div>
            @if(isset($check_list_executado))
            @foreach($check_list_executado as $check_list_executado_f)
            <div calss="div-row" style="display:flex;flex-direction:row;">
                <div style="margin-right:20px;width:30px;margin:2px;"> <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;">{{$check_list_executado_f->id}}</span></div>
                <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;margin-right:20px;width:20%;">{{$check_list_executado_f->observacao}}</span>
                <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;margin-right:20px;width:20%;">{{$check_list_executado_f->funcionario}}</span> <br>
                <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;margin-right:20px;width:20%;">Temperatura:{{$check_list_executado_f->temperatura}}</span>
                <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;margin-right:20px;width:20%;">Vibração:{{$check_list_executado_f->vibracao}}</span>
                <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px; margin-right:20px; width:20%;">
                    {{$check_list_executado_f->data_verificacao}}
                </span>
                <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px; margin-right:20px; width:20%;">
                    {{ $check_list_executado_f->hora_verificacao }}
                </span>
                <!-- Botão para abrir a modal -->

            </div>
            <hr>
            @endforeach
            @endif
        </div>
</main>
@endsection