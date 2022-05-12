@extends('app')

@section('content')

<h2 class="text-2xl font-medium">Selecione o comandante</h2>
<form action="{{ route('decks.comandante', ['id' => $id]) }}" method="POST">
    @csrf

    <div class="mt-4">
        <div class="grid grid-cols-6 gap-6">
            <label class="block col-span-2">
                <span class="text-gray-700 text-lg">Nome</span>
                <input required
                class="form-input {{ $errors->has('nome') ? 'border-red-500' : 'border-gray-300' }} focus:bg-white focus:shadow-none bg-gray-200 focus:bg-white mt-1 block w-full"
                    type="text"
                    name="nome"
                    value="{{ old('nome') ?? '' }}">
                    @error('nome')
                        <p class="text-red-500 text-xs mt-4">
                            {{ $message }}
                        </p>
                    @enderror
            </label>
            <label class="block col-span-6">
                <span class="text-gray-700 text-lg">Cores</span><br>
                <label>Branco</label>
                <input
                    class="form-checkbox mr-2"
                    type="checkbox"
                    name="cores[]"
                    value="W"
                    {{ old('cores') && in_array("W", old('cores')) ? 'checked' : '' }}>
                <label>Azul</label>
                <input
                    class="form-checkbox mr-2"
                    type="checkbox"
                    name="cores[]"
                    value="U"
                    {{ old('cores') && in_array("U", old('cores')) ? 'checked' : '' }}>
                <label>Preto</label>
                <input
                    class="form-checkbox mr-2"
                    type="checkbox"
                    name="cores[]"
                    value="B"
                    {{ old('cores') && in_array("B", old('cores')) ? 'checked' : '' }}>
                <label>Vermelho</label>
                <input
                    class="form-checkbox mr-2"
                    type="checkbox"
                    name="cores[]"
                    value="R"
                    {{ old('cores') && in_array("R", old('cores')) ? 'checked' : '' }}>
                <label>Verde</label>
                <input
                    class="form-checkbox mr-2"
                    type="checkbox"
                    name="cores[]"
                    value="G"
                    {{ old('cores') && in_array("G", old('cores')) ? 'checked' : '' }}>
                <label>Incolor</label>
                <input
                    class="form-checkbox mr-2"
                    type="checkbox"
                    name="cores[]"
                    value="C"
                    {{ old('cores') && in_array("C", old('cores')) ? 'checked' : '' }}>
                @error('cores')
                    <p class="text-red-500 text-xs mt-4">
                        {{ $message }}
                    </p>
                @enderror
            </label>
        </div>
    </div>
    <div class="flex justify-start mt-4">
        <button
            type="submit"
            class="my-3 py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-400 focus:outline-none">
            Pesquisar
        </button>
    </div>
</form>

@if (!empty($cartas))
    <form action="{{ route('decks.define_comandante', ['id' => $id]) }}" method="POST">
        @csrf

        <div class="grid grid-cols-6 gap-2 mt-4">
            @foreach($cartas as $carta)
            <label>
                <input
                    type="radio"
                    name="carta_id"
                    value="{{ $carta['id'] }}">
                <img src="{{ $carta['image_uris']['normal'] }}">
            </label>
            @endforeach
        </div>

        <button type="submit" class="my-3 py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-400 focus:outline-none">
            Selecionar
        </button>
    </form>
@endif

@endsection
