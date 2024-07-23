{{-- resources/views/recipe_form.blade.php --}}
@extends('layouts.app')

@section('content')

{{-- TODO ESTO ES LA LOGICA PARA AÑADIR PLATILLOS, NO TOCAR PORQUE LELE COLAAAAAAA--}}
<div class="container">
    <h1>{{ isset($recipe) ? 'Editar Recipe' : 'Agregar Recipe' }}</h1>

    <form action="{{ isset($recipe) ? route('recipes.update', $recipe->id) : route('recipes.store') }}" method="POST">
        @csrf
        @if(isset($recipe))
            @method('PUT')
        @endif
        <div class="mb-3">
            <label for="name" class="form-label">Nombre:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ isset($recipe) ? $recipe->name : '' }}" required>
        </div>
        <div class="mb-3">
            <label for="ingredient" class="form-label">Ingredientes:</label>
            <input type="text" name="ingredient" id="ingredient" class="form-control" value="{{ isset($recipe) ? $recipe->ingredient : '' }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción:</label>
            <input type="text" name="description" id="description" class="form-control" value="{{ isset($recipe) ? $recipe->description : '' }}" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Imagen (URL):</label>
            <input type="text" name="image" id="image" class="form-control" value="{{ isset($recipe) ? $recipe->image : '' }}" required>
        </div>
        <div class="mb-3">
            <label for="timeset" class="form-label">Tiempo de elaboración:</label>
            <input type="text" name="timeset" id="timeset" class="form-control" value="{{ isset($recipe) ? $recipe->timeset : '' }}" required>
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($recipe) ? 'Actualizar' : 'Agregar' }}</button>
    </form>
</div>
@endsection
