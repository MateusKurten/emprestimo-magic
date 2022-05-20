@extends('app')

@section('content')

<h1 class="mb-4 text-4xl">{{ $deck->nome }}</h1>

<div class="grid grid-cols-2">
    <div>
        <h2 class="text-2xl">Formato</h2>
        <p class="text-lg">{{$deck->formato->nome}}</p>
    </div>
    @if($deck->formato->exige_comandante)
        <div>
            <h2 class="text-2xl">Comandante</h2>
            <p class="text-lg">{{ $deck->comandante->nome ?? 'Não definido' }}</p>
        </div>
    @endif
</div>

<hr class="my-3">

<div class="grid grid-cols-2 gap-6">
    <div class="border-r pr-4">
        <h2 class="text-xl">Cartas</h2>
        <table class="table-auto border shadow-lg mt-4 w-full">
            <thead>
                <tr>
                    <th class="border border-gray-400 px-4 py-2 bg-gray-100" style="width: 40px">
                        Qtd
                    </th>
                    <th class="border border-gray-400 px-4 py-2 bg-gray-100">
                        Carta
                    </th>
                    <th class="border border-gray-400 px-4 py-2 bg-gray-100">
                        Dono da carta
                    </th>
                    <th class="border border-gray-400 px-4 py-2 bg-gray-100" style="width: 40px">
                        Ação
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartas as $carta)
                <tr>
                    <td class="border border-gray-400 px-2 py-2 text-center">
                        {{ $carta->quantidade }}
                    </td>
                    <td class="border border-gray-400 px-4 py-2 text-center"">
                        <div class="link-hover cursor-pointer">
                            <span>{{ $carta->nome }}</span>
                            <img src="{{ $carta->url_imagem }}"></img>
                        </div>
                    </td>
                    <td class="border border-gray-400 px-4 py-2 text-center">
                        {{ $carta->dono->usuario ?? '' }}
                    </td>
                    <td class="border border-gray-400 px-4 py-2 text-center">
                        <button
                            type="button"
                            data-modal-toggle="{{ 'confirmaDelete' . $carta->id }}"
                            class="py-2 px-4 text-center text-red-500">
                            Excluir
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        <h2 class="text-xl">Pesquisar Carta</h2>
        <form action="{{ route('cartas.busca', ['id' => $deck->id]) }}" method="POST">
            @csrf

            <div class="grid grid-cols-6 gap-6">
                <label class="block col-span-4">
                    <span class="text-gray-700 text-lg">Nome</span>
                    <input required
                    class="form-input {{ $errors->has('nome') ? 'border-red-500' : 'border-gray-300' }} focus:bg-white mt-1 block bg-gray-200 w-full"
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
            <div class="flex justify-start mt-4">
                <button
                    type="submit"
                    class="my-3 py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-400 focus:outline-none">
                    Pesquisar
                </button>
            </div>
        </form>

        @if (!empty($pesquisa_cartas))
            <form action="{{ route('cartas.store', ['id' => $deck->id]) }}" method="POST">
                @csrf

                <div class="grid grid-cols-3 gap-2 my-4">
                    @foreach($pesquisa_cartas as $carta)
                    <label>
                        <input
                            type="radio"
                            name="carta_id"
                            value="{{ $carta['id'] }}">
                        <img src="{{ $carta['image_uris']['normal'] }}">
                    </label>
                    @endforeach
                </div>

                <div class="block">
                    <span class="text-gray-700 text-lg">Dono da Carta</span><br>
                    <select class="form-select text-lg mb-3 mr-4 bg-gray-200 focus:bg-white border-gray-300" name="dono_id">
                        <option value="" disabled selected>Selecione o dono da carta caso não seja você.</option>
                        @foreach($amigos as $key => $amigo)
                            <option class="text-lg" value="{{ $key }}"> {{ $amigo }} </option>
                        @endforeach
                    <select>

                    <span class="text-gray-700 text-lg">Qtd</span>
                    <input required
                    class="form-input {{ $errors->has('quantidade') ? 'border-red-500' : 'border-gray-300' }} mt-1 w-20 bg-gray-200 focus:bg-white"
                        type="number"
                        min= "1"
                        name="qtd"
                        value="{{ old('quantidade') ?? 1 }}">
                    @error('quantidade')
                        <p class="text-red-500 text-xs mt-4">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit" class="my-3 py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-400 focus:outline-none">
                    Selecionar
                </button>
            </form>
        @endif

    </div>
</div>


{{-- Modal Excluir Carta--}}
@foreach($cartas as $carta)
    <div id="{{ 'confirmaDelete' . $carta->id }}" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-4 z-50 justify-center items-center h-modal md:h-full md:inset-0">
        <div class="relative px-4 w-full max-w-3xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex justify-between items-start p-5 rounded-t border-b dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 text-justify lg:text-2xl dark:text-white px-4">
                        Deseja remover a carta "{{ $carta->nome }}" do deck?
                    </h3>
                    <button
                        type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="{{ 'confirmaDelete' . $carta->id }}">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd">
                            </path>
                        </svg>
                    </button>
                </div>
                <!-- Modal footer -->
                <form action="{{ route('cartas.delete', ['carta' => $carta->id]) }}" method="POST">
                    @csrf
                    <div class="flex items-center justify-end p-2 mx-4 rounded-b border-gray-200 dark:border-gray-600">
                        <button
                            type="submit"
                            class="my-3 py-2 px-4 bg-blue-500 mx-2 text-white rounded hover:bg-blue-400 focus:outline-none">
                            Sim
                        </button>
                        <button
                            type="button"
                            class="my-3 py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-400 focus:outline-none"
                            data-modal-toggle="{{ 'confirmaDelete' . $carta->id }}">
                            Não
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@endsection
