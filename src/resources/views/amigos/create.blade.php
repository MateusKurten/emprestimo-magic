@extends('app')

@section('content')

<h2 class="text-2xl font-medium">Cadastrar Amigo</h2>
<form action="{{ route('amigos.store') }}" method="Post">
    @csrf

    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mt-4">
        <label class="block mb-12">
            <span class="text-gray-700">Procure o seu amigo abaixo.</span>
            @widget('Select', [
                'data' => collect($usuarios)->mapWithKeys(
                    function ($item, $key) { return [$item->usuario => $item->usuario];}
                )->all(),
                'name' => 'amigo_cadastrado',
                'placeholder' => 'Insira o nome do amigo'
            ])
        </label>
        <label class="block row-start-2 mt-2">
            <span class="text-gray-700">Caso não encontre, informe seu nome abaixo</span>
                <input
                    class="form-input border-gray-300 focus:bg-white focus:shadow-none bg-gray-200 focus:bg-white mt-1 block w-full"
                    type="text"
                    name="amigo">
        </label>
        <div class="flex justify-start col-span-2 row-start-3 mt-4">
            <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-400 focus:outline-none">
                Cadastrar
            </button>
        </div>
    </div>
</form>

@if($amigos)
    <table class="table-auto border shadow-lg mt-4 w-1/2">
        <thead>
            <tr>
                <th class="border border-gray-400 px-4 py-2 bg-gray-100">
                    Nome
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($amigos as $amigo)
            <tr>
                <td class="border border-gray-400 px-4 py-2 text-center">
                    {{ $amigo }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif

@endsection
