<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de serviços</title>
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
    <h3>Relatório de serviços</h3>
    <fieldset>
        <h4>Sidinei da rosa</h4>
        <h4>cel:(46)999842664 pix:banco sicoob 
            95842896087 pix:banco caixa</h4>
        <h4>Rua Luiz lovo 464 - Loteamento esplanada- Palmas-PR</h4>
        <hr>
        @foreach($empresa as $empresas_f)
        @endforeach
        <h3>Nome fantasia:{{''.$empresas_f['nome_fantasia']}}</h3>
        <h3>Razão social:
            {{$empresas_f[''.'razao_social']}}
        </h3>
        <h3>CNPJ:
            {{$empresas_f[''.'cnpj']}} 
        </h3>

    </fieldset>
    <style>
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
    <table id="customers">
        <thead>

            <tr>
                <th scope="col" class="">ID O.S</th>
                <th scope="col" class="">Data</th>
                <th scope="col" class="">Hora</th>
                <th scope="col" class="">Descrição</th>
                <th scope="col" class="">Executado</th>
            </tr>
        </thead>
        @foreach($ordens_servicos as $ordens_servicos_f)
        <tbody>
            <tr>
                <td>{{$ordens_servicos_f['id']}}</td>
                <td>{{ date( 'd/m/Y' , strtotime($ordens_servicos_f['data_inicio']))}}</td>
                <td>{{$ordens_servicos_f['hora_inicio']}}</td>
                <td>{{$ordens_servicos_f['descricao']}}</td>
                <td>{{$ordens_servicos_f['Executado']}}</td>
        </tbody>
        @endforeach
    </table>
    <p></p>

    <input type=" button" value="Imprimir" onclick="window.print()">

</body>
</html>