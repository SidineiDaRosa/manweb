@extends('app.layouts.app')
<main class="content">
    <div class="div-title-main">O.S. FECHADAS POR EQUIPAMENTO</div>
    <div class="container">
        <style>
            .div-title-main {
                font-family: sans-serif;
                font-weight: 500;
                font-size: 30px;
                text-transform: uppercase;
                color: darkgray;
                text-align: center;
                /* Centraliza o texto dentro da div */
                display: flex;
                justify-content: center;
                /* Centraliza a div no container pai */
                align-items: center;
                /* Alinha verticalmente se necessário */
                margin: 0 auto;
                /* Garante que a margem esquerda e direita sejam iguais */
            }

            .div-title-subtitle {
                font-family: sans-serif;
                font-weight: 500;
                font-size: 25px;
                text-transform: uppercase;
            }

            .div-title-subtitle {
                font-family: sans-serif;
                font-weight: 500;
                font-size: 25px;
                text-transform: uppercase;
            }

            .div-title-subtitle-md {
                font-family: sans-serif;
                font-weight: 500;
                font-size: 20px;
                text-transform: uppercase;
            }

            .div-conteudo-md {
                font-family: sans-serif;
                font-weight: 300;
                font-size: 18px;
            }
        </style>

        <div class="div-title-subtitle">{{$equipamento->nome}}</div>
        @foreach($equipamento_filho as $equipamento_filho_f)
        <h4 hidden>{{$equipamento_filho_f->nome}}</h4>
        @endforeach
        <div style="font-size: 20px; margin: 10px;">
            @foreach($usuarios as $usuario_f)
            @endforeach
            @foreach($ordens_servicos as $ordens_servico)
            <div style=" border: 1px solid darkgrey;border-radius:5px;padding:10px;">
                <div>ID: {{$ordens_servico->id}}</div>
                <div>Data Fim: {{ \Carbon\Carbon::parse($ordens_servico->data_fim)->format('d/m/Y') }} às {{$ordens_servico->hora_fim}}</div>
                <div style="color:darkblue;font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
                    Descrição da solicitação:</div>
                <div class="div-conteudo-md">
                    {{$ordens_servico->descricao}}
                    <div style="color:darkblue;font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
                        Descrição dos serviços executados:
                    </div>
                    @php
                    // Filtra serviços executados com base no 'ordem_servico_id'
                    $servicosFiltrados = $servicos_executados_colecao->where('ordem_servico_id', $ordens_servico->id);
                    @endphp
                    @foreach($servicosFiltrados as $servico_executado)
                    {{$servico_executado->descricao}} <br>
                    @foreach($usuarios as $usuario)
                    @if($servico_executado->funcionario_id == $usuario->id)
                    <div style="color:darkblue;font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;" hidden>
                    {{ $usuario->name}}
                    </div>
                    @endif
                    @endforeach
                    @endforeach
                    <hr>

                </div>
                <div style="color: green;">EMISSOR: {{$ordens_servico->responsavel}}</div>
            </div>
            <hr>

            @endforeach
        </div>
    </div>
</main>