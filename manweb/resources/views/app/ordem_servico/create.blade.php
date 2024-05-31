@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header-template mb-1">
            <div>
                Criar ordem de serviço apartir de um Patrimônio
            </div>
            <div>
                <a class="btn btn-primary btn-sm" href="{{route('ordem-servico.index')}}">Voltar</a>
            </div>
           
        </div>
        <div class="card-body">
            @component('app.ordem_servico.componentes.form_create', ['ordem_servico'=>$ordem_servico,
            'equipamentos'=>$equipamentos,'funcionarios'=>$funcionarios,
            'empresa'=>$empresa,
            'equipamento'=>$equipamento])
            @endcomponent
        </div>
    </div>
</main>

@endsection