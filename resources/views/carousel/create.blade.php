@extends('layouts.login_app')

@section('content')
<div class="container mx-auto mt-5">
    <h1 class="text-3xl font-bold mb-4">Agregar Nueva Imagen</h1>
    <form action="{{ route('carousel.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="image" class="block text-gray-700">Imagen:</label>
            <input type="file" name="image" id="image" class="mt-1 block w-full" required>
        </div>
        <div class="mb-4">
            <label for="active" class="inline-flex items-center">
                <input type="checkbox" name="active" id="active" class="form-checkbox">
                <span class="ml-2 text-gray-700">Activo</span>
            </label>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar Imagen</button>
    </form>
</div>
@endsection
