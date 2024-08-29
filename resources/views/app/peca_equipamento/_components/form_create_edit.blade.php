{{--Seta campos de preenchimentos necessários--}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        //chama função para setar os campos
        alterarBackgroundCampos();
    });

    function alterarBackgroundCampos() {
        document.getElementById('produto_id').style.background = "rgba(249, 187, 120, 0.2)";
        document.getElementById('quantidade').style.background = "rgba(249, 187, 120, 0.2)";
        document.getElementById('data_substituicao').style.background = "rgba(249, 187, 120, 0.2)";
        document.getElementById('hora_substituicao').style.background = "rgba(249, 187, 120, 0.2)";
        document.getElementById('intervalo_manutencao').style.background = "rgba(249, 187, 120, 0.2)";
        document.getElementById('status').style.background = "rgba(249, 187, 120, 0.2)";
        document.getElementById('criticidade').style.background = "rgba(249, 187, 120, 0.2)";
        document.getElementById('tipo_componente').style.background = "rgba(249, 187, 120, 0.2)";
        document.getElementById('descricao').style.background = "rgba(249, 187, 120, 0.2)";

    }
    //Fim da função que seta as cores dos campos
    function AtualizaProxManut() {
        // Obter os valores dos inputs
        const lastMaintenanceDate = document.getElementById('data_substituicao').value;
        const lastMaintenanceTime = document.getElementById('hora_substituicao').value;
        const maintenanceInterval = parseFloat(document.getElementById('intervalo_manutencao').value);

        if (lastMaintenanceDate && lastMaintenanceTime && !isNaN(maintenanceInterval)) {
            // Combinar data e hora em um único objeto Date
            const lastMaintenanceDateTime = new Date(`${lastMaintenanceDate}T${lastMaintenanceTime}`);

            // Calcular o intervalo de manutenção em milissegundos
            const maintenanceIntervalMs = maintenanceInterval * 60 * 60 * 1000;

            // Calcular a data e hora da próxima manutenção
            const nextMaintenanceDateTime = new Date(lastMaintenanceDateTime.getTime() + maintenanceIntervalMs);

            // Obter a data e hora da próxima manutenção em formatos legíveis
            const nextMaintenanceDate = nextMaintenanceDateTime.toISOString().split('T')[0];
            const nextMaintenanceTime = nextMaintenanceDateTime.toTimeString().split(' ')[0];

            // Calcular as horas restantes
            const currentDateTime = new Date();
            const remainingTimeMs = nextMaintenanceDateTime - currentDateTime;
            const remainingHours = Math.max(Math.floor(remainingTimeMs / (1000 * 60 * 60)), 0);

            // Exibir o alerta com a data e hora da próxima manutenção
            console.log(`Próxima manutenção: ${nextMaintenanceDate} às ${nextMaintenanceTime} intervalo de:${remainingHours}`);
            alert(`Próxima manutenção: ${nextMaintenanceDate} às ${nextMaintenanceTime} E restam: ${remainingHours} horas`);

            // Definir o valor dos campos com a data e hora da próxima manutenção
            document.getElementById('data_proxima_manutencao').value = `${nextMaintenanceDate}`;
            document.getElementById('hora_proxima_manutencao').value = `${nextMaintenanceTime}`;

            // Definir o valor do campo com as horas restantes
            document.getElementById('horas_proxima_manutencao').value = `${remainingHours}`;
            // Obter o campo pelo ID
            const descricaoCampo = document.getElementById('descricao');
            document.getElementById('descricao').value = '';

            // Remover o atributo readonly para habilitar o campo
            descricaoCampo.removeAttribute('readonly');

            // Definir o foco no campo
            descricaoCampo.focus();
        } else {
            alert('Por favor, preencha todos os campos corretamente.');
        }
    }
