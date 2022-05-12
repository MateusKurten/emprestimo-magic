@extends('app')

@section('content')

<div class="grid grid-cols-2 md:grid-cols-4 gap-8">

    <div class="block ">
        <button
            type="button"
            data-modal-toggle="formCriarDeck">
            <div class="border border-slate-200 rounded-lg shadow-2xl max-w-sm">
                <img class="object-fill mx-auto" src="{{ asset('images/add-deck.png') }}" alt="">
                <div class="flex justify-center my-4">
                    <h4 class="text-xl font-semibold">Novo deck</h4>
                </div>
            </div>
        </button>
    </div>

    @foreach ($decks as $deck)

    <div class="block ">
        <div class="border border-slate-200 rounded-lg shadow-2xl max-w-sm">
            <a href="{{ route('decks.edit', ['id' => $deck->id]) }}">
                <img class="object-fill mx-auto" src="{{ $deck->carta_referencia ? $deck->carta_referencia->url_art_crop : asset('images/add-deck.png') }}" alt="">
                <div class="flex justify-center my-4">
                    <h4 class="text-xl font-semibold">{{ $deck->nome }}</h4>
                </div>
                <hr>
                <div class="px-4 my-4">
                    <p class="text-center text-lg font-light"><strong>Formato:</strong> {{ $deck->formato->nome }}</p>
                    @if($deck->formato->exige_comandante)
                        <p class="text-center text-md font-light"><strong>Comandante:</strong> {{ $deck->comandante->nome ?? 'Não definido' }}</p>
                    @endif
                </div>
                <hr>
            </a>
            <div class="flex justify-center bg-slate-50">
                <button
                    type="button"
                    data-modal-toggle="{{ 'confirmaDelete' . $deck->id }}"
                    class="m-3 py-2 px-4 text-center bg-red-500 text-white rounded hover:bg-red-400 focus:outline-none">
                    Deletar
                </button>
            </div>
        </div>
    </div>

    <div id="{{ 'confirmaDelete' . $deck->id }}" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-4 z-50 justify-center items-center h-modal md:h-full md:inset-0">
        <div class="relative px-4 w-full max-w-xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex justify-between items-start p-5 rounded-t border-b dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 text-justify lg:text-2xl dark:text-white px-4">
                        Deseja apagar o deck "{{ $deck->nome }}"?
                    </h3>
                    <button
                        type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="{{ 'confirmaDelete' . $deck->id }}">
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
                <form action="{{ route('decks.delete') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $deck->id }}">
                    <div class="flex items-center justify-end p-2 mx-4 rounded-b border-gray-200 dark:border-gray-600">
                        <button
                            type="submit"
                            class="my-3 py-2 px-4 bg-blue-500 mx-2 text-white rounded hover:bg-blue-400 focus:outline-none">
                            Sim
                        </button>
                        <button
                            type="button"
                            class="my-3 py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-400 focus:outline-none"
                            data-modal-toggle="{{ 'confirmaDelete' . $deck->id }}">
                            Não
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endforeach

</div>

<div id="formCriarDeck" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-4 z-50 justify-center items-center h-modal md:h-full md:inset-0">
    <div class="relative px-4 w-full max-w-xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex justify-between items-start p-5 rounded-t border-b dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl dark:text-white">
                    Criar Deck
                </h3>
                <button
                    type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="formCriarDeck">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path
                            fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd">
                        </path>
                    </svg>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('decks.store') }}" method="post">
                @csrf

                <label class="block m-4" for="nome">
                    <span class="text-gray-700 text-lg">Nome</span><br>
                    <input type="text" class="form-input w-full text-lg" name="nome">
                </label>

                <label class="block m-4" for="Formato">
                    <span class="text-gray-700 text-lg">Formato</span><br>
                    <select class="form-select w-full text-lg" name="formato">
                        @foreach($formatos as $formato)
                            <option class="text-lg" value="{{ $formato->id }}"> {{ $formato->nome }} </option>
                        @endforeach
                    <select>
                </label>
                <!-- Modal footer -->
                <div class="flex items-center justify-center p-2 rounded-b border-gray-200 dark:border-gray-600">
                    <button
                        type="submit"
                        class="my-3 py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-400 focus:outline-none">
                        Criar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


