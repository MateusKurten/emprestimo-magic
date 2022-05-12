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
            'usuario' => 'teste',
            'senha' => bcrypt('teste'),
        ]);

        \DB::table('usuarios')->insert([
            'usuario' => 'teste2',
            'senha' => bcrypt('teste2'),
        ]);
    }
}
