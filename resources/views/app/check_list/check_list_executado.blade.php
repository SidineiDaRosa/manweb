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
            <div calss="div-row" style="display:flex;flex-direction:row;margin-right:5px;">
                <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;margin-right:20px;width:100px;margin-left:5px;">
                    <h6 style="font-family:Arial,sanserif;font-weight:700;color:darkgrey;">ID: </h6> {{$check_list_executado_f->id}}
                </span>
                <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;margin-right:20px;width:20%;">
                    <span style="font-family:Arial,sanserif;font-weight:700;color:dimgrey;font-weight:300">Descrição do check-List:<br>

                    </span>
                    id:{{ $check_list_executado_f->checkList->id}},
                    {{ $check_list_executado_f->checkList->descricao }}
                </span>
                <span style="font-family: Arial, Helvetica, sans-serif; margin-top: 4px; margin-right: 20px; width: 20%;">
                    <span style="font-family: Arial, sans-serif; font-weight: 700; color: darkgrey;">Observação:</span>
                    <div style="font-family: Arial, Helvetica; 
                 color: {{ $check_list_executado_f->observacao === 'Normal' ? 'green' : 'orange' }};">
                        {{$check_list_executado_f->observacao}}
                    </div>
                </span>
                <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;margin-right:20px;width:20%;">
                    <h6 style="font-family:Arial,sanserif;font-weight:700;color:darkgrey;">Funcionário: </h6> {{$check_list_executado_f->funcionario}}
                </span> <br>

                <!-- Mostra a temperatura em barra gráfica -->
                <div style="width: 20%; background-color: #e0e0e0; border-radius: 5px; overflow: hidden; height: 20px; border-right: 20px;">
                    <div style="
        width: {{ ($check_list_executado_f->temperatura / 200) * 100 }}%; 
        height: 100%; 
        background-color: 
            @if($check_list_executado_f->temperatura < 60) 
                #88e1d9; /* Verde para abaixo de 60°C */
            @elseif($check_list_executado_f->temperatura >= 60 && $check_list_executado_f->temperatura <= 100) 
                #ffecb5; /* Amarelo para entre 60°C e 100°C */
            @else 
                #f25b61; /* Vermelho para acima de 100°C */
            @endif
        transition: width 0.3s;">
                        {{$check_list_executado_f->temperatura}}°C
                    </div>
                </div>
                <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;margin-left:20px;width:10%;">
                    <h6 style="font-family:Arial,sanserif;font-weight:700;color:black;">Vibração: </h6> {{$check_list_executado_f->vibracao}}
                </span>

                <div style="width: 150px; height:50px; border-radius: 5px; 
    @if($check_list_executado_f->gravidade == 1) background-color:rgb(136, 225, 217);
    @elseif($check_list_executado_f->gravidade == 2) background-color: rgb(255, 224, 157);
    @elseif($check_list_executado_f->gravidade == 3) background-color:rgb(255, 183, 93);
    @elseif($check_list_executado_f->gravidade == 4) background-color: rgb(242, 91, 97);
    @endif
">
                    <span style="font-family: Arial, sans-serif; font-weight:200; color:darkgrey;font-size:15px;">Gravidade</span>
                    <hr style="margin:1px;">
                    <span style="font-family: Arial, Helvetica, sans-serif; margin-top: 4px; margin-right: 20px; width: 20%;color:darkgrey">
                        {{$check_list_executado_f->gravidade}}
                    </span>
                </div>

                <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px; margin-left:20px; width:20%;">
                    <h6 style="font-family:Arial,sanserif;font-weight:700;color:darkgrey;">Data e hora: </h6> {{ \Carbon\Carbon::parse($check_list_executado_f->data_verificacao)->format('d/m/Y') }} às {{ $check_list_executado_f->hora_verificacao }}
                </span>
                <form action="{{ route('check-list-exec-delete', $check_list_executado_f->id) }}" method="POST" onsubmit="return confirm('Tem certeza de que deseja deletar este registro: {{$check_list_executado_f->id}}?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-outline">
                        <i class="icofont-ui-delete" style="color: inherit;"></i>
                    </button>
                </form>

                <!-- Botão para abrir a modal -->

            </div>
            <hr>
            @endforeach
            @endif
        </div>
</main>
@endsection