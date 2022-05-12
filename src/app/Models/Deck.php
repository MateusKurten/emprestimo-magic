<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    use HasFactory;

    protected $table = 'decks';
    public $timestamps = false;

    /**
     * Os atributos que podem ser atribuídos em massa
     * @var array
     */
    protected $fillable = [
        'usuario_id',
        'formato_id',
        'nome',
        'carta_referencia_id',
        'comandante_id'
    ];

    /**
     * Obtem o usuario relacionado ao Deck.
     * @return \App\Models\Usuario
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    /**
     * Obtem o formato do Deck.
     * @return \App\Models\Formato
     */
    public function formato()
    {
        return $this->belongsTo(Formato::class);
    }

    /**
     * Obtem o Comandante.
     * @return \App\Models\Carta
     */
    public function comandante()
    {
        return $this->belongsTo(Carta::class, 'comandante_id');
    }

    /**
     * Obtem a carta referência.
     * @return \App\Models\Carta
     */
    public function carta_referencia()
    {
        return $this->belongsTo(Carta::class, 'carta_referencia_id');
    }

    /**
     * Obtem as cartas do Deck.
     * @return \App\Models\Carta
     */
    public function cartas()
    {
        return $this->hasMany(Carta::class);
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
