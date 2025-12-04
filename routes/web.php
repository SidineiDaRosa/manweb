<?php

use App\Console\Commands\UpdateLoop;
use App\Http\Controllers\Check_listController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdemServicoController;
use App\Http\Controllers\PedidoCompraListaController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\QrCodeController;
use app\Http\Controllers\EstoqueProdutoController;
use App\Http\Controllers\PedidosSaidaController;
use App\Http\Controllers\SaidaProdutoController;
use App\Http\Controllers\PedidoCompraAutoGenerateController;
use App\Http\Controllers\EquipamentoHistoryController;
use App\Http\Controllers\DahboardStatusOsController;
use App\Http\Controllers\UtilsController;
use App\Http\Controllers\SolicitacaoOsController;
use App\Http\Controllers\CheckListController;
use App\Http\Controllers\CheckListExecutadoController;
use App\Http\Controllers\CustosController;
use App\Http\Controllers\ControlPanelController;
use App\Models\OrdemServico;
use Illuminate\Http\Request;
use App\Http\Controllers\LubrificacaoExecutadaController;
//use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('site.home');
})->name('site.home'); // Dashboard principal

Route::get('/site/sobre_nos', function () {
    return view('site.sobre_nos');
})->name('site.sobre_nos');
Route::get('/site-panel', function () {
    return view('site.control_panel');
})->name('site.control_panel');
Route::get('/configuracoes', function () {
    return view('site.configuracoes');
})->name('site.configuracoes');
//---------------------------------------------------------//
//    Status Os
//---------------------------------------------------------//
Route::get('/dashboard-status-os', [DahboardStatusOsController::class, 'index'])->name('dashboard-status-os');

//Route::get('/', function () {
//return view('auth.login');
//});
Route::get('/asset-show', [EquipamentoHistoryController::class, 'asset_show'])->name('asset.show');
//--------------------------------------------------------//
// Autetication User
//--------------------------------------------------------//
Auth::routes();
Route::middleware('auth')->get('/users-management', [ControlPanelController::class, 'users_management'])->name('users.management');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('app.home');

Route::get('/e-comerce-show-produto', 'App\Http\Controllers\ProdutoControllerComerce@index');
//Route::post('/e-comerce-show-produto', [App\Http\Controllers\ProdutoControllerComerce::class, 'index']);
Route::post('/produtos-filtro-e-comerce', [App\Http\Controllers\ProdutoControllerComerce::class, 'index']);
//Route::get('/e-comerce-show-produto', 'App\Http\Controllers\ProdutoControllerComerce');
//Route::get('/filtro-e-comerce', [App\Http\Controllers\ProdutoControllerComerce::class, 'show']);
Route::post('/comerce-show-produto', [App\Http\Controllers\ProdutoControllerComerce::class, 'show']);
Route::post('/assets', [EquipamentoHistoryController::class, 'assets'])->name('assets'); //acesso sem autenticação
Route::post('/asset_history', [EquipamentoHistoryController::class, 'asset_show'])->name('asset_history'); //acesso sem autenticação
//-------------------------------------------------------------------------------------------------
// Rota do venda no site 
//-------------------------------------------------------------------------------------------------
//Marca
Route::middleware('auth')->resource('/marca', 'App\Http\Controllers\MarcaController');
//-------------------------------------------------------------------------------------------------
//Categoria
//-------------------------------------------------------------------------------------------------
use App\Http\Controllers\CategoriaController;

Route::get('/categorias/{id}', [CategoriaController::class, 'show'])->name('categorias.show');

Route::middleware('auth')->resource('/categoria', 'App\Http\Controllers\CategoriaController');
Route::middleware('auth')->get('/categoria-edit/{id}', [CategoriaController::class, 'edit'])->name('categoria.edit');
// Rota para processar a atualização (PUT)
Route::middleware('auth')->put('/categoria-update/{id}', [CategoriaController::class, 'update'])->name('categoria.update');
// familias

use App\Http\Controllers\FamiliaController;

// Rotas para famílias
Route::middleware('auth')->resource('/familia', FamiliaController::class);


//fornecedor
Route::middleware('auth')->resource('/fornecedor', 'App\Http\Controllers\FornecedorController');

