<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdutoAlmox extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['descricao', 'unidade', 'sap', 'unidade'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'produtosalmox';
}