</script>
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
        margin: -5px;
    }

    .box-conteudo {
        margin-left: 2px;
        justify-content: flex-start;
    }

    .titulo {
        display: flex;
        font-size: 15px;
        font-family: 'Poppins', sans-serif;
        margin-top: -5px;

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

    .input-text {
        margin-top: 5px;
        width: 50%;
        border: none;
        color: #2174d4;
        margin-right: 2px;
    }
</style>
<form action="{{ route('Peca-equipamento.store') }}" method="POST">
    @csrf
    <input type="hidden" name="form_token" value="{{ $formToken }}">

    <div class="container-box">
        {{-- Box 1 --}}
        <div class="item">
            <div class="box-conteudo">
                <div class="titulo">ID:</div>
                <hr>
                <div class="conteudo">
                    @php
                    $equipamentoId = $equipamento->first()->id ?? ''; // Obtemos o primeiro ID
                    @endphp
                    {{ $equipamentoId }}
                    <input type="text" name="equipamento" value="{{ $equipamentoId }}" hidden>
                </div>
                <div class="titulo">Equipamento/Patrimônio</div>
                <hr>
                <div class="conteudo">
                    @php
                    $equipamentoNome = $equipamento->first()->nome ?? ''; // Obtemos o primeiro nome
                    @endphp
                    {{ $equipamentoNome }}
                    <input id="equipamento_nome" type="text" name="equipamento_nome" value="{{ $equipamentoNome }}" hidden>
                </div>
                <div class="titulo">ID produto:</div>
                <hr>
                <div class="conteudo">
                    <input class="input-text" type="text" name="produto_id" id="produto_id" readonly>
                    <input class="input-text" name="quantidade" id="quantidade" type="number" step="0.2" placeholder="--insira a quantidade--">
                </div>
                <div class="titulo">Data:</div>
                <hr>
                <div class="conteudo">
                    <input class="input-text" name="data_substituicao" id="data_substituicao" type="date">
                    <input class="input-text" name="hora_substituicao" id="hora_substituicao" type="time">
                </div>
                <div class="titulo">Intervalo de manutenção</div>
                <hr>
                <div class="conteudo">
                    <input name="intervalo_manutencao" id="intervalo_manutencao" type="number" onchange="AtualizaProxManut()" placeholder="--insira o intervalo em horas--">
                </div>
            </div>
        </div>
        {{-- Box 2 --}}
        <div class="item">
            <div class="box-conteudo">
                <div class="titulo">Data da próxima manutenção</div>
                <hr>
                <div class="conteudo">
                    <input class="input-text" name="data_proxima_manutencao" id="data_proxima_manutencao" type="date" readonly>
                    <input class="input-text" name="hora_proxima_manutencao" id="hora_proxima_manutencao" type="time" readonly>
                </div>
                <div class="titulo">Horas para próxima manutenção</div>
                <hr>
                <div class="conteudo">
                    <input class="input-text" name="horas_proxima_manutencao" id="horas_proxima_manutencao" type="number" readonly>hs
                </div>
                <div class="titulo">Descrição do item</div>
                <hr style="margin-bottom:2px;">
                <div class="conteudo">
                   <textarea name="descricao" id="descricao" cols="100" rows="4" readonly style="border-width: 0.5px;"></textarea>
                </div>
            </div>
        </div>
        {{-- Box 3 --}}
        <div class="item">
            <div class="box-conteudo">
                <div class="titulo">Horímetro</div>
                <hr>
                <div class="conteudo">
                    <input class="input-text" name="horimetro" id="horimetro" type="number" value="0">
                    <input class="input-text" name="forma_medicao" id="forma_medicao" type="number" value="1" readonly>
                </div>
                <div class="titulo">Status</div>
                <hr>
                <div class="conteudo">
                    <select class="input-text" name="status" id="status">
                        <option value="ativado">Ativado</option>
                        <option value="desativado">Desativado</option>
                    </select>
                </div>
                <div class="titulo">Categoria</div>
                <hr>
                <div class="conteudo">
                    <select class="input-text" name="tipo_componente" id="tipo_componente">
                        <option value="manutencao">Manutenção</option>
                        <option value="Componente">Componente</option>
                        <option value="lubrificação">Lubrificação</option>
                        <option value="Chek-List">Check-List</option>
                        <option value="mensalidade">Mensalidade</option>
                    </select>
                </div>
                <div class="titulo">Grau de criticidade</div>
                <hr>
                <div class="conteudo">
                    <select class="input-text" name="criticidade" id="criticidade">
                        <option value="Extra Alta">Extra Alta</option>
                        <option value="Alta">Alta</option>
                        <option value="Média">Média</option>
                        <option value="Baixa">Baixa</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-outline-primary btn-sm" style="height:20px;">
                    Salvar
                </button>
            </div>
        </div>
    </div>
</form>

{{--fim card e do form que envia para salvar--}}
{{--------------fim continer box----------------------------------------}}
<!---estilização do input box buscar produtos---->
<style>
    #formSearchingProducts {
        background-color: white;
        width: 900px;
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

    #tblProdutos {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        background-color: rgb(211, 211, 211);
    }

    thead {
        background-color: rgb(169, 169, 169);
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 3px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }

    tr:hover {
        background-color: rgb(169, 169, 169);
    }
