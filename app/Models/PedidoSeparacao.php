<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PedidoSeparacao extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pedido_id',
        'inicio_separacao',
        'fim_separacao',
        'user_separacao'
    ];
    
    protected $casts = [
        'inicio_separcao' => 'datetime',
        'fim_separcao' => 'datetime',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pedidoseparacaos';
}
