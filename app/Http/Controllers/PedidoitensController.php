<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\PedidoProduto;
use App\Models\PedidoSeparacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoitensController extends Controller
{

  public function index(Request $request)
    {
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');
      
      $pedido = Pedido::find($request->id);

      return view('pedidoopcoes')->with('pedido', $pedido);
    }

    public function pesquisaitem(Request $request)
    {
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');

      $item = PedidoProduto::select('pedidoprodutos.id', 'pedidoprodutos.pedido_id', 'produtos.descricao', 'pedidoprodutos.qtde', 'pedidoprodutos.qtdeconferida',
                                    'pedidoprodutos.conferido', 'pedidoprodutos.updated_at')
                ->join('produtos', 'produtos.id', 'pedidoprodutos.produto_id')
                ->where('produtos.codigo', $request->codigo)
                ->where('pedidoprodutos.pedido_id', $request->pedido_id)->first();

    if (is_null($item))
        return redirect()->route('pedidoitens.itens', ['id' => $request->pedido_id]);
    
    return view('pedidoqtde')->with('item', $item);
    }

    public function itens(Request $request)
    {
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');

      $pedidoItens = PedidoProduto::select('pedidoprodutos.id', 'pedidoprodutos.pedido_id', 'produtos.descricao', 'pedidoprodutos.qtde', 'pedidoprodutos.qtdeconferida',
                                           'pedidos.numero', 'produtos.codigo', 'produtos.rua', 'pedidoprodutos.conferido', 'pedidos.qtde as qtdetotal',
                                           'pedidos.conferido as conferidototal', 'produtos.codigosap', 'produtos.codigorua')
                    ->join('pedidos', 'pedidos.id', 'pedidoprodutos.pedido_id')
                    ->join('produtos', 'produtos.id', 'pedidoprodutos.produto_id')
                    ->where('pedido_id', $request->id)
                    ->orderBy('pedidoprodutos.conferido')->get();

      return view('pedidoitens')->with('itens', $pedidoItens);
    }

    public function qtde(Request $request)
    {
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');

      // Inicia processo de separação
      $verificaInicio = PedidoSeparacao::where('pedido_id', $request->id)->first();

      if (is_null($verificaInicio))
      {
        $inicio = ['pedido_id'=>$request->id, 'inicio_separacao'=>now(), 'user_separacao'=>Auth::user()->id];
        PedidoSeparacao::create($inicio);
      }

      // Resgata item
      $item = PedidoProduto::proximoItem($request->id, $request->flag, $request->posicao);
      $pedidoitens = PedidoProduto::where('pedido_id', $request->id)->get();

      if (isset($item))
        return view('pedidoqtde')->with('item', $item)->with('pedidoitens', $pedidoitens);
      else
        return redirect('pedidos');
    }

    public function qtdemanual(Request $request)
    {
      // Resgata dados do item
      $item = PedidoProduto::select('pedidoprodutos.id', 'produtos.descricao', 'pedidoprodutos.qtde', 'pedidoprodutos.qtdeconferida',
                                    'pedidoprodutos.conferido', 'pedidoprodutos.updated_at','produtos.rua', 'pedidoprodutos.pedido_id', 'produtos.codigo',
                                    'produtos.codigosap', 'produtos.codigorua', 'pedidoprodutos.ordem')
                ->join('produtos', 'produtos.id', 'pedidoprodutos.produto_id')
                ->where('pedidoprodutos.id', $request->item_id)->first();

      return view('qtdemanual')->with('item', $item);
    }

     public function navegarItem(Request $request)
    {
      // Resgata item
      $item = PedidoProduto::proximoItem($request->id, $request->flag, $request->posicao);
      $pedidoitens = PedidoProduto::where('pedido_id', $request->id)->get();

      if (isset($item))
        return view('pedidoqtde')->with('item', $item)->with('pedidoitens', $pedidoitens);
      else
        return redirect('pedidos');
    }
}
