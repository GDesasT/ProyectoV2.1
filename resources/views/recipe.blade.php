@extends('layouts.app')

@section('content')
<div class="container">
    {{-- dan --}}
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
            <div class="mb-4">
                <label for="portionMultiplier" class="block mb-2 text-sm font-medium text-gray-600">Porciones:</label>
                <input type="number" id="portionMultiplier" value="1" min="1" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none">
            </div>
            <ul id="recipeModalIngredients" class="mb-4"></ul>
            <h3 class="mt-4 mb-2 text-lg font-bold">Preparación:</h3>
            <p id="recipeModalDescription" class="mb-4 text-gray-600" style="white-space: pre-wrap;"></p>

            {{-- <!-- Botón Elaborar -->
            <button id="elaborarBtn" class="w-full px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700">Elaborar</button>
        </div> --}}
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
    let currentRecipeId = null; // Variable global para almacenar el ID de la receta actual

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
        }, 300);
    }

    // Abrir modal de ver receta
    document.querySelectorAll('.viewRecipeModal').forEach(button => {
        button.addEventListener('click', function() {
            currentRecipeId = this.getAttribute('data-id'); // Asigna el ID de la receta a la variable global

            fetch(`/recipes/${currentRecipeId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('recipeModalTitle').innerText = data.recipe.name;
                    document.getElementById('recipeModalImage').src = data.recipe.image;
                    document.getElementById('recipeModalDescription').innerHTML = data.recipe.description;

                    const ingredientsList = document.getElementById('recipeModalIngredients');
                    ingredientsList.innerHTML = '';

                    const portionMultiplierInput = document.getElementById('portionMultiplier');
                    portionMultiplierInput.value = 1;

                    data.ingredients.forEach(ingredient => {
                        const listItem = document.createElement('li');
                        listItem.dataset.name = ingredient.name;
                        listItem.dataset.unit = ingredient.unit;
                        listItem.dataset.quantity = ingredient.quantity;
                        listItem.dataset.available = ingredient.available;

                        const requiredQuantity = ingredient.quantity;
                        const availableQuantity = ingredient.available;
                        const missingQuantity = Math.max(requiredQuantity - availableQuantity, 0);

                        listItem.innerHTML = `${ingredient.name}: ${availableQuantity.toFixed(2)}${ingredient.unit} / ${requiredQuantity.toFixed(2)}${ingredient.unit}`;

                        if (missingQuantity > 0) {
                            const missingSpan = document.createElement('span');
                            missingSpan.style.color = 'red';
                            missingSpan.innerText = ` (Faltan ${missingQuantity.toFixed(2)}${ingredient.unit})`;
                            listItem.appendChild(missingSpan);
                        }

                        ingredientsList.appendChild(listItem);
                    });

                    const modal = document.getElementById('viewRecipeModal');
                    showModal(modal);
                });
        });
    });

    // Añadir funcionalidad al botón "Elaborar"
    const elaborarBtn = document.getElementById('elaborarBtn');
    if (elaborarBtn) {
        elaborarBtn.addEventListener('click', function() {
            if (!currentRecipeId) {
                alert('Error: No se ha seleccionado ninguna receta.');
                return;
            }

            const portionMultiplier = parseFloat(document.getElementById('portionMultiplier').value) || 1;
            const ingredientsListItems = document.getElementById('recipeModalIngredients').querySelectorAll('li');
            let suficiente = true;

            ingredientsListItems.forEach(listItem => {
                const requiredPerPortion = parseFloat(listItem.dataset.quantity);
                const available = parseFloat(listItem.dataset.available);
                const totalRequired = requiredPerPortion * portionMultiplier;

                if (available < totalRequired) {
                    suficiente = false;
                }
            });

            if (suficiente) {
                fetch(`/recipes/elaborate/${currentRecipeId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        multiplier: portionMultiplier,
                    })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert('Receta elaborada correctamente.');
                        hideModal(document.getElementById('viewRecipeModal'));
                    } else {
                        alert('Error al elaborar la receta: ' + result.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ocurrió un error al procesar la solicitud.');
                });
            } else {
                alert('No hay suficientes ingredientes para elaborar esta receta.');
            }
        });
    } else {
        console.error('El botón Elaborar no se encontró en el DOM.');
    }

    document.getElementById('closeViewRecipeModal').addEventListener('click', function() {
        const modal = document.getElementById('viewRecipeModal');
        hideModal(modal);
        currentRecipeId = null; // Limpiar el ID de la receta cuando se cierra el modal
    });

    document.getElementById('openAddRecipeModal').addEventListener('click', function() {
        openAddRecipeModal();
    });

    document.querySelectorAll('.editRecipeModal').forEach(button => {
        button.addEventListener('click', function() {
            const recipeId = this.getAttribute('data-id');

            fetch(`/recipes/${recipeId}`)
                .then(response => response.json())
                .then(data => {
                    openAddRecipeModal(true, data.recipe);
                });
        });
    });

    function openAddRecipeModal(edit = false, recipe = null) {
        const modal = document.getElementById('addRecipeModal');
        showModal(modal);

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

    document.getElementById('closeAddRecipeModal').addEventListener('click', function() {
        const modal = document.getElementById('addRecipeModal');
        hideModal(modal);
    });

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

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-ingredient')) {
            event.target.parentElement.parentElement.remove();
        }
    });
    

    document.getElementById('portionMultiplier').addEventListener('input', function() {
        const portionMultiplier = parseFloat(this.value) || 1;
        const ingredientsListItems = document.getElementById('recipeModalIngredients').querySelectorAll('li');

        ingredientsListItems.forEach(listItem => {
            const name = listItem.dataset.name;
            const unit = listItem.dataset.unit;
            const quantityPerPortion = parseFloat(listItem.dataset.quantity).toFixed(2);
            const available = parseFloat(listItem.dataset.available).toFixed(2);

            const totalRequired = (quantityPerPortion * portionMultiplier).toFixed(2);
            const missing = Math.max(totalRequired - available, 0).toFixed(2);

            listItem.innerHTML = `${name}: ${available}${unit} / ${totalRequired}${unit}`;

            if (missing > 0) {
                const missingSpan = document.createElement('span');
                missingSpan.style.color = 'red';
                missingSpan.innerText = ` (Faltan ${missing}${unit})`;
                listItem.appendChild(missingSpan);
            }
        });
    });
});


</script>
@endsection
