<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Pedido extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id', 'solicitante', 'qtde', 'numero', 'user_id'];

    protected $casts = [
        'datafinalizado' => 'datetime',
    ];
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pedidos';

    public static function carregapedidos()
    {
      // Carrega pedidos iniciais e pendentes, e os pedidos finalizados dos ultimos 15 dias
      $datainicio = now()->subDays(15)->format('Y-m-d');

      $totalPedidos = Pedido::select('pedidos.*', 'users.name', 'users.id as usuario_id')
                              ->leftjoin('users', 'pedidos.user_associado', 'users.id')->get();

      // Filtro para usuário, caso não seja Admin
      if (Auth::user()->admin <> 1)
        $totalPedidos =  $totalPedidos->where('user_associado', Auth::user()->id);

      $pedidosPendentes =  $totalPedidos->where('finalizado', 0)->sortBy('created_at', SORT_REGULAR, false);        
        
      $pedidosIniciados =  $totalPedidos->where('finalizado', 1)->sortBy('created_at', SORT_REGULAR, false);
       
      $pedidosFechados =  $totalPedidos->where('finalizado', 2)->where('created_at', '>=', $datainicio)->sortBy('datafinalizado', SORT_REGULAR, true);
    
      return $pedidosIniciados->merge($pedidosPendentes)->merge($pedidosFechados);
    }


    public static function pesquisapedidos($numeropedido)
    {
        $totalPedidos = Pedido::select('pedidos.*', 'users.name', 'users.id as usuario_id')
                              ->leftjoin('users', 'pedidos.user_associado', 'users.id')
                              ->where('numero', 'like', '%' . $numeropedido . '%')->get();

        // Filtro para usuário, caso não seja Admin
        if (Auth::user()->admin <> 1)
            $totalPedidos =  $totalPedidos->where('user_associado', Auth::user()->id);

        $pedidosPendentes =  $totalPedidos->where('finalizado', 0)->sortBy('created_at', SORT_REGULAR, false);        
        
        $pedidosIniciados =  $totalPedidos->where('finalizado', 1)->sortBy('created_at', SORT_REGULAR, false);
         
        $pedidosFechados =  $totalPedidos->where('finalizado', 2)->sortBy('datafinalizado', SORT_REGULAR, true);
        
        return $pedidosIniciados->merge($pedidosPendentes)->merge($pedidosFechados);
    }

    public static function ControlaPedidos()
    {
        // Resgata periodo para visualização
        $config = Config::first();

        if (is_null($config->periodo_painel) || $config->periodo_painel == '')
            $periodo = 'DIÁRIO';
        else
            $periodo = $config->periodo_painel;

        if ($periodo == 'SEMANAL') 
        {
            $inicioSemana = Carbon::now()->startOfWeek(); 
            $fimSemana = Carbon::now()->endOfWeek();
            
            $dados = Pedido::whereBetween('created_at', [$inicioSemana, $fimSemana])->get();
        } 
        elseif ($periodo == 'MENSAL') 
        {
            $inicioMes = Carbon::now()->startOfMonth();
            $fimMes = Carbon::now()->endOfMonth();

            $dados = Pedido::whereBetween('created_at', [$inicioMes, $fimMes])->get();
        }
        else
        {
            $inicioDia = Carbon::now()->startOfDay();
            $fimDia    = Carbon::now()->endOfDay(); 
            $periodo = 'DIÁRIO';
            
            $dados = Pedido::whereBetween('created_at', [$inicioDia, $fimDia])->get();
        }
        
        $pedidos['total'] = $dados->count();
        $pedidos['novos'] = $dados->where('finalizado', 0)->count();
        $pedidos['separando'] = $dados->where('finalizado', 1)->count();
        $pedidos['finalizados'] = $dados->where('finalizado', 2)->count();
        $pedidos['semassoc'] = $dados->whereNull('user_associado')->count();
        $pedidos['periodo'] = $periodo;

        return $pedidos;
    }

    public static function PedidoSAP($numero_pedido)
    {
        $url = ENV('APP_ENV') == 'local' ? ENV('URL_SAP_DEV') : ENV('URL_SAP_PRD');

        $dados = Http::withBasicAuth(env('APP_ENV') == 'local' ? env('SAP_USER') : env('SAP_USER_PRD'), env('APP_ENV') == 'local' ? env('SAP_PASS') : env('SAP_PASS_PRD'))
            ->withHeaders([
                'integracao' => 'RESERVA_ALMOX',
                'rsnum' => $numero_pedido,
            ])
            ->get($url);

        $dados = $dados->json()["ARRAY"];

        $dados = collect($dados)->sortBy(str_replace('.', '', 'LGPBE'))->values()->toArray();
        
        return $dados;
    }

    public static function PedidosSAP($numeros_pedido)
    {
        $dados = array();

        $url = ENV('APP_ENV') == 'local' ? ENV('URL_SAP_DEV') : ENV('URL_SAP_PRD');

        foreach ($numeros_pedido as $num)
        {
              $response = Http::withBasicAuth(env('APP_ENV') == 'local' ? env('SAP_USER') : env('SAP_USER_PRD'), env('APP_ENV') == 'local' ? env('SAP_PASS') : env('SAP_PASS_PRD'))
            ->withHeaders([
                'integracao' => 'RESERVA_ALMOX',
                'rsnum' => $num,
            ])
            ->get($url);

            if (isset($response->json()["ARRAY"]) && is_array($response->json()["ARRAY"]))
                $dados = array_merge($dados, $response->json()["ARRAY"]);
        }

        $dados = collect($dados)->sortBy(str_replace('.', '', 'LGPBE'))->values()->toArray();

        return $dados;
    }

    // Trata e converte string com números de pedidos para ARRAY
    public static function stringPedidos($numeros_pedido)
    {
        $numeros = explode(',', $numeros_pedido);
        $numeros = array_map('trim', $numeros);  

        $numeros = array_map(function ($num) {
            return preg_replace('/\D/', '', $num); // remove caracteres
        }, $numeros);

        $numeros = array_filter($numeros);       // remove valores vazios ", ,"
        $numeros = array_unique($numeros);       // remove valores duplicados
        sort($numeros, SORT_NUMERIC);
        $numeros = array_values($numeros);
    
        return $numeros;
    }

    public static function itensDuplicados ($arrayPedidos)
    {
        foreach ($arrayPedidos as $item) 
        {          
          $chave = $item['LGPBE'] . '-' . $item['MATNR'];

          if (isset($duplicados[$chave]))                         // Se já existe, soma a quantidade
              $duplicados[$chave]['ERFMG'] += $item['ERFMG'];
          else                                                   // Se não existe, adiciona o item original
              $duplicados[$chave] = $item;
        }

        $duplicados = collect($duplicados)->sortBy(str_replace('.', '', 'LGPBE'))->values()->toArray();

        return array_values($duplicados);
    }


    // Verifica se pedidos simples ou duplicados já foram migrados
    public static function verificaPedidosMigrado ($arrayPedidos)
    {
        // Verifica se algum dos pedidos já existe no BD
        $verificaPedido = Pedido::whereIn('numero', $arrayPedidos)->first();
        
        if (isset($verificaPedido))
            return true;

        // Verifica se pedido associado já existe no BD
        $verificaPedido = Pedido::where('numero', implode(',', $arrayPedidos))->first();
        
        if (isset($verificaPedido))
            return true;

        // Verifica cada pedids que foi associado
         $verificaPedido = PedidosAgrupados::whereIn('numero', $arrayPedidos)->first();
        
        if (isset($verificaPedido))
            return true;
    }
}
