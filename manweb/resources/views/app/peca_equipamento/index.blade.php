@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <style>
            .card {
                background-color: rgb(211, 211, 211);
            }

            #equipamento_id {
                font-size: 20px;
            }
        </style>
        <div class="form-row mb-2">

            <div class="col-md-2 mb-0">
                <label for="equipamento_id" class="col-md-2 col-form-label text-bg">ID</label>
                <input id="equipamento_id" type="nuber" class="form-control -lg" name="equipamento_id" value="@foreach($equipamento as $equipamento_f)
                    {{$equipamento_f['id']}}
                    @endforeach" readonly>
                {{ $errors->has('id') ? $errors->first('id') : '' }}

            </div>
            <div class="col-md-4 mb-0 ">
                <label for="equipamento" class="col-md-4 col-form-label text-md-end">Nome do equipamento</label>
                <input id="equipamento" type="nuber" class="form-control -lg" name="equipamento" value="@foreach($equipamento as $equipamento_f)
                    {{$equipamento_f['nome']}}
                    @endforeach" readonly>
                {{ $errors->has('nome') ? $errors->first('nome') : '' }}
            </div>
            <div class="col-md-4 mb-0">
                <label for="descricao" class="col-md-2 col-form-label text-bg">Descrição</label>
                <input id="descricao" type="nuber" class="form-control -lg" name="descricao" value="@foreach($equipamento as $equipamento_f)
                    {{$equipamento_f['descricao']}}
                    @endforeach" readonly>
                {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}

            </div>
            <div class="col-md-6 mb-0">
                <label for="data_fabricacao" class="col-md-2 col-form-label text-bg">Data Fabricação</label>
                <input id="data_fabricacao" type="nuber" class="form-control -lg" name="data_fabricacao" value="@foreach($equipamento as $equipamento_f)
                    {{$equipamento_f['data_fabricacao']}}
                    @endforeach" readonly>
                {{ $errors->has('descricao') ? $errors->first('descricao') : '' }}

            </div>
            <p></p>
            <div class="col-md-4 mb-0">
                <label for="equipamento" class="col-md-4 col-form-label text-md-end"></label>
                <a href="{{ route('Peca-equipamento.create',['equipamento' => $equipamento_f->id]) }}" class="btn btn-sm btn-primary">
                    Cadastrar peça do equipamento
                </a>

                <a href="{{route('ordem-servico.create', ['empresa'=>6,'equipamento'=>$equipamento_f->id])}}" class="btn-sm btn-success">
                    <span class="icon text-white-50">
                        <i class="icofont-database-add icofont-2x"></i>
                    </span>
                    <span class="text">Nova ordem</span>
                </a>
            </div>
        </div>
    </div>
    <hr>
        <h5>Componentes deste equipamento</h5>
        <hr>
    <div class="card-body">
    <style>
                #tblOs {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    background-color: rgb(211, 211, 211);
                }
                #tblPecas {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    background-color: rgb(211, 211, 211);
                }
                thead {
                    background-color: rgb(169, 169, 169);
                }

                td,
                th {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 8px;
                }

                tr:nth-child(even) {
                    background-color: #dddddd;
                }

                tr:hover {
                    background-color: rgb(169, 169, 169);
                }
            </style>
        <table class="table-template table-sm table-striped table-hover" id="tblPecas">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">equipamento</th>
                    <th scope="col">Produto Id</th>
                    <th scope="col">Produto</th>
                    <th scope="col">Quantidade</th>
                    <th scope="col">Link</th>
                    <th scope="col">intervalo</th>
                    <th scope="col">data ultima substituação</th>
                    <th scope="col">Hora</th>
                    <th scope="col">data proxima</th>
                    <th scope="col">horas proxima</th>
                    <th scope="col">horimetro</th>
                    <th scope="col">status</th>
                    <th scope="col">Operaçoes</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($pecas_equipamento as $peca_equipamento)
                <tr>
                    <td scope="row">{{ $peca_equipamento->id }}</td>
                    <td>{{ $equipamento_f->nome}}</td>
                    <td>{{ $peca_equipamento->produto->id}} <a class="btn btn-sm-template btn-outline-primary" href="">

                            <i class="icofont-search-2"></i>
                        </a>
                    </td>
                    <td>{{ $peca_equipamento->produto->nome}}</td>
                    <td>{{ $peca_equipamento->quantidade}}</td>
                    <td>{{ $peca_equipamento->link_peca}}</td>
                    <td>{{ $peca_equipamento->intervalo_manutencao}}</td>
                    <td>{{ date( 'd/m/Y' , strtotime($peca_equipamento['data_substituicao']))}}</td>
                    <td>{{ $peca_equipamento->hora_substituicao}}</td>
                    <td>{{ date( 'd/m/Y' , strtotime($peca_equipamento['data_proxima_manutencao']))}}</td>
                    <td>{{ $peca_equipamento->horas_proxima_manutencao}}</td>
                    <td>{{ $peca_equipamento->horimetro}}</td>
                    <td>{{ $peca_equipamento->status}}</td>
                    <!--Div operaçoes do registro da ordem des serviço-->
                    <td>
                        <div {{-- class="div-op" --}} class="btn-group btn-group-actions visible-on-hover">
                            <a class="btn btn-sm-template btn-outline-primary" href="">
                                <i class="icofont-eye-alt"></i>
                            </a>
                            <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="">
                                <i class="icofont-ui-edit"></i> </a>
                            <!--Condoçes para deletar a os-->
                            <form id="" method="post" action="">
                                @method('DELETE')
                                @csrf
                            </form>
                            <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick=" DeletarOs()">
                                <i class="icofont-ui-delete"></i>
                                <script>
                                    function DeletarOs() {
                                        var x;
                                        var r = confirm("Deseja deletar a ordem de serviço?");
                                        if (r == true) {

                                            // document.getElementById('').submit()
                                        } else {
                                            x = "Você pressionou Cancelar!";
                                        }
                                        document.getElementById("demo").innerHTML = x;
                                    }
                                </script>
                            </a>
                            <!------------------------------>



                        </div>

                </tr>
                @endforeach
            </tbody>
        </table>

        <!------------------------------------------------------------------------------------------>
        <hr>
        <h5>Ordem de serviço deste equipamento</h5>
        
        <hr>
        <table class="" id="tblOs">
            <thead>
                <tr>
                    <th>ID</th>
                    <th hidden>Data emissao</th>
                    <th hidden>Hora</th>
                    <th>Data prevista</th>
                    <th>Hora prevista</th>
                    <th>Data fim</th>
                    <th>Hora fim</th>
                    <th>Empresa</th>
                    <th>Patrimônio</th>
                    <th>Emissor</th>
                    <th>Responsável</th>
                    <th>Descrição</th>
                    <th>Executado</th>
                    <th>link foto</th>
                    <th>Status</th>
                    <th>Valor</th>
                    <th>Operações</th>
                    <th>check</th>
                </tr>
            </thead>
            @foreach ($ordens_servicos as $ordem_servico)
            <tbody>
                <tr>
                    <td>{{ $ordem_servico->id }}</td>
                    <td hidden>{{ $ordem_servico->data_emissao}}</td>
                    <td hidden>{{ $ordem_servico->hora_emissao}}</td>
                    <td> {{ date( 'd/m/Y' , strtotime($ordem_servico['data_inicio']))}}</td>
                    <td>{{ $ordem_servico->hora_inicio}}</td>
                    <td> {{ date( 'd/m/Y' , strtotime($ordem_servico['data_fim']))}}</td>
                    <td>{{ $ordem_servico->hora_fim}}</td>
                    <td>
                        {{ $ordem_servico->Empresa->razao_social}}
                    </td>
                    <td>{{ $ordem_servico->equipamento->nome}}</td>
                    <td>{{ $ordem_servico->emissor}}</td>
                    <td>{{ $ordem_servico->responsavel}}</td>
                    <td id="descricao">

                        {{ $ordem_servico->descricao}}

                    </td>
                    <td>
                        {{ $ordem_servico->Executado}}


                    </td>
                    <td><a href="{{ $ordem_servico->link_foto}}" target="blank">link foto</a></td>
                    <td>{{ $ordem_servico->situacao}}
                        <div class="progress mb-3" role="progressbar" aria-label="Success example with label" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar text-bg-warning">{{ $ordem_servico->status_servicos}}%</div>
                        </div>
                    </td>
                    <td id="valor" value="{{ $ordem_servico->valor}}">{{ $ordem_servico->valor}}</td>
                    <!--Div operaçoes do registro da ordem des serviço-->
                    <td>
                        <div {{-- class="div-op" --}} class="btn-group btn-group-actions visible-on-hover">
                            <a class="btn btn-sm-template btn-outline-primary" href="{{route('ordem-servico.show', ['ordem_servico'=>$ordem_servico->id])}}">
                                <i class="icofont-eye-alt"></i>
                            </a>

                            <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{route('ordem-servico.edit', ['ordem_servico'=>$ordem_servico->id])}}">

                                <i class="icofont-ui-edit"></i> </a>

                            <!--Condoçes para deletar a os-->
                            <form id="form_{{ $ordem_servico->id }}" method="post" action="{{route('ordem-servico.destroy', ['ordem_servico'=>$ordem_servico->id])}}">
                                @method('DELETE')
                                @csrf

                            </form>
                            <a class="btn btn-sm-template btn-outline-danger @can('user') disabled @endcan" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick=" DeletarOs()">
                                <i class="icofont-ui-delete"></i>
                                <script>
                                    function DeletarOs() {
                                        var x;
                                        var r = confirm("Deseja deletar a ordem de serviço?");
                                        if (r == true) {

                                            document.getElementById('form_{{$ordem_servico->id }}').submit()
                                        } else {
                                            x = "Você pressionou Cancelar!";
                                        }
                                        document.getElementById("demo").innerHTML = x;
                                    }
                                </script>
                            </a>
                            <!------------------------------>

                        </div>
                    <td>
                        <div class="col-md-2 mb-0">
                            <input type="checkbox" name="" id="">
                        </div>
                    </td>

                </tr>

            </tbody>


            @endforeach

        </table>
</main>
@endsection