//produto
Route::middleware('auth')->resource('/produto', 'App\Http\Controllers\ProdutoController');
//----------------------------------------------//
//                Equipamento
//---------------------------------------------//
Route::middleware('auth')->resource('/equipamento', 'App\Http\Controllers\EquipamentoController');
//---------------------------------------------//
//                Ordem de serviço
//---------------------------------------------//
Route::middleware('auth')->resource('/ordem-servico', 'App\Http\Controllers\OrdemServicoController');
Route::put('/ordem_servico_up/{ordem_servico}', [OrdemServicoController::class, 'update'])->name('ordem_servico.update');
//ordem de serviço rota de pesquisas
Route::middleware('auth')->post('/filtro-os', [App\Http\Controllers\OrdemServicoController::class, 'index']);
// Programação de os e visualização semanal O.S.
Route::middleware('auth')->get('/program_os', [App\Http\Controllers\DahboardStatusOsController::class, 'programer_os'])->name('program_os');
//Atualiza datas via jason gráfico Gantt

Route::post('/ordem-servico/atualizar-intervalo', [OrdemServicoController::class, 'update_os_interval'])
    ->name('update.os.interval');
//   Abre os  gantt
Route::get('/filter-os-timeline', [OrdemServicoController::class, 'filter_os_timeline'])->name('filter.os.timeline');
Route::get('/gantt-timeline', [OrdemServicoController::class, 'gantt_timeline'])->name('gantt.os.timeline');
// Busca OS por texto like na descrição
Route::middleware('auth')->post('/filtro-os', [App\Http\Controllers\OrdemServicoController::class, 'index']);
//--------------------------------------------------------//
//                  Ordem de produção
//--------------------------------------------------------//
use App\Http\Controllers\OrdemProducaoController;

// Listar todas as ordens
Route::get('/ordens-producao', [OrdemProducaoController::class, 'index'])->name('ordens-producao.index');

// Mostrar formulário de criação
Route::get('/ordens-producao/create', [OrdemProducaoController::class, 'create'])->name('ordens-producao.create');

// Salvar nova ordem
Route::post('/ordens-producao', [OrdemProducaoController::class, 'store'])->name('ordens-producao.store');

// Mostrar ordem específica
Route::get('/ordens-producao/{ordem_producao}', [OrdemProducaoController::class, 'show'])->name('ordens-producao.show');

// Mostrar formulário de edição
Route::get('/ordens-producao/{ordem_producao}/edit', [OrdemProducaoController::class, 'edit'])->name('ordens-producao.edit');

// Atualizar ordem existente
Route::put('/ordens-producao/{ordem_producao}', [OrdemProducaoController::class, 'update'])->name('ordens-producao.update');
Route::patch('/ordens-producao/{ordem_producao}', [OrdemProducaoController::class, 'update']); // alternativa PATCH

// Deletar ordem
Route::delete('/ordens-producao/{ordem_producao}', [OrdemProducaoController::class, 'destroy'])->name('ordens-producao.destroy');
//--------------------------------------------------------//
//                 Entrada de produtos
//--------------------------------------------------------//
Route::middleware('auth')->resource('/entrada-produto', 'App\Http\Controllers\EntradaProdutoController');

Route::middleware('auth')->get(
    'produto_fornecedor/create',
    'App\Http\Controllers\ProdutoFornecedorController@create'
)->name('produto-fornecedor.create');
//------------------------------------------------//
//produto-fornecedor
//------------------------------------------------//
Route::middleware('auth')->post(
    'produto_fornecedor/store',
    'App\Http\Controllers\ProdutoFornecedorController@store'
)->name('produto-fornecedor.store');

Route::middleware('auth')->post(
    'produto_fornecedor/show',
    'App\Http\Controllers\ProdutoFornecedorController@show'
)->name('produto-fornecedor.show');

Route::middleware('auth')->delete(
    'produto_fornecedor/{produtoFornecedor}/{fornecedor}',
    'App\Http\Controllers\ProdutoFornecedorController@destroy'
)->name('produto-fornecedor.destroy');

Route::middleware('auth')->post(
    'produto_fornecedor/store/{fornecedor}',
    'App\Http\Controllers\ProdutoFornecedorController@store'
)->name('produto-fornecedor.store');

//recursos-ordem-producao
Route::middleware('auth')->post(
    'recursos-producao/store/{ordem_producao}',
    'App\Http\Controllers\RecursosProducaoController@store'
)->name('recursos-producao.store');

