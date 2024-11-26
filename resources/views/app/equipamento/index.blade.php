@extends('app.layouts.app')

@section('content')

<main class="content" style="">
    <div style="font-family: Arial, Helvetica, sans-serif;color:#333333">Lista de Equipamentos</div>
    <div class="card">
        <div class="card-header-template" style="background-color:rgb(245, 246, 248);">
            <!--------------------------------------------->
            <div class="col-md-0">

                <a href="{{ route('equipamento.create') }}" class="btn btn-outline-primary">
                    <i class="icofont-plus-circle"></i>

                    <span class="text">Novo Ativo/equipamento</span>
                </a>
                <a class="btn btn-outline-dark btn-bg" href="{{ route('app.home') }}">
                    <i class="icofont-dashboard"></i> Dashboard
                </a>
            </div>
            <!-- determina a largura do form-->
            <div class="col-md-0" style="width: 400px;">
                <form action="{{route('equipamento.index',['empresa'=>2])}}">
                    {{---------------------------------------------------}}
                    {{--Teste de searching equipamentos------------------}}
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="digite aqui..." aria-label="digite" aria-describedby="button-addon2" name="empresa" value="{{ $empresa_id}}" readonly hidden>

                        <input type="text" class="form-control" placeholder="--Digite o nome parcial--" aria-label="" aria-describedby="button-addon2" name="searching">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Busca Ativo/Equipamento</button>
                </form>
            </div>
            {{---fim----------------------------------------------}}
            </form>
        </div>
        <div class="col-md-0">
            <a href="{{route('empresas.index')}}" class="btn btn-outline-success">
                <span class="text">Unidades Empresariais</span>
            </a>
        </div>

    </div>

    <div class="card-body">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Equipamento Pai</th>
                    <th scope="col">Empresa</th>
                    <th scope="col">Operações</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($equipamentos as $equipamento)
                <tr>
                    <th scope="row">{{ $equipamento->id }}</td>
                    <td>{{ $equipamento->nome }}</td>
                    <td>{{ $equipamento->descricao }}</td>
                    <td>{{ $equipamento->marca->nome }}</td>
                    <td>{{ $equipamento->equip_pai->nome ?? '' }}</td>
                    <td>{{ $equipamento->Empresa->razao_social }}</td>

                    <td>
                        <div {{-- class="div-op" --}} class="btn-group btn-group-actions visible-on-hover">
                            <a class="btn btn-sm-template btn-outline-primary" href="{{ route('equipamento.show', ['equipamento' => $equipamento->id]) }}">
                                <i class="icofont-eye-alt"></i>
                            </a>
                            <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{ route('equipamento.edit', ['equipamento' => $equipamento->id]) }}">
                                <i class="icofont-ui-edit"></i> </a>
                            <form id="form_{{ $equipamento->id }}" method="post" action="{{ route('equipamento.destroy', ['equipamento' => $equipamento->id]) }}">
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
                            <a class="btn btn-outline-primary btn-bg" href="{{route('ordem-servico.create', ['equipamento'=>$equipamento->id,'empresa'=>2])}}"
                                title="Cria nova O.S.">
                                <span class="icon text-white-50">
                                </span>
                                <span class="text">o.s.</span>
                                <span class="material-symbols-outlined">
                                    assignment_add
                                </span>
                            </a>
                            <a class="btn btn-outline-success btn-bg" href="{{route('pedido-compra.create',['equipamento_id' => $equipamento->id])}}"
                            title="Cria novo Pedido de compra">
                                P.C.<span class="material-symbols-outlined">
                                    list_alt_add
                                </span>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    </div>


</main>
@endsection