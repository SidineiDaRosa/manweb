@extends('app.layouts.app')

@section('titulo', 'Empresa')

@section('content')

<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>Visualizar Empresa</div>
            <div>
                <a href="{{ route('empresas.index') }}" class="btn btn-primary btn-sm">
                    LISTAGEM
                </a>
            </div>
        </div>
        <div class="card-body">
            ID:
            {{ $empresa->id }}
            <p></p>
            <h4> Razão Social:
                {{ $empresa->razao_social }}
            </h4 >

            <p></p>
            Nome fantasia:
            {{ $empresa->nome_fantasia }}
            <p></p>
            CNPJ:
            {{ $empresa->cnpj }}
            <p></p>
            inscição estadual:
            {{ $empresa->insc_estadual }}
            <p></p>
            endereço:
            {{ $empresa->endereco}}
            <p></p>
            Bairro:
            {{ $empresa->bairro }}
            <p></p>
            Cidade:
            {{ $empresa->ciadeade }}
            <p></p>
            Estado:
            {{ $empresa->estado }}
            <p></p>
            Telefone:
            {{ $empresa->Telefone }}
            <p></p>
            E-mail:
            {{ $empresa->email }}


        </div>

    </div>


</main>

@endsection