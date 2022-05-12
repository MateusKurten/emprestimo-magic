<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Http\Request;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usuario',
        'senha',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'senha',
    ];

    /**
     * Obtem os amigos do usuário.
     * @return \App\Models\Usuario
     */
    public function amigos()
    {
        return $this->hasMany(Amigo::class);
    }

    /**
     * Obtem os decks do usuário.
     * @return \App\Models\Usuario
     */
    public function decks()
    {
        return $this->hasMany(Deck::class);
    }

    /**
     * Valida os campos da tabela de acordo com suas restrições do banco de dados
     * @param \Illuminate\Http\Request $request
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function valida(Request $request)
    {
        $customMessages = [
            'usuario.required' => '*Campo obrigatório',
            'senha.required'  => '*Campo obrigatório',
         ];

        return $request->validate([
            'usuario' => ['required'],
            'senha' => ['required'],
        ], $customMessages);
    }
}
