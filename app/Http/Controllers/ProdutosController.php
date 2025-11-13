<?php

namespace App\Http\Controllers;

use App\Models\Conferencia;
use App\Models\Conferido;
use App\Models\Pedido;
use App\Models\PedidoProduto;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

class ProdutosController extends Controller
{

  public function index()
  {
    if (Auth::user()->acesso_almox <> 1)
      return redirect()->route('welcome');
      
    $msg = "";

    return view('produtos')->with('msg', $msg);
  }

  public function alterar (Request $request)
    {    
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');

        $produto = Produto::find($request->id);

        return view('alterar')->with('produto', $produto)->with('msg', '');
    }

  public function atualizar (Request $request)
    {    
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');

      if ( $request->atualizar == 1)
      {
        Produto::where('id', $request->id)
               ->update(['codigosap' => $request->codigoproduto,
                         'codigo' => str_replace('.', '', $request->codigoproduto),
                         'descricao' => $request->descricao,
                         'codigorua' => $request->rua,
                         'rua' => str_replace('.', '', $request->rua),
                         'user_id' => Auth::user()->id]
        );

        $produto = Produto::find($request->id);

        return view('alterar')->with('produto', $produto)->with('msg', 'Produto alterado com sucesso');
      }
      elseif ($request->excluir == 1 )
      {
        Produto::where('id', $request->id)->delete();
        $produtos = [];

        return view('pesquisa')->with('produtos', $produtos)->with('msg', 'Produto excluído com sucesso');
      }
    }

    public function pesquisaSAP (Request $request)
    {
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');

      // Salva dados do Produto
      if (isset($request->salvar))
      {
        Produto::updateOrCreate(
            ['codigo' => $request->codigoproduto],
            ['codigorua' => $request->rua, 
            'rua' => str_replace('.', '', $request->rua),
            'codigosap' =>number_format($request->codigoproduto, 0, ',', '.'),
            'descricao' => $request->descricao, 
            'user_id' => Auth::user()->id]
        );
    
        return view('produtos')->with('msg', 'Produto salvo com sucesso!');
      }
      // Pesquisa Produto no SAP
      else
      {
        $url = 'http://192.168.80.40:50000/RESTAdapter/Retorno/TelaPreco';

        $msg =  "";
        
        $dados = [
            "codloja" => "1012",
            "codproduto" => $request->codigoproduto
        ];

        $response = Http::post($url, $dados);

        $dados = $response->json();
        $descproduto = $dados['DESMAT'];

        if ($descproduto == '')
        {
          // Pesquisa produtos já salvos na Base de Dados
          $pesquisa = Produto::where('codigo', $request->codigoproduto)->first();

          if (!isset($pesquisa))
            return view('produtos')->with('msg', "Produto ". '"'. $request->codigoproduto . '"'." não encontrado"); 
          else
            return view('produtos')->with('msg', $msg)->with('descproduto', $pesquisa->descricao)->with('codproduto', $pesquisa->codigo);
        }
        else 
          return view('produtos')->with('msg', $msg)->with('descproduto', $descproduto)->with('codproduto', $request->codigoproduto);
      }
    }

    public function pesquisa(Request $request)
    {
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');

      $msg = '';

      // Caso seja bipado QR Code com unidades
      $codigo = explode('|', $request->desc);

      $dadopesquisa = str_replace('.', '', $codigo[0]);

      if (isset($dadopesquisa))
      {
        if (is_numeric($dadopesquisa))
        {
          $produtos = Produto::where('codigo', 'like', '%' . $dadopesquisa . '%')->orderby('codigo')->get();
          
          if (count($produtos) == 0)
            $msg = 'Produto não encontrado';
        }
        elseif ($dadopesquisa <> "")
        {
          $produtos = Produto::where('descricao', 'like', '%' . $dadopesquisa . '%')->orderby('codigo')->get();

          if (count($produtos) == 0)
            $msg = 'Produto não encontrado';
        }
        else
          $produtos = [];
      }
      else
        $produtos = [];

      return view('pesquisa')->with('produtos', $produtos)->with('msg', $msg);
    }

    public function pedidosenviar(Request $request)
    {
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');

      $msg = '';

      if (isset($request->numeropedido))
      {
        $pedidos = Pedido::where('numero', 'like', '%' . $request->numeropedido . '%')->get();

        if (count($pedidos) == 0)
         $msg = 'Pedido não encontrado';
      }
      else
        $pedidos = [];

      return view('pedidosenviar')->with('pedidos', $pedidos)->with('msg', $msg);
    }

    public function limpar()
    {
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');
        
      $msg = "";
  
      return view('produtos')->with('msg', $msg);
    }

    public function pesquisapulmao(Request $request)
    {
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');

      $msg = '';

      // Caso seja bipado QR Code com unidades
      $codigo = explode('|', $request->desc);

      $dadopesquisa = str_replace('.', '', $codigo[0]);

      if (isset($dadopesquisa))
      {
        if (is_numeric($dadopesquisa))
        {
          $produtos = Produto::where('codigo', 'like', '%' . $dadopesquisa . '%')->orderby('codigo')->get();
          
          if (count($produtos) == 0)
            $msg = 'Produto não encontrado';
        }
        elseif ($dadopesquisa <> "")
        {
          $produtos = Produto::where('descricao', 'like', '%' . $dadopesquisa . '%')->orderby('codigo')->get();

          if (count($produtos) == 0)
            $msg = 'Produto não encontrado';
        }
        else
          $produtos = [];
      }
      else
        $produtos = [];

      return view('pulmao')->with('produtos', $produtos)->with('msg', $msg);
    }

    public function criaconferencia(Request $request)
    {
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');

      Conferencia::create(['descricao'=>$request->nome, 'user_id'=>Auth::user()->id]);

      return redirect('conferencias')->with('msg', 'Conferência criada com sucesso.');
    }

    public function conferencias(Request $request)
    {
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');

      $conferencias = Conferencia::orderBy('created_at','desc')->get();

      return view('conferencias')->with('conferencias', $conferencias);
    }

    public function conferidos(Request $request)
    {
      if (Auth::user()->acesso_almox <> 1)
        return redirect()->route('welcome');

      
      $item = PedidoProduto::select('pedidoprodutos.id', 'produtos.descricao', 'pedidoprodutos.qtde', 'pedidoprodutos.qtdeconferida',
                                       'pedidoprodutos.conferido', 'pedidoprodutos.updated_at','produtos.rua', 'pedidoprodutos.pedido_id', 'produtos.codigo',
                                       'produtos.codigosap', 'produtos.codigorua', 'produtos.unidade', 'pedidoprodutos.ordem')
                              ->join('produtos', 'produtos.id', 'pedidoprodutos.produto_id')
                              ->where('pedidoprodutos.pedido_id', 166)
                              ->where('pedidoprodutos.conferido', 0)
                              ->orderby('pedidoprodutos.ordem')->first();
                              

      $conferidos = Conferido::select('produtos.codigosap', 'produtos.codigorua', 'produtos.descricao', 'conferidos.unidades', 'conferidos.created_at')
                             ->join('produtos', 'produtos.id', 'conferidos.produto_id')
                             ->where('conferencia_id', $request->id)->get();

      return view('conferidos')->with('conferidos', $conferidos)->with('item', $item);
    }

    public function gravaconferido(Request $request)
    {
      dd($request);

    }
}