Route::middleware('auth')->post(
    'parada-equipamento/store/{ordem_producao}',
    'App\Http\Controllers\ParadaEquipamentoController@store'
)->name('parada-equipamento.store');
//---------------------------------------------------------//
//------------------Utilis controller---------------------//
//   Busca o horimetro inicial de Ordem de produção via ajax

Route::middleware('auth')->get(
    'utils/get-horimetro-inicial',
    'App\Http\Controllers\UtilsController@getHorimetroInicial'
)->name('utils.get-horimetro-inicial');
//------------------------------------------------------//
//----------------   os   ------------------------------//
Route::middleware('auth')->get(
    'utils/updateos',
    'App\Http\Controllers\UtilsController@updateos'
)->name('updateos');
Route::middleware('auth')->get(
    'utils/start-os',
    'App\Http\Controllers\UtilsController@startos'
)->name('start-os');

//busca o horimetro inicial de recursos de produção via ajax.
Route::middleware('auth')->get(
    'utils/get-horimetro-inicial-recursos',
    'App\Http\Controllers\UtilsController@getHorimetroInicialRecursos'
)->name('utils.get-horimetro-inicial-recursos');
//busca ultimo registro de ordem de serviço ajax.
Route::middleware('auth')->get(
    'utils/get-last-id-os',
    'App\Http\Controllers\UtilsController@getLastIdOs'
)->name('get-last-id-os');
//busca conta os por equipamento ajax.
Route::middleware('auth')->get(
    'utils/get-cont-os-equip',
    'App\Http\Controllers\UtilsController@getContOsEquip'
)->name('get-cont-os-equip');

//busca ordem se serviços todas.
Route::middleware('auth')->get(
    'utils/get-todas-os',
    'App\Http\Controllers\UtilsController@getTodasOs'
)->name('get-todas-os');
//busca ordem se serviços todas.
Route::middleware('auth')->post(
    'utils/validar-data-hora-termino',
    'App\Http\Controllers\UtilsController@validarDataHoraTermino'
)->name('validar-data-hora-termino');
//-------------------------------------------------------------//
//                Busca empresas
//-------------------------------------------------------------//
Route::middleware('auth')->post('/Empresas-filtro', [App\Http\Controllers\EmpresasController::class, 'index']);
Route::middleware('auth')->resource('/empresas', 'App\Http\Controllers\EmpresasController');
//Filtro Produtos
Route::middleware('auth')->post('/produtos-filtro', [App\Http\Controllers\ProdutoController::class, 'index']);
//Rota saida de produtos
Route::middleware('auth')->resource('/Saida-produto', 'App\Http\Controllers\SaidaProdutoController');
Route::middleware('auth')->resource('/mostra-produto', 'App\Http\Controllers\SaidaProdutoController');

//-------------------------------------------------------------//
//           Estoque de produtos
//-------------------------------------------------------------//
Route::middleware('auth')->post('/Estoque-Produtos-filtro', [App\Http\Controllers\EstoqueProdutoController::class, 'index']);
Route::middleware('auth')->resource('/Estoque-produto', 'App\Http\Controllers\EstoqueProdutoController');
Route::middleware('auth')->resource('Estoque-produto', EstoqueProdutoController::class);
//-------------------------------------------------------------//
//          Peças equipamentos
//-------------------------------------------------------------//
use App\Http\Controllers\PecaEquipamentoController;

Route::middleware('auth')->resource('/Peca-equipamento', 'App\Http\Controllers\PecaEquipamentoController');
//--
Route::middleware('auth')->post('/peca-equpamento-filtro', [App\Http\Controllers\PecaEquipamentoController::class, 'index']);


use App\Models\EstoqueProdutos;
use App\Models\PedidoCompraLista;

Route::middleware(['auth'])->get('/peca-equipamento-editar/{peca_equipamento_id}', [PecaEquipamentoController::class, 'edit'])->name('Peca-equipamento-editar.edit');
Route::middleware(['auth'])->put('/peca-equipamento/{pecas_equipamento}', [PecaEquipamentoController::class, 'update'])->name('Peca-equipamento.update');
Route::delete('/peca-equipamento/{id}', [PecaEquipamentoController::class, 'destroy'])
    ->name('peca-equipamento.destroy')
    ->middleware('auth');

