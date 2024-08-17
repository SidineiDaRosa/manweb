@extends('app.layouts.app')
@section('content')
<script src="{{ asset('js/update_datatime.js') }}" defer></script>
<script src="{{ asset('js/timeline_google.js') }}" defer></script>
<main class="content">

    <div class="titulo-main">
        Pedido de saída produtos com O.S.
    </div>

    <style>
        .titulo-main {
            font-size: 20px;
            color: gray;
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
            font-size: 20px;
            font-family: 'Poppins', sans-serif;
            color: #007b00;
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
                <div class="titulo">Emissão</div>
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
                    <input type="text" class="input-bordernone" name="emissor" id="emissor" value="{{$pedido_saida_f->funcionarios_id}}" required autocomplete="funcionarios_id " autofocus readonly>
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
                        <span class="material-symbols-outlined">
                            open_in_new
                        </span>
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
                <div class="titulo">Descrição</div>
                <hr>
                <div class="conteudo">
                    <input type="text" class="input-bordernone" name="descricao" id="descricao" value="{{$pedido_saida_f->descricao}}" required autocomplete="funcionarios_id " autofocus readonly>
                </div>
            </div>
        </div>
    </div>
    </form>
    {{--fim card--}}
    {{--------------fim continer box----------------------------------------}}
    <div class="card-body">
        <table class="table-template table-striped table-hover table-bordered">
            <thead>
                <tr>
                    <th scope="col" class="th-title">Id</th>
                    <th scope="col" class="th-title">Cod fabricante</th>
                    <th scope="col" class="th-title">Produto_ID</th>
                    <th scope="col" class="th-title">Descrição</th>
                    <th scope="col" class="th-title">Unidade</th>
                    <th scope="col" class="th-title">Quantidade</th>
                    <th scope="col" class="th-title">Valor Unit</th>
                    <th scope="col" class="th-title">Subtotal</th>
                    <th scope="col" class="th-title">Data</th>
                    <th scope="col" class="th-title">Patrmônio</th>
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
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!--Iframe do subformulario de produtos-->
    <!-- <iframe id="ifm1" src="{{route('item-produto-saida.index',['pedido' => $pedido_saida_f->id,'empresa_id'=>$pedido_saida_f->empresa->id,'equipamento'=>$pedido_saida_f->equipamento->id])}}" width="90%" height="600" style="border:1px solid black;">-->
    <!-- <iframe id="ifm1" src="{{route('item-produto-saida.index',['pedido' => $pedido_saida_f->id,'empresa_id'=>$pedido_saida_f->empresa->id,'equipamento'=>$pedido_saida_f->equipamento->id])}}" width="90%" height="600" style="border:1px solid black;">  
    </iframe>-->
    <hr>
    <div class="form-row">
        <input type="number" class="form-control" style="width:200px;" readonly name="produto_id" id="produto_id">
        <input type="text" class="form-control" style="width:50%;" readonly name="produto_nome" id="produto_nome">
        <input type="number" id="quantidade" name="quantidade" class="form-control" style="width:200px;" readonly>
        <!-- Botão de envio inicialmente oculto -->
        <button id="btnEnviar"class="btn btn-outline-primary" style="display: none;">Enviar</button>
    </div>

    {{------------------------------------------------}}
    {{--Tabela de peças dos equipamento---------------}}
    <table class="table" id="tblPecas">
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
                <th>Status</th>
                <th>Tipo de Componente</th>
                <th>Criticidade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pecas_equipamento as $peca_equipamento)
            <tr>
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
                <td>{{ $peca_equipamento->status}}</td>
                <td>{{ $peca_equipamento->tipo_componente}}</td>
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
                row.addEventListener("click", function() {
                    // Captura o ID e nome do produto das colunas corretas
                    let produtoId = this.querySelector('td:nth-child(1)').innerText; // Ajuste o índice conforme a coluna correta
                    let produtoNome = this.querySelector('td:nth-child(4)').innerText; // Ajuste o índice conforme a coluna correta

                    // Exibe a mensagem de confirmação
                    let confirmacao = confirm("Deseja adicionar o produto " + produtoNome + " ao seu pedido?");

                    // Define os valores nos campos ocultos do formulário
                    document.getElementById('produto_nome').value = produtoNome;
                    document.getElementById('produto_id').value = produtoId;

                    if (confirmacao) {
                        // Lógica para adicionar o produto ao pedido
                        alert("Produto " + produtoNome + " foi adicionado ao seu pedido!");

                        // Habilita o campo 'quantidade' e aplica o foco
                        let quantidadeField = document.getElementById('quantidade');
                        let btnEnviar = document.getElementById('btnEnviar');

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
    @if($pedido_saida_f->status != 'fechado')
    <iframe id="ifm1" src="{{ route('item-produto-saida.index', ['pedido' => $pedido_saida_f->id, 'empresa_id' => $pedido_saida_f->empresa->id, 'equipamento' => $pedido_saida_f->equipamento->id]) }}" width="90%" height="600" style="border:1px solid black;"></iframe>
    @endif
    @endsection

    <footer>
    </footer>

    </html>