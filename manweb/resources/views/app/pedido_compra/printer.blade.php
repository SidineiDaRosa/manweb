<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    body {
        text-align: center;
    }

    h3,
    h2,
    h4 {
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        font-weight: 500;
        font-stretch: ultra-condensed;
    }
</style>

<body>
    <img src="{{asset('img/logo_fapolpa.jpeg')}}" alt="Imagem do Produto" class="preview-image-logo">
    <style>
        .preview-image-logo{
            width: 400px;
            height:200px;
            margin: 0 5px;
        }
    </style>
    <fieldset>
        @foreach ($pedidos_compra as $pedido_compra)
        <h4>Pedido de compra:  {{ $pedido_compra->id }}</h4>

        <div class="row">
            <div>
                <Fieldset class="filed-data">
                    <legend>Emissão:</legend>{{ \Carbon\Carbon::parse($pedido_compra->data_emissao)->format('d/m/Y') }} {{ $pedido_compra->hora_emissao }}
                </Fieldset>
            </div>
            <div>
                <fieldset class="filed-data">
                    <legend>Previsão de uso:</legend>{{ \Carbon\Carbon::parse($pedido_compra->data_prevista)->format('d/m/Y') }} {{ $pedido_compra->hora_prevista}}
                </fieldset>
            </div>
            <div>
                <fieldset class="filed-data-long">
                    <legend>Patrimônio/equipamento:</legend>{{ $pedido_compra->equipamento->nome}}
                </fieldset>
            </div>
            <div>
                <fieldset class="filed-data-long">
                    <legend>Emissor:</legend>{{ $pedido_compra->funcionarios->primeiro_nome}}
                </fieldset>
            </div>

        </div>
        <div class="row">
            <div>
                <fieldset class="filed-data">
                    <legend>Situação:</legend>{{ $pedido_compra->status}}
                </fieldset>
            </div>
            <div>
                <fieldset class="filed-data-long-text">
                    <legend>Descrição:</legend>{{ $pedido_compra->descricao}}
                </fieldset>
            </div>
        </div>
        @endforeach

    </fieldset>
    <style>
        .filed-data-long-text {
            width: 590px;

        }

        fieldset {
            display: flex;
            flex-direction: column;
            text-align: center;
            align-items: center;
            border-radius: 5px;
            max-width: 98%;
        }

        body {
            align-items: center;
            text-align: center;
        }

        .row {
            display: flex;
            flex-direction: row;

        }

        .filed-data {
            width: 190px;
            flex-direction: row;
            align-items: center;
        }

        .filed-data-long {
            width: 400px;
            flex-direction: row;
        }

        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
    @foreach ($unidadeMedida as $unidadeMedida_ls)
    @endforeach
    <table id="customers">
        <thead>

            <tr>
                <th scope="col" class="">cod fabricante</th>
                <th scope="col" class="">Descrição</th>
                <th scope="col" class="">unidade</th>
                <th scope="col" class="">Quantidade</th>
                <th scope="col" class="">Imagem</th>
            </tr>
        </thead>
        @foreach ($pedido_compra_lista as $pedido_compra_ls)
        <tbody>
            <tr>
                @php
                $produto = $produtos->firstWhere('id', $pedido_compra_ls->produto_id);
                $unidade = $unidadeMedida->firstWhere('id', $produto->unidade_medida_id);
                @endphp

            <tr>
                <td>{{ $produto->cod_fabricante}}</td>
                <td>{{ $produto->nome ?? 'Produto não encontrado' }}</td>
                <td>{{ $unidade ? $unidade->nome : 'Unidade não encontrada' }}</td>
                <td>{{ $pedido_compra_ls->quantidade }}</td>
                <td>
                    @if ($produto)
                    <img src="/img/produtos/{{ $produto->image }}" alt="Imagem do Produto" class="preview-image">
                    @endif
                    <style>
                        .preview-image {
                            width: 100px;
                            height: 100px;
                            object-fit: cover;
                            margin: 0 5px;
                            cursor: pointer;
                        }
                    </style>
                </td>
        </tbody>
        @endforeach
    </table>
    <p></p>

    <input type=" button" value="Imprimir" onclick="window.print()">

</body>