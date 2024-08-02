@extends('app.layouts.app')
<main class="content">
    <div class="card">
        <div class="card-header-template">
            <div>
                Onde o produto é aplicado
            </div>
            <a class="btn btn-outline-dark sm" href="{{ route('app.home') }}">
                <i class="icofont-dashboard"></i> dashboard
            </a>
            <a href="{{ route('produto.index') }}" class="btn btn-outline-primary btn-sm">
                    <span class="material-symbols-outlined">
                        format_list_bulleted
                    </span>
                </a>
        </div>
        <style>
            .table_produtos {
                height: 40px;
                border: solid 1px;

            }

            .table_produtos td {
                border: solid 1px;
                height:30px;
            }
        </style>
        <table class="table_produtos">
            <thead>
                <tr>
                    <th>ID do Produto</th>
                    <th>Nome do Produto</th>
                    <th>Nome do Equipamento</th>
                    <th>Quantidade</th>
                    <th>Descrição da Aplicação</th>
                    <th>Horas Próxima Manutenção</th>
                    <th>Data Próxima Manutenção</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produto_aplicacao as $produto_aplicacao_f)
                <tr>
                    <td>{{ $produto_aplicacao_f->produto_id }}</td>
                    @php
                    $produto = $produtos->firstWhere('id', $produto_aplicacao_f->produto_id);
                    @endphp

                    @if($produto)
                    <td>{{ $produto->nome }}</td>
                    @else
                    <td class="not-found">Produto não encontrado</td>
                    @endif

                    @php
                    $equipamento = $equipamentos->firstWhere('id', $produto_aplicacao_f->equipamento);
                    @endphp

                    @if($equipamento)
                    <td>{{ $equipamento->nome }}</td>
                    @else
                    <td class="not-found">Equipamento não encontrado</td>
                    @endif
                    <td>{{ $produto_aplicacao_f->quantidade }}</td>
                    <td>{{ $produto_aplicacao_f->descricao }}</td>
                    <td>{{ $produto_aplicacao_f->horas_proxima_manutencao }}</td>
                    <td>{{ $produto_aplicacao_f->data_proxima_manutencao }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>