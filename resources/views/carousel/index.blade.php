@extends('layouts.login_app')

@section('content')
<div class="container mx-auto mt-5">
    <h1 class="text-3xl font-bold mb-4 text-center">{{ __('Imágenes del Carrusel') }}</h1>
    <div class="flex justify-center mb-4">
        <a href="{{ route('carousel.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">{{ __('Agregar Nueva Imagen') }}</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($images as $image)
            <div class="bg-white rounded shadow-md p-4 flex flex-col items-center">
                <img src="{{ Storage::url($image->path) }}" alt="{{ $image->description }}" class="h-40 w-full object-cover rounded mb-4">
                <div class="flex justify-between w-full mt-auto">
                    <a href="{{ route('carousel.toggle', $image->id) }}" class="text-blue-500 hover:underline">
                        {{ $image->is_active ? __('Desactivar') : __('Activar') }}
                    </a>
                    <form action="{{ route('carousel.destroy', $image->id) }}" method="POST" class="ml-auto" onsubmit="return confirm('{{ __('¿Estás seguro de que deseas eliminar esta imagen?') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">{{ __('Eliminar') }}</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
