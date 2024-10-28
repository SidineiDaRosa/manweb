@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header pb-2">
            Check-List índice
            <a class="btn btn-outline-dark mb-1" href="{{ route('app.home') }}" style="width:200px;">
                <i class="icofont-dashboard"></i> dashboard
            </a>
        </div>

        <div class="card-header justify-content-left pt-1">
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
                        {{ \Carbon\Carbon::parse($check_list_f->data_verificacao)->format('d/m/Y') }}as
                        {{$check_list_f->hora_verificacao}}
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
                    $intervaloVerificacao = 360;
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