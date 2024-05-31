<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/comum.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/template.css') }}">
    <script src="{{ asset('js/date_time.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
</head>

<main class="content" id="main1">
    <div class="card">
        <div class="card-header-template">
            <div> Item saida de produto</div>

        </div>
        <div class="card-body">
            <table class="table-template table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">equipamento</th>
                        <th scope="col">produto ID</th>
                        <th scope="col">produto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pecas_equipamento as $peca_equipamento)
                    <tr>
                        <td scope="row">{{ $peca_equipamento->id }}</td>
                        <td>{{ $peca_equipamento->equipamento}}</td>
                        <td>{{ $peca_equipamento->produto->id}}</td>
                        <td>{{ $peca_equipamento->produto->nome}}</td>
                        <td>

                            <a href="{{ route('Saida-produto.create',['produto' => $peca_equipamento->produto->id,'pedido'=>$pedido,'empresa'=>$empresa,
                                'peca_equipamento_id'=>$peca_equipamento->id
                                ]) }}" class="btn-sm btn-warning">
                                <i class="icofont-cart-alt"></i>
                                </span>
                                <span class="text">Saída estoque</span>
                            </a>
                        </td>
                    </tr>

                    @endforeach

                </tbody>
            </table>

        </div>


    </div>


</main>


</main>