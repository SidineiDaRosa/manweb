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
                    NOVO
                </a>
                <a class="btn btn-outline-primary btn-sm" href="{{ route('produto.edit', ['produto' => $produto->id]) }}">
                    <i class="icofont-ui-edit"></i> Editar </a>
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
                    max-width: 600px;
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
                    margin: -5px;
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
            </style>
            {{--------------------------------------------------------}}
            {{--Bloco de descrição e dadso do produto--}}
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
                <div class="conteudo">{{ $produto->descricao }}</div>
                <div class="titulo">Marca | Fabricante </div>
                <hr>
                <div class="conteudo" style="color:mediumblue;">{{ $produto->marca->nome }}-Cod Fab:{{ $produto->cod_fabricante }}</div>
                <div class="titulo">Quantidade em estoque</div>
                <hr>
                <div class="conteudo">{{$estoque_produtos_sum}}{{$produto->unidade_medida->nome}}</div>
                <div id=idOs class="conteudo" style="color:mediumblue">
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
                    <i class="icofont-database-add"></i>
                    </span>
                    <span class="text">Criar estoque</span>
                </a>
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
                    <a href="{{ route('entrada-produto.create',['produto' => $estoque_produto->produto->id,'estoque_id'=>$estoque_produto->id ]) }}" class="btn-sm btn-success">

                        <i class="icofont-database-add"></i>
                        </span>
                        <span class="text">Inserir estoque</span>
                    </a>

                <td>
            </tr>
            @endforeach

        </tbody>
    </table>

</main>

@endsection