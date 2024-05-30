@extends('app.layouts.app')

@section('content')

<main class="content">
    <div>LISTAGEM DE EQUIPAMENTOS</div>
    <div class="card">
        <div class="card-header-template">

            <!--------------------------------------------->
            <div class="col-md-0">
                <label for="btFiltrar" class=""> Novo </label>
                <p>
                    <a href="{{ route('equipamento.create') }}" class="btn btn-info btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="icofont-plus-circle"></i>
                        </span>
                        <span class="text">Novo equipamento</span>
                    </a>
            </div>
            <div class="col-md-0">
                <form action="{{route('equipamento.index',['empresa'=>2])}}">
                    <label for="btFiltrar" class="">id da empresa</label>
                    {{---------------------------------------------------}}
                    {{--Teste de searching equipamentos------------------}}
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="digite aqui..." aria-label="digite" aria-describedby="button-addon2" name="empresa" value="{{ $empresa_id}}" readonly>

                        <input type="text" class="form-control" placeholder="digite aqui..." aria-label="digite" aria-describedby="button-addon2" name="searching">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Busca</button>
                    </div>
                    {{---fim----------------------------------------------}}
            </div>
            </form>
            <div class="col-md-0">

                <label for="btFiltrar" class="">Empresas</label>
                <p>
                    <a href="{{route('empresas.index')}}" class="btn btn-info btn-icon-split">
                        <span class="text">Empresas</span>
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
