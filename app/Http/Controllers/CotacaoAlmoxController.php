<?php

namespace App\Http\Controllers;

use App\Models\Cotacao;
use App\Models\Entrega;
use App\Models\Fornecedor;
use App\Models\PedidosAlmox;
use App\Models\PedidosAlmoxProduto;
use App\Models\ProdutoAlmox;
use App\Models\Ramo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\DateTimeExcel\Days;

class CotacaoAlmoxController extends Controller
{

  public function index(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');
    
      // Seta data inicio
      if (isset($request->datainicio) || !is_null($request->datainicio))
        $dataInicio = $request->datainicio;
      else
        $dataInicio = now()->addDays(-30)->format('Y-m-d 00:00:00');;

      // Seta data fim
      if (isset($request->datafim) || !is_null($request->datafim))
        $dataFim = $request->datafim;
      else
        $dataFim = now()->format('Y-m-d 23:59:59');;
     
      $pedidos = PedidosAlmox::query();
      
      // Filtra numero pedido
      if (!is_null($request->numeropedido))
        $pedidos = $pedidos->where('numero_pedido', 'like', '%' . $request->numeropedido . '%');

      // Filtra data inicio
      if (!is_null($dataInicio))
        $pedidos = $pedidos->where('data_solicitacao', '>=', $dataInicio);

        // Filtra data fim
      if (!is_null($dataFim))
        $pedidos = $pedidos->where('data_solicitacao', '<=', $dataFim);

      $pedidos = $pedidos->orderby('created_at', 'desc')->get();

      foreach ($pedidos as $pedido)
        $pedido['qtdeitens'] = PedidosAlmoxProduto::where('pedidosalmox_id', $pedido->id)->get()->count();

      // Quantidade de fornecedores na cotação
      foreach ($pedidos as $pedido)
        $pedido['qtdefornec'] = Cotacao::where('pedidosalmox_id', $pedido->id)->count();

      return view('cotacaoalmox')->with('pedidos', $pedidos)->with('dataInicio', $dataInicio)->with('dataFim', $dataFim);
    }

    public function finalizapedido (Request $request)
    {
      $pedido = PedidosAlmox::find($request->pedido_id);

      return view('cotacaoalmoxfinalizar')->with('pedido', $pedido);
    }

    public function aprovapedido (Request $request)
    {
      $pedido = PedidosAlmox::find($request->pedido_id);

      return view('cotacaoalmoxaprovar')->with('pedido', $pedido);
    }

    public function gravafinalizado (Request $request)
    {
      $request->validate([
          'documento' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
      ]);
  
      // Salva documento
      if ($request->hasFile('documento')) 
      {
        $nomeArquivo = time().'_'.$request->file('documento')->getClientOriginalName();
        $path = $request->file('documento')->storeAs('documentos', $nomeArquivo, 'public');
      }
       else
        $path = null;

      PedidosAlmox::where('id', $request->pedido_id)->update(['finalizado'=>1, 'documento_finalizado'=>$path]);
      return redirect('cotacaoalmox')->with('msg', 'Cotação finalizada com sucesso.');
    }

    public function gravaaprovado (Request $request)
    {
      $request->validate([
          'documento' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
      ]);
 
      // Salva documento
      if ($request->hasFile('documento')) 
      {
        $nomeArquivo = time().'_'.$request->file('documento')->getClientOriginalName();
        $path = $request->file('documento')->storeAs('documentos', $nomeArquivo, 'public');
      }
      else
        $path = null;

      PedidosAlmox::where('id', $request->pedido_id)->update(['documento_aprovado'=>$path, 'data_aprovacao'=>now()]);

      return redirect('cotacaoalmox')->with('msg', 'Cotação aprovada com sucesso.');
    }

    public function gravadataspedido (Request $request)
    {
      $pedido = PedidosAlmox::find($request->pedido_id);

      if  (!is_null($request->dataenvio)) 
      {
        if ($request->dataenvio < date_format($pedido->data_solicitacao, 'Y-m-d'))
          return redirect()->route('visualizacotacaofornec', ['pedido_id'=>$request->pedido_id])->with('msg', 'ATENÇÃO: Data do Envio não pode ser menor que a Data da Solicitação.');
      }

      PedidosAlmox::where('id', $request->pedido_id)
                  ->update(['data_envio_cotacao'=>$request->dataenvio,
                            'data_aprovacao'=>$request->dataaprovacao,
                            'dias_retorno'=>$request->diasretorno]);
      
      return redirect()->route('visualizacotacaofornec', ['pedido_id'=>$request->pedido_id])->with('msg', 'Dados gravados com sucesso.');
    }

