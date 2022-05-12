@extends('app')

@section('content')

<h2 class="text-2xl font-medium mb-2">Onde estão minhas cartas?</h2>

<div class="bg-white p-6 rounded shadow mb-4">
    <h2 class="text-2xl font-medium">Filtro</h2>
    <form action="{{ route('usuarios.onde_estao_minhas_cartas') }}" method="GET">
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mt-4">
            <label class="block">
                <span class="text-gray-700">Carta</span>
                <input
                    type="text"
                    name="carta"
                    class="form-input {{ $errors->has('carta') ? 'border-red-500' : 'border-gray-300' }} block w-full focus:bg-white focus:shadow-none bg-gray-200"
                    value="{{ old('carta') }}">
            </label>
            <label class="block">
                <span class="text-gray-700">Procurar cartas com:</span>
                <select class="form-select block {{ $errors->has('amigo') ? 'border-red-500' : 'border-gray-300' }} focus:bg-white focus:shadow-none bg-gray-200" name="amigo">
                    <option value="" disabled selected>Selecione o amigo</option>
                    @foreach($amigos as $key => $amigo)
                        <option class="text-lg" value="{{ $key }}" @if(old('amigo') == $key) selected @endif> {{ $amigo }} </option>
                    @endforeach
                <select>
            </label>
            <div class="flex justify-start col-span-4 row-start-3">
                <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-400 focus:outline-none">
                    Pesquisar
                </button>
            </div>
        </div>
    </form>
</div>

<table class="table-auto border shadow-lg mt-4 w-1/2">
    <thead>
        <tr>
            <th class="border border-gray-400 px-4 py-2 bg-gray-100">
                Carta
            </th>
            <th class="border border-gray-400 px-4 py-2 bg-gray-100">
                Qtd
            </th>
            <th class="border border-gray-400 px-4 py-2 bg-gray-100">
                Está com...
            </th>
            <th class="border border-gray-400 px-4 py-2 bg-gray-100">
                Deck
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($cartas as $carta)
        <tr>
            <td class="border border-gray-400 px-4 py-2 text-center">
                <div class="link-hover cursor-pointer">
                    <span>{{ $carta->nome }}</span>
                    <img src="{{ $carta->url_imagem }}"></img>
                </div>
            </td>
            <td class="border border-gray-400 px-4 py-2 text-center">
                {{ $carta->quantidade }}
            </td>
            <td class="border border-gray-400 px-4 py-2 text-center">
                {{ $carta->deck->usuario->usuario }}
            </td>
            <td class="border border-gray-400 px-4 py-2 text-center">
                {{ $carta->deck->nome }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