//------------------------------------------//
//  Pedidos de compra                       //
//------------------------------------------//
Route::middleware('auth')->resource('/pedido-compra', 'App\Http\Controllers\PedidoCompraController');
Route::middleware('auth')->get('/pedido/{id}', [App\Http\Controllers\PedidoCompraController::class, 'open_po_id'])
    ->name('pedido.open');
//  insere o produto  no estoque
Route::middleware('auth')->post('/insert_item', [App\Http\Controllers\PedidoCompraController::class, 'storeItem'])
    ->name('pedido.store.ajax');
Route::middleware('auth')->get('/dashboard-estoque', [EstoqueProdutoController::class, 'storeProductInventory'])->name('dashboard.estoque');
//------------------------------------------//
// Filtro pedido de entrada
//------------------------------------------//
Route::middleware('auth')->post('/Ent-Produtos-filtro', [App\Http\Controllers\EntradaProdutoController::class, 'index']);
//Rota control panel
Route::middleware('auth')->resource('/control-panel', 'App\Http\Controllers\ControlPanelController');
//Rota Busca produto para dicionar item a pedidos
Route::middleware('auth')->resource('/item-produto', 'App\Http\Controllers\ItemProdutoController');
//Filtro Produtos item
Route::middleware('auth')->post('/item-produto-filtro', [App\Http\Controllers\ItemProdutoController::class, 'index']);

//--------------------------------------------------------//
//               Pedidos de saida
//--------------------------------------------------------//
Route::middleware('auth')->resource('/pedido-saida', 'App\Http\Controllers\PedidosSaidaController');
//Busca saida do produto
Route::middleware('auth')->resource('/pedido-saida-lista', 'App\Http\Controllers\PedidoSaidaListaController');
Route::middleware('auth')->post('/pedido-saida-filtro', [App\Http\Controllers\PedidosSaidaController::class, 'index']);
Route::middleware('auth')->resource('/item-produto-saida', 'App\Http\Controllers\ItemSaidaProdutoController');
//--------------------------------------------------------//
//   Deletar o pedido de saida
//--------------------------------------------------------//
Route::middleware('auth')->delete('/pedidos-saida/{id}', [PedidosSaidaController::class, 'destroy'])->name('pedidos-saida.destroy');

//--------------------------------------------------------//
// Busca produtos para adicionar em pedidos de sáida com O.S.
//--------------------------------------------------------//
Route::middleware('auth')->post('/pedido-saida-searching-products', [App\Http\Controllers\PedidoSaidaListaController::class, 'searching_products'])->name('pedido-saida-searching-products');

//----------------------------------------------------//
//               Saida De produtos store        
//----------------------------------------------------//
Route::middleware('auth')->resource('/saida-produto-add-item', 'App\Http\Controllers\SaidaProdutoController');
//Filtro Produtos item  saida 
Route::middleware('auth')->post('/Item-Saida-Produto', [App\Http\Controllers\ItemSaidaProdutoController::class, 'index']);
//Serviçoes executados
//Route::middleware('auth')->post('/Servicos-executado-index', [App\Http\Controllers\ServicosExecutadosController::class, 'index']);
Route::middleware('auth')->resource('/Servicos-executado', 'App\Http\Controllers\ServicosExecutadoController');
//--------------------------------------------------------------------//
//---Pedido de compra lista-------------------------------------------//
Route::middleware('auth')->resource('/pedido-compra-lista', 'App\Http\Controllers\PedidoCompraListaController');
//Rota que atualiza pedido de compra
Route::middleware('auth')->get(
    'utils/updatepedidocompra',
    'App\Http\Controllers\UtilsController@updatepedidocompra'
)->name('updatepedidocompra');
Route::middleware('auth')->get('/pedido-compra-printer/{numpedidocompra}', 'App\Http\Controllers\PedidoCompraListaController@printer')->name('pedido-compra-lista-printer');
Route::delete('/delete-item-pedido-delete', 'App\Http\Controllers\PedidoCompraListaController@destroy')->name('delete-item-pedido-delete');
//===============================================================//
//Adiciona componente ao equipamento
//---------------------------------------------------------------//
//Filtro Produtos
Route::middleware('auth')->post('/Produtos-filtro-componente', [App\Http\Controllers\PecaEquipamentoController::class, 'create'])->name('Produtos-filtro-componente');
//Edita o componente
Route::middleware('auth')->post('/Produtos-filtro-componente-edit', [App\Http\Controllers\PecaEquipamentoController::class, 'searching_products'])->name('Produtos-filtro-componente-edit');
//---------------------------------------------------------------//
// Envia requisição ajax para atualizar um chek-list
//---------------------------------------------------------------//
Route::post('/checklist/send', [Check_listController::class, 'send'])->name('checklist.send');
//---------------------------------------------------------------//
// Envia requisição ajax para atualizar um chek-list
//---------------------------------------------------------------//
Route::middleware('auth')->get(
    'utils/update-chek-list',
    'App\Http\Controllers\UtilsController@update_chek_list'
)->name('update-chek-list');
Route::middleware('auth')->get(
    'utils/search',
    'App\Http\Controllers\UtilsController@search'
)->name('search');
//------------------------------------------------------------//
// Deletar um item de umpedido de compra
Route::delete('/pedido-compra-lista/{id}', [PedidoCompraListaController::class, 'destroy'])->name('pedido-compra-lista.destroy');
//-----------------------------------------------------------//
// Gerar Qr code

