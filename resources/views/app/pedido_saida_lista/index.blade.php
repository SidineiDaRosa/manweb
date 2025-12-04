@extends('app.layouts.app')
@section('content')
<script src="{{ asset('js/update_datatime.js') }}" defer></script>
<script src="{{ asset('js/timeline_google.js') }}" defer></script>
<main class="content">

    <div class="titulo-main">
        Solicitação de Saída de Produto Vinculada à O.S.
    </div>
    <style>
        .titulo-main {
            font-size: 15px;
            color:dimgrey;
            text-align: center;
            margin-top: -2;
        }
    </style>
    <style>
        .card-header {
            background-color: rgb(211, 211, 211);
            opacity: 0.95;
        }
    </style>
    <script>
        function Funcao() {
            alert('teste');
            document.getElementById("t1").value = "{{$funcionarios}}"
        }
    </script>
    @foreach ($pedidos_saida as $pedido_saida_f)
    @endforeach


    {{----------------------------------------------------------------------}}
    {{--Continer box--}}
    <style>
        .container-box {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: flex-start;
            background-color: white;
            margin: -1;
            margin-bottom: -50px;

        }

        .item {
            width: calc(33% - 20px);
            height: auto;
            margin: 10px;
            padding: 15px;
            background-color: white;
            overflow: auto;
            /* Impede que o conteúdo transborde */
            font-weight: 500;
        }

        .box {
            display: flex;
            width: 100%;
            height: auto;
            margin-bottom: 1px;
            background-color: #ccc;
            border-radius: 5px;
            padding: 5px;


        }

        @media (max-width: 900px) {
            .item {
                width: 100%;
                margin: 0px -80;
            }
        }

        hr {
            margin: 0px;
        }

        .box-conteudo {
            margin-left: 50px;
            justify-content: flex-start;
        }

        .titulo {
            display: flex;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;

        }

        .conteudo {
            display: flex;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
            color: #9ea39eff;
            margin-bottom: 5px;
        }

        #patrimonio {
            color: #2174d4;
        }

        .input-bordernone {
            border: none;
            color: #007b00;
        }
    </style>
    <div class="container-box">
        {{--Box 1--}}
        <div class="item">
            <div class="box-conteudo">
                <div class="titulo">Emissão</div>
                <hr>
                <div class="conteudo">
                    <input type="date" class="input-bordernone" name="data_inicio" id="data_inicio" value="{{$pedido_saida_f->data_emissao ?? old('data_emissao') }}" readonly>
                    <input type="time" class="input-bordernone" name="hora_inicio" id="hora_inicio" value="{{$pedido_saida_f->hora_emissao ?? old('hora_emissao') }}" required autocomplete="hora_emissao" autofocus readonly>
                </div>
                <div class="titulo">Previsão para a utilização</div>
                <hr>
                <div class="conteudo">
                    <input type="date" class="input-bordernone" name="data_fim" id="dataFim" value="{{$pedido_saida_f->data_prevista ?? old('data_prevista') }}" required autocomplete="data_prevista" autofocus readonly>
                    <input type="time" class="input-bordernone" name="hora_fim" id="horaFim" value="{{$pedido_saida_f->hora_prevista ?? old('hora_prevista') }}" required autocomplete="hora_prevista" autofocus readonly>
                </div>
                <div class="titulo">Status</div>
                <hr>
                <div class="conteudo">
                    <input type="text" class="input-bordernone" name="status" id="status" value="{{$pedido_saida_f->status ?? old('status') }}" required autocomplete="status" autofocus readonly>
                </div>
            </div>
        </div>
        {{--Box 2--}}
        <div class="item">
            <div class="box-conteudo">
                <div class="titulo">ID Pedido</div>
                <hr>
                <div class="conteudo">
                    <input type="number" class="input-bordernone" name="id" id="data_inicio" value="{{$pedido_saida_f->id ?? old('id') }}" required autocomplete="id" autofocus readonly>
                </div>
                <div class="titulo">Emissor</div>
                <hr>
                <div class="conteudo">
                    <input type="text" class="input-bordernone" name="emissor" id="emissor" value="{{$pedido_saida_f->funcionarios->primeiro_nome}}" required autocomplete="funcionarios_id " autofocus readonly>
                </div>
                <div class="titulo">Descrição</div>
                <hr>
                <div class="conteudo">
                    <input type="text" class="input-bordernone" name="descricao" id="descricao" value="{{$pedido_saida_f->descricao}}" required autocomplete="funcionarios_id " autofocus readonly>
                </div>
            </div>
        </div>
        {{--Box 3--}}
        <div class="item">
            <div class="box-conteudo">
                <div class="titulo">OS</div>
                <hr>
                <div class="conteudo">
                    <input type="text" class="input-bordernone" name="ordem_servico_id" id="ordem_servico_id" placeholder="ordem_serviço_id" value="{{$pedido_saida_f->ordem_servico_id}}" readonly>
                    <a class="btn btn-sm-template btn-outline-primary" href="{{route('ordem-servico.show', ['ordem_servico'=>$pedido_saida_f->ordem_servico_id])}}">
                        O.S.
                    </a>
                </div>
                <div class="titulo">Pedidos</div>
                <hr>
                <div class="conteudo">
                    <a href="{{route('pedido-saida.index')}}" class="btn btn-outline-dark btn-sm">
                        <i class="icofont-list"></i>
                        Lista de pedidos
                    </a>
                </div>
                <div class="titulo">Equipamento/Patrimônio</div>
                <hr>
                <div class="conteudo">
                    <input type="text" class="input-bordernone" name="equipamento" id="equipamento" value="{{$pedido_saida_f->equipamento->nome ?? old('hora_prevista') }}" required autocomplete="funcionarios_id " autofocus readonly>
                </div>

            </div>
        </div>
    </div>
    {{--fim card--}}
    {{--------------fim continer box----------------------------------------}}

    <!--  Tabela de produtos adicionados ao pedido-->

    <div class="card-body" style="border:solid #007b00 1px;margin-top:40px;">
        <h6 style="font-family: Arial, Helvetica, sans-serif;font-weight:700;">Produtos adicionados ao pedido</h6>
        <table class="table" style="">
            <thead style="background-color: #ccc;font-weight:300;font-family:Arial;">
                <tr>
                    <th>Id</th>
                    <th>Cod fabricante</th>
                    <th>Produto_ID</th>
                    <th>Descrição</th>
                    <th>Unidade</th>
                    <th>Quantidade</th>
                    <th>Valor Unit</th>
                    <th>Subtotal</th>
                    <th>Data</th>
                    <th>Patrmônio</th>
                    <th>Operações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($saidas_produto as $saida_produto)
                <tr>
                    <th scope="row">{{$saida_produto->id }}</td>
                    <td>{{ $saida_produto->produto->cod_fabricante}}</td>
                    <td>{{ $saida_produto->produto->id}}
                        <a class="btn btn-sm-template btn-outline-primary" href="{{ route('produto.show', ['produto' => $saida_produto->produto->id]) }}">
                            <i class="icofont-eye-alt"></i>
                        </a>
                    </td>
                    <td>{{ $saida_produto->produto->nome}}</td>
                    <td>{{ $saida_produto->unidade_medida}}</td>
                    <td>{{ $saida_produto->quantidade}}</td>
                    <td>{{ $saida_produto->valor}}</td>
                    <td>{{ $saida_produto->subtotal}}</td>
                    <td>{{ $saida_produto->data }}</td>
                    <td>{{ $saida_produto->equipamento->nome}}</td>
                    <td>
                        <!-- Botão de exclusão -->
                        <form id="delete-form-{{ $saida_produto->id }}" action="{{ route('saida-produto.destroy', $saida_produto->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="pedidos_saida_id" value="{{ $saida_produto->pedidos_saida_id }}">
                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $saida_produto->id }})">Deletar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!--Fim da tabela de produtos adicionados ao pedido-->

        <!--Inicio de exlcusão do item e extrono para o estoque-->

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(id) {
                Swal.fire({
                    title: 'Deseja excluir este item do pedido? Neste caso o item será extornado para o estoque novamente.',
                    text: "Você não poderá reverter isso!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submete o formulário
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }
        </script>
    </div>
    <hr>
    @if($pedido_saida_f->status != 'fechado')
    <hr>
    {{-- Formulário com os dados para adicionar o item --}}
    <h6 style="font-family: Arial, Helvetica, sans-serif;font-weight:700;">Adicionar Produto ao pedido</h6>
    <form id="form_add_item" action="{{ route('saida-produto-add-item.store') }}" method="POST" style="margin-left:20px;">
        @csrf
        <div class="form-row">
            <input type="number" name="componente_id" id="componente_id" value="" readonly hidden>
            <input type="number" name="pedido_id" id="pedido_id" value="{{$pedido_saida_f->id ?? old('id') }}" readonly hidden>
            <input type="text" class="form-control" style="width:200px;" readonly name="produto_id" id="produto_id">
            <input type="text" class="form-control" style="width:50%;" readonly name="produto_nome" id="produto_nome">
            <input type="number" id="quantidade" name="quantidade" class="form-control" style="width:200px;" readonly>
            <!-- Botão de envio inicialmente oculto -->
            <button id="btnEnviar" class="btn btn-outline-primary" style="display: none;" onclick="">Adicionar</button>
        </div>
    </form>
    <hr>
    {{------------------------------------------------}}
    {{--Tabela de peças dos equipamento---------------}}
    {{------------------------------------------------}}


    <span style="margin-left:20px;">
        <h6 style="font-family: Arial, Helvetica, sans-serif;font-weight:700;">Componentes do equipamento com periodicidade programada</h5>
            <input type="button" id="Btn-togglePecas" class="btn btn-warning btn-sm" value="Exibir peças do equipamento" onclick="togglePecas()">
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById('tblPecas').style.display = 'none';
                });

                function togglePecas() {
                    let tabela = document.getElementById('tblPecas');
                    if (tabela.style.display === 'none' || tabela.style.display === '') {
                        tabela.style.display = 'block';
                        document.getElementById('Btn-togglePecas').value = 'Ocultar peças do equipamento'
                    } else {
                        tabela.style.display = 'none';
                        document.getElementById('Btn-togglePecas').value = 'Exibir peças do equipamento'
                    }
                }
            </script>
    </span>

    <table class="table" id="tblPecas" style="margin-left:1px; border:solid 1px blue; margin-top:10px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Equipamento</th>
                <th>Descrição</th>
                <th>Produto_id</th>
                <th>Produto </th>
                <th>Quantidade</th>
                <th>intervalo</th>
                <th>data ultima substituação</th>
                <th>data proxima</th>
                <th>Horas restante</th>
                <th>Criticidade</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($pecas_equipamento as $peca_equipamento)
            <tr title="De um duplo Click para adicionar o ítem a lista.">

                <td>{{$peca_equipamento->id}}</td>
                @foreach ($patrimonio as $equipamento)
                @if ($equipamento['id'] == $peca_equipamento->equipamento)
                <td>
                    <a class="txt-link" href="{{ route('equipamento.show', ['equipamento' => $equipamento->id]) }}">{{ $equipamento['nome'] }}</a>
                </td> <!-- Exibindo o nome do equipamento -->
                <style>
                </style>
                @endif
                @endforeach
                <td>{{ $peca_equipamento->descricao}}</td>
                <td>
                    {{ $peca_equipamento->produto->id}}
                </td>
                <td>
                    <a class="txt-link" href="{{ route('produto.show', ['produto' =>$peca_equipamento->produto->id]) }}">
                        {{ $peca_equipamento->produto->nome}}
                    </a>
                </td>
                <td>{{ $peca_equipamento->quantidade}}</td>
                <td>{{ $peca_equipamento->intervalo_manutencao}}hs</td>
                <td>{{ date( 'd/m/Y' , strtotime($peca_equipamento['data_substituicao']))}}-{{ $peca_equipamento->hora_substituicao}}</td>
                <td>{{ date( 'd/m/Y' , strtotime($peca_equipamento['data_proxima_manutencao']))}}</td>
                <td class="
    @if($peca_equipamento->horas_proxima_manutencao >= 48)
        bg-success
    @elseif($peca_equipamento->horas_proxima_manutencao < 48 && $peca_equipamento->horas_proxima_manutencao > 0)
        bg-warning
    @else
        bg-danger
    @endif
