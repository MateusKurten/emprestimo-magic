<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Carta extends Model
{
    use HasFactory;

    protected $table = 'cartas';
    public $timestamps = false;

    /**
     * Os atributos que podem ser atribuídos em massa
     * @var array
     */
    protected $fillable = [
        'deck_id',
        'dono_id',
        'nome',
        'quantidade',
        'id_scryfall',
        'url_imagem',
        'url_art_crop'
    ];

    /**
     * Obtem o dono da carta.
     * @return \App\Models\Usuario
     */
    public function dono()
    {
        return $this->belongsTo(Usuario::class, 'dono_id');
    }

    /**
     * Obtem o deck em que a carta está sendo usada.
     * @return \App\Models\Deck
     */
    public function deck()
    {
        return $this->belongsTo(Deck::class);
    }

    /**
     * Obtem dados da api Scryfall.
     * @return array
     */
    public static function getDadosScryfall($id)
    {
        $response = Http::get('https://api.scryfall.com/cards/' . $id);
        if ($response->status() == 200) {
            return $response->json();
        }

        return [];
    }

    /**
     * Valida os campos da tabela de acordo com suas restrições do banco de dados
     * @param \Illuminate\Http\Request $request
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public static function valida($request)
    {
        $customMessages = [
            'nome.required' => '*Campo obrigatório',
            'formato.required'  => '*Campo obrigatório',
            'formato.integer'  => '*Formulário inválido',
         ];

        return $request->validate([
            'nome' => ['required'],
            'formato' => ['required', 'integer'],
        ], $customMessages);
    }
}
