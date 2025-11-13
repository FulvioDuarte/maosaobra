<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Models\Ramo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{

  public function index()
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');
    
      $fornecedores = Fornecedor::select('fornecedors.*', 'ramos.descricao')
                                ->leftjoin('ramos', 'ramos.id', 'fornecedors.ramo_id')
                                ->orderBy('nome')->get();

      $ramos = Ramo::where('descricao', '<>', "")->orderBy('descricao')->get();
      
      return view('fornecedor')->with('fornecedores', $fornecedores)->with('ramos', $ramos);
    }

    public function criar()
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      $ramos = Ramo::orderBy('descricao')->get();
      
      return view('fornecedorcriar')->with('ramos', $ramos);
    }

    public function gravar(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      $dados['nome'] = $request->nomefornecedor;
      $dados['telefone1'] = $request->telefonefornecedor1;
      $dados['telefone2'] = $request->telefonefornecedor2;
      $dados['contato'] = $request->contatofornecedor;
      $dados['email'] = $request->emailfornecedor;
      $dados['email2'] = $request->email2fornecedor;
      $dados['ramo_id'] = $request->ramofornecedor;
      $dados['cidade'] = $request->cidadefornecedor;
      $dados['uf'] = $request->uf;

      Fornecedor::create($dados);

      return redirect('fornecedor')->with('msg', 'Fornecedor criado com sucesso.');
    }

    public function pesquisar(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      $fornecedores = Fornecedor::select('fornecedors.*', 'ramos.descricao')
                                ->leftjoin('ramos', 'ramos.id', 'fornecedors.ramo_id')->orderBy('nome');
    
      // Filtro por nome do fornecedor
      if (!is_null($request->pesquisarnome))
        $fornecedores = $fornecedores->where('nome', 'like', '%'. $request->pesquisarnome . '%');

      // Filtro por ramo
      if (!is_null($request->filtroramos))
        $fornecedores = $fornecedores->where('ramo_id', $request->filtroramos);

      $fornecedores = $fornecedores->orderby('nome')->get();

      $ramos = Ramo::where('descricao', '<>', "")->orderBy('descricao')->get();

      return view('fornecedor')->with('fornecedores', $fornecedores)->with('ramos', $ramos);
    }

    public function editar(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      $fornecedor = Fornecedor::find($request->fornecedor_id);

      $ramos = Ramo::orderBy('descricao')->get();

      return view('fornecedoreditar')->with('fornecedor', $fornecedor)->with('ramos', $ramos);
    }

    public function salvar(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      Fornecedor::where('id',$request->fornecedor_id)
                ->update(['nome'=>$request->nomefornecedor,
                          'telefone1'=>$request->telefonefornecedor1,
                          'telefone2'=>$request->telefonefornecedor2,
                          'contato'=>$request->contatofornecedor,
                          'email'=>$request->emailfornecedor,
                          'email2'=>$request->email2fornecedor,
                          'ramo_id'=>$request->ramofornecedor,
                        ]);

      return redirect('fornecedor')->with('msg', 'Fornecedor atualizado com sucesso.');
    }

    public function excluir(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      Fornecedor::where('id',$request->fornecedor_id)->delete();

      return redirect('fornecedor')->with('msg', 'Fornecedor excluído com sucesso.');;
    }
}
