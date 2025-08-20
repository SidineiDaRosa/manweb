<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="{{ asset('js/left.js') }}" defer></script>
    <title>Left</title>
</head>

</html>
<!--Classe principal do menu left
<header class="header" style="color:#454d66;">   important-->

<style>
    .sidebar-submenu-expanded-a-1 {

        opacity: 0.9;
        font-size: 40px;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }

    .spn-txt-menu {
        font-family: 'Roboto', sans-serif;
        font-size: 20px;
    }
</style>

<aside class="sidebar" id="sidebarleft">
    <nav class="menu mt-3" id="">
        <!--Classe inicio das listas de menu-->

        <ul class="nav-list">
            <a class="sidebar-submenu-expanded-a" href="{{ route('app.home') }}">
                <i class="icofont-dashboard icofont-1x">&nbsp&nbsp&nbsp
                    <span class="spn-txt-menu">DASHBOARD</span>
                </i>
            </a><br>
            <hr>
            <li class="nav-item">
                <a onclick="FunExpandMenuDashboard();">
                    &nbsp&nbsp&nbsp
                    <span class="spn-txt-menu">Outros</span>
                    </i>
                    <i class="icofont-caret-down icofont-2x"></i>
                </a>
                <div class="sidebar-submenu-expanded" id="sidebar-submenu-expanded-dashboard">
                    <a href="{{ route('dashboard-status-os') }}" class="title-menu">Painel de Visualização O.S.</a>
                    <hr>
                    <a class="sidebar-submenu-expanded-a" href="{{ route('control-panel.index') }}">Painel de controle</a><br>
                    <hr>
                    <a class="sidebar-submenu-expanded-a" href="{{ route('site.configuracoes') }}" hidden>Configurações</a>
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
                    <a class="sidebar-submenu-expanded-a" href="{{route('marca.index')}}">Cadastro de marcas</a><br>
                    <hr>
                    <a class="sidebar-submenu-expanded-a" href="#">Cadastro de Segmentos</a>
                </div>
            </li>

            <!--Menu recursos-->
            <li class="nav-item">
                <a onclick="FunExpandMenuRecursos();">
                    <i class="icofont-cubes icofont-2x"></i>
                    &nbsp&nbspGestão de Suprimentos
                    <i class="icofont-caret-down icofont-2x"></i>
                </a>
                <div class="sidebar-submenu-expanded" id="sidebar-submenu-expanded-recursos">
                    <a class="sidebar-submenu-expanded-a" href="{{route('custos.dashboard')}}">Custos</a><br><!--chama pela segunda opção Name  da rota-->
                    <hr>
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
                        <a class="sidebar-submenu-expanded-a" href="#">&nbsp&nbspAtivos</a><br>
                        <a class="sidebar-submenu-expanded-a" href="{{ route('Peca-equipamento.index') }}">&nbsp&nbspFiltros de Chek-List Lubrificação</a><br>
                        <hr>
                        <a class="sidebar-submenu-expanded-a" href="">Manutenção</a><br>
                        <a class="sidebar-submenu-expanded-a" href="{{route('ordem-servico.index')}}">
                            <i class="icofont-repair"></i>
                            &nbsp&nbspOrdem de Serviço</a><br>
                        <a class="sidebar-submenu-expanded-a" href="{{route('index_kpis')}}">
                            <i class="icofont-dashboard-web"></i>
                            &nbsp&nbspKPIs</a><br>
                        <a class="sidebar-submenu-expanded-a" href="#">
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
            @auth
            @if(Auth::user()->level === 0)
            <li class="nav-item">
                <a href="{{ route('register') }}">
                    <i class="icofont-users mr-2 icofont-2x"></i>
                    &nbsp Criar Usuários
                    <i class="icofont-caret-down icofont-2x"></i>
                </a>
            </li>
            <li>
                <a href="{{ route('register') }}">
                    <i class="icofont-users mr-2 icofont-2x"></i>
                    &nbspEditar Usuário
                    <i class="icofont-caret-down icofont-2x"></i>
                </a>
            </li>

            @endif
            @endauth

    </nav>

</aside>