@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header pb-2">
            <a class="btn btn-outline-dark mb-1" href="{{ route('app.home') }}" style="width:200px;">
                <i class="icofont-dashboard"></i> Dashboard
            </a>
            <a href="{{ route('checklist.executado.get') }}"
                class="btn btn-outline-primary mb-1">
                <i class="bi bi-list-check"></i>
                &nbsp; Checklists
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
            <div class="btn btn-dark mb-1" style="width:200px;margin:5px;">
                <a href="{{route('check-list-nat',['type'=>1,'nat'=>'Mecanico'])}}" style="color: white; text-decoration: none;">Mecânico: {{$contChListMec}}</a>
            </div>
            <div class="btn btn-warning mb-1" style="width:200px;margin:5px;">
                <a href="{{route('check-list-nat',['type'=>1,'nat'=>'Eletrico'])}}" style="color: white; text-decoration: none;">Elétrico: {{$contChListElet}}</a>
            </div>
            <div class="btn btn-primary mb-1" style="width:200px;margin:5px;">
                <a href="{{route('check-list-nat',['type'=>1,'nat'=>'Civil'])}}" style="color: white; text-decoration: none;">Civíl: {{$contChListCiv}}</a>
            </div>
            <div class="btn btn-primary mb-1" style="width:200px;margin:5px;">
                <a href="{{route('check-list-nat',['type'=>1,'nat'=>'Operacional'])}}" style="color: white; text-decoration: none;">Operacional: {{$contChListOpe}}</a>
            </div>
            <!-- <div class="btn btn-success mb-1" style="width:200px;margin:5px;">
              <a href="{{route('check-list-nat',['type'=>1,'nat'=>'SESMT'])}}" style="color: white; text-decoration: none;">SESMT: {{$contChListOpe}}</a>
            </div>-->
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
                    <th>Especialidade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($check_lists_open as $check_lists_open_f)
                <tr>
                    <td>{{$check_lists_open_f->id}}</td>
                    <td>{{$check_lists_open_f->descricao}}</td>
                    <td>{{$check_lists_open_f->equipamento->nome}}</td>
                    <td>{{$check_lists_open_f->intervalo}}hs</td>
                    <td>{{$check_lists_open_f->data_verificacao}}</td>
                    <td>{{$check_lists_open_f->hora_verificacao}}</td>
                    <td>{{$check_lists_open_f->natureza}}</td>
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
            <h5>{{ $checkListsStatus_f->equipamento->id }}&nbsp;{{ $checkListsStatus_f->equipamento->nome }}</h5>
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
                        &nbsp; Avarias encontradas
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
                    <div><strong>Data Fim:</strong> {{ \Carbon\Carbon::parse($alerta->updated_at)->format('d/m/Y H:i') }}</div>
                    <div><strong>Gerado por:</strong> {{$alerta->funcionario}}</div>
                    <div style="color: darkblue;"><strong>Obs.:</strong> {{ $alerta->observacao }}</div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @endforeach
        @endif
        <h6>Checklists por equipamento</h6>
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
                    <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px;">Especialidade Técnica:</span>
                    <select class="form-control" name="natureza" id="Natureza" style="width: 300px;">
                        <option value="Elétrico">Elétrico</option>
                        <option value="Mecânico">Mecânico</option>
                        <option value="Civíl">Civíl</option>
                        <option value="Operacional">Operacional</option>
                        <!--<option value="SESMT">SESMT</option>-->
                    </select>
                </div>
                <hr>

                <button type="submit" class="btn btn-primary">Adicionar Check-List</button>
                <a href="{{ route('check-list-finalizado',['equipamento_id'=>$equipamento->id]) }}" class="btn btn-dark">Check-List Executado</a>
                @endif
            </form>

            <div class="checklist-container">

                @if(isset($equipamento) && isset($check_list))
                @foreach($check_list as $check_list_f)
                <div class="checklist-item">
                    <div class="checklist-details">
                        <span class="detail-item">
                            <h5>ID:</h5> {{ $check_list_f->id }}
                        </span>
                        <span class="detail-item description">
                            <h5>Descrição:</h5> {{ $check_list_f->descricao }}
                        </span>
                        <span class="detail-item">
                            <h5>Especialidade técnica:</h5> {{ $check_list_f->natureza }}
                        </span>
                        <span class="detail-item">
                            <h5>Intervalo entre checagem:</h5> {{ $check_list_f->intervalo }}hs
                        </span>
                        <span class="detail-item date-time">
                            <h5>Data/Hora última chacagem:</h5>
                            @if(!empty($check_list_f->data_verificacao))
                            {{ \Carbon\Carbon::parse($check_list_f->data_verificacao)->format('d/m/Y') }} às
                            {{ $check_list_f->hora_verificacao }}
                            @else
                            Data não informada ainda.
                            @endif
                        </span>
                    </div>
                    @php
                    $dataVerificacao = !empty($check_list_f->data_verificacao)
                    ? new DateTime($check_list_f->data_verificacao)
                    : null;

                    $dataAtual = new DateTime();
                    $horasDiferenca = 0;

                    if ($dataVerificacao) {
                    $diferenca = $dataAtual->diff($dataVerificacao);
                    // diferença total em horas
                    $horasDiferenca = ($diferenca->days * 24) + $diferenca->h;
                    }

                    // intervalo específico do checklist
                    $intervaloVerificacao = $check_list_f->intervalo;
                    @endphp

                    <div class="checklist-status">
                        @if (empty($check_list_f->data_verificacao))
                        <i class="bi bi-question-circle-fill text-secondary icon-md" title="Sem data"></i>
                        @elseif ($horasDiferenca >= $intervaloVerificacao)
                        <i class="bi bi-x-circle-fill text-danger icon-xl" title="Vencido"></i>
                        @elseif ($horasDiferenca >= ($intervaloVerificacao * 0.90))
                        <i class="bi bi-exclamation-triangle-fill text-warning icon-lg" title="Próximo de vencer"></i>
                        @else
                        <i class="bi bi-check-circle-fill text-success icon-md" title="Dentro do prazo"></i>
                        @endif
                    </div>
                    <style>
                        /* tamanhos personalizados para os ícones */
                        .icon-xl {
                            font-size: 30px !important;
                            /* bem grande */
                        }

                        .icon-lg {
                            font-size: 30px !important;
                        }

                        .icon-md {
                            font-size: 30px !important;
                        }

                        .icon-sm {
                            font-size: 30px !important;
                        }
                    </style>
                    <div class="checklist-actions">
                        <a class="btn btn-sm-template btn-outline-success @can('user') disabled @endcan" href="{{ route('check-list-edit', ['check_list' => $check_list_f->id]) }}">
                            <i class="icofont-ui-edit"></i>
                        </a>
                        <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="deleteChecklist({{ $check_list_f->id }})">
                            <i class="icofont-ui-delete"></i>
                        </a>
                    </div>
                </div>
                <hr class="checklist-separator">
                @endforeach
                @endif
            </div>
            <!--  fim lista de checklist-->
        </div>
        <style>
            .checklist-container {
                padding: 15px;
            }

            .checklist-item {
                display: flex;
                flex-wrap: wrap;
                /* Allows items to wrap on smaller screens */
                align-items: center;
                justify-content: space-between;
                /* Distributes space between main sections */
                background-color: #f9f9f9;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 15px;
                margin-bottom: 10px;
                /* Space between checklist items */
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            }

            .checklist-details {
                display: flex;
                flex-wrap: wrap;
                /* Allow details to wrap if necessary */
                flex-grow: 1;
                /* Allows details section to take available space */
                gap: 15px;
                /* Space between individual detail items */
                margin-right: 20px;
                /* Space before status icon */
            }

            .detail-item {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 0.95em;
                min-width: 120px;
                /* Ensures minimum width for each detail for better alignment */
            }

            .detail-item h5 {
                margin-bottom: 2px;
                font-size: 1em;
                color: #555;
            }

            .detail-item.description {
                flex-basis: 200px;
                /* Give more space to description */
                flex-grow: 1;
                /* Allow it to grow */
            }

            .detail-item.date-time {
                flex-basis: 180px;
                /* Give more space to date/time */
                flex-grow: 1;
            }

            .checklist-status {
                margin-right: 20px;
                /* Space before action buttons */
            }

            .status-icon {
                height: 30px;
                width: auto;
            }

            .checklist-actions {
                display: flex;
                gap: 8px;
                /* Space between action buttons */
            }

            .checklist-separator {
                border: 0;
                border-top: 1px solid #eee;
                margin: 15px 0;
            }

            /* Basic responsiveness for smaller screens */
            @media (max-width: 768px) {
                .checklist-item {
                    flex-direction: column;
                    /* Stack items vertically */
                    align-items: flex-start;
                    /* Align items to the start when stacked */
                }

                .checklist-details {
                    width: 100%;
                    /* Take full width */
                    margin-bottom: 15px;
                    margin-right: 0;
                }

                .detail-item {
                    min-width: unset;
                    /* Remove min-width for better stacking */
                    width: 100%;
                    /* Make each detail item take full width */
                }

                .checklist-status,
                .checklist-actions {
                    width: 100%;
                    display: flex;
                    /* Keep actions and status in a row */
                    justify-content: flex-end;
                    /* Push actions to the right */
                    margin-top: 10px;
                    margin-right: 0;
                }
            }
        </style>
        <!--------------------------------------------------->
        <!-- Deletar o check-list-->
        <script>
            function deleteChecklist(checkListId) {
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