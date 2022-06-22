<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('usuarios')->insert([
            'usuario' => 'mateus.kurten',
            'senha' => bcrypt('123456'),
        ]);

        \DB::table('usuarios')->insert([
            'usuario' => 'Amigo 1',
            'senha' => bcrypt('amigo1'),
        ]);

        \DB::table('usuarios')->insert([
            'usuario' => 'Amigo 2',
            'senha' => bcrypt('amigo2'),
        ]);

        \DB::table('usuarios')->insert([
            'usuario' => 'Amigo 3',
            'senha' => bcrypt('amigo3'),
        ]);

        \DB::table('usuarios')->insert([
            'usuario' => 'Amigo 4',
            'senha' => bcrypt('amigo4'),
        ]);
    }
}
