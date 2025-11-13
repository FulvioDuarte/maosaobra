<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PedidoConferencia extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pedido_id',
        'inicio_conferencia',
        'fim_conferencia',
        'user_conferencia'
    ];
    
    protected $casts = [
        'inicio_conferencia' => 'datetime',
        'fim_conferencia' => 'datetime',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pedidoconferencias';
}
