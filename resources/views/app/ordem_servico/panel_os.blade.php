<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel OS Grid</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* Grid principal */
        .grid-os {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            /* 4 colunas */
            gap: 15px;
        }

        /* Cada OS */
        .os-card {
            background: #fff;
            padding: 12px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            font-size: 14px;
        }

        .os-card h3 {
            margin-top: 0;
            color: #0d6efd;
            font-size: 16px;
        }

        .item {
            margin-bottom: 5px;
        }

        .label {
            font-weight: bold;
        }

        /* Responsivo: 2 colunas em telas médias, 1 coluna em celular */
        @media (max-width: 1200px) {
            .grid-os {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 700px) {
            .grid-os {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="grid-os">
        @foreach($ordem_servicos as $ordem_servico)
        <div class="os-card">
            <h3>{{ $ordem_servico->id }}-----{{ $ordem_servico->equipamento->nome }}</h3>

            <div class="item"><span class="label">Data Início:</span> {{ $ordem_servico->data_inicio }} - {{ $ordem_servico->hora_inicio }}</div>
            <div class="item"><span class="label">Data Fim:</span> {{ $ordem_servico->data_fim }} - {{ $ordem_servico->hora_fim }}</div>
            <div class="item"><span class="label">Descrição:</span> {{ $ordem_servico->descricao }}</div>
            <div class="item"><span class="label">Status:</span> {{ $ordem_servico->situacao ?? 'Não definido' }}</div>
            <div class="item"><span class="label">SS:</span> {{ $ordem_servico->ss_id }}</div>

            @if($ordem_servico->ss && $ordem_servico->ss->imagem)
            <div class="item" style="margin-top:10px;">
                <img src="{{ asset('img/request_os/' . $ordem_servico->ss->imagem) }}"
                    alt="Foto SS"
                    style="width:100%; max-height:200px; object-fit:cover; border-radius:4px;">
            </div>
            @endif

        </div>
        @endforeach
    </div>


</body>

</html>