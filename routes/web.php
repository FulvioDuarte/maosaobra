<?php

use App\Http\Controllers\CotacaoAlmoxController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ParametrosController;
use App\Http\Controllers\PedidoitensController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ProdutosAlmoxController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\RamosController;
use App\Http\Controllers\SalaControleController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\EtiquetaController;
use App\Http\Controllers\ConfigController;
use Illuminate\Support\Facades\Route;


Route::get("/", [WelcomeController::class, 'index'])->name('welcome');
Route::post("/", [WelcomeController::class, 'store']);

Route::get("salacontrole", [SalaControleController::class, 'index'])->name('salacontrole');
    
Route::get("configpainel/{desc}", [ConfigController::class, 'configpainel'])->name('configpainel');

Route::middleware(['auth'])->group(function () {
    Route::get("menuprincipal", [MenuController::class, 'menuprincipal'])->name('menuprincipal');
    
    Route::get("menu", [MenuController::class, 'index'])->name('menu.index');
    
    Route::get("cadastrarproduto", [ProdutosController::class, 'index'])->name('cadastrarproduto');
    Route::get("produtos", [ProdutosController::class, 'index'])->name('produtos.index');
    Route::get("limpar", [ProdutosController::class, 'limpar'])->name('limpar');
    Route::post("pesquisaSAP", [ProdutosController::class, 'pesquisaSAP'])->name('pesquisaSAP');
    Route::get("pesquisa", [ProdutosController::class, 'pesquisa'])->name('pesquisa');
    Route::post("pesquisa", [ProdutosController::class, 'pesquisa'])->name('produtos.pesquisa');
    Route::get("alterar/{id}", [ProdutosController::class, 'alterar'])->name('alterar');
    Route::post("atualizar", [ProdutosController::class, 'atualizar'])->name('atualizar');
    
    Route::get("pedidosenviar", [ProdutosController::class, 'pedidosenviar'])->name('pedidosenviar');
    Route::post("pedidosenviar", [ProdutosController::class, 'pedidosenviar'])->name('pedidosenviar');
    
    Route::get("pedidos", [PedidosController::class, 'index'])->name('pedidos.index');
    Route::get("reiniciar", [PedidosController::class, 'reiniciar'])->name('reiniciar');
    Route::post("pesquisarpedido", [PedidosController::class, 'pesquisarpedido'])->name('pesquisarpedido');
    Route::get("finalizar/{id}", [PedidosController::class, 'finalizar'])->name('finalizar');
    Route::post("confirmarqtde", [PedidosController::class, 'confirmarqtde'])->name('confirmarqtde');
    Route::get("excluir/{id}", [PedidosController::class, 'excluir'])->name('excluir');
    Route::get("reativar/{id}", [PedidosController::class, 'reativar'])->name('reativar');
    Route::get("visualizar/{id}", [PedidosController::class, 'visualizar'])->name('visualizar');
    
    Route::get("pedidoassociar", [ParametrosController::class, 'index'])->name('pedidoassociar');
    Route::post("pedidoassociar", [ParametrosController::class, 'index'])->name('pedidoassociar');
    Route::post("gravarassociacao", [ParametrosController::class, 'gravarassociacao'])->name('gravarassociacao');
    Route::get("pedidorelatorio", [ParametrosController::class, 'pedidorelatorio'])->name('pedidorelatorio');
    Route::post("pedidorelatorio", [ParametrosController::class, 'pedidorelatorio'])->name('pedidorelatorio');
    
    Route::get("enviar", [PedidosController::class, 'enviar'])->name('enviar');
    Route::post("enviaremail", [PedidosController::class, 'enviaremail'])->name('enviaremail');
    
    Route::get("pedidoopcoes/{id}", [PedidoitensController::class, 'index'])->name('pedidoopcoes.index');
    Route::get("pedidoitens/{id}", [PedidoitensController::class, 'itens'])->name('pedidoitens.itens');
    Route::post("pesquisaitem", [PedidoitensController::class, 'pesquisaitem'])->name('pesquisaitem');
    
    Route::post("pedidoqtde/{id}", [PedidoitensController::class, 'qtde'])->name('pedidoqtde.qtde');
    
    Route::post("qtdemanual/{item_id}", [PedidoitensController::class, 'qtdemanual'])->name('qtdemanual');
    Route::post("navegaritem", [PedidoitensController::class, 'navegaritem'])->name('navegaritem');
        
    // GESTÃO DE COMPRAS
    Route::get("ramos", [RamosController::class, 'index'])->name('ramos');
    Route::post("pesquisaramo", [RamosController::class, 'pesquisar'])->name('pesquisaramo');
    Route::post("salvaramo", [RamosController::class, 'salvar'])->name('salvaramo');
    Route::get("criaramo", [RamosController::class, 'criar'])->name('criaramo');
    Route::post("gravaramo", [RamosController::class, 'gravar'])->name('gravaramo');
    Route::post("editaramo", [RamosController::class, 'editar'])->name('editaramo');
    Route::post("excluiramo", [RamosController::class, 'excluir'])->name('excluiramo');
    
    Route::get("fornecedor", [FornecedorController::class, 'index'])->name('fornecedor');
    Route::post("pesquisafornecedor", [FornecedorController::class, 'pesquisar'])->name('pesquisafornecedor');
    Route::get("criafornecedor", [FornecedorController::class, 'criar'])->name('criafornecedor');
    Route::post("editafornecedor", [FornecedorController::class, 'editar'])->name('editafornecedor');
    Route::post("salvafornecedor", [FornecedorController::class, 'salvar'])->name('salvafornecedor');
    Route::post("gravafornecedor", [FornecedorController::class, 'gravar'])->name('gravafornecedor');
    Route::post("excluifornecedor", [FornecedorController::class, 'excluir'])->name('excluifornecedor');
    
    Route::get("produtoalmox", [ProdutosAlmoxController::class, 'index'])->name('produtoalmox');
    Route::post("pesquisaprodutoalmox", [ProdutosAlmoxController::class, 'pesquisar'])->name('pesquisaprodutoalmox');
    Route::get("editaprodutoalmox", [ProdutosAlmoxController::class, 'editar'])->name('editaprodutoalmox');
    Route::post("editaprodutoalmox", [ProdutosAlmoxController::class, 'editar'])->name('editaprodutoalmox');
    Route::post("salvaprodutoalmox", [ProdutosAlmoxController::class, 'salvar'])->name('salvaprodutoalmox');
    Route::post("excluiprodutoalmox", [ProdutosAlmoxController::class, 'excluir'])->name('excluiprodutoalmox');
    Route::get("criaprodutoalmox", [ProdutosAlmoxController::class, 'criar'])->name('criaprodutoalmox');
    Route::post("gravaprodutoalmox", [ProdutosAlmoxController::class, 'gravar'])->name('gravaprodutoalmox');
    
    Route::get("cotacaoalmox", [CotacaoAlmoxController::class, 'index'])->name('cotacaoalmox');
    Route::post("cotacaoalmox", [CotacaoAlmoxController::class, 'index'])->name('cotacaoalmox');
    Route::get("visualizacotacaoalmox", [CotacaoAlmoxController::class, 'visualizar'])->name('visualizacotacaoalmox');
    Route::post("visualizacotacaoalmox", [CotacaoAlmoxController::class, 'visualizar'])->name('visualizacotacaoalmox');
    Route::get("criacotacaoalmox", [CotacaoAlmoxController::class, 'criar'])->name('criacotacaoalmox');
    Route::post("gravacotacaoalmox", [CotacaoAlmoxController::class, 'gravar'])->name('gravacotacaoalmox');
    Route::post("salvacotacaoalmox", [CotacaoAlmoxController::class, 'salvar'])->name('salvacotacaoalmox');
    Route::post("editacotacaoalmox", [CotacaoAlmoxController::class, 'editar'])->name('editacotacaoalmox');
    Route::post("excluicotacaoalmox", [CotacaoAlmoxController::class, 'excluir'])->name('excluicotacaoalmox');
    Route::get("cotacaoitemcriar", [CotacaoAlmoxController::class, 'criaritem'])->name('cotacaoitemcriar');
    
    Route::get("dashboard", [DashboardController::class, 'index'])->name('dashboard');
    Route::post("dashboard", [DashboardController::class, 'index'])->name('dashboard');
    Route::get("timeline/{pedido_id}", [DashboardController::class, 'timeline'])->name('timeline');
    
    Route::post("visualizacotacaofornec/{pedido_id}", [CotacaoAlmoxController::class, 'visualizarcotacaofornec'])->name('visualizacotacaofornec');
    Route::get("visualizacotacaofornec/{pedido_id}", [CotacaoAlmoxController::class, 'visualizarcotacaofornec'])->name('visualizacotacaofornec');
    Route::post("gravadataspedido/{pedido_id}", [CotacaoAlmoxController::class, 'gravadataspedido'])->name('gravadataspedido');
    Route::get("finalizapedido/{pedido_id}", [CotacaoAlmoxController::class, 'finalizapedido'])->name('finalizapedido');
    Route::get("aprovapedido/{pedido_id}", [CotacaoAlmoxController::class, 'aprovapedido'])->name('aprovapedido');
    Route::post("gravafinalizado", [CotacaoAlmoxController::class, 'gravafinalizado'])->name('gravafinalizado');
    Route::post("gravaaprovado", [CotacaoAlmoxController::class, 'gravaaprovado'])->name('gravaaprovado');
    
    Route::post("solicitarcotacaofornec", [CotacaoAlmoxController::class, 'solicitarcotacaofornec'])->name('solicitarcotacaofornec');
    
    Route::get("criaitem/{pedido_id}", [CotacaoAlmoxController::class, 'criaritem'])->name('criaitem');
    Route::post("gravaitem", [CotacaoAlmoxController::class, 'gravaritem'])->name('gravaitem');
    Route::post("excluiitem", [CotacaoAlmoxController::class, 'excluiritem'])->name('excluiitem');
    Route::get("acrescentarfornecedor/{pedido_id}", [CotacaoAlmoxController::class, 'acrescentarfornecedor'])->name('acrescentarfornecedor');
    Route::post("gravarcotacaofornec", [CotacaoAlmoxController::class, 'gravarcotacaofornec'])->name('gravarcotacaofornec');
    Route::post("excluircotacaofornec/{pedido_id}", [CotacaoAlmoxController::class, 'excluircotacaofornec'])->name('excluircotacaofornec');
    Route::post("editarcotacaofornec/{pedido_id}", [CotacaoAlmoxController::class, 'editarcotacaofornec'])->name('editarcotacaofornec');
    Route::post("salvarcotacaofornec", [CotacaoAlmoxController::class, 'salvarcotacaofornec'])->name('salvarcotacaofornec');
    
    Route::get("cotacaoimprimir/{pedido_id}", [CotacaoAlmoxController::class, 'cotacaoimprimir'])->name('cotacaoimprimir');
    
    Route::get("pulmao", [ProdutosController::class, 'pesquisapulmao'])->name('pulmao');
    Route::post("pulmao", [ProdutosController::class, 'pesquisapulmao'])->name('pulmao');
    Route::post("criaconferencia", [ProdutosController::class, 'criaconferencia'])->name('criaconferencia');
    Route::get("conferidos/{id}", [ProdutosController::class, 'conferidos'])->name('conferidos');
    Route::post("gravaconferido", [ProdutosController::class, 'gravaconferido'])->name('gravaconferido');
    Route::get("conferencias", [ProdutosController::class, 'conferencias'])->name('conferencias');

    // SAP
    Route::post("migrarpesquisa", [PedidosController::class, 'pesquisaPedidoSap'])->name('migrarpesquisa');
    Route::post("migrar", [PedidosController::class, 'migraPedidoSap'])->name('migrar');

    // ETIQUETAS
    Route::post('imprimir', [EtiquetaController::class, 'imprimir'])->name('imprimir');
    Route::post('imprimirpulmao', [EtiquetaController::class, 'imprimirpulmao'])->name('imprimirpulmao');

});


