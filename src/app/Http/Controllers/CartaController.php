<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use App\Models\Carta;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CartaController extends Controller
{
    public function busca(Request $request)
    {
        $request->flash();

        if ($request->nome) {
            $url = 'https://api.scryfall.com/cards/search?q=';
            $nome = urlencode($request->nome);
            $cores = isset($request->cores) ? '+color%3D' . implode($request->cores) : '';
            $response = Http::get($url . $nome . $cores);
            if ($response->status() == 200) {
                $cartas = $response->json()['data'];
            }
        }

        $amigos = [];
        $usuario = Usuario::where('usuario', session('usuario'))->first();
        foreach($usuario->amigos as $amigo){
            $usuarioAmigo = Usuario::find($amigo->amigo_id);
            $amigos[$usuarioAmigo->id] = $usuarioAmigo->usuario;
        }

        $request->session()->put('pesquisa_cartas', $cartas ?? []);

        return redirect()->route('decks.edit', [
            'id' => $request->id
        ]);
    }

    public function store(Request $request)
    {
        $deck = Deck::find($request->id);

        $dadosScryfall = Carta::getDadosScryfall($request->carta_id);

        $carta = Carta::create([
            'deck_id' => $deck->id,
            'dono_id' => $request->dono_id ?? NULL,
            'nome' => $dadosScryfall['name'],
            'quantidade' => $request->qtd,
            'id_scryfall' => $request->carta_id,
            'url_imagem' => $dadosScryfall['image_uris']['normal'],
            'url_art_crop' => $dadosScryfall['image_uris']['art_crop'],
        ]);

        if (!isset($deck->carta_referencia)) {
            $deck->carta_referencia_id = $carta->id;
            $deck->save();
        }

        $amigos = [];
        $usuario = Usuario::where('usuario', session('usuario'))->first();
        foreach($usuario->amigos as $amigo){
            $usuarioAmigo = Usuario::find($amigo->amigo_id);
            $amigos[$usuarioAmigo->id] = $usuarioAmigo->usuario;
        }

        return redirect()->route('decks.edit', [
            'id' => $request->id
        ])->with('msg', 'Carta adicionada com sucesso!');
    }

    public function delete(Request $request)
    {
        try {
            $carta = Carta::find($request->carta);
            $carta->delete();

            return back()->with('msg', 'Carta excluída com sucesso');
        } catch (\Throwable $th) {
            return back()->with('msg', [
                'title' => 'Erro!',
                'subtitle' => $th->getMessage(),
                'preset' => 'danger'
            ]);
        }
    }
}
