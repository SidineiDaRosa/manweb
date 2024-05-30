@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>Cadastro de Equipamentos</div>
            <div>
                <a class="btn btn-sm btn-primary" href="{{route('equipamento.index')}}" class="btn">
                    LISTAGEM
                </a>
            </div>
        </div>
        
        <div class="card-body">
            @component('app.equipamento._components.form_create_edit', ['marcas'=>$marcas,
             'equipamentos'=>$equipamentos,
             'empresas'=>$empresas ])       
            @endcomponent
        </div>
    </div>

</main>


@endsection
