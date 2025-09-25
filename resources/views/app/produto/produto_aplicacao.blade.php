@extends('app.layouts.app')

<main class="content">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                Onde o produto é aplicado esse componente
            </div>
            <div class="d-flex gap-2">
                <a class="btn btn-outline-dark btn-sm" href="{{ route('app.home') }}">
                    <i class="icofont-dashboard"></i> Dashboard
                </a>
                <a href="{{ route('produto.index') }}" class="btn btn-outline-primary btn-sm">
                    Produto
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark text-center">
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
                            <td class="text-center">{{ $produto_aplicacao_f->produto_id }}</td>
                            
                            @php
                                $produto = $produtos->firstWhere('id', $produto_aplicacao_f->produto_id);
                            @endphp
                            <td>
                                {{ $produto ? $produto->nome : 'Produto não encontrado' }}
                            </td>

                            @php
                                $equipamento = $equipamentos->firstWhere('id', $produto_aplicacao_f->equipamento);
                            @endphp
                            <td>
                                {{ $equipamento ? $equipamento->nome : 'Equipamento não encontrado' }}
                            </td>

                            <td class="text-center">{{ $produto_aplicacao_f->quantidade }}</td>
                            <td>{{ $produto_aplicacao_f->descricao }}</td>
                            <td class="text-center">{{ $produto_aplicacao_f->horas_proxima_manutencao }}</td>
                            <td class="text-center">{{ $produto_aplicacao_f->data_proxima_manutencao }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>
