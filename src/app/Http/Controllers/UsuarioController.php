<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Carta;
use App\Models\Deck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function cadastro()
    {
        return view('usuarios.cadastro');
    }

    public function store(Request $request)
    {
        $dadosValidados = Usuario::valida($request);
        $nomeUsuarios = Usuario::select('usuario')->get()->toArray();
        if(!in_array(['usuario' => $dadosValidados['usuario']], $nomeUsuarios)) {
            $usuario = Usuario::create([
                'usuario' => $dadosValidados['usuario'],
                'senha' => bcrypt($dadosValidados['senha']),
            ]);
        } else {
            $usuario = Usuario::where('usuario', $dadosValidados['usuario'])->first();
            if ($usuario->senha) {
                return back()->with('msg', '*Este nome de usuário já existe');
            } else {
                $usuario->senha = bcrypt($dadosValidados['senha']);
                $usuario->save();
            }
        }

        return redirect()->route('login')->with('msg', 'Cadastro efetuado com sucesso! Entre com seu usuário e senha.');
    }

    public function auth(Request $request)
    {
        try {
            $usuario = Usuario::where('usuario', $request->usuario)->first();
            if(Hash::check($request->senha, $usuario->senha)) {
                session(['usuario' => $request->usuario]);
                return redirect()->route('decks');
            } else {
                return back()->with('msg', 'Usuário ou senha errada!');
            }
        } catch (\Throwable $th) {
            return back()->with('msg', 'Usuário ou senha errada!');
        }

    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }

    public function buscaMinhasCartas(Request $request)
    {
        $request->flash();
        $usuario = Usuario::where('usuario', session('usuario'))->first();
        $amigos = [];
        foreach($usuario->amigos as $amigo){
            $usuarioAmigo = Usuario::find($amigo->amigo_id);
            $amigos[$usuarioAmigo->id] = $usuarioAmigo->usuario;
        }
        $cartas = Carta::where('dono_id', $usuario->id);
        if ($request->carta) {
            $cartasPesquisadas = Carta::where('nome', 'like', '%' . $request->carta . '%')->get();
            $ids = [];
            foreach($cartasPesquisadas as $carta) {
                $ids[] = $carta->id;
            }
            $cartas = $cartas->whereIn('id', $ids);
        }

        if ($request->amigo) {
            $cartasDoAmigo = [];
            $cartas = $cartas->get();
            foreach($cartas as $carta) {
                if ($carta->deck->usuario->id == $request->amigo) {
                    $cartasDoAmigo[] = $carta;
                }
            }
            $cartas = $cartasDoAmigo;
        }

        return view('usuarios.onde_estao_minhas_cartas', [
            'cartas' => is_array($cartas) ? $cartas : $cartas->get(),
            'amigos' => $amigos,
        ]);
    }

    public function buscaCartasEmprestadas(Request $request)
    {
        $request->flash();
        $usuario = Usuario::where('usuario', session('usuario'))->first();
        $cartas = Deck::select(
                'cartas.id as carta_id',
                'cartas.nome as nome',
                'cartas.url_imagem',
                'cartas.quantidade',
                'decks.nome as nome_deck',
                'usuarios.usuario',
                'usuarios.id as usuario_id')
            ->join('cartas', 'cartas.deck_id', '=', 'decks.id')
            ->join('usuarios', 'cartas.dono_id', '=', 'usuarios.id')
            ->where('decks.usuario_id', $usuario->id)
            ->whereNotNull('cartas.dono_id');

        if ($request->carta) {
            $cartas = $cartas->where('cartas.nome', 'like', '%' . $request->carta . '%');
        }

        if ($request->amigo) {
            $cartasDoAmigo = [];
            $cartas = $cartas->get();
            foreach($cartas as $carta) {
                if ($carta->usuario_id == $request->amigo) {
                    $cartasDoAmigo[] = $carta;
                }
            }
            $cartas = $cartasDoAmigo;
        }

        $amigos = [];
        foreach($usuario->amigos as $amigo){
            $usuarioAmigo = Usuario::find($amigo->amigo_id);
            $amigos[$usuarioAmigo->id] = $usuarioAmigo->usuario;
        }

        return view('usuarios.cartas_emprestadas', [
            'cartas' => is_array($cartas) ? $cartas : $cartas->get(),
            'amigos' => $amigos,
        ]);
    }
}
