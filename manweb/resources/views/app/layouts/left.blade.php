<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <script src="{{ asset('js/left.js') }}" defer></script>
    <title>Document</title>
</head>

</html>
<!--Classe principal do menu left-->
<style>
    .sidebar-submenu-expanded-a-1 {

        opacity: 0.9;
        font-size: 40px;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }
</style>

<aside class="sidebar" id="sidebarleft">
    <nav class="menu mt-3" id="">
        <!--Classe inicio das listas de menu-->

        <ul class="nav-list">
            <li class="nav-item">
                <a onclick="FunExpandMenuDashboard();">
                    <i class="icofont-dashboard icofont-2x">&nbsp&nbsp&nbspDashboard</i>
                    <i class="icofont-caret-down icofont-2x"></i>

                </a>
                <div class="sidebar-submenu-expanded" id="sidebar-submenu-expanded-dashboard">
                    <a href="{{ route('app.home') }}" class="title-menu">DASHBOARD OS</a><p>
                    <a class="sidebar-submenu-expanded-a" href="{{ route('control-panel.index') }}">Painel de controle</a><br>
                    <hr>
                    <a class="sidebar-submenu-expanded-a" href="{{ route('site.configuracoes') }}">Configurações</a>
                </div>
            </li>
            <hr>
            <!--Menu home page-->
            <li class="nav-item">
                <a onclick="FunExpandMenuHome();">

                    <i class="icofont-company icofont-2x"></i></i>&nbsp&nbsp&nbspUnidades Cia
                    <i class="icofont-caret-down icofont-2x"></i>


                </a>
                <div class="sidebar-submenu-expanded" id="sidebar-submenu-expanded-home">
                    <a class="sidebar-submenu-expanded-a" href="{{route('empresas.index')}}">Busca unidade empresarial</a><br>

                    <hr>
                    <a class="sidebar-submenu-expanded-a" href="#"></a>
                </div>
            </li>
            <!--Menu marcas-->
            <li class="nav-item">
                <a onclick="FunExpandMenuMarcas();">
                    <i class="icofont-cc icofont-2x"></i>
                    &nbsp&nbspMarcas
                    <i class="icofont-caret-down icofont-2x"></i>
                </a>
                <div class="sidebar-submenu-expanded" id="sidebar-submenu-expanded-marcas">
                    <a class="sidebar-submenu-expanded-a" href="{{route('marca.index')}}">Busca Marcas</a><br>
                    <a class="sidebar-submenu-expanded-a" href="">Cadastro de marcas</a><br>
                    <hr>
                    <a class="sidebar-submenu-expanded-a" href="">Cadastro de grupo /categoria</a>
                </div>
            </li>
            <!--Menu recursos-->
            <li class="nav-item">
                <a onclick="FunExpandMenuRecursos();">
                    <i class="icofont-cubes icofont-2x"></i>
                    &nbsp&nbspRecursos
                    <i class="icofont-caret-down icofont-2x"></i>
                </a>
                <div class="sidebar-submenu-expanded" id="sidebar-submenu-expanded-recursos">
                    <a class="sidebar-submenu-expanded-a" href="{{route('produto.index')}}">Produtos</a><br>
                    <hr>
                    <a class="sidebar-submenu-expanded-a" href="{{route('Estoque-produto.index')}}">Estoque de produtos</a><br>
                    <hr>
                    <a class="sidebar-submenu-expanded-a" href="{{route('pedido-compra.index')}}">Pedidos de compra</a>
                    <hr>
                    <a class="sidebar-submenu-expanded-a" href="{{route('entrada-produto.index')}}">Entrada de
                        produtos</a>
                    <hr>
                    <a class="sidebar-submenu-expanded-a" href="{{route('pedido-saida.index')}}">Pedidos de saída</a>
                    <hr>
                    <a class="sidebar-submenu-expanded-a" href="{{route('fornecedor.index')}}">Fornecedores</a>
                    <hr>
                    <a class="sidebar-submenu-expanded-a" href="{{route('produto-fornecedor.create')}}">Por
                        fornecedor</a><br>
                    <hr>
                    <a class="sidebar-submenu-expanded-a" href="{{route('categoria.index')}}">Categoria</a><br>

                </div>
            </li>
            <!--Menu Máquinas e equipamentos-->
            <li class="nav-item">
                <a href="#">
                    <a onclick="FunExpandMenuPeatrimonio();">
                        <i class="icofont-vehicle-trucktor icofont-2x"></i>
                        &nbsp&nbspAtivos
                        <i class="icofont-caret-down icofont-2x"></i>
                    </a>
                    <div class="sidebar-submenu-expanded" id="sidebar-submenu-expanded-patrimonio">
                        <a class="sidebar-submenu-expanded-a" href="{{route('equipamento.index')}}">&nbsp&nbspAtivos e Passivos</a><br>
                        <a class="sidebar-submenu-expanded-a" href="{{ route('equipamento.create') }}">&nbsp&nbspCadastro de
                            equipamentos</a><br>
                        <hr>
                        <a class="sidebar-submenu-expanded-a" href="">Manutenção</a><br>
                        <a class="sidebar-submenu-expanded-a" href="{{route('ordem-servico.index')}}">
                            <i class="icofont-repair"></i>
                            &nbsp&nbspOrdem de serviço</a><br>
                        <a class="sidebar-submenu-expanded-a" href="">
                            <i class="icofont-dashboard-web"></i>
                            &nbsp&nbspRelatórios</a><br>
                        <a class="sidebar-submenu-expanded-a" href="">
                            <i class="icofont-bars"></i>
                            &nbsp&nbspGráficos</a>
                    </div>
            </li>

            <li class="nav-item">
                <a href="#">
                    <a href="{{route('ordem-producao.index')}}">
                        <i class="icofont-industries-4 icofont-2x"></i>
                        &nbsp&nbspProdução
                        <i class="icofont-caret-down icofont-2x"></i>

                    </a>
            </li>


            <li class="nav-item">
                <a href="{{route('register')}}">
                    <i class="icofont-users mr-2 icofont-2x"></i>
                    &nbspUsuários
                    <i class="icofont-caret-down icofont-2x"></i>
                </a>
            </li>

    </nav>

</aside>