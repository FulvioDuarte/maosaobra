<?php

namespace App\Http\Controllers;

use App\Models\Ramo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RamosController extends Controller
{

  public function index()
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');
    
      $ramos = Ramo::where('descricao', '<>', "")->orderBy('descricao')->get();
      
      return view('ramos')->with('ramos', $ramos);
    }

    public function pesquisar(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      if ($request->pesquisarnome <> "")
        $ramos = Ramo::where('descricao', 'like', '%'. $request->pesquisarnome . '%')->orderBy('descricao')->get();
      else
        $ramos = Ramo::orderBy('descricao')->get();

      return view('ramos')->with('ramos', $ramos);
    }

    public function criar()
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');
      
      return view('ramoscriar');
    }

    public function gravar(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      $dados['descricao'] = $request->nomeramo;

      Ramo::create($dados);

      return redirect('ramos')->with('msg', 'Ramo criado com sucesso.');
    }

    public function editar(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      $ramo = Ramo::find($request->ramo_id);

      return view('ramoseditar')->with('ramo', $ramo);
    }

    public function salvar(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      Ramo::where('id',$request->ramo_id)->update(['descricao'=>$request->nomeramo]);

      return redirect('ramos')->with('msg', 'Ramo atualizado com sucesso.');
    }

    public function excluir(Request $request)
    {
      if (Auth::user()->acesso_compras <> 1)
        return redirect()->route('welcome');

      Ramo::where('id',$request->ramo_id)->delete();

      return redirect('ramos')->with('msg', 'Ramo excluído com sucesso.');;
    }
}
