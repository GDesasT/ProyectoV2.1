@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($recipe) ? 'Editar Receta' : 'Agregar Receta' }}</h1>

    <form action="{{ isset($recipe) ? route('recipes.update', $recipe->id) : route('recipes.store') }}" method="POST">
        @csrf
        @if(isset($recipe))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="name" class="form-label">Nombre de la Receta:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ isset($recipe) ? $recipe->name : '' }}" required>
            <small class="form-text text-muted">Especifica un nombre único para la receta.</small>
        </div>

        <div class="mb-3">
            <label for="difficult" class="form-label">Dificultad:</label>
            <select name="difficult" id="difficult" class="form-control" required>
                <option value="">Selecciona la dificultad</option>
                <option value="Fácil" {{ isset($recipe) && $recipe->difficult == 'Fácil' ? 'selected' : '' }}>Fácil</option>
                <option value="Media" {{ isset($recipe) && $recipe->difficult == 'Media' ? 'selected' : '' }}>Media</option>
                <option value="Difícil" {{ isset($recipe) && $recipe->difficult == 'Difícil' ? 'selected' : '' }}>Difícil</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="ingredient" class="form-label">Ingredientes:</label>
            <div id="ingredients-wrapper">
                @if(isset($recipe) && $recipe->ingredient)
                    @foreach(json_decode($recipe->ingredient, true) as $ingredient)
                    <div class="mb-2 ingredient-group">
                        <div class="flex items-center space-x-2">
                            <input type="text" name="ingredient_name[]" placeholder="Nombre del Ingrediente" class="form-control" value="{{ $ingredient['name'] }}" required>
                            <input type="number" name="ingredient_quantity[]" placeholder="Cantidad" class="form-control" value="{{ $ingredient['quantity'] }}" step="0.01" required>
                            <select name="ingredient_unit[]" class="form-control">
                                <option value="kg" {{ $ingredient['unit'] == 'kg' ? 'selected' : '' }}>Kg</option>
                                <option value="g" {{ $ingredient['unit'] == 'g' ? 'selected' : '' }}>g</option>
                                <option value="l" {{ $ingredient['unit'] == 'l' ? 'selected' : '' }}>L</option>
                                <option value="unidad" {{ $ingredient['unit'] == 'unidad' ? 'selected' : '' }}>Unidad</option>
                            </select>
                            <button type="button" class="text-red-500 remove-ingredient">&times;</button>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="mb-2 ingredient-group">
                        <div class="flex items-center space-x-2">
                            <input type="text" name="ingredient_name[]" placeholder="Nombre del Ingrediente" class="form-control" required>
                            <input type="number" name="ingredient_quantity[]" placeholder="Cantidad" class="form-control" step="0.01" required>
                            <select name="ingredient_unit[]" class="form-control">
                                <option value="kg">Kg</option>
                                <option value="g">g</option>
                                <option value="l">L</option>
                                <option value="unidad">Unidad</option>
                            </select>
                            <button type="button" class="text-red-500 remove-ingredient">&times;</button>
                        </div>
                    </div>
                @endif
            </div>
            <button type="button" id="add-ingredient" class="mt-2 btn btn-success">Añadir Ingrediente</button>
            <small class="form-text text-muted">Especifica los ingredientes necesarios para la receta. Puedes añadir más con el botón.</small>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Descripción del Procedimiento:</label>
            <textarea name="description" id="description" class="form-control" rows="5" required>{{ isset($recipe) ? $recipe->description : '' }}</textarea>
            <small class="form-text text-muted">Describe detalladamente los pasos para preparar la receta.</small>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Imagen (URL):</label>
            <input type="text" name="image" id="image" class="form-control" value="{{ isset($recipe) ? $recipe->image : '' }}" required>
            <small class="form-text text-muted">Proporciona una URL de la imagen representativa de la receta.</small>
        </div>

        <div class="mb-3">
            <label for="timeset" class="form-label">Tiempo de Elaboración:</label>
            <input type="text" name="timeset" id="timeset" class="form-control" value="{{ isset($recipe) ? $recipe->timeset : '' }}" required>
            <small class="form-text text-muted">Indica el tiempo total necesario para preparar la receta.</small>
        </div>

        <div class="mb-3">
            <label for="shortdesc" class="form-label">Descripción Breve:</label>
            <textarea name="shortdesc" id="shortdesc" class="form-control" rows="2" required>{{ isset($recipe) ? $recipe->shortdesc : '' }}</textarea>
            <small class="form-text text-muted">Proporciona una breve descripción o resumen de la receta.</small>
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($recipe) ? 'Actualizar' : 'Agregar' }}</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addIngredientButton = document.getElementById('add-ingredient');
        const ingredientsWrapper = document.getElementById('ingredients-wrapper');

        addIngredientButton.addEventListener('click', () => {
            const newIngredientGroup = document.createElement('div');
            newIngredientGroup.classList.add('ingredient-group', 'mb-2');
            newIngredientGroup.innerHTML = `
                <div class="flex items-center space-x-2">
                    <input type="text" name="ingredient_name[]" placeholder="Nombre del Ingrediente" class="form-control" required>
                    <input type="number" name="ingredient_quantity[]" placeholder="Cantidad" class="form-control" step="0.01" required>
                    <select name="ingredient_unit[]" class="form-control">
                        <option value="kg">Kg</option>
                        <option value="g">g</option>
                        <option value="l">L</option>
                        <option value="unidad">Unidad</option>
                    </select>
                    <button type="button" class="text-red-500 remove-ingredient">&times;</button>
                </div>
            `;
            ingredientsWrapper.appendChild(newIngredientGroup);
        });

        // Eliminar un grupo de ingredientes
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-ingredient')) {
                event.target.parentElement.parentElement.remove();
            }
        });

        // Convertir los datos a JSON al enviar el formulario
        document.querySelector('form').addEventListener('submit', function(event) {
            const ingredientNames = document.querySelectorAll('input[name="ingredient_name[]"]');
            const ingredientQuantities = document.querySelectorAll('input[name="ingredient_quantity[]"]');
            const ingredientUnits = document.querySelectorAll('select[name="ingredient_unit[]"]');

            const ingredients = Array.from(ingredientNames).map((_, index) => {
                return {
                    name: ingredientNames[index].value,
                    quantity: ingredientQuantities[index].value,
                    unit: ingredientUnits[index].value
                };
            });

            // Crear un input oculto para enviar el JSON
            const ingredientInput = document.createElement('input');
            ingredientInput.type = 'hidden';
            ingredientInput.name = 'ingredient';
            ingredientInput.value = JSON.stringify(ingredients);
            this.appendChild(ingredientInput);
        });
    });
</script>
@endsection
