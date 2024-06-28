<?php

use App\Http\Controllers\Check_listController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdemServicoController;
use App\Http\Controllers\PedidoCompraListaController;
use Illuminate\Support\Facades\Auth;
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
})->name('site.home');
Route::get('/site/sobre_nos', function () {
    return view('site.sobre_nos');
})->name('site.sobre_nos');
Route::get('/site-panel', function () {
    return view('site.control_panel');
})->name('site.control_panel');
Route::get('/configuracoes', function () {
    return view('site.configuracoes');
})->name('site.configuracoes');

//Route::get('/', function () {
//return view('auth.login');
//});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('app.home');

Route::get('/e-comerce-show-produto', 'App\Http\Controllers\ProdutoControllerComerce@index');
//Route::post('/e-comerce-show-produto', [App\Http\Controllers\ProdutoControllerComerce::class, 'index']);
Route::post('/Produtos-filtro-e-comerce', [App\Http\Controllers\ProdutoControllerComerce::class, 'index']);
//Route::get('/e-comerce-show-produto', 'App\Http\Controllers\ProdutoControllerComerce');
//Route::get('/filtro-e-comerce', [App\Http\Controllers\ProdutoControllerComerce::class, 'show']);
Route::post('/comerce-show-produto', [App\Http\Controllers\ProdutoControllerComerce::class, 'show']);
//-------------------------------------------------------------------------------------------------
// Rota do venda no site 
//-------------------------------------------------------------------------------------------------
//Marca
Route::middleware('auth')->resource('/marca', 'App\Http\Controllers\MarcaController');
//Categoria
Route::middleware('auth')->resource('/categoria', 'App\Http\Controllers\CategoriaController');
Route::middleware('auth')->resource('/categoria-edit', 'App\Http\Controllers\CategoriaController');
//fornecedor
Route::middleware('auth')->resource('/fornecedor', 'App\Http\Controllers\FornecedorController');

//produto
Route::middleware('auth')->resource('/produto', 'App\Http\Controllers\ProdutoController');
//equipamento
Route::middleware('auth')->resource('/equipamento', 'App\Http\Controllers\EquipamentoController');

//ordem de serviço
Route::middleware('auth')->resource('/ordem-servico', 'App\Http\Controllers\OrdemServicoController');

//ordem de serviço rota de pesquisas
Route::middleware('auth')->post('/filtro-os', [App\Http\Controllers\OrdemServicoController::class, 'index']);

//ordem de produção

Route::middleware('auth')->resource('/ordem-producao', 'App\Http\Controllers\OrdemProducaoController');

//entrada de produto
Route::middleware('auth')->resource('/entrada-produto', 'App\Http\Controllers\EntradaProdutoController');

Route::middleware('auth')->get(
    'produto_fornecedor/create',
    'App\Http\Controllers\ProdutoFornecedorController@create'
)->name('produto-fornecedor.create');

//produto-fornecedor
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
//busca o horimetro inicial de Ordem de produção via ajax
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
//busca empresas
Route::middleware('auth')->post('/Empresas-filtro', [App\Http\Controllers\EmpresasController::class, 'index']);
Route::middleware('auth')->resource('/empresas', 'App\Http\Controllers\EmpresasController');
//Filtro Produtos
Route::middleware('auth')->post('/Produtos-filtro', [App\Http\Controllers\ProdutoController::class, 'index']);
//Rota saida de produtos
Route::middleware('auth')->resource('/Saida-produto', 'App\Http\Controllers\SaidaProdutoController');
Route::middleware('auth')->resource('/mostra-produto', 'App\Http\Controllers\SaidaProdutoController');
//Rota estoque de produtos
Route::middleware('auth')->resource('/Estoque-produto', 'App\Http\Controllers\EstoqueProdutoController');
//Rota filtro estoque de produtos
Route::middleware('auth')->post('/Estoque-Produtos-filtro', [App\Http\Controllers\EstoqueProdutoController::class, 'index']);
//Rota pecas equipamentos
Route::middleware('auth')->resource('/Peca-equipamento', 'App\Http\Controllers\PecaEquipamentoController');
//--
Route::middleware('auth')->post('/peca-equpamento-filtro', [App\Http\Controllers\PecaEquipamentoController::class, 'index']);

use App\Http\Controllers\PecaEquipamentoController;
use App\Models\PedidoCompraLista;

Route::middleware(['auth'])->get('/peca-equipamento-editar/{peca_equipamento_id}', [PecaEquipamentoController::class, 'edit'])->name('Peca-equipamento-editar.edit');
Route::middleware(['auth'])->put('/peca-equipamento/{pecas_equipamento}', [PecaEquipamentoController::class, 'update'])->name('Peca-equipamento.update');

//Rota pedidos de compra
Route::middleware('auth')->resource('/pedido-compra', 'App\Http\Controllers\PedidoCompraController');
//Rota filtro pedido de entrada
Route::middleware('auth')->post('/Ent-Produtos-filtro', [App\Http\Controllers\EntradaProdutoController::class, 'index']);
//Rota control panel
Route::middleware('auth')->resource('/control-panel', 'App\Http\Controllers\ControlPanelController');
//Rota Busca produto para dicionar item a pedidos
Route::middleware('auth')->resource('/item-produto', 'App\Http\Controllers\ItemProdutoController');
//Filtro Produtos item
Route::middleware('auth')->post('/item-produto-filtro', [App\Http\Controllers\ItemProdutoController::class, 'index']);
//rota qrcode
///Route::get('qrcode', function () {
///return QrCode::size(300)->generate('A basic example of QR code!');//https://morioh.com/p/5f7b3d064fb9----https://techvblogs.com/blog/generate-qr-code-laravel-8
///});
///Route::get('qrcode-with-color', function () {
/// return \QrCode::size(300)
/// ->backgroundColor(255,55,0)
///  ->generate('A simple example of QR code');
///});

//Rotas pedidos de saida--------------------------------------------------------------------------
Route::middleware('auth')->resource('/pedido-saida', 'App\Http\Controllers\PedidosSaidaController');
//Rota pedidos de saida
Route::middleware('auth')->resource('/pedido-saida-lista', 'App\Http\Controllers\PedidoSaidaListaController');
Route::middleware('auth')->post('/pedido-saida-filtro', [App\Http\Controllers\PedidosSaidaController::class, 'index']);
Route::middleware('auth')->resource('/item-produto-saida', 'App\Http\Controllers\ItemSaidaProdutoController');
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
//Route::delete('/item/{id}', [PedidoCompraLista::class, 'destroy'])->name('item.destroy');
Route::delete('/pedido-compra-lista/{id}', [PedidoCompraListaController::class, 'destroy'])->name('pedido-compra-lista.destroy');
