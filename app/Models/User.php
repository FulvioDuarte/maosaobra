<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'matricula',
        'setor',
        'acesso',
        'codgernac',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function UserAssociados()
    {
        $usuarios = Pedido::whereNotNull('user_associado')
                    ->select('user_associado', DB::raw('count(*) as total'), 'users.name')
                    ->join('users', 'users.id', 'pedidos.user_associado')
                    ->where('pedidos.finalizado', '<>', 2)
                    ->groupBy('user_associado', 'users.name')->get();

        return $usuarios;
    }
}
