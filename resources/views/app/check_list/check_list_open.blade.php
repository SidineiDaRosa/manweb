<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/comum.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/template.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="{{ asset('js/date_time.js') }}"></script>{{--arquivo de atualização de datas e hora--}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Check-List</title>
</head>

<body style="background-color:antiquewhite;">

    <div>
        <div class="card-header pb-2">
            <h2 style="font-family: Arial, Helvetica, sans-serif;">Check-List</h2>
        </div>

        <div class="card-header justify-content-left pt-1">
            {{--//------------------------------------------------//--}}
            {{--Check list por equipamento--}}
            {{--//------------------------------------------------//--}}

            <!-- Gravar um novo check list para o equipamento -->
            <h5>{{$equipamento->nome}}</h5>
            {{$funcionario}}
        </div>
        <!-- CSS do Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- JS do Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <div style="">
            <div style="box-sizing: border-box; width: 100vw; height: 100vh; padding: 10px; overflow: hidden;">
                @if(isset($check_list))
                @foreach($check_list as $check_list_f)
                <div calss="div-row" style="display:flex;flex-direction:row;">
                    <div style="margin-right:20px;width:30px;margin:2px;"> <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;">{{$check_list_f->id}}</span></div>
                    <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;margin-right:20px;width:20%;">{{$check_list_f->descricao}}</span>
                    <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px; margin-right:20px; width:20%;">
                        {{ \Carbon\Carbon::parse($check_list_f->data_verificacao)->format('d/m/Y') }}
                    </span>

                    <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px; margin-right:20px; width:20%;">
                        {{ $check_list_f->hora_verificacao }}
                    </span>
                    @php
                    // Converte a data de verificação para um objeto DateTime (apenas a data, sem hora)
                    $dataVerificacao = new DateTime($check_list_f->data_verificacao); // A data de verificação
                    $dataAtual = new DateTime(); // Obtém a data atual

                    // Calcula a diferença entre a data atual e a data de verificação
                    $diferenca = $dataAtual->diff($dataVerificacao);

                    // Converte a diferença total para horas (apenas usando dias)
                    $horasDiferenca = ($diferenca->days * 24); // Converte os dias para horas

                    // Defina o intervalo de verificação em horas (360hs no seu caso)
                    $intervaloVerificacao = 25;
                    @endphp

                    <!-- Para depuração: exibe a diferença em horas -->


                    @if ($horasDiferenca >= $intervaloVerificacao)
                    <!-- Mostrar a imagem de "warning" se já tiver passado mais de 360 horas -->
                    <img style="height:30px; width:auto;" src="{{ asset('img/warning.png') }}" alt="Aviso">
                    @else
                    <!-- Mostrar a imagem de "check-mark" se a diferença for de 360 horas ou menos -->
                    <img style="height:30px; width:auto;" src="{{ asset('img/check-mark.png') }}" alt="Checado">
                    @endif
                    <!-- Botão para abrir a modal -->
                    <button type="button" class="btn btn-outline-success open-modal-btn" data-bs-toggle="modal"
                        data-bs-target="#modalCheckList-{{$check_list_f->id}}"
                        data-id="{{$check_list_f->id}}"
                        data-descricao="{{$check_list_f->descricao}}"
                        style="float:right">
                        Checar
                    </button>
                </div>
                <!-- Modal para inserção dos dados -->
                <div class="modal fade" id="modalCheckList-{{$check_list_f->id}}" tabindex="-1" aria-labelledby="modalCheckListLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg"> <!-- Aumentando o tamanho da modal -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCheckListLabel">Inserir dados do Check List</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulário para inserir os dados -->
                                <form id="checkListForm-{{$check_list_f->id}}" method="post" action="{{ route('check-list-executado') }}">
                                    @csrf
                                    <input type="hidden" name="check_list_id" value="{{$check_list_f->id}}">
                                    <input type="hidden" name="equipamento_id" value="{{$check_list_f->equipamento_id}}">
                                    <input type="text" name="funcionario" value="{{$funcionario}}" class="form-control" readonly>
                                    <!-- Descrição -->
                                    <div class="mb-3">
                                        <label for="descricao" class="form-label">Descrição</label>
                                        <input type="text" class="form-control" value="{{$check_list_f->descricao}}" readonly>
                                    </div>
                                    <!-- Temperatura -->
                                    <div class="mb-3">
                                        <label for="descricao" class="form-label">Temperatura</label>
                                        <input type="number" id="observacao" class="form-control" name="temperatura" value="">
                                    </div>
                                    <!-- Vibração -->
                                    <div class="mb-3">
                                        <label for="descricao" class="form-label">Vibração</label>
                                        <input type="number" id="vibracao" class="form-control" name="vibracao" value="">
                                    </div>
                                    <!-- Seção de Gravidade -->
                                    <div>
                                        <label class="form-label">Gravidade</label>
                                        <div class="row g-2">
                                            <div class="col-6 col-md-3">
                                                <div class="form-check" style="border: 2px solid green; padding: 10px; border-radius: 5px;">
                                                    <input class="form-check-input" type="radio" name="gravidade" id="gravidade-baixo" value="1" checked>
                                                    <label class="form-check-label" for="gravidade-baixo">Baixo</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="form-check" style="border: 2px solid orange; padding: 10px; border-radius: 5px;">
                                                    <input class="form-check-input" type="radio" name="gravidade" id="gravidade-medio" value="2">
                                                    <label class="form-check-label" for="gravidade-medio">Médio</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="form-check" style="border: 2px solid yellow; padding: 10px; border-radius: 5px;">
                                                    <input class="form-check-input" type="radio" name="gravidade" id="gravidade-alto" value="3">
                                                    <label class="form-check-label" for="gravidade-alto">Alto</label>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="form-check" style="background-color:red; color:white; border-radius: 5px; padding: 10px;">
                                                    <input class="form-check-input" type="radio" name="gravidade" id="gravidade-gravissimo" value="4">
                                                    <label class="form-check-label" for="gravidade-gravissimo">Gravíssimo</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Observações -->
                                    <div class="mb-3 mt-4">
                                        <label for="observacoes" class="form-label">Observações</label>
                                        <input type="text" id="observacao" class="form-control" name="observacao" value="Normal" required>
                                    </div>
                                    <!-- Botões -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                        <!-- Adicionando o atributo 'form' para garantir que o botão submeta o formulário correto -->
                                        <button type="submit" form="checkListForm-{{$check_list_f->id}}" class="btn btn-primary">Salvar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                @endforeach
                @endif
            </div>
        </div>
        <!--Filtrar check list do equipamento-->

        <!-- Mensagens de retorno-->
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</body>

</html>