@extends('app.layouts.app')

@section('content')
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>Cadastro de local de estoque</div>
            <div>
                <a href="{{ route('entrada-produto.index') }}" class="btn btn-sm btn-primary">
                    LISTAGEM
                </a>
            </div>
        </div>
   
        <div class="card-body">
            @component('app.estoque_produto._components.form_create_edit', [
            'produtos' => $produtos,
            'fornecedores'=>$fornecedores,'empresa'=>$empresa,'unidades' => $unidades
            ])
            @endcomponent
        </div>
    </div>

</main>
@endsection