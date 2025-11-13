<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['codigo', 'descricao', 'rua', 'user_id', 'codigosap', 'codigorua', 'unidade', 'unidade1'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'produtos';
}
