<?php

namespace App\Http\Controllers;

use App\Models\Formato;
use App\Models\Deck;
use App\Models\Usuario;
use App\Models\Carta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DeckController extends Controller
{
    public function index()
    {
        $formatos = Formato::all();
        $usuario = Usuario::where('usuario', session('usuario'))->first();
        $decks = Deck::where('usuario_id', $usuario->id)->get();

        return view('decks.index', [
            'decks' => $decks,
            'formatos' => $formatos
        ]);
    }

    public function store(Request $request)
    {
        $dadosValidados = Deck::valida($request);
        $formato = Formato::find($dadosValidados['formato']);
        $deck = Deck::create([
            'usuario_id' => Usuario::where('usuario', session('usuario'))->first()->id,
            'formato_id' => $formato->id,
            'nome' => $dadosValidados['nome'],
        ]);

        if ($formato->exige_comandante) {
            return redirect()->route('decks.comandante', [
                'id' => $deck->id
            ]);
        }

        return redirect()->route('decks.edit', [
            'id' => $deck->id
        ]);
    }

    public function edit($id)
    {
        $deck = Deck::find($id);
        $usuario = Usuario::where('usuario', session('usuario'))->first();
        $amigos = [];

        foreach($usuario->amigos as $amigo){
            $usuarioAmigo = Usuario::find($amigo->amigo_id);
            $amigos[$usuarioAmigo->id] = $usuarioAmigo->usuario;
        }

        $cartas = Carta::where('deck_id', $id)->get();

        return view('decks.edit', [
            'deck' => $deck,
            'cartas' => $cartas,
            'amigos' => $amigos
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = Deck::valida($request);
        $deck = Deck::find($id);
        $deck->nome = $validatedData['nome'];
        $deck->formato_id = $validatedData['formato_id'];
        $deck->save();

        return redirect()->route('decks')->with('msg', 'Deck editado com sucesso!');
    }

    public function delete(Request $request)
    {
        try {
            $deck = Deck::find($request->id);
            $deck->delete();

            return redirect()->route('decks')->with('msg', 'Deck excluído com sucesso!');
        } catch (\Throwable $th) {

            return redirect()->route('decks')->with('msg', [
                'title' => 'Erro!',
                'subtitle' => $th->getMessage(),
                'preset' => 'danger'
            ]);
        }
    }

    public function comandante($id, Request $request)
    {
        $request->flash();

        if ($request->nome) {
            $url = 'https://api.scryfall.com/cards/search?q=';
            $nome = urlencode($request->nome);
            $cores = isset($request->cores) ? '+color%3D' . implode($request->cores) : '';
            $isCommander = "+is%3Acommander";
            $response = Http::get($url . $nome . $cores . $isCommander);
            if ($response->status() == 200) {
                $cartas = $response->json()['data'];
            }
        }

        return view('decks.comandante', [
            'id' => $id,
            'cartas' => $cartas ?? [],
        ]);
    }

    public function defineComandante($id, Request $request)
    {
        $deck = Deck::find($id);

        $dadosScryfall = Carta::getDadosScryfall($request->carta_id);

        $carta = Carta::create([
            'deck_id' => $deck->id,
            'nome' => $dadosScryfall['name'],
            'quantidade' => 1,
            'id_scryfall' => $request->carta_id,
            'url_imagem' => $dadosScryfall['image_uris']['normal'],
            'url_art_crop' => $dadosScryfall['image_uris']['art_crop'],
        ]);

        $deck->carta_referencia_id = $carta->id;
        $deck->comandante_id = $carta->id;
        $deck->save();

        return redirect()->route('decks.edit', [
            'id' => $id,
        ]);
    }

    public function procuraCarta(Request $request)
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

        return view('decks.edit', [
            'deck' => Deck::find($request->id),
            'pesquisa_cartas' => $cartas ?? [],
            'amigos' => $amigos,
            'cartas' => Carta::where('deck_id', $request->id)->get(),
        ]);
    }

    public function adicionaCarta(Request $request)
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

        return view('decks.edit', [
            'deck' => $deck,
            'pesquisa_cartas' => [],
            'amigos' => $amigos,
            'cartas' => Carta::where('deck_id', $request->id)->get(),
        ])->with('msg', 'Carta adicionada com sucesso!');
    }

    public function deletaCarta(Request $request)
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
