<?php

namespace App\Http\Controllers;

use App\Events\ControlaPedidos;
use App\Events\UserAssociado;
use App\Models\Pedido;
use App\Models\PedidoProduto;
use App\Models\PedidoSeparacao;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParametrosController extends Controller
{

  public function index(Request $request)
    { 
      if (Auth::user()->admin <> 1)
      return redirect()->route('welcome');

      // Pesquisa número pedido  
      if (isset($request->numeropedido))
        $pedidos = Pedido::pesquisapedidos($request->numeropedido);
      else
        $pedidos = Pedido::carregapedidos();

      // Filtro por usuário 
      if (!is_null($request->filtronome))
        $pedidos = $pedidos->where('usuario_id', $request->filtronome);

      // Filtro por Status 
      if (!is_null($request->filtrostatus))
          if ($request->filtrostatus == 3) // Excluido
            $pedidos = Pedido::onlyTrashed()->get();
          else
            $pedidos = $pedidos->where('finalizado', $request->filtrostatus);
      
      // Filtro por data
      if (!is_null($request->datainicio) && !is_null($request->datafim))
          $pedidos = $pedidos->where('created_at', '>=', $request->datainicio)->where('created_at', '<=', $request->datafim . ' 23:59');
      elseif (!is_null($request->datainicio))
          $pedidos = $pedidos->where('created_at', '>=', $request->datainicio);
      elseif (!is_null($request->datafim))
          $pedidos = $pedidos->where('created_at', '<=', $request->datafim);

      // Calcula tempo gasto para separação.
      foreach ($pedidos as $pedido)
      {
        $separacao = PedidoSeparacao::where('pedido_id', $pedido['id'])->first();
        
        if (isset($separacao))
        {
          $inicio = Carbon::parse($separacao->inicio_separacao);
          $fim = Carbon::parse($separacao->fim_separacao);
        }
        else
        {
          $inicio = null;
          $fim = null;
        }

        if ($request->filtrostatus == 3) // Excluido
        {
          $pedido['tempo'] = "-";
        }
        elseif (!is_null($inicio) && !is_null($fim))
        {
          $diferenca =  $fim->diffInMinutes($inicio);

          // Converte para horas e minutos
          $horas = floor($diferenca / 60);
          $minutos = $diferenca % 60;
  
          $horas = str_pad($horas, 2, '0', STR_PAD_LEFT);
          $minutos = str_pad($minutos, 2, '0', STR_PAD_LEFT);
  
          $pedido['tempo'] = $horas . 'hs ' . $minutos . 'min';
        }
        else
          $pedido['tempo'] = "-";
      }

      $usuarios = User::all();

      return view('pedidoassociar')->with('pedidos', $pedidos)->with('usuarios', $usuarios);
    }

    public function gravarassociacao(Request $request)
    {
      if (Auth::user()->admin <> 1)
        return redirect()->route('welcome');

      if (!is_null($request->associados))
      {
        foreach ($request->associados as $indice=>$associado)
          Pedido::where('id', $indice)->update(['user_associado' => $associado['usuario_id'], 'user_id' => Auth::user()->id]);

        $mensagem = 'Associação realizada com sucesso';
      } else
        $mensagem = 'Nenhuma associação foi realizada';
   
      $pedidos = Pedido::carregapedidos();

      $usuarios = User::all();
      
      // EVENTO
      $dados = Pedido::ControlaPedidos();
      event(new ControlaPedidos($dados));
      
      // EVENTO
      $dados = User::UserAssociados();
      event(new UserAssociado($dados->toArray()));

      return view('pedidoassociar')->with('pedidos', $pedidos)->with('usuarios', $usuarios)->with('mensagem', $mensagem);
    }

    public function pedidorelatorio(Request $request)
    {
      if (Auth::user()->admin <> 1)
        return redirect()->route('welcome');

      if (isset($request->datainicio))
      {
       // dd($request->datainicio);
        $usuarios = Pedido::select('user_associado', 'users.name')
                          ->join('users', 'users.id', 'pedidos.user_associado')
                          ->where('pedidos.created_at', '>=', $request->datainicio)
                          ->where('pedidos.created_at', '<=', $request->datafim . ' 23:59')
                          ->whereNotNull('user_associado')->groupby('user_associado', 'users.name')->orderby('users.name')->get();
        
        $pedidostotal = Pedido::all();
        
        if (count($usuarios) > 0)
        {
          foreach ($usuarios as $indice=>$usuario)
          {
            $dados[$indice]['id'] = $usuario['user_associado'];
            $dados[$indice]['usuario'] = $usuario['name'];
            $dados[$indice]['novos'] = $pedidostotal->where('user_associado', $usuario['user_associado'])->where('finalizado', 0)->count();
            $dados[$indice]['pendentes'] = $pedidostotal->where('user_associado', $usuario['user_associado'])->where('finalizado', 1)->count();
            $dados[$indice]['finalizados'] = $pedidostotal->where('user_associado', $usuario['user_associado'])->where('finalizado', 2)->count();
          }
        } else
          $dados = [];
      }
      else
        $dados = [];

      return view('pedidorelatorio')->with('dados', $dados);
    }
}