    public function visualizarcotacaofornec (Request $request)
    {
      $cotacaofornec = Cotacao::select('fornecedors.id', 'fornecedors.nome', 'fornecedors.contato', 'fornecedors.telefone1', 'fornecedors.telefone2', 'fornecedors.email')
                              ->join('fornecedors', 'fornecedors.id', 'cotacaos.fornecedor_id') 
                              ->where('cotacaos.pedidosalmox_id', $request->pedido_id)->distinct()->get(); 

      $pedido = PedidosAlmox::find($request->pedido_id);

      $entregas = Entrega::orderBy('codigo')->get();

      return view('cotacaovisualizar')->with('pedido', $pedido)->with('cotacaofornec', $cotacaofornec)->with('entregas', $entregas);
    }

    public function salvarcotacaofornec (Request $request)
    {
      foreach ($request->dados as $dado)
        Cotacao::where('id', $dado['id'])->update(['dias_envio'=>str_replace(['.', ','], ['', '.'], $request->dias_envio ?? 0), 
                                                   'preco_un'=>str_replace(['.', ','], ['', '.'], $dado['preco_un']), 
                                                   'frete'=>str_replace(['.', ','], ['', '.'], $request->frete), 
                                                   'desconto'=>str_replace(['.', ','], ['', '.'], $request->desconto)]);

      $cotacao = Cotacao::find($request->dados[0]['id']);
      $pedido_id = $cotacao->pedidosalmox_id;

      return redirect()->route('visualizacotacaofornec', ['pedido_id'=>$pedido_id])->with('msg', 'Preços gravados com sucesso.');
    }

    public function editarcotacaofornec (Request $request)
    {
      $cotacaos = Cotacao::select('cotacaos.*', 'produtosalmox.descricao as nomeproduto')
                         ->join('produtosalmox', 'produtosalmox.id', 'cotacaos.produtosalmox_id')
                         ->where('fornecedor_id', $request->fornec_id)->where('pedidosalmox_id', $request->pedido_id)->get();

      $pedido = PedidosAlmox::find($request->pedido_id);

      return view('cotacaoeditar')->with('cotacaos', $cotacaos)->with('pedido', $pedido);
    }

    public function excluircotacaofornec (Request $request)
    {
      Cotacao::where('fornecedor_id', $request->fornec_id)->where('pedidosalmox_id', $request->pedido_id)->delete();

      $verifica = Cotacao::where('fornecedor_id', $request->fornec_id)->where('pedidosalmox_id', $request->pedido_id)->get()->count();

      // Reseta as datas, pois não tem nenhum fornecedor
      if ($verifica == 0)
        PedidosAlmox::where('id', $request->pedido_id)->update(['data_envio_cotacao'=>null, 'data_aprovacao'=>null, 'dias_retorno'=>null]);


      return redirect()->route('visualizacotacaofornec', ['pedido_id'=>$request->pedido_id])->with('msg', 'Fornecedor excluído com sucesso.');
    }

    public function gravarcotacaofornec (Request $request)
    {
      $produtos = PedidosAlmoxProduto::where('pedidosalmox_id', $request->pedido_id)->get();

      // Verifica a quantidade de fornecedores associados
      $verifica = Cotacao::where('pedidosalmox_id', $request->pedido_id)->get();

      //dd($verifica, $produtos, $request->fornecedores);
      if ((count($verifica)/count($produtos) + count($request->fornecedores)) > 3)
        return redirect()->route('acrescentarfornecedor', ['pedido_id'=>$request->pedido_id])->with('msg', 'ATENÇÃO: quantidade de associação máxima de 3 (três) fornecedores');
    
      // Acrescentar produtos para cotação nos fornecedores selecionados
      foreach ($produtos as $produto)
      {
        if (isset($request->fornecedores))
        {
          foreach ($request->fornecedores as $fornecedor)
          {
            $dados['pedidosalmox_produto_id'] = $produto->id;
            $dados['produtosalmox_id'] = $produto->produtosalmox_id;
            $dados['pedidosalmox_id'] = $produto->pedidosalmox_id;
            $dados['qtde'] = $produto->qtde;
            $dados['fornecedor_id'] = $fornecedor;
            Cotacao::create($dados);
          }  
        } 
      }

      return redirect()->route('visualizacotacaofornec', ['pedido_id'=>$request->pedido_id])->with('msg', 'Fornecedor associado com sucesso.');
    }

