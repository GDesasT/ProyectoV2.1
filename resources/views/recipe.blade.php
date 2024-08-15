@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-6 text-xl font-bold">Recetario</h1>

    <!-- Botón para abrir el modal de añadir receta -->
    <button id="openAddRecipeModal" class="px-4 py-2 mb-6 text-white bg-blue-500 rounded hover:bg-blue-700">Añadir Receta</button>

    <!-- Paneles de recetas -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($recipes as $recipe)
        <div class="relative p-4 bg-white rounded-lg shadow-lg">
            <img src="{{ $recipe->image }}" alt="{{ $recipe->name }}" class="object-cover w-full h-48 mb-4 rounded-lg">
            <h2 class="mb-2 text-lg font-bold">{{ $recipe->name }}</h2>
            <p class="mb-4 text-gray-600">{{ $recipe->shortdesc }}</p>
            <div class="flex items-center justify-between">
                <button class="px-4 py-2 text-white bg-green-500 rounded hover:bg-green-700 viewRecipeModal" data-id="{{ $recipe->id }}">Ver Receta</button>
                <div class="flex space-x-2">
                    <button class="px-3 py-2 text-white bg-yellow-500 rounded hover:bg-yellow-700 editRecipeModal" data-id="{{ $recipe->id }}">Editar</button>
                    <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta receta?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-2 text-white bg-red-600 rounded hover:bg-red-700">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Modal para ver receta -->
    <div id="viewRecipeModal" class="fixed inset-0 flex items-center justify-center hidden transition-opacity duration-300 bg-black bg-opacity-70">
        <div class="relative w-full max-w-lg max-h-full p-4 overflow-auto transition-transform duration-300 transform scale-90 bg-white rounded-lg sm:max-w-xl md:max-w-2xl">
            <button class="absolute text-2xl text-gray-600 cursor-pointer top-2 right-2 sm:top-4 sm:right-4" id="closeViewRecipeModal">&times;</button>
            <h2 id="recipeModalTitle" class="mb-6 text-2xl font-bold text-center text-gray-800 sm:text-3xl"></h2>
            <img id="recipeModalImage" class="object-cover w-full h-48 mb-4 rounded-lg">
            <h3 class="mt-4 mb-2 text-lg font-bold">Ingredientes:</h3>
            <ul id="recipeModalIngredients" class="mb-4"></ul>
            <h3 class="mt-4 mb-2 text-lg font-bold">Preparación:</h3>
            <p id="recipeModalDescription" class="mb-4 text-gray-600"></p>
        </div>
    </div>

    <!-- Modal para añadir/editar receta -->
    <div id="addRecipeModal" class="fixed inset-0 flex items-center justify-center hidden transition-opacity duration-300 bg-black bg-opacity-70">
        <div class="relative w-full max-w-lg max-h-full p-4 overflow-auto transition-transform duration-300 transform scale-90 bg-white rounded-lg sm:max-w-xl md:max-w-2xl">
            <button class="absolute text-2xl text-gray-600 cursor-pointer top-2 right-2 sm:top-4 sm:right-4" id="closeAddRecipeModal">&times;</button>
            <h2 id="modalTitle" class="mb-6 text-2xl font-bold text-center text-gray-800 sm:text-3xl"></h2>
            <form id="addRecipeForm" action="{{ route('recipes.store') }}" method="POST">
                @csrf
                <input type="hidden" id="recipeId" name="recipeId">
                <div class="mb-4">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-600">Nombre:</label>
                    <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
                </div>
                <div class="mb-4">
                    <label for="difficult" class="block mb-2 text-sm font-medium text-gray-600">Dificultad:</label>
                    <select name="difficult" id="difficult" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
                        <option value="Fácil">Fácil</option>
                        <option value="Media">Media</option>
                        <option value="Difícil">Difícil</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="shortdesc" class="block mb-2 text-sm font-medium text-gray-600">Descripción Breve:</label>
                    <input type="text" name="shortdesc" id="shortdesc" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
                </div>
                <div class="mb-4">
                    <label for="image" class="block mb-2 text-sm font-medium text-gray-600">Imagen (URL):</label>
                    <input type="text" name="image" id="image" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
                </div>
                <div class="mb-4">
                    <label for="timeset" class="block mb-2 text-sm font-medium text-gray-600">Tiempo de preparación:</label>
                    <input type="text" name="timeset" id="timeset" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
                </div>

                <!-- Ingredientes -->
                <div class="mb-4">
                    <label for="ingredient" class="block mb-2 text-sm font-medium text-gray-600">Ingredientes:</label>
                    <div id="ingredients-wrapper">
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
                    </div>
                    <button type="button" id="add-ingredient" class="mt-2 btn btn-success">Añadir Ingrediente</button>
                </div>

                <div class="mb-4">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-600">Descripción del Procedimiento:</label>
                    <textarea name="description" id="description" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" rows="4" required></textarea>
                </div>

                <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring focus:ring-blue-300 focus:outline-none">Guardar Receta</button>
            </form>
        </div>
    </div>
</div>

<!-- Estilos para las animaciones del modal -->
<style>
    /* Animación de desvanecido */
    .modal-fade-enter {
        opacity: 0;
    }

    .modal-fade-enter-active {
        opacity: 1;
        transition: opacity 0.3s ease-out;
    }

    .modal-fade-leave-active {
        opacity: 0;
        transition: opacity 0.3s ease-in;
    }
</style>

