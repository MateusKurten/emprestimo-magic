<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formato extends Model
{
    use HasFactory;

    protected $table = 'formatos';
    public $timestamps = false;

    /**
     * Os atributos que podem ser atribuídos em massa
     * @var array
     */
    protected $fillable = [
        'nome',
        'descricao',
        'exige_comandante'
    ];
}
