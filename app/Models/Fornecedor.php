<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedor extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id','nome', 'telefone1', 'telefone2', 'email', 'email2', 'contato', 'ramo_id', 'user_id', 'cidade', 'uf'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fornecedors';
}
