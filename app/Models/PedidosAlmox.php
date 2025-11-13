<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PedidosAlmox extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'data_solicitacao',
        'data_envio_cotacao',
        'data_aprovacao',
        'comprador',
        'solicitante',
        'setor',
        'centro_custo',
        'ordem_servico',
        'telefone_ramal',
        'requisicao',
        'aprovacao',
        'numero_pedido',        
        'finalizado',        
        'documento_aprovado',        
        'documento_finalizado', 
        'localcompra',
        'localentrega'       
    ];

    protected $casts = [
        'data_solicitacao' => 'datetime',
        'data_envio_cotacao' => 'datetime',
        'data_aprovacao' => 'datetime',
    ];

    /**',
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pedidosalmox';
}