Route::middleware('auth')->post('/gerar-qrcode', 'App\Http\Controllers\QrCodeController@gerarQRCode')->name('generate-qrcode');
//----------------------------------------------------------//
//   Imprimir em PDF
Route::post('/imprimir-pdf', [App\Http\Controllers\PdfController::class, 'gerarPDF'])->name('gerar.pdf');
//----------------------------------------------------------//
// 
// Deleta item pedido de saida
Route::middleware('auth')->delete('/saida-produto/{id}', [SaidaProdutoController::class, 'destroy'])->name('saida-produto.destroy');
//----------------------------------------------------------//
//   PedidoCompraAutoGenerateController

//Gerar pedido de compra apartir de produtos
Route::middleware('auth')->post('/pedido-compra-auto-generate', [PedidoCompraAutoGenerateController::class, 'pedido_compra_auto_generate'])->name('pedido-compra-auto-generate');
Route::middleware('auth')->get('/pedido-compra/show', [PedidoCompraAutoGenerateController::class, 'show'])
    ->name('pedido.compra.show');
//----------------------------------------------------------//
//   Deletar peças de equipamento
//----------------------------------------------------------//
Route::delete('/peca-equipamento/{id}', [PecaEquipamentoController::class, 'destroy'])->name('peca_equipamento.destroy');
//---------------------------------------------------------//
//    QRcode equipamentos history
//---------------------------------------------------------//
Route::get('/assets', [EquipamentoHistoryController::class, 'assets'])->name('assets');

//---------------------------------------------------------//
//    Criar solicitação de Os
//---------------------------------------------------------//
Route::get('/solicitacao-os', [SolicitacaoOsController::class, 'create']);
Route::post('solicitacao-os', [SolicitacaoOsController::class, 'store'])->name('solicitacao-os.store');
Route::get('/solicitacoes-pendentes', [SolicitacaoOsController::class, 'cont']);
Route::get('/solicitacoes-os', [SolicitacaoOsController::class, 'index']);
Route::post('/solicitacao_os/{id}/aceitar', [SolicitacaoOsController::class, 'aceitar'])->name('solicitacao_os.aceitar');
Route::post('/solicitacao_os/{id}/espera', [SolicitacaoOsController::class, 'espera'])->name('solicitacao_os.espera');
Route::post('/solicitacao_os/{id}/recusar', [SolicitacaoOsController::class, 'recusar'])->name('solicitacao_os.recusar');
Route::get('/solicitacoes', [SolicitacaoOsController::class, 'solicitacoes'])->name('solicitacoes-os');
//----------------------------------------------------------//
//   CHECK LIST                 
//----------------------------------------------------------//
//
Route::get('/check-list-index', [CheckListController::class, 'index'])->name('check-list-index');
Route::get('/check-list-index-nat', [CheckListController::class, 'index'])->name('check-list-nat');
//rota acessada pelos executante de check list
Route::get('/check-list-index-executar', [CheckListController::class, 'executar'])->name('check-list-index-executar');
Route::post('/check-list-show', [CheckListController::class, 'show'])->name('check-list-show');
Route::post('/check-list-save', [CheckListController::class, 'store'])->name('check-list-gravar');
Route::post('/check-list/gravar', [CheckListController::class, 'store'])->name('check-list-gravar');
Route::get('/check-list-show', [CheckListController::class, 'show'])->name('check-list-show');
Route::get('/check-list-edit', [CheckListController::class, 'edit'])->name('check-list-edit');
//Busca  check lists pendentes via jason, pela ToolBar reader
Route::get('/check-list-pendentes', [CheckListController::class, 'cont']);
// Rota para atualizar um check-list
Route::get('/check-list/update', [CheckListController::class, 'update'])->name('check-list-update');
Route::delete('/check-list-delete/{check_list_id}', [CheckListController::class, 'destroy'])->name('check-list-delete');
//----------------------------------------------------------//
//   CHECK LIST  EXECUTADOS             
//----------------------------------------------------------//
Route::post('/check-list-cheked', [CheckListExecutadoController::class, 'store'])->name('check-list-executado');
Route::get('/check-list-cheked-index', [CheckListExecutadoController::class, 'index'])->name('check-list-cheked-index');
Route::get('/check-list-finalizado', [CheckListExecutadoController::class, 'executado'])->name('check-list-finalizado');

