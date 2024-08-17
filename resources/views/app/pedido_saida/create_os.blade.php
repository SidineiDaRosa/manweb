@extends('app.layouts.app')
@section('content')
<script src="{{ asset('js/update_datatime.js') }}" defer></script>
<script src="{{ asset('js/timeline_google.js') }}" defer></script>
<main class="content">
    <div class="card">
        <div> Criar novo pedido de saída com O.S</div>
        <div class="col-md-2"> <a href="{{route('pedido-saida.index')}}" class="btn btn-info btn-icon-split">
                <span class="icon text-white-20">
                    <i class="icofont-list"></i>
                </span>
                <span class="text">Voltar para pedidos de saída</span>
            </a></div>
    </div>
    <div class="card-header">
        <script>
            function Funcao() {
                alert('teste');
                document.getElementById("t1").value = "{{$funcionarios}}"
            }
        </script>
        <!----**************************************************************************************--->
        <!----Grava -->
        <!---*************************************************************************************----->
        @if (isset($ordem_servico->id))
        <form action="{{route('pedido-saida.store',['pedidos_saida' => $pedidos_saida->id]) }}" method="POST">
            @csrf
            @method('PUT')
            @else
            <form action="{{ route('pedido-saida.store') }}" method="POST">
                @csrf
                @endif
                @foreach ($ordem_servico as $ordem_servico_f)
                @endforeach
                <div class="form-row">
                    <div class="col-md-1">
                        <label for="data_inicio">Data emissão:</label>
                        <input type="date" class="form-control -lg" name="data_emissao" id="data_emissao" placeholder="dataPrevista" value="" readonly>
                    </div>
                    <div class="col-md-1">
                        <label for="hora_inicio">Hora emissão:</label>
                        <input type="time" class="form-control" name="hora_emissao" id="hora_emissao" placeholder="horaPrevista" value="" readonly>
                    </div>
                    <div class="col-md-1">
                        <label for="dataFim">Data prevista:</label>
                        <input type="date" class="form-control" name="data_prevista" id="dataFim" placeholder="dataFim" value="">
                    </div>
                    <div class="col-md-1">
                        <label for="horaFim">Hora Prevista:</label>
                        <input type="time" class="form-control" name="hora_prevista" id="horaFim" placeholder="horaFim" value="">
                    </div>
                    <!------------------------------------------------------------------------------------------->
                    <!---os-->
                    <div class="col-md-1">
                        <label for="ordem_serviço_id">Ordem serviço:</label>
                        <input type="text" class="form-control" name="ordem_servico_id" id="ordem_servico_id" placeholder="ordem_serviço_id" value="{{$ordem_servico_f->id}}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="funcionarios_id" class="">Emissor</label>
                        <input type="text" class="form-control" id="emissor" name="emissor" placeholder="emissor" value="{{auth()->user()->name}}" readonly>
                        <input type="text" class="form-control" id="funcionarios_id" name="funcionarios_id" value="{{auth()->user()->id}}" hidden>
                    </div>
                    <!------------------------------------------------------------------------------------------->
                    <!---equipamento-->
                    <!------------------------------------------------------------------------------------------->

                    <div class="col-md-1">
                        <label for="equipamento_id" class="">ID Equipamento</label>

                        <input type="text" class="form-control" id="equipamento_id" name="equipamento_id" placeholder="equipamento_id" value="{{$ordem_servico_f->equipamento->id}}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="equipamento_id" class="">Nome do Equipamento</label>

                        <input type="text" class="form-control" id="equipamento_nome" name="equipamento_nome" placeholder="equipamento_id" value="{{$ordem_servico_f->equipamento->nome}}" readonly>

                    </div>
                    <!---------Select empresa------------->
                    <!--------------------------------------------------------------------------------------->

                    <div class="col-md-0">
                        <label for="empresa_id" class="">Empresa</label>

                        <input type="text" class="form-control" id="empresa_id" name="empresa_id" placeholder="empresa_id" value="{{$ordem_servico_f->empresa->id}}" readonly>

                    </div>
                    <div class="col-md-4 mb-1">
                        <label for="cliente" class="">Empresa/Destino</label>
                        <input type="text" class="form-control" id="empresa_mnome" name="empresa_nome" value="{{$ordem_servico_f->empresa->razao_social}}" readonly>
                        <input type="text" class="form-control" id="fornecedor_id" name="fornecedor_id" value="{{$ordem_servico_f->empresa->id}}" hidden>
                    </div>
                    <!----------------------------------->
                    <div class="col-md-5 mb-1">
                        <label for="cliente" class="">Obs.</label>
                        <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descreva algo..." value="">
                    </div>
                    <div class="col-md-2 mb-0">
                        <label for="situacao" class="">Status:</label>
                        <select class="form-control" name="status" id="situacao" value="">
                            <option value="aberto">aberto</option>
                            <option value="fechado">fechado</option>
                            <option value="indefinido">indefinido</option>
                            <option value="cancelada">cancelada</option>
                            <option value="em andamento">em andamento</option>
                        </select>
                    </div>
                    <!------------------------------------------------------------------------------------------->
                    <div class="col-md-2 mt-3">
                        <div style="margin-top: 14px;">
                            <button type="submit" class="btn btn-outline-primary">Salvar</button>
                        </div>
                    </div>
            </form>

    </div>
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
    @endsection
    <footer>
    </footer>

    </html>