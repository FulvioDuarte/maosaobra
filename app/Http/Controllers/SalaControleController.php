<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SalaControleController extends Controller
{

  public function index()
    {
      $pedidos = Pedido::ControlaPedidos();

      $userAssociados = User::UserAssociados();

     return view('salacontrole')->with('pedidos', $pedidos)
                                ->with('userAssociados', $userAssociados);

    }
}
