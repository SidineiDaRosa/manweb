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

    <main class="content">
        <div class="card">
            <div class="card-header-template">
                <div>Saída de Produtos</div>
                <div>
                    <a href="{{ route('Saida-produto.index') }}" class="btn btn-sm btn-primary">
                        LISTAGEM
                    </a>
                </div>
            </div>
            <div class="card-body">
                @component('app.saida_produto._components.form_create_edit', [
                    'produtos' => $produtos,
                    'estoque' => $estoque,
                    'pedido' => $pedido,
                    'equipamento_id' => $equipamento_id,
                    'pedido_saida_produtos'=>$pedido_saida_produtos,
                    'estoque_produtos'=>$estoque_produtos,
                    'peca_equipamento_id'=>$peca_equipamento_id,'peca_equipamento'=>$peca_equipamento
                    ])
                @endcomponent
            </div>
        </div>

    </main>

