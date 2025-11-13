<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cotacao extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['pedidosalmox_produto_id', 
                           'qtde', 
                           'dias_envio', 
                           'preco_un', 
                           'frete', 
                           'desconto', 
                           'preco_total', 
                           'produtosalmox_id',
                           'pedidosalmox_id',
                           'fornecedor_id',
                           'user_id'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cotacaos';
}