Route::post('/check-list-filter', [CheckListExecutadoController::class, 'executado'])->name('check-list-filter');
Route::get('/check-list-funcionario', [CheckListExecutadoController::class, 'funcionario'])->name('check-list-funcionario');
Route::delete('/check-list-exec-delete/{id}', [CheckListExecutadoController::class, 'destroy'])->name('check-list-exec-delete');
//----------------------------------------------------------//
//   Check-list  Criar O.S.            
//----------------------------------------------------------//
Route::middleware('auth')->post('/new_os_check_list', [OrdemServicoController::class, 'new_os_check_list'])->name('new_os_check_list');

//----------------------------------------------------------//
//   CUSTOS GERAIS           
//----------------------------------------------------------//

Route::get('/dashboard-custos', [CustosController::class, 'dashboard'])->name('custos.dashboard');
//----------------------------------------------------------//
//   KPYs          
//----------------------------------------------------------//
use App\Http\Controllers\KPIsController;

Route::get('/dashboard', [KPIsController::class, 'dashboard'])->name('kpis.dashboard');
Route::get('/index-kpis', [KPIsController::class, 'index'])->name('index_kpis');
//----------------------------------------------------------//
//   Atualizar orímetro        
//----------------------------------------------------------//
use App\Http\Controllers\EquipamentoController;

Route::post('/update-horimetro', [EquipamentoController::class, 'update_hour_meter']);
//----------------------------------------------------------//
//   Controle Panel    
//----------------------------------------------------------//

use App\Http\Controllers\UpdateLoopController;
use App\Http\Controllers\NotificationsController;

Route::post('/loop/ativar', [UpdateLoopController::class, 'ativar'])->name('loop.ativar');
Route::post('/loop/desativar', [UpdateLoopController::class, 'desativar'])->name('loop.desativar');
Route::get('/loop', [UpdateLoopController::class, 'form'])->name('loop.form');
//Adquire a contagem de notificações.
Route::get('/alarms-count', [UpdateLoopController::class, 'alarms_count']);
Route::get('/notificacoes', [NotificationsController::class, 'index'])->name('notificacoes.index');
//----------------------------------------------------------//
//   Blog
//----------------------------------------------------------//
use App\Http\Controllers\PostController;

Route::get('/blog/painel', [PostController::class, 'index'])->name('blog.painel');
Route::post('/messages/painel', [PostController::class, 'store'])->name('messages.store');

use App\Http\Controllers\GroupController;

Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
Route::post('/groups/{group}/attach-users', [GroupController::class, 'attachUsers'])->name('groups.attachUsers');
Route::get('/groups/{group}', [GroupController::class, 'show'])->name('groups.show');
Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');

Route::get('/messages/fetch/{group}', [PostController::class, 'fetch'])->name('messages.fetch');
Route::get('/messages-count', [PostController::class, 'messages_count_user'])->name('messages.count');


//----------------------------------------------------------//
//   Dashboard status  os
//----------------------------------------------------------//

Route::post('/ordem-servico/modal', [OrdemServicoController::class, 'storeFromModal'])->name('ordem_servico.modal');

//----------------------------------------------------------//
//   Artigos  sobre manutenção
//----------------------------------------------------------//
use App\Http\Controllers\DocumentoController;

Route::get('/documentos/manutencao', [DocumentoController::class, 'index'])->name('documentos.manutencao');
Route::get('/documentos/normas', [DocumentoController::class, 'normas'])->name('documentos.normas');
//============================================================//
// HELP
//-------------------------------------------------------------//

