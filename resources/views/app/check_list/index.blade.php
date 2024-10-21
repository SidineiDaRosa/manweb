@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header pb-2">
            <p class="mb-0">Check-List</p>
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
            <form action="{{ route('check-list-gravar') }}" method="POST">
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
                    <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px; margin-right:20px; width:20%;">
                        <h5> ID:</h5> {{$check_list_f->id}}
                    </span>
                    <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px; margin-right:20px; width:20%;">
                        <h5>Descrição: </h5>{{$check_list_f->descricao}}
                    </span>
                    <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px; margin-right:20px; width:20%;">
                        <h5>Intervalo: </h5> {{$check_list_f->intervalo}}hs
                    </span>
                    <span style="font-family: Arial, Helvetica, sans-serif; margin-top:4px; margin-right:20px; width:20%;">
                        <h5>Data hora: </h5>
                        {{ \Carbon\Carbon::parse($check_list_f->data_verificacao)->format('d/m/Y') }} as {{$check_list_f->hora_verificacao}}
                    </span>
                    <!-- operações de edição-->
                    <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="">
                        <i class="icofont-ui-edit"></i> </a>
                    <form id="form_{{ $equipamento->id }}" method="post" action="{{ route('check-list-delete', ['check_list_id' => $check_list_f->id]) }}">
                        @method('DELETE')
                        @csrf
                    </form>
                    <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick=" DeletarEquipamento()">
                        <i class="icofont-ui-delete"></i></a>
                    <script>
                        function DeletarEquipamento() {
                            var x;
                            var r = confirm("Deseja deletar o equipamento?");
                            if (r == true) {

                                //document.getElementById('form_{{ $equipamento->id}}').submit()
                            } else {
                                x = "Você pressionou Cancelar!";
                            }
                            document.getElementById("demo").innerHTML = x;
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