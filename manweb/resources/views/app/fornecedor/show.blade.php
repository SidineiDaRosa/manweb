@extends('app.layouts.app')

@section('titulo', 'Fornecedor')

@section('content')

    <main class="content">
        <div class="card">
            <div class="card-header-template">
                <div>Visualizar Fornecedor</div>

                <div>
                    <a href="{{ route('fornecedor.index') }}" class="btn btn-primary btn-sm">
                        LISTAGEM
                    </a>
                  
                </div>

            </div>

            <div class="card-body">
                <table class="table-template table-hover">
                    <tr>
                        <th class="th-title">ID</td>
                        <td>{{ $fornecedor->id }}</td>
                    </tr>
                    <tr>
                        <th class="th-title">Razão Social</td>
                        <td>{{ $fornecedor->razao_social }}</td>
                    </tr>
                    <tr>
                        <th class="th-title">Nome Fantasia</td>
                        <td>{{ $fornecedor->nome_fantasia }}</td>
                    </tr>
                    <tr>
                        <th class="th-title">CNPJ</td>
                        <td>{{ $fornecedor->cnpj }}</td>
                    </tr>
                    <tr>
                        <th class="th-title">Insc. Estadual</td>
                        <td>{{ $fornecedor->insc_estadual }}</td>
                    </tr>
                    <tr>
                        <th class="th-title">Endereço</td>
                        <td>{{ $fornecedor->endereco }}</td>
                    </tr>
                    <tr>
                        <th class="th-title">Bairro</td>
                        <td>{{ $fornecedor->bairro }}</td>
                    </tr>
                    <tr>
                        <th class="th-title">Cidade</td>
                        <td>{{ $fornecedor->cidade }}</td>
                    </tr>
                    <tr>
                        <th class="th-title">uf</td>
                        <td>{{ $fornecedor->estado }}</td>
                    </tr>
                    <tr>
                        <th class="th-title">Telefone</td>
                        <td>{{ $fornecedor->telefone }}</td>
                    </tr>
                    <tr>
                        <th class="th-title">Contato</td>
                        <td>{{ $fornecedor->contato }}</td>
                    </tr>
                    <tr>
                        <th class="th-title">E-mail</td>
                        <td>{{ $fornecedor->email }}</td>
                    </tr>
                    <tr>
                        <th class="th-title">Site</td>
                        <td>{{ $fornecedor->site }}</td>
                    </tr>

                </table>
            </div>

        </div>


    </main>

@endsection
