<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{

  public function index()
  {
    return view('menu');
  }

  public function menuprincipal()
  {
    if (Auth::user()->acesso_almox == 1 && Auth::user()->acesso_compras == 1)
      return view('menuprincipal');
    else
      return redirect()->route('welcome');
  }
}
