
@if (isset($equipamento->id))
<form action="{{ route('Peca-equipamento.update', ['pecas_equipamento' => $pecas_equipamento->id]) }}" method="POST">
    @csrf
    @method('PUT')
    @else
    <form action="{{ route('Peca-equipamento.store') }}" method="POST">
        @csrf
        @endif
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
                let dataUltimaSub, anoUltimasub, diaUltimaSub
                let dataProxManut
                let intervaloMan
                let mesesInter
                let diasInter
                let mesesProxima, diasProxima, anosProxima
                dataUltimaSub = document.getElementById('data_substituicao').value
                intervaloMan = document.getElementById('intervalo_manutencao').value
                let dataUltimaSub_1 = new Date(dataUltimaSub)
                let anoUltima = dataUltimaSub_1.getFullYear();
                let mesUltima = dataUltimaSub_1.getMonth() + 1;
                let diaUltima = dataUltimaSub_1.getDate() + 1;
                if (intervaloMan >= 8700) {
                    let anosInter = (intervaloMan / 8700)
                    let anosInter_1 = (parseInt(anosInter))
                    let getMeses = (parseInt(((anosInter - anosInter_1) * 8700) / 730))
                    mesesProxima = String(getMeses + 1).padStart(2, '0');
                    anosProxima = String(anosInter_1 + anoUltima).padStart(4, '0');
                    diasProxima = String(diaUltima).padStart(2, '0')
                    alert('A data da próxima manutenção será agendada para:' + diasProxima + '-' + mesesProxima + '-' + anosProxima)
                }
                if (intervaloMan >= 720 & intervaloMan < 8700) {
                    mesesInter = (parseInt(intervaloMan / 730))
                    //mesesProxima =( mesesInter + mesUltima).padStart(2, '0')
                    anosProxima = String(anoUltima).padStart(4, '0');
                    mesesProxima = String(mesesInter + mesUltima).padStart(2, '0');
                    diasProxima = String(diaUltima).padStart(2, '0')
                    alert('A data da próxima manutenção será agendada para:' + diasProxima + '-' + mesesProxima + '-' + anosProxima)
                }
                if (intervaloMan >= 1 & intervaloMan < 720) {
                    diasInter = (parseInt(intervaloMan / 24)) + diaUltima
                    if (diasInter >= 30) {
                        mesUltima = mesUltima + 1

                        diasInter = diasInter - 30
                        diasInter = diasInter

                    }
                    anosProxima = anoUltima
                    mesesProxima = String(mesUltima).padStart(2, '0');
                    diasProxima = String(diasInter).padStart(2, '0')
                    alert('A data da próxima manutenção será agendada para:' + diasProxima + '-' + mesesProxima + '-' + anosProxima)
                }
                //var dia = String(data_atual.getDate()).padStart(2, '0');
                //var mes = String(mesesProxima .getMonth() + 1).padStart(2, '0');
                dataProxManut = anosProxima + '-' + mesesProxima + '-' + diasProxima
                document.getElementById('data_proxima_manutencao').value = dataProxManut
                document.getElementById('horas_proxima_manutencao').value = intervaloMan
                // document.getElementById('link_peca').value='vazio'
                // document.getElementById('forma_medicao').value=1
            }
        </script>
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
        <div class="container-box">
            {{--Box 1--}}
            <div class="item">
                <div class="box-conteudo">
                    <div class="titulo">ID:</div>
                    <hr>
                    <div class="conteudo">@foreach($equipamento as $equipamento_f)
                        {{$equipamento_f['id']}}
                        @endforeach
                        <input type="text" name="equipamento" value="@foreach($equipamento as $equipamento_f)
                        {{$equipamento_f['id']}}
                        @endforeach" hidden>
                    </div>
                    <div class="titulo">Equipamento/Patrimônio</div>
                    <hr>
                    <div class="conteudo">
                        @foreach($equipamento as $equipamento_f)
                        {{$equipamento_f['nome']}}
                        @endforeach
                        <input id="equipamento_nome" type="text" name="equipamento_nome" value="@foreach($equipamento as $equipamento_f)
                    {{$equipamento_f['nome']}}
                    @endforeach" hidden>
                    </div>
                    <div class="titulo">Descrição do item</div>
                    <hr>
                    <div class="conteudo">
                        <input name="descricao" id="descricao" type="text" value="" placeholder="--insira uma descrição para o item--">
                    </div>
                </div>
            </div>
            {{--Box 2--}}
            <div class="item">
                <div class="box-conteudo">
                    <div class="titulo">ID produto:</div>
                    <hr>
                    <div class="conteudo">
                        <input class="input-text" type="text" name="produto_id" id="produto_id" readonly>
                        <input class="input-text" name="quantidade" id="quantidade" type="number" step="0.2" value="" placeholder="--insira a quantidade--">
                    </div>
                    <div class="titulo">Data:</div>
                    <hr>
                    <div class="conteudo">
                        <input class="input-text" name="data_substituicao" id="data_substituicao" type="date" value="">
                        <input class="input-text" name="hora_substituicao" id="hora_substituicao" type="time" value="">
                    </div>
                    <div class="titulo">Intervalo de manutenção</div>
                    <hr>
                    <div class="conteudo">
                        <input name="intervalo_manutencao" id="intervalo_manutencao" type="number" value="" onchange="AtualizaProxManut()" placeholder="--insira o intervalo em horas--">
                    </div>
                    <div class="titulo">Data da próxima manutencão</div>
                    <hr>
                    <div class="conteudo">
                        <input class="input-text" name="data_proxima_manutencao" id="data_proxima_manutencao" type="date" value="" readonly>
                        <input class="input-text" name="horas_proxima_manutencao" id="horas_proxima_manutencao" type="number" value="" readonly>hs
                    </div>
                    <button type=" submit" class="btn btn-outline-primary btn-sm" style="height:20px;">
                        Salvar
                    </button>

                </div>
            </div>

            {{--Box 3--}}
            <div class="item">
                <div class="box-conteudo">

                    <div class="titulo">Horimetro</div>
                    <hr>
                    <div class="conteudo">
                        <input class="input-text" name="horimetro" id="horimetro" type="number" value="0">
                        <input class="input-text" name="forma_medicao" id="forma_medicao" type="number" value="1" readonly>
                    </div>
                    <div class="titulo">Status</div>
                    <hr>
                    <div class="conteudo">
                        <select class="input-text" name="status" id="status" value="ativado">
                            <option value="ativado">Ativado</option>
                            <option value="desativado">Desativado</option>
                        </select>
                    </div>
                    <div class="titulo">Categoria</div>
                    <hr>
                    <div class="conteudo">
                        <select class="input-text" name="tipo_componente" id="tipo_componente" value="ativado">
                            <option value="lubrificação">lubrificação</option>
                            <option value="Componente">Componente</option>
                            <option value="mensalidade">Calibração</option>
                        </select>
                    </div>
                    <div class="titulo">Grau de criticidade</div>
                    <hr>
                    <div class="conteudo">
                        <select class="input-text" name="criticidade" id="criticidade" value="ativado">
                            <option value="Extra Alta">Extra Alta</option>
                            <option value="Alta">Alta</option>
                            <option value="Média">Média</option>
                            <option value="Baixa">Baixa</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
    {{--fim card--}}
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
                    <th scope="col">Id</th>
                    <th scope="col">Qrcode</th>
                    <th scope="col">cod_fabricante</th>
                    <th scope="col">Nome</th>
                    <th scope="col">un medida</th>
                    <th scope="col">Fabricante</th>
                    <th scope="col">Ver peça</th>
                    <th scope="col">Imagem</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Operações</th>

                </tr>
            </thead>

            <tbody>
                @foreach ($produtos as $produto)
                <tr>
                    <th>{{ $produto->id }}</td>
                    <td> {!! QrCode::size(50)->backgroundColor(255,255,255)->generate( $produto->id.'--'.$produto->nome) !!}</td>
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
                                // JavaScript para manipular o clique do botão e preencher os inputs
                                document.querySelectorAll('#select-btn').forEach(button => {
                                    button.addEventListener('click', function() {
                                        // Obtendo a linha onde o botão foi clicado
                                        const row = this.closest('tr');

                                        // Obtendo o valor dos dados da linha
                                        const produtoId = row.cells[0].textContent;
                                        const produtoNome = row.cells[1].textContent;

                                        // Preenchendo os inputs com os valores obtidos
                                        document.getElementById('produto_id').value = produtoId;
                                        // document.getElementById('produto_nome').value = produtoId;
                                        //document.getElementById('produto_nome').value = produtoNome;

                                    });

                                });
                                //-----------------------------------
                                // JavaScript para manipular o clique na linha e preencher os inputs
                                document.querySelectorAll('#tblProdutos tr').forEach(row => {
                                    row.addEventListener('click', function() {
                                        // Ignorando a linha do cabeçalho
                                        if (this.rowIndex === 0) return;

                                        // Obtendo o valor dos dados da linha
                                        const produtoId = this.cells[0].textContent;
                                        const produtoNome = this.cells[1].textContent;

                                        // Preenchendo os inputs com os valores obtidos
                                        document.getElementById('produto_id').value = produtoId;
                                        //document.getElementById('produto_nome').value = produtoNome;
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