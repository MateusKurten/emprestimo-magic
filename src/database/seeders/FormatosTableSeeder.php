<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FormatosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('formatos')->insert([
            'nome' => 'Commander',
            'descricao' => 'Cada jogador escolhe uma criatura lendária para ser seu "comandante" e cria um deck com 99 cards baseados naquela criatura.',
            'exige_comandante' => 1,
        ]);

        \DB::table('formatos')->insert([
            'nome' => 'Brawl',
            'descricao' => 'Escolha seu campeão! Brawl tem um pouco de Padrão, e um pouco de Commander, e é um desafio único e empolgante de criação de decks.',
            'exige_comandante' => 1,
        ]);

        \DB::table('formatos')->insert([
            'nome' => 'Pauper',
            'descricao' => 'Restringe os decks a apenas cards de raridade comum.',
            'exige_comandante' => 0,
        ]);

        \DB::table('formatos')->insert([
            'nome' => 'Standard',
            'descricao' => 'O formato Standard utiliza as coleções mais recentes de Magic.',
            'exige_comandante' => 0,
        ]);

        \DB::table('formatos')->insert([
            'nome' => 'Black Silver (Standard)',
            'descricao' => 'Restringe os decks a apenas cards de raridade comum e incomum do formato Standard.',
            'exige_comandante' => 0,
        ]);

        \DB::table('formatos')->insert([
            'nome' => 'Pioneer',
            'descricao' => 'O formato Pionner utiliza as todas as coleções padrões de Magic lançadas a partir de Retorno à Ravnica (2012).',
            'exige_comandante' => 0,
        ]);

        \DB::table('formatos')->insert([
            'nome' => 'Black Silver (Pioneer)',
            'descricao' => 'Restringe os decks a apenas cards de raridade comum e incomum do formato Pioneer.',
            'exige_comandante' => 0,
        ]);

        \DB::table('formatos')->insert([
            'nome' => 'For Fun',
            'descricao' => 'Vale qualquer coisa!',
            'exige_comandante' => 0,
        ]);
    }
}
