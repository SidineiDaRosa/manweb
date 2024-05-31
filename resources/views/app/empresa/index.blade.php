@extends('app.layouts.app')

@section('titulo', 'Marcas')

@section('content')

<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>Listagem de Empresas</div>
            <form action="{{'Empresas-filtro'}}" method="POST">
                @csrf

                <!--input box filtro buscar empresas--------->

                <input type="text" id="query" name="empresa1" placeholder="Buscar empresa..." aria-label="Search through site content">
                <button type="submit">
                    <i class="icofont-search"></i>

                </button>

            </form>
            <div>
                <a class="btn btn-bg-template btn-outline-primary" href="{{route('empresas.create')}}">

                    <i class="icofont-company"></i>
                   new unit company
                </a>

            </div>
        </div>
        <!-------------------------------------------------------------------------->
        <style>
            form {
                background-color: white;
                width: 500px;
                height: 44px;
                border-radius: 5px;
                display: flex;
                flex-direction: row;
                align-items: center;
            }

            input {
                all: unset;
                font: 16px system-ui;
                color: blue;
                height: 100%;
                width: 100%;
                padding: 6px 10px;
            }

            ::placeholder {
                color: blueviolet;
                opacity: 0.9;
            }


            button {
                all: unset;
                cursor: pointer;
                width: 44px;
                height: 44px;
            }
        </style>
        <!-------------------------------------------------------------------------->

        <div class="card-body">
            <table class="table-template table-hover table-striped table-bordered">
                <thead class="bg-active ">
                    <tr>
                        <th scope="col" class="th-title">Id</th>
                        <th scope="col" class="th-title">Razão social</th>
                        <th scope="col" class="th-title">Nome fantasia</th>
                        <th scope="col" class="th-title">Cnpj</th>
                        <th scope="col" class="th-title">Inscrição estadual</th>
                        <th scope="col" class="th-title">Endereço</th>
                        <th scope="col" class="th-title">Bairro</th>
                        <th scope="col" class="th-title">Cidade</th>
                        <th scope="col" class="th-title">Operações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empresas as $empresa)
                    <tr>

                        <th scope="row">{{ $empresa->id }}</th>
                        <td>{{ $empresa->razao_social }}</td>
                        <td>{{ $empresa->nome_fantasia }}</td>
                        <td>{{ $empresa->cnpj }}</td>
                        <td>{{ $empresa->insc_estadual }}</td>
                        <td>{{ $empresa->endereco}}</td>
                        <td>{{ $empresa->bairro}}</td>
                        <td>{{ $empresa->cidade}}</td>
                        <td>
                            <div class="col-sm-0">
                                <a href="{{route('equipamento.index', ['empresa'=>$empresa->id])}}" class="btn-sm btn-success">
                                    <span class="icon text-white-50">
                                        <i class="icofont-search"></i>
                                    </span>
                                    <span class="text">Busca Equipamentos</span>
                                </a>
                            </div>
                        </td>
                        @csrf
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>


</main>

@endsection