<!-- Script de manejo de modales y AJAX -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Función para mostrar un modal con animación de desvanecido
        function showModal(modal) {
            modal.classList.remove('hidden');
            modal.classList.add('modal-fade-enter');
            setTimeout(() => {
                modal.classList.add('modal-fade-enter-active');
                modal.classList.remove('modal-fade-enter');
            }, 10);
        }

        // Función para ocultar un modal con animación de desvanecido
        function hideModal(modal) {
            modal.classList.add('modal-fade-leave-active');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('modal-fade-leave-active', 'modal-fade-enter-active');
            }, 300); // El tiempo debe coincidir con la duración de la transición
        }

        // Abrir modal de ver receta
        document.querySelectorAll('.viewRecipeModal').forEach(button => {
            button.addEventListener('click', function() {
                const recipeId = this.getAttribute('data-id');

                // Hacer una petición AJAX para obtener los detalles de la receta
                fetch(`/recipes/${recipeId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Llenar los datos del modal con la receta
                        document.getElementById('recipeModalTitle').innerText = data.recipe.name;
                        document.getElementById('recipeModalImage').src = data.recipe.image;
                        document.getElementById('recipeModalDescription').innerText = data.recipe.description;

                        const ingredientsList = document.getElementById('recipeModalIngredients');
                        ingredientsList.innerHTML = '';
                        data.ingredients.forEach(ingredient => {
                            const listItem = document.createElement('li');
                            listItem.innerHTML = `${ingredient.name}: ${ingredient.available}${ingredient.unit} / ${ingredient.quantity}${ingredient.unit}`;
                            if (ingredient.missing > 0) {
                                const missingSpan = document.createElement('span');
                                missingSpan.style.color = 'red';
                                missingSpan.innerText = ` (Faltan ${ingredient.missing}${ingredient.unit})`;
                                listItem.appendChild(missingSpan);
                            }
                            ingredientsList.appendChild(listItem);
                        });

                        // Mostrar el modal con animación
                        const modal = document.getElementById('viewRecipeModal');
                        showModal(modal);
                    });
            });
        });

        // Cerrar modal de ver receta
        document.getElementById('closeViewRecipeModal').addEventListener('click', function() {
            const modal = document.getElementById('viewRecipeModal');
            hideModal(modal);
        });

        // Abrir modal de agregar receta
        document.getElementById('openAddRecipeModal').addEventListener('click', function() {
            openAddRecipeModal();
        });

        // Función para abrir el modal de añadir/editar receta
        function openAddRecipeModal(edit = false, recipe = null) {
            const modal = document.getElementById('addRecipeModal');
            showModal(modal);

            // Limpiar o llenar el formulario según sea necesario
            if (edit && recipe) {
                document.getElementById('modalTitle').innerText = 'Editar Receta';
                document.getElementById('recipeId').value = recipe.id;
                document.getElementById('name').value = recipe.name;
                document.getElementById('difficult').value = recipe.difficult;
                document.getElementById('shortdesc').value = recipe.shortdesc;
                document.getElementById('image').value = recipe.image;
                document.getElementById('timeset').value = recipe.timeset;
                document.getElementById('description').value = recipe.description;

                const ingredients = JSON.parse(recipe.ingredient);
                const ingredientsWrapper = document.getElementById('ingredients-wrapper');
                ingredientsWrapper.innerHTML = '';
                ingredients.forEach(ingredient => {
                    const ingredientGroup = document.createElement('div');
                    ingredientGroup.classList.add('ingredient-group', 'mb-2');
                    ingredientGroup.innerHTML = `
                        <div class="flex items-center space-x-2">
                            <input type="text" name="ingredient_name[]" value="${ingredient.name}" placeholder="Nombre del Ingrediente" class="form-control" required>
                            <input type="number" name="ingredient_quantity[]" value="${ingredient.quantity}" placeholder="Cantidad" class="form-control" step="0.01" required>
                            <select name="ingredient_unit[]" class="form-control">
                                <option value="kg" ${ingredient.unit === 'kg' ? 'selected' : ''}>Kg</option>
                                <option value="g" ${ingredient.unit === 'g' ? 'selected' : ''}>g</option>
                                <option value="l" ${ingredient.unit === 'l' ? 'selected' : ''}>L</option>
                                <option value="unidad" ${ingredient.unit === 'unidad' ? 'selected' : ''}>Unidad</option>
                            </select>
                            <button type="button" class="text-red-500 remove-ingredient">&times;</button>
                        </div>
                    `;
                    ingredientsWrapper.appendChild(ingredientGroup);
                });
            } else {
                document.getElementById('modalTitle').innerText = 'Añadir Nueva Receta';
                document.getElementById('addRecipeForm').reset();
                document.getElementById('recipeId').value = '';
                document.getElementById('ingredients-wrapper').innerHTML = '';
            }
        }

        // Cerrar modal de añadir/editar receta
        document.getElementById('closeAddRecipeModal').addEventListener('click', function() {
            const modal = document.getElementById('addRecipeModal');
            hideModal(modal);
        });

        // Añadir nuevo ingrediente en el modal de añadir/editar receta
        document.getElementById('add-ingredient').addEventListener('click', function() {
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
            document.getElementById('ingredients-wrapper').appendChild(newIngredientGroup);
        });

        // Eliminar un grupo de ingredientes
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-ingredient')) {
                event.target.parentElement.parentElement.remove();
            }
        });
    });
</script>
@endsection
