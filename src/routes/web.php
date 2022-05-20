<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('decks');
});



Route::get('/login', [\App\Http\Controllers\UsuarioController::class, 'login'])->name('login');
Route::get('/cadastro', [\App\Http\Controllers\UsuarioController::class, 'cadastro'])->name('usuarios.cadastro');
Route::post('/usuarios/store', [\App\Http\Controllers\UsuarioController::class, 'store'])->name('usuarios.store');
Route::post('/auth', [\App\Http\Controllers\UsuarioController::class, 'auth'])->name('usuarios.auth');

Route::group([
    'middleware' => 'autenticador',
], function ($router) {
    Route::get('/logout', [\App\Http\Controllers\UsuarioController::class, 'logout'])->name('usuarios.logout');
    Route::any('/decks', [\App\Http\Controllers\DeckController::class, 'index'])->name('decks');
    Route::any('/decks/comandante/{id}', [\App\Http\Controllers\DeckController::class, 'comandante'])->name('decks.comandante');
    Route::post('/decks/define-comandante/{id}', [\App\Http\Controllers\DeckController::class, 'defineComandante'])->name('decks.define_comandante');
    Route::post('/decks/store', [\App\Http\Controllers\DeckController::class, 'store'])->name('decks.store');
    Route::post('/decks/delete', [\App\Http\Controllers\DeckController::class, 'delete'])->name('decks.delete');
    Route::any('/decks/{id}', [\App\Http\Controllers\DeckController::class, 'edit'])->name('decks.edit');
    Route::post('/cartas/delete', [\App\Http\Controllers\CartaController::class, 'delete'])->name('cartas.delete');
    Route::post('/cartas/busca', [\App\Http\Controllers\CartaController::class, 'busca'])->name('cartas.busca');
    Route::post('/cartas/store', [\App\Http\Controllers\CartaController::class, 'store'])->name('cartas.store');
    Route::any('/formatos', [\App\Http\Controllers\FormatoController::class, 'index'])->name('formatos');
    Route::any('/onde-estao-minhas-cartas', [\App\Http\Controllers\UsuarioController::class, 'buscaMinhasCartas'])->name('usuarios.onde_estao_minhas_cartas');
    Route::any('/cartas-emprestadas', [\App\Http\Controllers\UsuarioController::class, 'buscaCartasEmprestadas'])->name('usuarios.cartas_emprestadas');
    Route::get('/amigos/create', [\App\Http\Controllers\AmigoController::class, 'create'])->name('amigos.create');
    Route::post('/amigos/store', [\App\Http\Controllers\AmigoController::class, 'store'])->name('amigos.store');
});