    public function acrescentarfornecedor (Request $request)
    {
      $cotacao = Cotacao::where('pedidosalmox_id', $request->pedido_id)->pluck('fornecedor_id')->toArray();

      $fornecedores = Fornecedor::select('fornecedors.*', 'ramos.descricao')
                                ->leftjoin('ramos', 'ramos.id', 'fornecedors.ramo_id')
                                ->whereNotin('fornecedors.id', $cotacao)
                                ->orderby('fornecedors.nome')->get();
      
      $pedido = PedidosAlmox::find($request->pedido_id);

      return view('acrescentarfornecedor')->with('fornecedores', $fornecedores)->with('pedido', $pedido);
    }
  
      public function visualizar(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      $items = PedidosAlmoxProduto::select('pedidosalmox_produtos.id', 'pedidosalmox_produtos.qtde','pedidosalmox_produtos.requisicao', 'produtosalmox.descricao', 'produtosalmox.unidade',   
                                           'produtosalmox.sap', 'pedidosalmox.numero_pedido', 'pedidosalmox.id as pedido_id')
                ->join('pedidosalmox', 'pedidosalmox.id', 'pedidosalmox_produtos.pedidosalmox_id')
                ->join('produtosalmox', 'produtosalmox.id', 'pedidosalmox_produtos.produtosalmox_id')
                ->where('pedidosalmox_id', $request->pedido_id)->get();

      $pedido = PedidosAlmox::find($request->pedido_id);

      return view('cotacaoalmoxvisualizar')->with('items', $items)->with('pedido', $pedido);
    }

    public function gravar(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      $dados['comprador'] = $request->comprador;
      $dados['solicitante'] = $request->solicitante;
      $dados['setor'] = $request->setor;
      $dados['datasolicitacao'] = $request->data_solicitacao;
      $dados['centro_custo'] = $request->centrocusto;
      $dados['ordem_servico'] = $request->ordemservico;
      $dados['telefone_ramal'] = $request->telefoneramal;
      $dados['requisicao'] = $request->requisicao;
      $dados['aprovacao'] = $request->aprovacao;
      $dados['numero_pedido'] = $request->pedido;
      $dados['data_solicitacao'] = now()->toDateTimeString();
 
      PedidosAlmox::create($dados);

      return redirect('cotacaoalmox')->with('msg', 'Pedido criado com sucesso.');
    }

    public function editar(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      $pedido = PedidosAlmox::find($request->pedido_id);

      return view('cotacaoalmoxeditar')->with('pedido', $pedido);
    }

    public function criar()
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      $ramos = Ramo::orderBy('descricao')->get();
      
