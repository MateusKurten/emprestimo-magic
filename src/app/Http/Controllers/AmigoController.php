<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Amigo;
use Illuminate\Http\Request;

class AmigoController extends Controller
{
    public function create(Request $request)
    {
        $usuario = Usuario::where('usuario', $request->session()->get('usuario'))->first();

        $amigos = [];
        foreach($usuario->amigos as $amigo){
            $usuarioAmigo = Usuario::find($amigo->amigo_id);
            $amigos[$usuarioAmigo->id] = $usuarioAmigo->usuario;
        }

        return view('amigos.create', [
            'usuarios' => Usuario::where('id', '!=', $usuario->id)->get(),
            'amigos' => $amigos
        ]);
    }

    public function store(Request $request)
    {
        if (!$request->amigo_cadastrado && !$request->amigo) {
            return back()->with('msg', [
                'title' => 'O nome do amigo é obrigatório',
                'preset' => 'danger'
            ]);
        }

        if ($request->amigo) {
            $amigo = Usuario::create([
                'usuario' => $request->amigo,
            ]);
        } else {
            $amigo = Usuario::where('usuario', $request->amigo_cadastrado)->first();
        }

        $usuario = Usuario::where('usuario', $request->session()->get('usuario'))->first();

        $relacaoAmigoUsuario = Amigo::create([
            'usuario_id' => $usuario->id,
            'amigo_id' => $amigo->id,
        ]);

        $relacaoAmigoUsuario = Amigo::create([
            'usuario_id' => $amigo->id,
            'amigo_id' => $usuario->id,
        ]);

        return back()->with('msg', 'Amigo adicionado com sucesso');
    }
}
