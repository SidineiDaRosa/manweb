@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header pb-2">

            <h6> {{$equipamento->id}}-{{$equipamento->nome}}</h6>
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
            <!-- aplica filtro de check=-list-->
            <form action="{{ route('check-list-filter',['equipamento_id'=>$equipamento->id]) }}" method="post" id="form_filter_check_list">
                @csrf
                <div style="display: flex;flex-direction:row;">
                    <input type="text" class="form-control " name="equipamento_id" id="equipamento_id" value="{{$equipamento->id}}" hidden>
                    <input type="date" class="form-control " name="data_inicio" id="data_inicio" value="" style="width: 200px">
                    <input type="date" class="form-control" name="data_fim" id="data+_fim" value="" style="width: 200px">
                    <select class="form-control" name="natureza" id="Natureza" style="width: 300px;">
                        <option value="Elétrico">--Selecione a gravidade--</option>
                        <option value="1">Normal</option>
                        <option value="2">Médio</option>
                        <option value="3">Alto</option>
                        <option value="4">Gravíssimo</option>
                    </select>
                    <button type="submit" class="btn btn-outline-success open-modal-btn" name="check_list_filter"
                        style="float:right;margin-left:5px;">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>

        <div>
            @if(isset($check_list_executado))
            @foreach($check_list_executado as $check_list_executado_f)
            <div calss=" div-row" style="display:flex;flex-direction:row;margin-right:5px;">
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
                <!-- Imagem -->
                @php
                $caminhoCompleto = public_path($check_list_executado_f->imagem);
                @endphp

                @if ($check_list_executado_f->imagem && file_exists($caminhoCompleto))
                <img src="{{ asset($check_list_executado_f->imagem) }}" alt="Imagem checklist" style="max-width: 200px;">
                @else
                <p><i class="text-danger">Imagem não disponível.</i></p>
                @endif
                <!-- Botão para abrir a modal de criação de uma nova O.S. -->
                <button type="button" class="btn btn-outline-success open-modal-btn"
                    data-bs-toggle="modal" data-bs-target="#dateTimeModal"
                    data-id="{{ $check_list_executado_f->id }}"

                    data-time="{{ \Carbon\Carbon::parse($check_list_executado_f->data_verificacao)->format('d/m/Y') }} às {{ $check_list_executado_f->hora_verificacao }}"
                    check-list-id="{{ $check_list_executado_f->checkList->id}}"
                    check-list-desc="{{ $check_list_executado_f->checkList->descricao }}"
                    check-list-obs="{{$check_list_executado_f->observacao}}"
                    style="float:right;margin-left:5px;height:38px;margin-right:5px;">
                    Criar O.S.
                </button>
                <form action="{{ route('check-list-exec-delete', $check_list_executado_f->id) }}" method="POST" onsubmit="return confirm('Tem certeza de que deseja deletar este registro: {{$check_list_executado_f->id}}?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-outline">
                        <i class="icofont-ui-delete" style="color: inherit;"></i>
                    </button>
                </form>

            </div>
            <hr>
            @endforeach
            @endif
        </div>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- jQuery (opcional se você só quiser usar para manipulação) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Bootstrap JS (para modais, precisa da biblioteca JS) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Modal -->
        <div class="modal fade" id="dateTimeModal" tabindex="-1" aria-labelledby="dateTimeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dateTimeModalLabel">Criar O.S.</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Exibindo o ID na modal via JavaScript -->
                        <div id="modalIdDisplay" style="font-family: Arial, Helvetica, sans-serif; margin-bottom: 15px;">
                            <h6 style="font-family: Arial, sans-serif; font-weight: 700; color: darkgrey;">

                            </h6>
                        </div>

                        <!-- Formulário de Data e Hora -->
                        <form id="new-os-form" method="POST" action="{{route('new_os_check_list') }}">
                            @csrf

                            <span>{{$equipamento->id}}</span>
                            <span>{{$equipamento->nome}}</span>
                            <input type="text" id="equipamento_id" value="{{$equipamento->id}}" name="equipamento_id" hidden>
                            <div class="mb-3">

                                Checagem ID: <input type="text" id="dynamicId" value="" readonly> <br>
                                Data time: <input type="text" id="data_time_modal" value="" readonly> <br>
                                Check list id: <input type="text" id="check_list_id" value="" readonly> <br>
                                check list desc: <input type="text" id="check_list_desc" value="" readonly> <br>
                                <label for="startDateTime" class="form-label">Data e Hora Inicial</label>
                                <input type="datetime-local" class="form-control" id="startDateTime" name="data_inicio" required>
                            </div>
                            <div class="mb-3">
                                <label for="endDateTime" class="form-label">Data e Hora Final</label>
                                <input type="datetime-local" class="form-control" id="endDateTime" name="data_fim" required>
                            </div>
                            <div class="mb-3">
                                <label for="endDateTime" class="form-label">Descrição</label>
                                <textarea class="form-control" rows="4" maxlength="300" id="text_area_desc" name="descricao">
                                </textarea>
                            </div>
                            <div class="orm-control" style="width:300px;">
                                <select class="orm-control" style="width:300px;" id="specialidade_do_servico" name="natureza">
                                    <option value="mecanica">Mecânica</option>
                                    <option value="eletrica">Elétrica</option>
                                    <option value="civil">Civil</option>
                                    <option value="sesmt">SESMT</option>
                                    <!-- Outras especialidades conforme necessário -->
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" form="new-os-form">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Seleciona a modal e escuta o evento de exibição (show.bs.modal)
                const dateTimeModal = document.getElementById("dateTimeModal");

                dateTimeModal.addEventListener("show.bs.modal", function(event) {
                    // Obtém o botão que abriu a modal
                    const button = event.relatedTarget;

                    // Pega os dadso do registro de checagem que fica dentro do botão que gera a ordem
                    const itemId = button.getAttribute("data-id");
                    const dataTime = button.getAttribute("data-time");
                    const checkListId = button.getAttribute("check-list-id");
                    const checkListDesc = button.getAttribute("check-list-desc");
                    const checkListObs = button.getAttribute("check-list-obs");
                    // Atualiza o conteúdo do elemento com o ID dinâmico na modal
                    document.getElementById("dynamicId").value = itemId;
                    document.getElementById("data_time_modal").value = dataTime;
                    document.getElementById("check_list_id").value = checkListId;
                    document.getElementById("check_list_desc").value = checkListDesc;
                    // document.getElementById("check_list_obs").value = checkListObs;
                    document.getElementById('text_area_desc').value = 'O.S. criado apartir da checagem ' + itemId + ', em: ' +
                        dataTime + ', do Check-List ID:' + checkListId + ' Desc.: ' + checkListDesc + ', Obs.' + checkListObs
                });
            });
        </script>
</main>
@endsection