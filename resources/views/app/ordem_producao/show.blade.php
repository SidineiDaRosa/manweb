@extends('app.layouts.app')

@section('content')
    <main class="content">
        <div class="card">
            <div class="card-header-template">
                <div>
                    Visualizar Ordem de Produção
                </div>
                <div>
                    <a class="btn btn-primary btn-sm mr-2" href="{{ route('ordem-producao.create') }}">NOVO</a>
                    <a class="btn btn-primary btn-sm" href="{{ route('ordem-producao.index') }}">LISTAGEM</a>
                </div>
            </div>

            <div class="card-body-template mt-1">
                <table class="table-template ">
                    <tr>
                        <th colspan="8" class="th-title-main text-center">INFORMAÇÕES SOBRE FUNCIONAMENTO -
                            {{ $ordem_producao->equipamento->nome }}</th>
                    </tr>
                    <tr>

                        <td class="text-right th-title pr-2" style="width: 6rem;">CÓDIGO</td>
                        <td class="pl-2" style="width: 6rem;">{{ $ordem_producao->id }}</td>
                        <td class="text-right th-title pr-2" style="width: 6rem;">Data</td>
                        <td class="pl-2" style="width: 6rem;">
                            {{ \Carbon\Carbon::parse($ordem_producao->data_inicio)->format('d/m/Y') }}</td>
                        <td class="th-title pr-2 text-right">Estado da Ordem</td>
                        <td class="pl-2">{{ $ordem_producao->status }}</td>
                    </tr>

                    <tr>
                        <td class="text-center th-title" colspan="2">HORÁRIO OPERAÇÃO</td>
                        <td class="text-center th-title" colspan="2">HORÍMETRO</td>
                        <td colspan="4" class="text-center th-title">PRODUÇÃO</td>
                    </tr>

                    <tr>
                        <td class="text-right pr-2 th-title">Início</td>
                        <td class="pl-2">{{ $ordem_producao->hora_inicio }}</td>
                        <td class="text-right pr-2 th-title" style="width: 6rem;">Início</td>
                        <td class="pl-2" style="width: 6rem;">{{ number_format($horimetro_inicial, 2) }}</td>
                        <td class="text-right th-title pr-2" style="width: 10rem;">PRODUTO</td>
                        <td class="pl-2">{{ $ordem_producao->produto->nome }}</td>
                        <td class="text-right th-title pr-2">QUANTIDADE</td>
                        <td class="pl-2">{{ number_format($ordem_producao->quantidade_producao, 0) }}
                            {{ $ordem_producao->produto->unidade_medida->nome }}</td>
                    </tr>

                    <tr>
                        <td class="text-right th-title pr-2">Término</td>
                        <td class="pl-2">{{ $ordem_producao->hora_fim }}</td>
                        <td class="text-right th-title pr-2">Término</td>
                        <td class="pl-2">{{ number_format($ordem_producao->horimetro_final, 2) }}</td>
                        <td class="text-right th-title pr-2">PRODUÇÃO POR HORA</td>
                        <td class="pl-2">{{ number_format($producao_por_hora) }}
                            {{ $ordem_producao->produto->unidade_medida->nome }} - POR HORA</td>
                        <td class="th-title"></td>
                        <td class="th-title"></td>

                    </tr>

                    <tr>
                        <td class="text-right th-title pr-2">Total</td>
                        <td class="pl-2">{{ $total_horas_equipamento }}</td>
                        <td class="text-right th-title pr-2">Total</td>
                        <td class="pl-2">{{ number_format($total_horimetro, 2) }}</td>
                        <td class="th-title" colspan="4"></td>

                    </tr>

                    <tr>
                        <td colspan="8" class="th-title-main text-center">REGISTRO DE PARADAS DE EQUIPAMENTOS</td>
                    </tr>

                    @if (isset($paradas) && $paradas->count() > 0)
                        <tr>
                            <td class="text-right th-title pr-2">Hora Inicial</td>
                            <td class="text-right th-title pr-2">Hora Final</td>
                            <td class="text-center th-title pr-2" colspan="6">Descrição das Ocorências</td>
                        </tr>

                        @foreach ($paradas as $parada)
                            <tr>
                                <td class="text-center">{{ $parada->hora_inicio }}</td>
                                <td class="text-center">{{ $parada->hora_fim }}</td>
                                <td colspan="6">{{ $parada->descricao }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center"> Não houve paradas de equipamentos</td>
                        </tr>
                    @endif

                    <tr>
                        <td colspan="8" class="th-title-main text-center">INFORMAÇÕES SOBRE OPERAÇÃO DOS EQUIPAMENTOS</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="th-title">Equipamento</td>
                        <td class="th-title">combustível</td>
                        <td class="th-title">quantidade</td>
                        <td class="th-title">Horímetro Inicial</td>
                        <td class="th-title">Horímetro Final</td>
                        <td class="th-title">Hora Inicial</td>
                        <td class="th-title">Hora Final</td>
                    </tr>
                    @foreach ($recursos_producao as $recurso)
                        <tr>
                            <td colspan="2">{{ $recurso->equipamento->nome }}</td>
                            <td>{{ $recurso->produto->nome }}</td>
                            <td>{{ $recurso->quantidade }}</td>
                            <td>{{ $recurso->horimetro_inicial }}</td>
                            <td>{{ $recurso->horimetro_final }}</td>
                            <td>{{ $recurso->hora_inicio }}</td>
                            <td>{{ $recurso->hora_fim }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="8" class="th-title-main text-center">CONDIÇÕES SOBRE ESTOQUE DOS MATERIAIS</td>
                    </tr>
                    <tr>
                        <td class="th-title">produto</td>
                        <td class="th-title">capacidade</td>
                        <td class="th-title">estoque anterior</td>
                        <td class="th-title">Recebimento de Material</td>
                        <td class="th-title">Nota Fiscal</td>
                        <td class="th-title">Fornecedor</td>
                        <td class="th-title">Consumo</td>
                        <td class="th-title">Estoque Final</td>
                    </tr>
                    @foreach ($recursos_produtos as $produto)
                        <tr>
                            <td class="th-title">{{$produto->produto->nome}}</td>
                            <td class="th-title">capacidade</td>
                            <td class="th-title">estoque anterior</td>
                            <td class="th-title">Recebimento de Material</td>
                            <td class="th-title">Nota Fiscal</td>
                            <td class="th-title">Fornecedor</td>
                            <td class="th-title">Consumo</td>
                            <td class="th-title">Estoque Final</td>
                        </tr>
                    @endforeach


                </table>
            </div>
        </div>

    </main>
@endsection
