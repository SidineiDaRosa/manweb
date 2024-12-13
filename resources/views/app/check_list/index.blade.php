@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header pb-2">
            Check-List índice
            <a class="btn btn-outline-dark mb-1" href="{{ route('app.home') }}" style="width:200px;">
                <i class="icofont-dashboard"></i> Dashboard
            </a>
        </div>
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
        <table  class="table table-sm" style="table-layout: fixed;">
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
        @if(isset($check_lists_status))
        <table class="table table-sm" style="table-layout: fixed;">
            <thead>
                <tr>
                    <th>Equipamento</th>
                    <th>Pendentes</th>
                    <th>Executadas</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($check_lists_status as $checkListsStatus_f)
                <tr>
                    <td>{{ $checkListsStatus_f->equipamento->nome }}</td>
                    <td style="background-color: orange; color: black;font-size:20px;">{{ $checkListsStatus_f->pendentes }}</td>
                    <td style="background-color: lightgreen; color: black;font-size:20px;">{{ $checkListsStatus_f->executados }}</td>
                    <td>
                        <form action="{{ route('check-list-show') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="equipamento_id" value="{{ $checkListsStatus_f->equipamento->id }}">
                            <button type="submit" class="btn btn-outline-dark mb-1" style="width:200px;float:right;">
                                Visualizar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        <!--  tabela mostra os check list aberto-->

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