</style>
<!-------------------------------------------------------------------------->
<div class="card-top">
    <style>
        .card-top {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 2px;
            margin-bottom: 2px;
        }
    </style>
    <div class="card-header-template">
        <form id="formSearchingProducts" action="{{ route('Produtos-filtro-componente') }}" method="POST">
            @csrf
            <input type="text" name="equipamento" value="@foreach($equipamento as $equipamento_for)
                        {{$equipamento_for['id']}}
                        @endforeach" hidden>
            <div class="col-md-4 mb-0">
                <select class="form-control" name="tipofiltro" id="tipofiltro" value="" placeholder="Selecione o tipo de filtro">
                    <option value="2">Busca Pelas inicias</option>
                    <option value="1">Busca pelo ID</option>
                    <option value="3">Busca pelo Código do Fabricante</option>
                    <option value="4">Busca por categoria</option>
                </select>
            </div>
            <div class="col-md-4">
                <select name="categoria_id" id="" class="form-control-template">
                    <option value=""> --Selecione a Categoria--</option>
                    @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ ($produto->categoria_id ?? old('categoria_id')) == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nome }}
                    </option>
                    @endforeach
                </select>
                {{ $errors->has('categoria_id') ? $errors->first('categoria_id') : '' }}
            </div>
            <!--input box filtro buscar produto--------->
            <input type="text" id="query" name="produto" placeholder="Buscar produto..." aria-label="Search through site content">
            <button type="submit">
                <i class="icofont-search icofont-2x"></i>
            </button>
        </form>
    </div>
</div>
<hr>
<div class="card-body">
    <table class="" id="tblProdutos">
        <thead>
            <tr>
                <th>ID</th>
                <th>cod_fabricante</th>
                <th>Nome</th>
                <th>Un medida</th>
                <th>Fabricante</th>
                <th>Ver peça</th>
                <th>Imagem</th>
                <th>Categoria</th>
                <th>Operações</th>

            </tr>
        </thead>

        <tbody>
            @foreach ($produtos as $produto)
            <tr>
                <th>{{ $produto->id }} <button class=" btn btn-sm-template btn-outline-primary" id="add-product" value="{{ $produto->id }}" onclick="AddProduct();">Adicionar</button></td>

                    <script>
                        function AddProduct() {
                            // Obtém o valor do input
                            let productId = document.getElementById('add-product').value;

                            // Pergunta ao usuário se deseja adicionar o produto
                            if (confirm('Você realmente deseja adicionar o produto com ID: ' + productId + '?')) {
                                // Se o usuário confirmar, mostra um alerta e limpa o campo
                                alert('Produto adicionado com ID: ' + productId);
                                document.getElementById('produto_id').value = productId;
                                document.getElementById('produto_id').style.background = '#90EE90';
                            } else {
                                // Se o usuário cancelar, apenas mostra uma mensagem
                                alert('A adição do produto foi cancelada.');
                            }
                        }
                    </script>
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