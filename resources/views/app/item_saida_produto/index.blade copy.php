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

            <form id="formSearchingProducts" action="{{'Item-Saida-Produto'}}" method="POST">
                @csrf
                <!--------------------------------------------------------------------------------------->
                <!---------Select empresa------------->
                <!--------------------------------------------------------------------------------------->

                <input type="text" name="pedido" value="{{$pedido}}" readonly id="#input1"> <input type="text" name="empresa_id" value="{{$empresa_id}}" readonly id="#input1">
                <input type="text" name="equipamento_id" value="{{$equipamento_id}}" readonly id="#input1">
                <div class="col-md-4 mb-0">
                    <select class="form-control" name="tipofiltro" id="tipofiltro" value="" placeholder="Selecione o tipo de filtro">
                        <option value="1">Busca pelo Id</option>
                        <option value="2">Pela empresa</option>


                    </select>
                </div>
                <!---estilização do input box buscar produtos---->
                <style>
                    body {
                        width: 100%;
                    }

                    #input1 {
                        width: 50px;

                    }

                    #formSearchingProducts {
                        background-color: white;
                        width: 100%;
                        height: 44px;
                        border-radius: 5px;
                        display: flex;
                        flex-direction: row;
                        align-items: center;
                    }

                    input {
                        all: unset;
                        font: 16px system-ui;
                        color: blue;
                        height: 100%;
                        width: 100%;
                        padding: 6px 10px;
                    }

                    ::placeholder {
                        color: blueviolet;
                        opacity: 0.9;
                    }


                    button {
                        all: unset;
                        cursor: pointer;
                        width: 44px;
                        height: 44px;
                    }
                </style>
                <!-------------------------------------------------------------------------->
                <!--input box filtro buscar produto--------->

                <input type="text" id="query" name="produto" placeholder="Buscar produto..." aria-label="Search through site content">
                <button type="submit">
                    <i class="icofont-search"></i>
                </button>

            </form>

        </div>
        <div class="card-body">
            <table class="table-template table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col" class="th-title">Id</th>
                        <th scope="col" class="th-title">Produto id</th>
                        <th scope="col" class="th-title">Produto</th>
                        <th scope="col" class="th-title">Unid</th>
                        <th scope="col" class="th-title">Quantidade</th>
                        <th scope="col" class="th-title">Valor</th>
                        <th scope="col" class="th-title">estoque minimo</th>
                        <th scope="col" class="th-title">estoque máximo</th>
                        <th scope="col" class="th-title">Local</th>
                        <th scope="col" class="th-title">empresa</th>
                        <th scope="col" class="th-title">operaçoes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estoque_produtos as $estoque_produto)
                    <tr>
                        <th scope="row">{{ $estoque_produto->id }}</td>
                        <td>{{ $estoque_produto->produto->id}}</td>
                        <td>{{ $estoque_produto->produto->nome }}</td>
                        <td>{{ $estoque_produto->unidade_medida }}</td>
                        <td>{{ $estoque_produto->quantidade }}</td>
                        <td>{{ $estoque_produto->valor }}</td>
                        <td>{{ $estoque_produto->estoque_minimo }}</td>
                        <td>{{ $estoque_produto->estoque_maximo}}</td>
                        <td>{{ $estoque_produto->local}}</td>
                        <td>{{ $estoque_produto->empresa->nome_fantasia}}</td>

                        <td>
                            @foreach($produtos as $produto)
                            @endforeach

                            <a href="{{ route('Saida-produto.create',['produto' => $produto->id,'estoque_id'=>$estoque_produto->id,'pedido'=>$pedido,
                                ]) }}" class="btn-sm btn-warning">
                                <i class="icofont-cart-alt"></i>
                                </span>
                                <span class="text">Saída estoque</span>
                            </a>
                        <td>
                        </td>
                        </td>
                    </tr>

                    @endforeach

                </tbody>
            </table>

        </div>


    </div>


</main>