<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conferido extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['pacote_id', 
                           'conferencia_id',
                           'unidades',
                           'user_id'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'conferidos';
}
