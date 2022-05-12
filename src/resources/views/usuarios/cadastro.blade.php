<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Cadastro</title>

    <link rel="stylesheet" href="{{ url(mix('css/app.css')) }}">
    <script src="{{ url(mix('js/app.js')) }}" defer></script>
</head>
<body class="bg-gray-200 min-h-screen font-base">
<div id="app">
    <div class="min-h-screen flex items-center">
        <div class="bg-white w-full max-w-lg rounded-lg shadow overflow-hidden mx-auto">
            <div class="py-4 px-6">
                <div class="mt-1 text-center font-bold text-gray-600 text-xl">Gerencia Decks</div>
                <div class="mt-1 text-center text-gray-600">Cadastro</div>
                <form method="post" action="{{route('usuarios.store')}}">
                    @csrf

                    <div class="mt-4 w-full">
                        @if (session('msg'))
                            <p class="text-red-500 text-xs mt-4">
                                {{ session('msg') }}
                            </p>
                        @endif
                        <label for="usuario">Insira seu nome de usuario (vísivel para outros usuários)</label>
                        <input required
                            type="text"
                            class="w-full mt-2 py-3 px-4 bg-gray-100 text-gray-700 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white"
                            name="usuario"
                            id="usuario"
                            value="{{ old('usuario') }}">
                        @error('usuario')
                            <p class="text-red-500 text-xs mt-4">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="mt-4 w-full">
                        <label for="senha">Informe sua senha</label>
                        <input required type="password" class="w-full mt-2 py-3 px-4 bg-gray-100 text-gray-700 border border-gray-300 rounded  block appearance-none placeholder-gray-500 focus:outline-none focus:bg-white" name="senha" id="senha">
                        @error('senha')
                            <p class="text-red-500 text-xs mt-4">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="flex justify-center items-center mt-6">
                        <a href="{{ route('login') }}" class="py-2 px-4 mx-1 bg-gray-700 text-white rounded hover:bg-gray-600 focus:outline-none">
                            Voltar
                        </a>
                        <button type="submit" class="mx-1 py-2 px-4 bg-gray-700 text-white rounded hover:bg-gray-600 focus:outline-none">
                            Enviar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
