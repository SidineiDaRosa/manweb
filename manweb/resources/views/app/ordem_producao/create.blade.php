@extends('app.layouts.app')

@section('content')

    <main class="content">
        <div class="card">
            <div class="card-header-template mb-1">
                <div>
                    CADASTRAR ORDEM DE PRODUÇÃO
                </div>
                <div>
                    <a class="btn btn-primary btn-sm" href="{{ route('ordem-producao.index') }}">LISTAGEM</a>
                    <a class="btn btn-primary btn-sm" href="{{ route('ordem-producao.index') }}">CADASTRO DE PARADAS</a>
                </div>
            </div>
            @isset($recursos_producao)
                @component('app.ordem_producao._components.form_create_recursos', 
                    [
                    'ordem_producao' => $ordem_producao,
                    'equipamentos' => $equipamentos,
                    'produtos' => $produtos,
                    'recursos_producao' => $recursos_producao,
                    'paradas_equipamento'=>$paradas_equipamento
                    ])
                @endcomponent
            @else
                @isset($ordem_producao)
                    @component('app.ordem_producao._components.form_create_recursos', ['ordem_producao' => $ordem_producao,
                        'equipamentos' => $equipamentos, 'produtos' => $produtos])
                    @endcomponent
                @else
                    @component('app.ordem_producao._components.form_create_edit', ['equipamentos' => $equipamentos, 'produtos' =>
                        $produtos])
                    @endcomponent
                @endisset
            @endisset
        </div>

    </main>

@endsection