Route::get('/site_help', function () {
    return view('site.help');
})->name('site.help');
//============================================================//
// Lubrificação 
//-------------------------------------------------------------//

use App\Http\Controllers\LubrificacaoController;

Route::get('/lubrificacoes', [LubrificacaoController::class, 'index'])->name('lubrificacao.index');

Route::resource('lubrificacao', LubrificacaoController::class);
Route::post('/lubrificacao-intervalo', [LubrificacaoController::class, 'store_intervalo'])->name('medicao.store');


Route::resource('lubrificacoes-executadas', LubrificacaoExecutadaController::class);
Route::get('/lubrificacoes-executadas/{lubrificacao}/edit', [LubrificacaoExecutadaController::class, 'edit'])
    ->name('lubrificacoes-executadas.edit');
//Count 
Route::get('/lubrificacao-count', [LubrificacaoController::class, 'countPendentes']);



// Abrir a view externa para execução

Route::post('lubrificacao/{id}/executar-externo', [LubrificacaoExecutadaController::class, 'executar'])
    ->name('lubrificacao.executar.externo.salvar');

Route::get('/executar-lubrificacao/{equipamento}', [LubrificacaoExecutadaController::class, 'executar_lub'])
    ->name('executar.lubrificacao');
Route::post('/open-lubrificacao/{equipamento}', [LubrificacaoExecutadaController::class, 'executar_open'])
    ->name('open.lubrificacao');

Route::post('/lubrificacao/executar/{id}', [LubrificacaoExecutadaController::class, 'executarAcao'])
    ->name('lubrificacao.executar.acao');
// Rota para buscar todas as lubrificações executadas


Route::get('/lubrificacoes-feitas', [LubrificacaoExecutadaController::class, 'index'])
    ->name('lubrificacao.executadas');
//
// Manutenção
Route::prefix('manutencao')->group(function () {
    Route::get('/preventiva', fn() => view('site.manutencao.manutencao_preventiva'))->name('manutencao.preventiva');
    Route::get('/corretiva', fn() => view('site.manutencao.manutencao_corretiva'))->name('manutencao.corretiva');
    Route::get('/preditiva', fn() => view('site.manutencao.manutencao_preditiva'))->name('manutencao.preditiva');
    Route::get('/lubrificacao', fn() => view('site.manutencao.lubrificacao'))->name('manutencao.lubrificacao');
});
Route::get('/about', function () {
    return view('site.about');
})->name('about');
//========================================================//
// Projetos

use App\Http\Controllers\ProjectController;

Route::resource('projetos', ProjectController::class);
// Rota para listar todos os projetos
Route::get('/projetos-index', [ProjectController::class, 'index'])->name('projetos.index');
//Busca os relacionadas a projeto
Route::get('/ordem-servico/projeto/{projeto_id}', [ProjectController::class, 'get_os_project'])
    ->name('ordem.servico.projeto');
//retrona para o gantt
Route::get('/ordem-servico/projeto/{projeto_id}/gantt', [ProjectController::class, 'gantt_timeline'])
    ->name('ordem.servico.projeto.gantt');
//===================================================
// Funcionários
//===================================================
use App\Http\Controllers\FuncionarioController;
// Lista todos os funcionários
Route::get('/funcionarios', [FuncionarioController::class, 'index'])
    ->name('funcionarios.index');

// Exibe o formulário para criar um novo funcionário
Route::get('/funcionarios/create', [FuncionarioController::class, 'create'])->name('funcionarios.create');

// Salva o novo funcionário no banco de dados
Route::post('/funcionarios', [FuncionarioController::class, 'store'])->name('funcionarios.store');

// Exibe um funcionário específico (opcional)
Route::get('/funcionarios/{id}', [FuncionarioController::class, 'show'])->name('funcionarios.show');

// Exibe o formulário de edição de um funcionário
Route::get('/funcionarios/{id}/edit', [FuncionarioController::class, 'edit'])->name('funcionarios.edit');

// Atualiza os dados de um funcionário
Route::put('/funcionarios/{id}', [FuncionarioController::class, 'update'])->name('funcionarios.update');

// Exclui um funcionário
Route::delete('/funcionarios/{id}', [FuncionarioController::class, 'destroy'])->name('funcionarios.destroy');
