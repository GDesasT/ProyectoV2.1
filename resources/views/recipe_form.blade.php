@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-6 text-xl font-bold">{{ $recipe->name }}</h1>
    <img src="{{ $recipe->image }}" alt="{{ $recipe->name }}" class="object-cover w-full h-48 mb-4 rounded-lg">

    <h3 class="mt-4 mb-2 text-lg font-bold">Ingredientes:</h3>
    <ul class="mb-4">
        @foreach ($ingredients as $ingredient)
        <li>
            {{ $ingredient['name'] }}: {{ $ingredient['available'] }}{{ $ingredient['unit'] }} / {{ $ingredient['quantity'] }}{{ $ingredient['unit'] }}
            @if ($ingredient['missing'] > 0)
            <span style="color: red;">(Faltan {{ $ingredient['missing'] }}{{ $ingredient['unit'] }})</span>
            @endif
        </li>
        @endforeach
    </ul>

    <h3 class="mt-4 mb-2 text-lg font-bold">Preparación:</h3>
    <p class="mb-4 text-gray-600">{{ $recipe->description }}</p>
</div>
@endsection
