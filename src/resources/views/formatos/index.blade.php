@extends('app')

@section('content')

<h1 class="mb-4 text-4xl">Formatos</h1>

  @foreach($formatos as $formato)

    <h2 class="text-2xl">{{$formato->nome}}</h2>
    <p class="text-lg">{{$formato->descricao}}</p>
    <hr class="my-3">

  @endforeach

@endsection