      return view('cotacaoalmoxcriar')->with('ramos', $ramos);
    }

    public function salvar(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      PedidosAlmox::where('id',$request->pedido_id)
                ->update(['comprador'=>$request->comprador,
                          'solicitante'=>$request->solicitante,
                          'setor'=>$request->setor,
                          'data_solicitacao'=>$request->datasolicitacao,
                          'centro_custo'=>$request->centrocusto,
                          'ordem_servico'=>$request->ordemservico,
                          'telefone_ramal'=>$request->telefoneramal,
                          'requisicao'=>$request->requisicao,
                          'aprovacao'=>$request->aprovacao,
                          'numero_pedido'=>$request->pedido,
                        ]);

      return redirect('cotacaoalmox')->with('msg', 'Pedido atualizado com sucesso.');
    }

    public function criaritem(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      $pedido = PedidosAlmox::find($request->pedido_id);
      
      $fornecAssociado = Cotacao::where('pedidosalmox_id', $request->pedido_id)->count();
      
      // Resgata os produtos que já estão associados
      $produtosAssociados = PedidosAlmoxProduto::where('pedidosalmox_id', $request->pedido_id)->distinct()->pluck('produtosalmox_id');
    
      $produtos = ProdutoAlmox::whereNotIn('id', $produtosAssociados)->get();
      
      return view('itemcriar')->with('pedido', $pedido)->with('produtos', $produtos)->with('fornecAssociado', $fornecAssociado);
    }

    public function gravaritem(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      $dados['requisicao'] = $request->requisicao;
      $dados['qtde'] = $request->qtde;
      $dados['produtosalmox_id'] = $request->produto_id;
      $dados['pedidosalmox_id'] = $request->pedido_id;

      PedidosAlmoxProduto::create($dados);
      // Exclui fornecedores
      Cotacao::where('pedidosalmox_id', $request->pedido_id)->delete();

      return redirect()->route('criaitem', ['pedido_id' => $request->pedido_id])->with('msg', 'Item inserido com sucesso.');
    }

    public function excluiritem(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');
      
      $item = PedidosAlmoxProduto::find($request->item_id);
      $pedido = PedidosAlmox::find($item->pedidosalmox_id);
      
      PedidosAlmoxProduto::where('id', $request->item_id)->delete();
      // Exclui fornecedores
      Cotacao::where('pedidosalmox_id', $pedido->id)->delete();

      return redirect()->route('visualizacotacaoalmox', ['pedido_id' => $pedido->id])->with('msg', 'Item exlcuído com sucesso.');
    }

    public function solicitarcotacaofornec(Request $request)
    {
      // Grava dados do local de compra e entrega
      PedidosAlmox::where('id', $request->pedido_id)->update(['localcompra_id'=>$request->localcompra, 'localentrega_id'=>$request->localentrega]);
      
      $cabecalho = Entrega::find($request->localcompra);
      $localentrega = Entrega::find($request->localentrega);
      
      $items = Cotacao::select('produtosalmox.id', 'produtosalmox.descricao', 'produtosalmox.unidade', 'cotacaos.qtde')
                      ->join('produtosalmox', 'produtosalmox.id', 'cotacaos.produtosalmox_id')
                      ->where('pedidosalmox_id', $request->pedido_id)->get();

      $pedido = PedidosAlmox::find($request->pedido_id);

      return view('cotacaosolicitar')->with('cabecalho', $cabecalho)->with('localentrega', $localentrega)->with('items', $items)->with('pedido', $pedido);
    }

    public function excluir(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      PedidosAlmox::where('id',$request->pedido_id)->delete();

      return redirect('cotacaoalmox')->with('msg', 'Pedido excluído com sucesso.');;
    }

    public function cotacaoimprimir(Request $request)
    {

      $cabecalho = PedidosAlmox::find($request->pedido_id);

      $empresas = Cotacao::select('fornecedors.nome', 'fornecedors.cidade', 'fornecedors.uf', 'fornecedors.telefone1', 'fornecedors.telefone2', 'fornecedors.contato', 'fornecedors.id')
                         ->join('fornecedors', 'cotacaos.fornecedor_id', 'fornecedors.id')
                         ->where('cotacaos.pedidosalmox_id', $request->pedido_id)->distinct()->orderby('fornecedors.id')->get();

      $items = PedidosAlmoxProduto::select('produtosalmox.id as produtosalmox_id', 'produtosalmox.descricao', 'produtosalmox.unidade', 'produtosalmox.sap', 'pedidosalmox_produtos.requisicao','pedidosalmox_produtos.qtde')
                                  ->join('produtosalmox', 'pedidosalmox_produtos.produtosalmox_id', 'produtosalmox.id')
                                  ->where('pedidosalmox_produtos.pedidosalmox_id', $request->pedido_id)->get();

      $cotacao = Cotacao::join('fornecedors', 'cotacaos.fornecedor_id', 'fornecedors.id', 'cotacaos.preco_total')
                        ->where('cotacaos.pedidosalmox_id', $request->pedido_id)->orderby('fornecedors.id')->get();
      
      $freteDesconto = Cotacao::select('frete', 'desconto','fornecedor_id')
                              ->where('pedidosalmox_id', $request->pedido_id)->distinct()->orderBy('fornecedor_id')->get();


      $precoTotal = Cotacao::select('preco_total', 'fornecedor_id')->where('pedidosalmox_id', $request->pedido_id)->distinct()->orderBy('fornecedor_id')->get();

      foreach ($items as $item)
        $item['cotacao'] = $cotacao->where('produtosalmox_id', $item['produtosalmox_id'])->values();

      // Calcula preço total
      $precoTotal = $cotacao
      ->groupBy('fornecedor_id')
      ->map(function ($items, $fornecedorId) {
            return [
                'fornecedor_id' => $fornecedorId,
                'valor_produtos' => $items->sum('preco_total'),
            ];
        })
      ->values()->sortBy('fornecedor_id');        

      // Identifica menor preço das cotações
      $menorpreco = null;

      if (count($precoTotal) > 1)
      {
        $valor = $precoTotal[0]['valor_produtos'];
        $menorpreco = 0;

        foreach ($precoTotal as $indice=>$total)
        {
          if ($total['valor_produtos'] < $valor)
            $menorpreco = $indice;

          $valor = $total['valor_produtos'];
        }
      }

      return view('cotacaoimprimir')->with('cabecalho', $cabecalho)
                                    ->with('empresas', $empresas)
                                    ->with('freteDesconto', $freteDesconto)
                                    ->with('precoTotal', $precoTotal)
                                    ->with('menorpreco', $menorpreco)
                                    ->with('items', $items);
    }
}
