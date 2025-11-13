<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Config;

class ConfigController extends Controller
{

  public function configpainel(Request $request)
    {
      Config::query()->update(['periodo_painel' => $request->desc]);

      return redirect('salacontrole');
    }
}
