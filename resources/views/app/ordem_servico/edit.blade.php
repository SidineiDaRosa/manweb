@extends('app.layouts.app')

@section('content')


<main class="content">
    
    <div class="card">
        <div class="card-header-template mb-1">
            <div>
                Editar ordem de serviço
            </div>
            <div>
                <a class="btn btn-primary btn-sm" href="{{ route('ordem-servico.index') }}">Voltar</a>
            </div>
        </div>
        <div class="card-body">
            @component('app.ordem_servico.componentes.form_edit',
            [
            'ordem_servico'=>$ordem_servico,
            'equipamentos'=>$equipamentos,
            'funcionarios'=>$funcionarios,
            'empresas'=>$empresas
            ])
            @endcomponent
        </div>
    </div>

</main>

@endsection