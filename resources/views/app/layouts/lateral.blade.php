<style>
/* Sidebar */
.sidebar {
    width: 250px;
    background-color: #f5f5f5;
    min-height: 100vh; /* corrige problema do conteúdo sumindo */
    padding: 10px;
    box-sizing: border-box;
    overflow-y: auto;
}

.nav-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav-list li {
    margin-bottom: 5px;
}

.nav-list a {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #b1b7caff;
    padding: 8px;
    border-radius: 4px;
    transition: background 0.2s;
}

.nav-list a:hover {
    background-color: rgba(0,0,0,0.05);
}

.nav-list i {
    margin-right: 8px;
}

.submenu {
    display: none; /* escondido por padrão */
    padding-left: 20px;
}

.submenu a {
    font-size: 14px;
    padding: 6px 8px;
    display: block; /* garante que ocupe linha inteira */
}

.submenu.show {
    display: block; /* exibe submenu */
}

.divider {
    border-bottom: 1px solid #ccc;
    margin: 5px 0;
}

.spn-txt-menu {
    font-size: 16px;
}

.arrow {
    margin-left:auto;
    display: inline-block;
    transition: transform 0.3s ease;
    font-size: 16px;
}

.arrow.down {
    transform: rotate(90deg); /* seta vira "v" */
}

/* Responsivo simples */
@media(max-width: 768px){
    .sidebar {
        width: 100%;
        height: auto;
    }
}
</style>

<aside class="sidebar" id="sidebarleft">
<ul class="nav-list">
    <!-- Dashboard -->
    <li>
        <a href="{{ route('app.home') }}">
            <i class="icofont-dashboard icofont-1x"></i>
            <span class="spn-txt-menu">DASHBOARD</span>
        </a>
    </li>

    <div class="divider"></div>

    <!-- Outros -->
    <li>
        <a href="javascript:void(0);" onclick="toggleSubmenu('dashboard-submenu')">
            <i class="icofont-settings icofont-1x"></i>
            <span class="spn-txt-menu">Outros</span>
            <span class="arrow">&gt;</span>
        </a>
        <div class="submenu" id="dashboard-submenu">
            <a href="{{ route('dashboard-status-os') }}">Painel de Visualização O.S.</a>
            <a href="{{ route('control-panel.index') }}">Painel de controle</a>
            <a href="{{ route('site.configuracoes') }}" hidden>Configurações</a>
        </div>
    </li>

    <div class="divider"></div>

    <!-- Unidades Cia -->
    <li>
        <a href="javascript:void(0);" onclick="toggleSubmenu('home-submenu')">
            <i class="icofont-company icofont-2x"></i>
            <span class="spn-txt-menu">&nbsp;Unidades Cia</span>
            <span class="arrow">&gt;</span>
        </a>
        <div class="submenu" id="home-submenu">
            <a href="{{ route('empresas.index') }}">Busca unidade empresarial</a>
        </div>
    </li>

    <!-- Marcas -->
    <li>
        <a href="javascript:void(0);" onclick="toggleSubmenu('marcas-submenu')">
            <i class="icofont-cc icofont-2x"></i>
            <span class="spn-txt-menu">&nbsp;Marcas</span>
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
            <i class="icofont-cubes icofont-2x"></i>
            <span class="spn-txt-menu">&nbsp;Gestão de Suprimentos</span>
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
            <i class="icofont-vehicle-trucktor icofont-2x"></i>
            <span class="spn-txt-menu">&nbsp;Ativos</span>
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
            <i class="icofont-industries-4 icofont-2x"></i>
            <span class="spn-txt-menu">&nbsp;Produção</span>
        </a>
    </li>

    <!-- Usuários admin -->
    @auth
        @if(Auth::user()->level === 0)
            <li>
                <a href="{{ route('register') }}">
                    <i class="icofont-users mr-2 icofont-2x"></i>
                    <span class="spn-txt-menu">&nbsp;Criar Usuários</span>
                </a>
            </li>
            <li>
                <a href="{{ route('register') }}">
                    <i class="icofont-users mr-2 icofont-2x"></i>
                    <span class="spn-txt-menu">&nbsp;Editar Usuário</span>
                </a>
            </li>
        @endif
    @endauth
</ul>
</aside>

<script>
function toggleSubmenu(id){
    const submenu = document.getElementById(id);
    submenu.classList.toggle('show');

    // Alterna seta > para v
    const arrow = submenu.previousElementSibling.querySelector('.arrow');
    if(arrow) arrow.classList.toggle('down');
}
</script>
