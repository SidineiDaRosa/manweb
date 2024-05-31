



@extends('app.layouts.app')

@section('titulo', 'Produtos')

@section('content')

<main class="content">
    <div class="card">
   
        <div class="card-header">
            <p>Editar Produto</p>
        </div>
        <div class="card-footer justify-content-left">
            <a href="{{route('produto.index')}}" class="btn">
                LISTAGEM DE PRODUTOS
            </a>

            <a href="{{route('produto.create')}}" class="btn">
                NOVO PRODUTO
            </a>
        </div>
        <div class="card-header-template">
            <div class="col-md-2 mb-0">
                <label for="equipamento_id" class="col-md-2 col-form-label text-md-end">ID</label>
                <input id="equipamento_id" type="nuber" class="form-control-template" name="equipamento_id" value="@foreach($equipamento as $equipamento_f)
                    {{$equipamento_f['id']}}
                    @endforeach" readonly>
                {{ $errors->has('id') ? $errors->first('id') : '' }}

            </div>
            <div class="col-md-4 mb-0">
                <label for="equipamento" class="col-md-4 col-form-label text-md-end">Nome equipamento</label>
                <input id="equipamento" type="nuber" class="form-control-template" name="equipamento" value="@foreach($equipamento as $equipamento_f)
                    {{$equipamento_f['nome']}}
                    @endforeach" readonly>
                {{ $errors->has('nome') ? $errors->first('nome') : '' }}

            </div>
        </div>
        <div class="card-body">
            @component('app.produto._components.form_create_edit', ['produto'=>$produto, 'marcas'=>$marcas, 'unidades'=>$unidades, 'categorias'=>$categorias])
                    
                @endcomponent  
        </div>
    </div>

</main>

@endsection