">
                    {{ $peca_equipamento->horas_proxima_manutencao }}
                </td>
                <td>{{ $peca_equipamento->criticidade}}</td>
                </div>
                @endforeach
        </tbody>
    </table>

    <style>
        tr:hover {
            background-color: rgba(255, 165, 0, 0.2);
            /* ou #FFDAB9 */
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Seleciona todas as linhas da tabela, exceto o cabeçalho
            var rows = document.querySelectorAll("#tblPecas tbody tr");

            rows.forEach(function(row) {
                row.addEventListener("dblclick", function() {
                    // Captura o ID e nome do produto das colunas corretas
                    let componenteId = this.querySelector('td:nth-child(1)').innerText; // Ajuste o índice conforme a coluna correta
                    let produtoId = this.querySelector('td:nth-child(5)').innerText; // Ajuste o índice conforme a coluna correta
                    let produtoNome = this.querySelector('td:nth-child(6)').innerText; // Ajuste o índice conforme a coluna correta

                    // Exibe a mensagem de confirmação
                    let confirmacao = confirm("Deseja adicionar o produto " + produtoNome + " ao seu pedido?");

                    if (confirmacao) {
                        // Lógica para adicionar o produto ao pedido
                        alert("Produto " + produtoNome + " foi adicionado ao seu pedido!");
                        // Define os valores nos campos ocultos do formulário
                        document.getElementById('componente_id').value = componenteId;
                        document.getElementById('produto_id').value = produtoId;
                        document.getElementById('produto_nome').value = produtoNome;
                        // Habilita o campo 'quantidade' e aplica o foco
                        let quantidadeField = document.getElementById('quantidade');
                        let btnEnviar = document.getElementById('btnEnviar');
                        document.getElementById('produto_nome').style.background = '#a0d8a0';
                        document.getElementById('produto_id').style.background = '#a0d8a0';
                        quantidadeField.removeAttribute('readonly'); // Remove o atributo readonly
                        quantidadeField.focus(); // Aplica o foco no campo

                        // Mostra o botão de envio
                        btnEnviar.style.display = 'block';
                    } else {
                        alert("Produto não foi adicionado.");
                    }
                });
            });

            // Evento para o botão de envio
            document.getElementById('btnEnviar').addEventListener('click', function() {
                let quantidade = document.getElementById('quantidade').value;
                let produtoNome = document.getElementById('produto_nome').value;
                let produtoId = document.getElementById('produto_id').value;


                if (quantidade) {
                    // Exemplo de lógica para enviar os dados
                    alert("Enviando produto " + produtoNome + " (ID: " + produtoId + ") com quantidade: " + quantidade);

                    // Aqui você pode adicionar código para enviar os dados para o servidor ou processar conforme necessário
                    // Por exemplo, você pode usar AJAX para enviar os dados:
                    /*
                    fetch('/url-do-servidor', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            produto_id: produtoId,
                            quantidade: quantidade
                        }),
                    }).then(response => response.json())
                      .then(data => {
                          console.log('Success:', data);
                      })
                      .catch((error) => {
                          console.error('Error:', error);
                      });
                    */
                } else {
                    alert("Por favor, insira uma quantidade.");
                }
            });
        });
    </script>
    {{--//----------------------------------------------------//--}}
    {{-- Busca produtos que não estão na lista                ----}}
    {{--//----------------------------------------------------//--}}
    <hr>
    <h6 style="font-family: Arial, Helvetica, sans-serif;font-weight:700;">Buscar no estoque de produtos</h6>
    <div class="card-header-template" style="width:100%;display:flex;flex-direction:row;justify-content:center;">
        <form id="formSearchingProducts" action="{{ route('pedido-saida-searching-products') }}" method="POST" style="width:100%;display:flex;flex-direction:row;justify-content:center;">
            @csrf
            <input type=" text" name="pedido_saida_id" value="{{$pedido_saida_f->id}}" hidden></input>
            <div class="col-md-4 mb-0">
                <select class="form-control" name="tipofiltro" id="tipofiltro">
                    <option value="2">Busca Pelas iniciais</option>
                    <option value="1">Busca pelo ID</option>
                    <option value="3">Busca pelo Código do Fabricante</option>
                    <option value="4">Busca por categoria</option>
                </select>
            </div>

            <div class="col-md-4" id="categoriaDiv" style="display: none;">
                <select name="categoria_id" class="form-control">
                    <option value=""> --Selecione a Categoria--</option>
                    @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ ($produto->categoria_id ?? old('categoria_id')) == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nome }}
                    </option>
                    @endforeach
                </select>
                {{ $errors->has('categoria_id') ? $errors->first('categoria_id') : '' }}
            </div>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $('#tipofiltro').change(function() {
                    if ($(this).val() == '4') { // categoria
                        $('#categoriaDiv').show();
                        $('#categoriaDiv select').focus(); // foco no select
                        $('#query').hide(); // esconde o input de texto
                    } else {
                        $('#categoriaDiv').hide();
                        $('#query').show(); // mostra o input de texto
                        $('#query').focus(); // foco no input de texto
                    }
                });

                // Opcional: dispara o change ao carregar a página para ajustar a visibilidade inicial
                $(document).ready(function() {
                    $('#tipofiltro').trigger('change');
                });
            </script>

            <!--input box filtro buscar produto--------->
            <input class="form-control" type="text" id="query" name="query_like_producto_name" placeholder="Buscar produto..." aria-label="Search through site content">
            <button type="submit" class="btn btn-outline-primary">
                <i class="icofont-search"></i> Buscar
            </button>
        </form>
    </div>

    <hr>
    <div class="card-body">
        <table class="table" id="tblProdutos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>cod.Fab.</th>
                    <th>Nome</th>
                    <th>un medida</th>
                    <th>Fabricante</th>
                    <th>Ver peça</th>
                    <th>Imagem</th>
                    <th>Categoria</th>
                    <th>Ações</th>

                </tr>
            </thead>

            <tbody title="De um duplo Clique para adicionar um produto 📦">

                @foreach ($produtos as $produto)
                <tr>
                    <th>{{ $produto->id }}</td>
                    <td>{{ $produto->cod_fabricante }}</td>
                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->unidade_medida->nome}}</td>
                    <td>{{ $produto->marca->nome}}</td>
                    <td><a href="{{ $produto->link_peca}}" target="blank">Ver no site do fabricante
                            <i class="icofont-arrow-right"></i>
                        </a></td>
                    <td>
                        <img src="/img/produtos/{{ $produto->image}}" alt="imagem" class="preview-image">
                    </td>
                    <style>
                        .preview-image {
                            width: 100px;
                            height: 100px;
                            object-fit: cover;
                            margin: 0 5px;
                            cursor: pointer;
                        }
                    </style>
                    <td>{{ $produto->categoria->nome}}</td>
                    <td>
                        <div {{-- class="div-op" --}} class="btn-group btn-group-actions visible-on-hover">

                            <script>
                                // JavaScript para manipular o clique na linha e preencher os inputs
                                document.querySelectorAll('#tblProdutos tbody tr').forEach(row => { // Seleciona apenas as linhas do corpo da tabela
                                    row.addEventListener('dblclick', function() {
                                        // Obtendo o valor dos dados da linha
                                        let produto_id = this.cells[0].textContent;
                                        const produtoNome = this.cells[2].textContent;

                                        // Verifica se os valores estão preenchidos
                                        if (!produto_id || !produtoNome) {
                                            alert("Os dados do produto estão incompletos.");
                                            return;
                                        }
                                        // Preenchendo os inputs com os valores obtidos
                                        document.getElementById('produto_id').value = produto_id;
                                        document.getElementById('produto_nome').value = produtoNome;
                                        document.getElementById('componente_id').value = 0;
                                        document.getElementById('produto_nome').style.background = '#a0d8a0';
                                        document.getElementById('produto_id').style.background = '#a0d8a0';

                                        // Habilita o campo 'quantidade' e aplica o foco
                                        let quantidadeField = document.getElementById('quantidade');
                                        let btnEnviar = document.getElementById('btnEnviar');
                                        quantidadeField.removeAttribute('readonly'); // Remove o atributo readonly
                                        quantidadeField.focus(); // Aplica o foco no campo

                                        // Mostra o botão de envio
                                        btnEnviar.style.display = 'block';
                                    });
                                });
                            </script>

                            <button class=" btn btn-sm-template btn-outline-primary" id="select-btn" hidden>Selecionar</button>

                            <a class=" btn btn-sm-template btn-outline-primary" href="{{ route('produto.show', ['produto' => $produto->id]) }}">
                                <i class="icofont-eye-alt"></i>
                            </a>
                        </div>
                    </td>
                    <td>
                        @if(isset($num_pedido) && $num_pedido >= 1)
                        <a href="{{ route('pedido-compra-lista.index', ['produto_id' => $produto->id,'numpedidocompra'=>$num_pedido]) }}">Adicionar ao pedido:{{ $num_pedido }}</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{--Fim do if de estiver fechado--}}
    @endif
    @endsection
    <footer>
    </footer>



    </html>