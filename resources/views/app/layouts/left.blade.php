<style>
/* Sidebar */
.sidebar {
    position: fixed;       /* sidebar fixa na tela */
    top: 60px;             /* recuo do topo */
    left: 0;
    width: 60px;           /* sidebar recolhida */
    height: calc(100vh - 60px);
    background-color: #5e5b5bff;
    overflow-x: hidden;
    overflow-y: auto;
    transition: width 0.5s ease;
    padding: 10px 0;
    box-sizing: border-box;
}

/* Sidebar expandida ao passar mouse */
.sidebar:hover {
    width: 250px;
}

/* Lista de navegação */
.nav-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

/* Cada item da lista */
.nav-list li {
    position: relative;
}

/* Links da sidebar */
.nav-list a {
    display: flex;
    align-items: center;
    height: 60px;        /* altura fixa do item */
    text-decoration: none;
    color: #b1b7caff;
    padding: 0 10px;
    border-radius: 4px;
    transition: background 0.2s;
}

.nav-list a:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

/* Wrapper do ícone */
.icon-wrapper {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* Texto do menu, escondido inicialmente */
.spn-txt-menu {
    margin-left: 10px;
    opacity: 0;
    transition: opacity 0.3s;
    white-space: nowrap;
}

/* Mostra texto ao expandir sidebar */
.sidebar:hover .spn-txt-menu {
    opacity: 1;
}

/* Submenus */
.submenu {
    display: none;
    padding-left: 70px; /* recuo para aparecer ao lado do ícone */
    flex-direction: column;
}

.submenu a {
    height: auto;
    padding: 6px 8px;
    font-size: 14px;
}

.submenu.show {
    display: flex;
}

/* Divider */
.nav-list li.divider {
    border-bottom: 1px solid #ccc;
    margin: 5px 0;
    list-style: none;
    pointer-events: none;
}

/* Setas */
.arrow {
    margin-left: auto;
    display: inline-block;
    transition: transform 0.3s ease;
    font-size: 16px;
}

.arrow.down {
    transform: rotate(90deg);
}
</style>

<aside class="sidebar" id="sidebarleft">
    <ul class="nav-list">
        <!-- Dashboard -->
        <li>
            <a href="{{ route('app.home') }}">
                <div class="icon-wrapper">
                    <i class="icofont-dashboard icofont-2x"></i>
                </div>
                <span class="spn-txt-menu">DASHBOARD</span>
            </a>
        </li>

        <li class="divider"></li>

        <!-- Outros -->
        <li>
            <a href="javascript:void(0);" onclick="toggleSubmenu('dashboard-submenu')">
                <div class="icon-wrapper">
                    <i class="icofont-settings icofont-2x"></i>
                </div>
                <span class="spn-txt-menu">Outros</span>
                <span class="arrow">&gt;</span>
            </a>
            <div class="submenu" id="dashboard-submenu">
                <a href="{{ route('dashboard-status-os') }}">Painel de Visualização O.S.</a>
                <a href="{{ route('control-panel.index') }}">Painel de controle</a>
                <a href="{{ route('site.configuracoes') }}" hidden>Configurações</a>
            </div>
        </li>

        <li class="divider"></li>

        <!-- Unidades Cia -->
        <li>
            <a href="javascript:void(0);" onclick="toggleSubmenu('home-submenu')">
                <div class="icon-wrapper">
                    <i class="icofont-company icofont-2x"></i>
                </div>
                <span class="spn-txt-menu">Unidades Cia</span>
                <span class="arrow">&gt;</span>
            </a>
            <div class="submenu" id="home-submenu">
                <a href="{{ route('empresas.index') }}">Busca unidade empresarial</a>
            </div>
        </li>

        <!-- Marcas -->
        <li>
            <a href="javascript:void(0);" onclick="toggleSubmenu('marcas-submenu')">
                <div class="icon-wrapper">
                    <i class="icofont-cc icofont-2x"></i>
                </div>
                <span class="spn-txt-menu">Marcas</span>
                <span class="arrow">&gt;</span>
            </a>
            <div class="submenu" id="marcas-submenu">
                <a href="{{ route('marca.index') }}">Cadastro de marcas</a>
                <a href="#">Cadastro de Segmentos</a>
            </div>
        </li>

        <!-- Gestão de Suprimentos -->
        <li>
            <a href="javascript:void(0);" onclick="toggleSubmenu('recursos-submenu')">
                <div class="icon-wrapper">
                    <i class="icofont-cubes icofont-2x"></i>
                </div>
                <span class="spn-txt-menu">Gestão de Suprimentos</span>
                <span class="arrow">&gt;</span>
            </a>
            <div class="submenu" id="recursos-submenu">
                <a href="{{ route('custos.dashboard') }}">Custos</a>
                <a href="{{ route('produto.index') }}">Produtos</a>
                <a href="{{ route('Estoque-produto.index') }}">Estoque de produtos</a>
                <a href="{{ route('pedido-compra.index') }}">Pedidos de compra</a>
                <a href="{{ route('entrada-produto.index') }}">Entrada de produtos</a>
                <a href="{{ route('pedido-saida.index') }}">Pedidos de saída</a>
                <a href="{{ route('fornecedor.index') }}">Fornecedores</a>
                <a href="{{ route('produto-fornecedor.create') }}">Por fornecedor</a>
                <a href="{{ route('categoria.index') }}">Categoria</a>
            </div>
        </li>

        <!-- Ativos -->
        <li>
            <a href="javascript:void(0);" onclick="toggleSubmenu('patrimonio-submenu')">
                <div class="icon-wrapper">
                    <i class="icofont-vehicle-trucktor icofont-2x"></i>
                </div>
                <span class="spn-txt-menu">Ativos</span>
                <span class="arrow">&gt;</span>
            </a>
            <div class="submenu" id="patrimonio-submenu">
                <a href="#">Ativos</a>
                <a href="{{ route('Peca-equipamento.index') }}">Filtros de Check-List Lubrificação</a>
                <a href="#">Manutenção</a>
                <a href="{{ route('ordem-servico.index') }}">Ordem de Serviço</a>
                <a href="{{ route('index_kpis') }}">KPIs</a>
                <a href="#">Gráficos</a>
            </div>
        </li>

        <!-- Produção -->
        <li>
            <a href="{{ route('ordem-producao.index') }}">
                <div class="icon-wrapper">
                    <i class="icofont-industries-4 icofont-2x"></i>
                </div>
                <span class="spn-txt-menu">Produção</span>
            </a>
        </li>

        <!-- Usuários admin -->
        @auth
        @if(Auth::user()->level === 0)
        <li>
            <a href="{{ route('register') }}">
                <div class="icon-wrapper">
                    <i class="icofont-users icofont-2x"></i>
                </div>
                <span class="spn-txt-menu">Criar Usuários</span>
            </a>
        </li>
        <li>
            <a href="{{ route('register') }}">
                <div class="icon-wrapper">
                    <i class="icofont-users icofont-2x"></i>
                </div>
                <span class="spn-txt-menu">Editar Usuário</span>
            </a>
        </li>
        @endif
        @endauth
    </ul>
</aside>

<script>
function toggleSubmenu(id) {
    const submenu = document.getElementById(id);
    submenu.classList.toggle('show');

    // Alterna seta > para v
    const arrow = submenu.previousElementSibling.querySelector('.arrow');
    if (arrow) arrow.classList.toggle('down');
}
</script>
