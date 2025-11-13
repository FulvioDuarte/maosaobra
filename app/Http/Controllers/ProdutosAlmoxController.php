<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Models\PedidosAlmoxProduto;
use App\Models\ProdutoAlmox;
use App\Models\Ramo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProdutosAlmoxController extends Controller
{

  public function index()
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');
    
      $produtos = [];

      return view('produtoalmox')->with('produtos', $produtos);
    }

    public function criar()
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');
      
      return view('produtoalmoxcriar');
    }

    public function gravar(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      $dados['descricao'] = $request->nomeproduto;
      $dados['sap'] = $request->sap;
      $dados['unidade'] = $request->unidade;

      $verifica = ProdutoAlmox::where('descricao', $request->nomeproduto)->first();

      if (is_null($verifica))
        ProdutoAlmox::create($dados);
      else
        return redirect()->route('criaprodutoalmox')->with('msg', 'Já existe um produto cadastrado com a mesma descrição.');

      return redirect('produtoalmox')->with('msg', 'Produto criado com sucesso.');
    }

    public function pesquisar(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      $produtos = ProdutoAlmox::orderBy('descricao');

      // Filtro por nome do produto
      if (!is_null($request->pesquisarnome))
        $produtos = $produtos->where('descricao', 'like', '%'. $request->pesquisarnome . '%');

      $produtos = $produtos->orderby('descricao')->get();

      return view('produtoalmox')->with('produtos', $produtos);
    }

    public function editar(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      $produto = ProdutoAlmox::find($request->produto_id);

      return view('produtoalmoxeditar')->with('produto', $produto);
    }

    public function salvar(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      $validar = PedidosAlmoxProduto::where('produtosalmox_id', $request->produto_id)->first();
      
      if (!is_null($validar))
        return redirect('produtoalmox')->with('msg', '⚠️ ATENÇÃO: Produto não pode ser editado, pois já exite cotações associadas.');

      ProdutoAlmox::where('id',$request->produto_id)
                ->update(['descricao'=>$request->nomeproduto,
                          'sap'=>$request->sapproduto,
                          'unidade'=>$request->unidadeproduto
                        ]);

      return redirect('produtoalmox')->with('msg', 'Produto atualizado com sucesso.');
    }

    public function excluir(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      ProdutoAlmox::where('id',$request->produto_id)->delete();

      return redirect('produtoalmox')->with('msg', 'Produto excluído com sucesso.');;
    }
}
