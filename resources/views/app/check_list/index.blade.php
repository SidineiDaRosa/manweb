@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header pb-2">
            <a class="btn btn-outline-dark mb-1" href="{{ route('app.home') }}" style="width:200px;">
                <i class="icofont-dashboard"></i> Dashboard
            </a>
        </div>
        <hr>
        {{--//------------------------------------------------//--}}
        {{--Filtrar o check list por equipamento--}}
        {{--//------------------------------------------------//--}}
        <form action="{{ route('check-list-show') }}" method="POST" id="form_fornecedor">
            @csrf
            <select name="equipamento_id" id="equipamento_id" class="form-control"
                onchange="document.getElementById('form_fornecedor').submit();">
                <option value=""> --Selecione O Ativo--</option>
                @foreach ($equipamentos as $equipamento_f)
                <option value="{{ $equipamento_f->id }}"
                    {{ isset($fornecedor) ? ($fornecedor == $equipamento_f->id ? 'selected' : '') : '' }}>
                    {{ $equipamento_f->nome }}
                </option>
                @endforeach
            </select>
        </form>
        <br>
        @if(isset($contChListMec))
        <span style="font-family: Arial, Helvetica, sans-serif;height:40px;font-weight:bold;">Check-Lists pendentes</span>
        <div style="display:flex;flex-direction:row;">
            <div class="btn btn-success mb-1" style="width:200px;margin:5px;">
                <a href="{{route('check-list-nat',['type'=>1,'nat'=>'Mecanico'])}}" style="color: white; text-decoration: none;">Mecânico: {{$contChListMec}}</a>
            </div>
            <div class="btn btn-warning mb-1" style="width:200px;margin:5px;">
                <a href="{{route('check-list-nat',['type'=>1,'nat'=>'Eletrico'])}}" style="color: white; text-decoration: none;">Elétrico: {{$contChListElet}}</a>
            </div>
            <div class="btn btn-primary mb-1" style="width:200px;margin:5px;">
                <a href="{{route('check-list-nat',['type'=>1,'nat'=>'Civil'])}}" style="color: white; text-decoration: none;">Civíl: {{$contChListCiv}}</a>
            </div>
            <div class="btn btn-dark mb-1" style="width:200px;margin:5px;">
                <a href="{{route('check-list-nat',['type'=>1,'nat'=>'Operacional'])}}" style="color: white; text-decoration: none;">Operacional: {{$contChListOpe}}</a>
            </div>
        </div>
        @endif
        @isset($check_lists_open)
        <table class="table table-sm" style="table-layout: fixed;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Equipamento</th>
                    <th>Intervalo</th>
                    <th>Data de Verificação</th>
                    <th>Hora de Verificação</th>
                    <th>Natureza</th>
                    <th>Criado em</th>
                    <th>Atualizado em</th>
                </tr>
            </thead>
            <tbody>
                @foreach($check_lists_open as $check_lists_open_f)
                <tr>
                    <td>{{$check_lists_open_f->id}}</td>
                    <td>{{$check_lists_open_f->descricao}}</td>
                    <td>{{$check_lists_open_f->equipamento_id}}</td>
                    <td>{{$check_lists_open_f->intervalo}}</td>
                    <td>{{$check_lists_open_f->data_verificacao}}</td>
                    <td>{{$check_lists_open_f->hora_verificacao}}</td>
                    <td>{{$check_lists_open_f->natureza}}</td>
                    <td>{{$check_lists_open_f->created_at}}</td>
                    <td>{{$check_lists_open_f->updated_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @endisset

        <hr>
        <!-- Tabela que mostra os pendedntes e e executados-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

        @if(isset($check_lists_status))
        @foreach($check_lists_status as $checkListsStatus_f)
        <div class="card mb-3 p-3 shadow-sm" style="">
            <h5>{{ $checkListsStatus_f->equipamento->nome }}</h5>
            <div style="display: flex; flex-direction: row; gap: 20px; align-items: center; flex-wrap: wrap;" class="mb-3">
                {{-- Pendentes --}}
                @if($checkListsStatus_f->pendentes > 0)
                <div style="display: flex; align-items: center; background-color: #fff3cd; color: #856404; padding: 6px 12px; border-radius: 6px; font-size: 14px; gap: 8px; min-height: 30px;">
                    <i class="bi bi-exclamation-circle-fill" style="font-size: 16px;"></i>
                    <span>Pendentes:</span>
                    <strong style="font-size: 16px;">{{ $checkListsStatus_f->pendentes }}</strong>
                </div>
                @else
                <div style="display: flex; align-items: center; background-color: #d1e7dd; color: #0f5132; padding: 6px 12px; border-radius: 6px; font-size: 14px; gap: 8px; min-height: 30px;">
                    <i class="bi bi-check-circle-fill" style="font-size: 18px;"></i>
                    <span>Tudo OK</span>
                </div>
                @endif


                {{-- Executadas --}}
                <div style="display: flex; align-items: center; background-color: #d4edda; color: #155724; padding: 6px 12px; border-radius: 6px; font-size: 14px; gap: 8px; min-height: 30px;">
                    <i class="bi bi-check-circle-fill" style="font-size: 16px;"></i>
                    <span>Executadas:</span>
                    <strong style="font-size: 16px;">{{ $checkListsStatus_f->executados }}</strong>
                </div>
                {{-- Botões --}}
                <div style="display: flex; gap: 10px;">
                    <form action="{{ route('check-list-show') }}" method="POST">
                        @csrf
                        <input type="hidden" name="equipamento_id" value="{{ $checkListsStatus_f->equipamento->id }}">
                        <button type="submit" class="btn btn-outline-dark">Check-lists</button>
                    </form>
                    <a href="{{ route('check-list-finalizado', ['equipamento_id' => $checkListsStatus_f->equipamento->id]) }}"
                        class="btn d-flex align-items-center gap-2"
                        style="background-color: rgb(255, 243, 205); color: rgba(112, 112, 109, 1); border: 1px solid rgb(255, 221, 128);">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                      &nbsp;  Avarias encontradas
                    </a>


                </div>
            </div>



            {{-- Alertas específicos --}}
            @php
            $alertasDoEquipamento = $checkListExcAlerts->where('equipamento_id', $checkListsStatus_f->equipamento->id);
            @endphp
            @if($alertasDoEquipamento->isNotEmpty())
            <div class="alert alert-warning mt-3 mb-0" style="background-color: #f8f5efff; padding: 10px;">
                @foreach($alertasDoEquipamento as $alerta)
                <div style="background: white; padding: 10px 15px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 10px;">
                    <div><strong>Checklist:</strong> {{ $alerta->checklist->descricao ?? 'N/A' }}</div>
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <strong>Gravidade:</strong>
                        <span>{{ $alerta->gravidade }}</span>
                        @php
                        $nivelGravidade = intval($alerta->gravidade);
                        @endphp
                        @if($nivelGravidade >= 3 && $nivelGravidade <= 5)
                            <i class="bi bi-exclamation-triangle-fill" style="color: orange; font-size: 18px;"></i>
                            @else
                            <i class="bi bi-info-circle-fill" style="color: gray; font-size: 18px;"></i>
                            @endif
                    </div>
                    <div><strong>Data Fim:</strong> {{ \Carbon\Carbon::parse($alerta->data_fim)->format('d/m/Y H:i') }}</div>
                    <div style="color: darkblue;"><strong>Obs.:</strong> {{ $alerta->observacao }}</div>
                </div>
                @endforeach
            </div>
            @endif




        </div>
        @endforeach
        @endif

        <hr>
        <div class="card-header justify-content-left pt-1">
            <!-- Gravar um novo check list para o equipamento -->
            <form id="form_store" action="{{ route('check-list-gravar') }}" method="POST">
                @csrf
                <div style="display: flex; flex-direction: row;">
                    @if(isset($equipamento))
                    <input type="text" class="form-control" name="equipamento_id" id="equipamento_id" value="{{$equipamento->id}}" readonly hidden>
                    <input type="text" class="form-control" name="ativo_nome" id="ativo_nome" value="{{$equipamento->nome}}" readonly style="width: 400px">
                    <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px;"> Descrição: </span>
                    <input type="text" class="form-control" name="descricao" id="descricao" style="width: 400px;">
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

                <button type="submit" class="btn btn-primary">Adicionar Check-List</button>
                <a href="{{ route('check-list-finalizado',['equipamento_id'=>$equipamento->id]) }}" class="btn btn-dark">Check-List Executado</a>
                @endif
            </form>
            <hr>
            <!--  tabela mostra os check list aberto-->
            <div calss="div-row">

                @if(isset($equipamento))
                @if(isset($check_list))
                @foreach($check_list as $check_list_f)
                <div style="display:flex;flex-direction:row;">
                    <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px; margin-right:100px;">
                        <h5> ID:</h5> {{$check_list_f->id}}
                    </span>
                    <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px; margin-right:20px; width:20%;">
                        <h5>Descrição: </h5>{{$check_list_f->descricao}}
                    </span>
                    <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px; margin-right:20px; width:20%;">
                        <h5>Natureza: </h5>{{$check_list_f->natureza}}
                    </span>
                    <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px; margin-right:20px; width:20%;">
                        <h5>Intervalo: </h5> {{$check_list_f->intervalo}}hs
                    </span>
                    <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px; margin-right:20px; width:30%;">
                        <h5>Data hora: </h5>
                        @if(!empty($check_list_f->data_verificacao))
                        {{ \Carbon\Carbon::parse($check_list_f->data_verificacao)->format('d/m/Y') }}as
                        {{$check_list_f->hora_verificacao}}
                        @else
                        Data não informada ainda.
                        @endif
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
                    $intervaloVerificacao = 330;
                    @endphp

                    <!-- Para depuração: exibe a diferença em horas -->
                    @if (empty($check_list_f->data_verificacao) || $horasDiferenca >= $intervaloVerificacao)
                    <!-- Mostrar a imagem de "warning" se já tiver passado mais de 360 horas -->
                    <img style="height:30px; width:auto;" src="{{ asset('img/warning.png') }}" alt="Aviso">
                    @else
                    <!-- Mostrar a imagem de "check-mark" se a diferença for de 360 horas ou menos -->
                    <img style="height:30px; width:auto;" src="{{ asset('img/check-mark.png') }}" alt="Checado">
                    @endif
                    <!-- operações de edição-->
                    <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{route('check-list-edit',['check_list'=>$check_list_f->id])}}">
                        <i class="icofont-ui-edit"></i> </a>
                    <!--------------------------------------------------------------------------------->
                    <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="DeletarEquipamento({{ $check_list_f->id }})">
                        <i class="icofont-ui-delete"></i>
                    </a>

                    <script>
                        function DeletarEquipamento(checkListId) {
                            var r = confirm("Deseja deletar o checklist com ID: " + checkListId + "?");
                            if (r == true) {
                                // Chamada AJAX para deletar o checklist
                                fetch(`{{ url('check-list-delete') }}/${checkListId}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Content-Type': 'application/json'
                                        }
                                    })
                                    .then(response => {
                                        if (response.ok) {
                                            alert("Checklist deletado com sucesso!");
                                            // Atualize a página ou remova o item da lista, se necessário
                                            location.reload(); // Por exemplo, recarregue a página
                                        } else {
                                            alert("Erro ao deletar o checklist.");
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Erro:', error);
                                        alert("Ocorreu um erro ao deletar o checklist.");
                                    });
                            }
                        }
                    </script>


                </div>
                <hr style="margin-top:2px;">

                @endforeach
                @endif
                @endif
            </div>
        </div>
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