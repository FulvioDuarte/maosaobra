<?php

namespace App\Http\Controllers;

use App\Events\ControlaPedidos;
use App\Events\UserAssociado;
use App\Mail\NotificacaoUsuario;
use App\Models\Pedido;
use App\Models\PedidoProduto;
use App\Models\PedidosAgrupados;
use App\Models\PedidoSeparacao;
use App\Models\Produto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class PedidosController extends Controller
{

    public function index()
    {
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');

      $pedidos = Pedido::carregapedidos();
          
      return view('pedidos')->with('pedidos', $pedidos);
    }

    public function pesquisarpedido(Request $request)
    {
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');

      $pedidos = Pedido::pesquisapedidos($request->numeropedido);

      return view('pedidos')->with('pedidos', $pedidos);
    }

    public function finalizar(Request $request)
    {
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');
    
      Pedido::where('id', $request->id)->update(['finalizado'=>2, 'datafinalizado'=>now(), 'user_id'=>Auth::user()->id, 'finalizado_parcial'=>1]);

      // Finaliza Separação
      PedidoSeparacao::where('pedido_id', $request->id)->update(['fim_separacao'=>now(), 'user_separacao'=>Auth::user()->id]);

      return redirect('pedidos');
    }

      public function reiniciar(Request $request)
    {
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');

      // Reinicia os itens
      PedidoProduto::where('pedido_id',$request->id)->update(['user_id'=>Auth::user()->id, 'qtdeconferida'=>0, 'conferido'=>0]);
      
      // Reinicia o pedido
      Pedido::where('id',$request->id)->update(['user_id'=>Auth::user()->id, 'conferido'=>0, 'finalizado'=>0, 'datafinalizado'=>null, 'finalizado_parcial'=>null]);

      // Reinicia processo de separação
      PedidoSeparacao::where('pedido_id', $request->id)->delete();

      $inicio = ['pedido_id'=>$request->id, 'inicio_separacao'=>now(), 'user_separacao'=>Auth::user()->id];
      PedidoSeparacao::create($inicio);
      
      // EVENTO
      $dados = Pedido::ControlaPedidos();
      event(new ControlaPedidos($dados));

      // EVENTO
      $dados = User::UserAssociados();
      event(new UserAssociado($dados->toArray()));

      // Resgata item
      $item = PedidoProduto::proximoItem($request->id, 'next', null);
      $pedidoitens = PedidoProduto::where('pedido_id', $request->id)->get();

      return view('pedidoqtde')->with('item', $item)->with('pedidoitens', $pedidoitens);
    }

    public function confirmarqtde(Request $request)
    {      
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');
              
      // Regsta o item a ser atualizado
      $item = PedidoProduto::find($request->id);

      // Verifica se quantidade foi total ou parcial
      if ($item->qtde == $request->quantidade_bipada)
        // Total
        PedidoProduto::where('id',$request->id)->update(['conferido'=>2, 'user_id'=>Auth::user()->id, 'qtdeconferida'=>$request->quantidade_bipada]);
      else
        //Parcial
        PedidoProduto::where('id',$request->id)->update(['conferido'=>1, 'user_id'=>Auth::user()->id, 'qtdeconferida'=>$request->quantidade_bipada]);
      
      // Resgata os itens atualizados e conta
      $itensConferidos = PedidoProduto::where('pedido_id',$item->pedido_id)->whereIn('conferido', [1,2])->count();

      // Atualiza a quantidade de itens conferidos
      Pedido::where('id',$item->pedido_id)->update(['conferido'=>$itensConferidos, 'finalizado'=>1, 'user_id'=>Auth::user()->id]);

      //Resgata o Pedido
      $pedido = Pedido::find($item->pedido_id);

      // EVENTO
      $dados = Pedido::ControlaPedidos();
      event(new ControlaPedidos($dados));

      // Verifica se Pedido está todo conferido
      if ($pedido->qtde == $pedido->conferido)
      {
        Pedido::where('id',$item->pedido_id)->update(['finalizado'=>2, 'datafinalizado'=>now(), 'user_id'=>Auth::user()->id]);
        
        // Finaliza processo de Separação
        PedidoSeparacao::where('pedido_id', $item->pedido_id)->update(['fim_separacao'=>now(), 'user_separacao'=>Auth::user()->id]);

        // Flag de pedido finalizado, mas com itens faltantes - finalizado parcial
        $finalizadoParcial = PedidoProduto::where('pedido_id', $item->pedido_id)->get();

        if ($finalizadoParcial->sum('qtde') <> $finalizadoParcial->sum('qtdeconferida'))
          Pedido::where('id', $item->pedido_id)->update(['finalizado_parcial' => 1 ]);

        $pedidos = Pedido::carregapedidos();

        // EVENTO
        $dados = Pedido::ControlaPedidos();
        event(new ControlaPedidos($dados));

        // EVENTO
        $dados = User::UserAssociados();
        event(new UserAssociado($dados->toArray()));

        return view('pedidos')->with('pedidos', $pedidos)->with('mensagem', 'PEDIDO CONFERIDO');
      }
      else
      {
        // Resgata item
        $resgataItem = PedidoProduto::proximoItem($item->pedido_id, $request->flag, $request->posicao);
        $pedidoitens = PedidoProduto::where('pedido_id', $item->pedido_id)->get();

        return view('pedidoqtde')->with('item', $resgataItem)->with('pedidoitens', $pedidoitens);
      }
    }

    public function enviar(Request $request)
    {
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');
      
      $pedido = Pedido::find($request->id);

      return view('enviar')->with('pedido', $pedido);
    }

    public function enviaremail(Request $request)
    {
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');

      $pedido = Pedido::find($request->pedido_id);
      
      $itens = PedidoProduto::select('produtos.codigo', 'produtos.descricao', 'produtos.rua', 'pedidoprodutos.qtde')
               ->join('produtos', 'produtos.id', 'pedidoprodutos.produto_id')    
               ->where('pedido_id', $request->pedido_id)->get();

      $dados = [
        'numeropedido' => $pedido->numero,
        'email' => $request->email,
        'itens' => $itens,
    ];

    Mail::to($request->email)->send(new NotificacaoUsuario($dados));
    
    $pedidos = [];

    return view('pedidosenviar')->with('pedidos', $pedidos)->with('msg', 'Email enviado com sucesso');
    }

    public function excluir ($id)
    {
      // Verifica se usuário é Admin
      if (Auth::user()->admin <> 1)
        return redirect()->route('welcome');

      // Zera conferencia dos itens do pedido
      PedidoProduto::where('pedido_id', $id)->update(['qtdeconferida' => 0, 'conferido' => 0]);
      PedidoProduto::where('pedido_id', $id)->delete();
      
      // Zera conferencia do pedido
      Pedido::where('id', $id)->update(['conferido' => 0, 'finalizado' => 0, 'user_associado' => null]);
      Pedido::where('id', $id)->delete();
  
      // Exclui pedidos associados, caso exista
      PedidosAgrupados::where('pedido_id', $id)->delete();

      // EVENTO
      $dados = Pedido::ControlaPedidos();
      event(new ControlaPedidos($dados));

      // EVENTO
      $dados = User::UserAssociados();
      event(new UserAssociado($dados->toArray()));

      return redirect(route('pedidoassociar'));
    }

    public function visualizar ($id)
    {
      $dadosPedido = PedidoProduto::select('pedidoprodutos.*', 'pedidos.numero', 'produtos.codigosap', 'produtos.unidade', 'produtos.unidade1',
                                           'produtos.codigorua', 'produtos.descricao', 'pedidos.solicitante', 'pedidoprodutos.qtde')
                           ->join('pedidos', 'pedidoprodutos.pedido_id', 'pedidos.id')
                           ->join('produtos', 'pedidoprodutos.produto_id', 'produtos.id')
                           ->where('pedidos.id', $id)->get();
                       
      if(count($dadosPedido)>0)
        return view('pedidovisualizar')->with('dados', $dadosPedido);
      else
        return redirect('pedidoassociar')->with('msg', 'Nenhum produto encontrado no Pedido');
    }

    public function reativar ($id)
    {
      // Verifica se usuário é Admin
      if (Auth::user()->admin <> 1)
        return redirect()->route('welcome');
 
      Pedido::withTrashed()->where('id', $id)->restore();
      PedidoProduto::withTrashed()->where('pedido_id', $id)->restore();
  
      // EVENTO
      $dados = Pedido::ControlaPedidos();
      event(new ControlaPedidos($dados));

      // EVENTO
      $dados = User::UserAssociados();
      event(new UserAssociado($dados->toArray()));

      return redirect(route('pedidoassociar'));
    }

    public function pesquisaPedidoSap(Request $request)
    {
      $duplicados = [];

      $numeros = Pedido::stringPedidos($request->numeromigrar);

      // Verifica se pedidos já foram migrados
      if (Pedido::verificaPedidosMigrado($numeros))
        return redirect('pedidoassociar')->with('msg', 'Atenção: Pedido(s) já migrado(s).');

      // Verifica se pedido será agrupado
      if (strpos($request->numeromigrar, ',') !== false) 
      {
         // SAP
        $dados = Pedido::PedidosSAP($numeros);
        // Itens duplicados
        if (count($dados) > 0 )
          $duplicados = Pedido::itensDuplicados($dados);
      } 
      // Migração simples
      else 
        // SAP
        $dados = Pedido::PedidoSAP($request->numeromigrar);
  
      return view('pedidomigrar')->with('dados', $dados)->with('duplicados', $duplicados)->with('numeropedido', implode(',', $numeros));
    }

    public function migraPedidoSap(Request $request)
    {
      $numeros = [];

      // Verifica se pedido serão agrupados
      if (strpos($request->numero_pedido, ',') !== false) 
      {
        $numeros = Pedido::stringPedidos($request->numero_pedido);
        $dados = Pedido::PedidosSAP($numeros);
        $resultados = Pedido::itensDuplicados($dados);

        $numeroPedido = implode(',', $numeros);
      }
      else
      {
        $resultados = Pedido::PedidoSAP($request->numero_pedido);

        $numeroPedido = $request->numero_pedido;
      }

      // Migra pedido(s)
      if (count($resultados) > 0) 
      {
        // Calcula quantidade de itens ATIVOS e NÃO CONCLUÍDOS
        $qtdeItens = collect($resultados)->where('XLOEK', '<>', 'X')->where('KZEAR', '<>', 'X')->count();
  
        // Grava PEDIDO
        $pedido = [
            'solicitante'=>$resultados[0]['USNAM'],
            'qtde'=>$qtdeItens,
            'numero'=>$numeroPedido
          ];
        
        $resgataPedido = Pedido::create($pedido);
 
        // ITENS
        foreach ($resultados as $ordem=>$item)
        {       
          //Verifica se produto já existe
          $verificaProduto = Produto::where('codigo', (int) $item['MATNR'])->first();

          // Grava produto
          if (is_null($verificaProduto))
          {
            $produto = [
                'codigosap'=>number_format($item['MATNR'], 0, ',', '.'),
                'rua'=>str_replace('.', '', $item['LGPBE']),
                'descricao'=>$item['MAKTX'],
                'user_id'=>Auth::user()->id,
                'unidade'=>$item['ERFME'],
                'unidade1'=>$item['MEINS'],
                'codigo'=> (int) $item['MATNR'],
                'codigorua'=>$item['LGPBE'],
            ];
            Produto::create($produto);
          }
            
          // Verifica se a RUA foi alterada e atualiza
          elseif ($verificaProduto->rua <> str_replace('.', '', $item['LGPBE']))
            Produto::where('codigo', (int) $item['MATNR'])->update(['rua'=>str_replace('.', '', $item['LGPBE']), 'codigorua'=>$item['LGPBE']]);
            
          // Verifica se as UNIDADES foram alteradas e atualiza
          elseif ($verificaProduto->unidade <> $item['ERFME'] || $verificaProduto->unidade1 <> $item['MEINS'])
            Produto::where('codigo', (int) $item['MATNR'])->update(['unidade'=>$item['ERFME'], 'unidade1'=>$item['MEINS']]);
            
          // Verifica se produto foi "substituído / excluído" e não pode estar "concluído"
          if ($item['XLOEK'] <> 'X' && $item['KZEAR'] <> 'X')
          {
            $resgataProduto = Produto::where('codigo', (int) $item['MATNR'])->first();

            // Associa Produto ao Pedido
            $pedidoProduto = [
                'pedido_id'=>$resgataPedido->id,
                'produto_id'=>$resgataProduto->id,
                'user_id'=>Auth::user()->id,
                'qtde'=>$item['ERFMG'],
                'checklist'=>$item['SCHGT'],
                'elm'=>$item['XLOEK'],
                'aprov'=>$item['XWAOK'],
                'concl'=>$item['KZEAR'],
                'datanec'=>$item['BDTER'],
                'cen'=>$item['WERKS'],
                'dep'=>$item['LGORT'],
                'criado'=>$item['USNAM'],
                'aprovador'=>$item['USUARIO'],
                'dataaprov'=>$item['DATA'],
                'horaprov'=>$item['HORA'],
                'ordem'=>$ordem,
            ];
            PedidoProduto::create($pedidoProduto);
          }
        }

        // Verifica se PEDIDO possui pelo menos um PRODUTO
        $verificaMigracao = PedidoProduto::where('pedido_id', $resgataPedido->id)->get()->count();

        if ($verificaMigracao == 0)
        {
          Pedido::where('id', $resgataPedido->id)->delete();
          return redirect('pedidoassociar')->with('msgWrn', 'Pedido(s) '. $numeroPedido . ' não migrado. Favor verificar se Pedido possui algum item ativo.');
        }
        else
        {
          // Grava pedidos agrupados para pesquisa
          foreach($numeros as $numero)
            PedidosAgrupados::create(['pedido_id'=>$resgataPedido->id, 'numero'=>$numero]);
        }

        // EVENTO
        $dados = Pedido::ControlaPedidos();
        event(new ControlaPedidos($dados));
      
        return redirect('pedidoassociar')->with('msg', 'O(s) Pedido(s) '. $numeroPedido . ' migrado com sucesso.');
      }
      else
        return redirect('pedidoassociar')->with('msgWrn', 'Pedido não migrado.Favor verificar se Pedido possui algum item ativo.');
    }
}
