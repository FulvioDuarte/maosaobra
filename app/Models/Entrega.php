<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entrega extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['codigo', 'nome', 'fantasia', 'razao', 'cnpj', 'endereco', 'email', 'telefone'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'entregas';
}
