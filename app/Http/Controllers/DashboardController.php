<?php

namespace App\Http\Controllers;

use App\Models\Cotacao;
use App\Models\Fornecedor;
use App\Models\PedidosAlmox;
use App\Models\PedidosAlmoxProduto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

  public function index(Request $request)
  {
    // Resgata pedidos com alguma associação de Fonecedor
    $pedidosCotados = Cotacao::distinct('pedidosalmox_id')->pluck('pedidosalmox_id')->toarray();

    $ativos = PedidosAlmox::whereNull('data_aprovacao')->whereIn('id', $pedidosCotados)->get();
    
    // Gera quantitativo - novos (sem fornecedores associados)
    $pedidosNovos = PedidosAlmox::whereNull('finalizado')->whereNotIn('id', $pedidosCotados)->get();
    $pedidos['semsolicitacao'] = $pedidosNovos->count();

    // Gera quantitativo - não enviados
    $pedidos['semenvio'] = $ativos->whereNotNull('data_solicitacao')->whereNull('data_envio_cotacao')->count();
    
    // Gera quantitativo - não aprovados
    $pedidos['semaprovacao'] = $ativos->whereNotNull('data_solicitacao')->whereNotNull('data_envio_cotacao')->whereNull('data_aprovacao')->count();
    
    // Calcula os pedidos atrasados
    $calculaatraso = PedidosAlmox::whereNotNull('data_envio_cotacao')->whereIn('id', $pedidosCotados)
                                 ->whereNotNull('dias_retorno')->get();

    $atrasado = [];
    foreach ($calculaatraso as $calcula)
    {
      $data = Carbon::parse($calcula->data_envio_cotacao)->addDays($calcula->dias_retorno);
      
      if ($data < now())
        $atrasado[] = $calcula; 
    }

    $pedidos['atrasados'] = count($atrasado);

    if (!is_null($request->numeropedido) && $request->numeropedido <> '' )
    {
      $dados = PedidosAlmox::where('numero_pedido', 'like', '%' . $request->numeropedido . '%')->get();
    }
    else
    {
      if ($request->tipo == 'semsolicitacao')
        $dados = $pedidosNovos;
      elseif ($request->tipo == 'naoenviado')
        $dados = $ativos->whereNotNull('data_solicitacao')->whereNull('data_envio_cotacao');
      elseif ($request->tipo == 'semaprovacao')
        $dados = $ativos->whereNotNull('data_solicitacao')->whereNotNull('data_envio_cotacao')->whereNull('data_aprovacao');
      elseif ($request->tipo == 'atrasado')
        $dados = $atrasado;
      else
        $dados = $pedidosNovos;
    }

    return view('dashboard')->with('pedidos', $pedidos)->with('dados', $dados);
  }

  public function timeline(Request $request)
  {
    $pedido = PedidosAlmox::find($request->pedido_id);

    $itens = PedidosAlmoxProduto::where('pedidosalmox_id', $request->pedido_id)->get();

    $fornecedores = Cotacao::select('cotacaos.fornecedor_id', 'fornecedors.nome')
                           ->join('fornecedors', 'cotacaos.fornecedor_id', 'fornecedors.id') 
                           ->where('pedidosalmox_id', $request->pedido_id)->distinct()->get()->count(); 
    
    $precos = Cotacao::select('fornecedor_id', 'dias_envio', 'preco_un', 'frete', 'desconto')
                     ->where('pedidosalmox_id', $request->pedido_id)->distinct()->get();

    if (count($precos) == 0)
      $preco['semprodutos'] = 1;
    else
      $preco['semprodutos'] = 0;

    $preco['sempreco'] = $precos->whereNull('dias_envio')->whereNull('preco_un')->whereNull('frete')->whereNull('desconto')->count();

    return view('timeline')->with('pedido', $pedido)
                           ->with('itens', $itens)
                           ->with('fornecedores', $fornecedores)
                           ->with('preco', $preco);
  }
}
