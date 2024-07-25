@extends('layouts.login_app')

@section('content')
<div class="container mx-auto mt-5">
    <h1 class="text-3xl font-bold mb-4">{{ __('Imágenes del Carrusel') }}</h1>
    <a href="{{ route('carousel.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">{{ __('Agregar Nueva Imagen') }}</a>
    <div class="mt-4">
        @foreach($images as $image)
            <div class="flex items-center justify-between mt-2">
                <img src="{{ Storage::url($image->path) }}" alt="{{ $image->description }}" class="h-20">
                <a href="{{ route('carousel.toggle', $image->id) }}" class="text-blue-500">
                    {{ $image->is_active ? __('Desactivar') : __('Activar') }}
                </a>
                <form action="{{ route('carousel.destroy', $image->id) }}" method="POST" onsubmit="return confirm('{{ __('¿Estás seguro de que deseas eliminar esta imagen?') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500">{{ __('Eliminar') }}</button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection
