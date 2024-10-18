@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header pb-2">
            <p class="mb-0">Check-List</p>
        </div>

        <div class="card-header justify-content-left pt-1">
            {{--//------------------------------------------------//--}}
            {{--Check list por equipamento--}}
            {{--//------------------------------------------------//--}}

            <!-- Gravar um novo check list para o equipamento -->
            <h5>{{$equipamento->nome}}</h5>
            <button type="button" class="btn btn-outline-success open-modal-btn"
                onclick="window.location.href='{{ route('check-list-index') }}'"
                style="float:right">
                Check-List índice
            </button>
        </div>
        <!-- CSS do Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- JS do Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <div class="card-body">
            <div>
                @if(isset($check_list))
                @foreach($check_list as $check_list_f)
                <div calss="div-row" style="display:flex;flex-direction:row;">
                    <div style="margin-right:20px;width:30px;margin:2px;"> <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;">{{$check_list_f->id}}</span></div>
                    <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;margin-right:20px;width:20%;">{{$check_list_f->descricao}}</span>
                    <span style="font-family: Arial, Helvetica, sans-serif;margin-top:4px;margin-right:20px;width:20%;">Intervalo de verificação:{{$check_list_f->intervalo}}hs</span>
                    <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px; margin-right:20px; width:20%;">
                        {{$check_list_f->data_verificacao}}
                    </span>

                    <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px; margin-right:20px; width:20%;">
                        {{ $check_list_f->hora_verificacao }}
                    </span>


                    @if (date('Y-m-d', strtotime($check_list_f->hora_verificacao)) === date('Y-m-d'))
                    <!-- Mostrar a imagem de "check-mark" se a data for igual à data atual -->
                    <img style="height:30px; width:auto;" src="{{ asset('img/check-mark.png') }}" alt="Checado">
                    @else
                    <!-- Mostrar a imagem de "warning" se a data for diferente da data atual -->
                    <img style="height:30px; width:auto;" src="{{ asset('img/warning.png') }}" alt="Aviso">
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
                                    <!-- Descrição -->
                                    <div class="mb-3">
                                        <label for="descricao" class="form-label">Descrição</label>
                                        <input type="text" class="form-control" value="{{$check_list_f->descricao}}" readonly>
                                    </div>
                                    <!-- Temperatura -->
                                    <div class="mb-3">
                                        <label for="descricao" class="form-label">Temperatura</label>
                                        <input type="number" id="observacao" class="form-control" name="temperatura" value="" >
                                    </div>
                                       <!-- Vibração -->
                                       <div class="mb-3">
                                        <label for="descricao" class="form-label">Vibração</label>
                                        <input type="number" id="vibracao" class="form-control" name="vibracao" value="" >
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

</main>
@endsection