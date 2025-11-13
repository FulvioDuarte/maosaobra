<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PedidosAlmoxProduto extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'requisicao',
        'qtde',        
        'produtosalmox_id',        
        'pedidosalmox_id',        
    ];


    /**',
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pedidosalmox_produtos';
}
