@extends('app.layouts.app')

@section('titulo', 'Produtos')

@section('content')

<main class="content">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <div class="card">
        <div class="card-header-template">
            <div>Visualização do Produto</div>
            <div>

                <a href="{{ route('produto.index') }}" class="btn btn-outline-primary btn-sm">
                    <span class="material-symbols-outlined">
                        format_list_bulleted
                    </span>
                </a>
                <a href="{{ route('produto.create') }}" class="btn btn-outline-primary btn-sm">
                    Novo
                </a>
                <a class="btn btn-outline-primary btn-sm" href="{{ route('produto.edit', ['produto' => $produto->id]) }}">
                    <i class="icofont-ui-edit"></i> Editar </a>
                <a class="btn btn-outline-dark sm" href="{{ route('app.home') }}">
                    <i class="icofont-dashboard"></i> dashboard
                </a>
            </div>
        </div>
        <div class="card-body">
            <!--  div dos fotos-->
            <div class="carousel-container">
                <div class="carousel-images">
                    <img src="/img/produtos/{{ $produto->image}}" alt="Imagem 1">
                    <img src="/img/produtos/{{ $produto->image2}}" alt="Imagem 2">
                    <img src="/img/produtos/{{ $produto->image3}}" alt="Imagem 3">
                    <!-- Adicione mais imagens conforme necessário -->
                </div>
                <div class="carousel-preview">
                    <img src="/img/produtos/{{ $produto->image}}" alt="imagem" class="preview-image">
                    <img src="/img/produtos/{{ $produto->image2}}" alt="imagem" class="preview-image">
                    <img src="/img/produtos/{{ $produto->image3}}" alt="imagem" class="preview-image">
                    <!-- Adicione mais imagens conforme necessário -->
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const carouselImages = document.querySelector('.carousel-images');
                    const previewImages = document.querySelectorAll('.preview-image');

                    previewImages.forEach((preview, index) => {
                        preview.addEventListener('click', () => {
                            carouselImages.style.transform = `translateX(-${index * 100}%)`;
                        });
                    });
                });
            </script>
            <style>
                .carousel-container {
                    max-width: 370px;
                    margin: 0 auto;
                    overflow: hidden;
                    float: left;
                    margin-left: 100px;
                }

                .carousel-images {
                    display: flex;
                    transition: transform 0.5s ease;
                }

                .carousel-images img {
                    width: 100%;
                    height: auto;
                    object-fit: cover;
                }

                .carousel-preview {
                    display: flex;
                    justify-content: center;
                    margin-top: 10px;
                }

                .preview-image {
                    width: 50px;
                    height: 50px;
                    object-fit: cover;
                    margin: 0 5px;
                    cursor: pointer;
                }

                .preview-image:hover {
                    border: 2px solid blue;
                }
            </style>
            <!--  div dos dados do produto-->
            <style>
                #dados-tec {
                    height: 500px;
                    width: 500px;
                    float: right;

                    margin-right: 100px;
                }

                hr {
                    margin: -2px;
                    color: dimgray;
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

                .conteudo-sm {
                    display: flex;
                    font-size: 15px;
                    font-family: 'Poppins', sans-serif;
                    color: dimgray;
                    margin-bottom: 5px;
                    font-weight: 400;
                }
            </style>
            {{--------------------------------------------------------}}
            {{--Bloco de descrição e dados do produto--}}
            {{--------------------------------------------------------}}
            <div id="dados-tec">
                <div id=idOs class="conteudo" style="color:mediumblue">
                    ID:&nbsp&nbsp{{ $produto->id }}
                </div>
                <div class="titulo">Nome do produto</div>
                <hr>
                <div class="conteudo">{{ $produto->nome }}</div>
                <div class="titulo">Descrição do produto</div>
                <hr>
                <div class="conteudo-sm">{{ $produto->descricao }}</div>
                <div class="titulo">Marca | Fabricante </div>
                <hr>
                <div class="conteudo" style="color:mediumblue;">{{ $produto->marca->nome }}&nbsp&nbsp|&nbsp&nbspCod Fab:{{ $produto->cod_fabricante }}</div>
                <div class="titulo">Quantidade em estoque</div>
                <hr>
                <div class="conteudo">{{$estoque_produtos_sum}}&nbsp&nbsp{{$produto->unidade_medida->nome}}</div>
                <div id=idOs class="conteudo" style="color:mediumblue" hidden>
                    Valor total:&nbsp&nbspR${{number_format($estoque_produtos_sum_valor, 2, ',', '.')}}
                </div>
                <div class="titulo">Categoria</div>
                <div class="conteudo">{{ $produto->categoria->nome}}</div>
                <hr>
                <a href="{{ $produto->link_peca}}" target="blank">Ver no site do fabricante<span class="material-symbols-outlined">
                        open_in_new
                    </span></a>
                <a href="{{route('pedido-saida-lista.index', ['produto_id'=>$produto->id])}}" target="blank">Consultar saídas<span class="material-symbols-outlined">
                        open_in_new
                    </span></a>
                <a href="{{ route('Estoque-produto.create',['produto' => $produto->id]) }}" class="btn btn-outline-success btn-sm">
                    <i class="icofont-cubes"></i>
                    </span>
                    <span class="text">Criar estoque</span>
                </a>
                <a class="btn btn-sm-template btn-outline-success  @can('user') disabled @endcan" href="{{ route('produto.edit', ['produto' => $produto->id]) }}" title="editar dados do produto">

                    <i class="icofont-ui-edit"></i> </a>
                <a class="btn btn-bg-template btn-outline-success  @can('user') disabled @endcan" href="{{ route('produto.index', ['produto' => $produto->id,'tipofiltro'=>10]) }}" title="Onde é aplicado este produto">
                    <span class="text">Onde é aplicado este produto</span></a>
                {{--//-----------------------------------------//--}}
                {{--// Cria automaticamente um pedido de compra//--}}
                {{--//-----------------------------------------//--}}
                <!-- jQuery -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <!-- Bootstrap JavaScript -->
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

                <!-- Botão para abrir o modal -->
                <a class="btn btn-bg-template btn-outline-success @can('user') disabled @endcan" data-toggle="modal" data-target="#myModal" title="Onde é aplicado este produto">
                    <span class="text">Gerar Pedido de Compra</span>
                </a>

                <!-- O modal Gerar Pedido de Compra-->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Gerar Pedido de Compra</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Conteúdo do modal aqui -->
                                Finalidade: ID:70 Amoxarifado <br>
                                Emissão: <input type="date" name="data_emissao" id="data_emissao" readonly><input type="time" name="hora_emissao" id="hora_emissao" readonly><br>
                                Previsão: <input type="date" name="data_emissao" id="data_emissao" readonly><input type="time" name="hora_prevista" id="hora_prevista" readonly><br>
                                ID Produto:<input type="number" name="id" id="id" value="{{$produto->id}}" readonly><br>
                                Nome Produto:<input class="conteudo" type="text" name="nome" id="nome" value="{{$produto->nome}}" readonly style="width: 300px;;"><br>
                                <hr>
                                <p></p>
                                Digite A Quantidade:
                                <input type="number">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" id="btnSalvar">Salvar Pedido de compra</button>
                            </div>
                        </div>
                    </div>
                </div>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $('#btnSalvar').click(function() {
                            // Coleta os dados do formulário
                            var dataEmissao = $('#data_emissao').val();
                            var horaEmissao = $('#hora_emissao').val();
                            var idProduto = $('#id').val();
                            var quantidade = $('input[type="number"]').val(); // Assumindo que este é o campo de quantidade

                            // Envia os dados para a rota
                            $.ajax({
                                url: '{{ route("pedido.compra.auto.generate") }}', // Rota definida no Laravel
                                type: 'GET',
                                data: {
                                    data_emissao: dataEmissao,
                                    hora_emissao: horaEmissao,
                                    data_prevista: dataPrevista,
                                    hora_prevista: horaPrevista,
                                    id: idProduto,
                                    nome: nomeProduto,
                                    quantidade: quantidade
                                },
                                success: function(response) {
                                    // Manipule a resposta conforme necessário
                                    console.log('Pedido de compra gerado com sucesso!', response);
                                    // Feche o modal se desejado
                                    $('#myModal').modal('hide');
                                },
                                error: function(xhr, status, error) {
                                    // Manipule erros
                                    console.error('Erro ao gerar pedido de compra', error);
                                }
                            });
                        });
                    });
                </script>
                {{--//-----------------Fim------------------------//--}}
                <p>
                <div>
                    <?php

                    $protocolo = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == "on") ? "https" : "http");
                    $url = '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                    $urlPaginaAtual = $protocolo . $url
                    //echo $protocolo.$url;
                    ?>
                    <p>
                        {!! QrCode::size(50)->backgroundColor(255,255,255)->generate( $urlPaginaAtual ) !!}
                        {!! QrCode::size(50)->backgroundColor(255,255,255)->generate( $produto->id.'--'.$produto->nome) !!}
                    <p>
                </div>
            </div>
        </div>
    </div>
    <hr>
    {{--------------------------------------------------------------------------------------------}}
    {{--Tabela que busca o status do estoque de produtos------------------------------------------}}
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col" class="th-title">Id do estoque</th>
                <th scope="col" class="th-title">Produto id</th>
                <th scope="col" class="th-title">Produto</th>
                <th scope="col" class="th-title">Cod. Unid. Medida</th>
                <th scope="col" class="th-title">Quant. Estoque</th>
                <th scope="col" class="th-title">Estoque minimo</th>
                <th scope="col" class="th-title">estoque máximo</th>
                <th scope="col" class="th-title">Valor</th>
                <th scope="col" class="th-title">Local do estoque</th>
                <th scope="col" class="th-title">Empresa</th>
                <th scope="col" class="th-title">Operações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estoque_produtos as $estoque_produto)
            <tr>
                <th scope="row">{{ $estoque_produto->id }}</td>
                <td>{{ $estoque_produto->produto->id}}</td>
                <td>{{ $estoque_produto->produto->nome }}</td>
                <td>{{ $estoque_produto->unidade_medida}}</td>
                <td>{{ $estoque_produto->quantidade }}</td>
                <td>{{ $estoque_produto->estoque_minimo }}</td>
                <td>{{ $estoque_produto->estoque_maximo}}</td>
                <td>{{ $estoque_produto->valor }}</td>
                <td>{{ $estoque_produto->local}}</td>
                <td>{{ $estoque_produto->empresa->nome_fantasia}}</td>
                <td>
                    <a href="{{ route('entrada-produto.create',['produto' => $estoque_produto->produto->id,'estoque_id'=>$estoque_produto->id ]) }}" class="btn btn-bg-template btn-outline-primary  @can('user') disabled @endcan">

                        <i class="icofont-database-add"></i>
                        </span>
                        <span class="text">Inserir estoque</span>
                    </a>
                    <a class="btn btn-bg-template btn-outline-success  @can('user') disabled @endcan" href="{{ route('Estoque-produto.edit', ['Estoque_produto' => $estoque_produto->id]) }}" title="Editar dados do estoque">
                        <i class="icofont-ui-edit"></i>
                        <span class="text">Editar</span></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <style>
        .bg-warning-light {
            background-color: #FFFFE0;
            /* Amarelo claro */
        }

        .bg-success {
            background-color: #28a745;
            /* Verde */
        }

        .bg-warning {
            background-color: #ffc107;
            /* Amarelo forte */
        }

        .bg-danger {
            background-color: #dc3545;
            /* Vermelho */
        }
    </style>
</main>

@endsection