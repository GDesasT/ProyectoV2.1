@extends('layouts.login_app')

@section('content')
@auth
<div class="container">
    <h1>Gestión de Recipes</h1>

    {{-- Carrusel de Recetas Recomendadas --}}
    <div class="bg-white-100">
        <div class="container p-4 mx-auto">
            <h1 class="mb-8 text-2xl font-semibold">Recetas Recomendadas</h1>

            <div class="relative overflow-hidden">
                <div class="overflow-hidden carousel-wrapper">
                    <div class="flex gap-6 carousel-slide">
                        @foreach ($recipes as $index => $recipe)
                        <div class="block transition-transform duration-300 transform bg-white rounded-lg cursor-pointer carousel-item group shadow-secondary-1 dark:bg-surface-dark hover:scale-105" data-modal="modal1" data-index="{{ $index }}">
                            <a href="#!" class="relative block overflow-hidden rounded-lg">
                                <img class="object-cover w-full transition-transform duration-300 rounded-t-lg h-96 group-hover:scale-110" src="{{ $recipe->image }}" alt="{{ $recipe->name }}" />
                                <div class="absolute inset-0 flex items-center justify-center p-6 transition-opacity duration-300 bg-black opacity-0 bg-opacity-60 group-hover:opacity-100">
                                    <div class="text-center text-white">
                                        <h5 class="mb-3 text-2xl font-medium">{{ $recipe->name }}</h5>
                                        <p class="mb-2 text-lg">Complejidad: {{ $recipe->difficult }}</p>
                                        <p class="mb-2 text-lg">Tiempo: {{ $recipe->timeset }}</p>
                                        <p class="text-lg">{{ $recipe->shortdesc }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>

                    <!-- Navegación del Carrusel -->
                    <button class="absolute p-2 text-white transform -translate-y-1/2 bg-gray-700 rounded-full top-1/2 left-4" id="prevBtn">&lt;</button>
                    <button class="absolute p-2 text-white transform -translate-y-1/2 bg-gray-700 rounded-full top-1/2 right-4" id="nextBtn">&gt;</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Botón para abrir el modal de agregar receta --}}
    <button id="openAddRecipeModal" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Agregar Nueva Receta</button>

    {{-- Modal para agregar receta --}}
    <div id="addRecipeModal" class="fixed inset-0 flex items-center justify-center hidden transition-opacity duration-300 bg-black bg-opacity-70">
        <div class="relative w-full h-auto max-w-2xl max-h-screen p-8 overflow-auto transition-transform duration-300 transform scale-90 bg-white rounded-lg">
            <button class="absolute text-2xl text-gray-600 cursor-pointer top-4 right-4" id="closeAddRecipeModal">&times;</button>
            <h2 class="mb-6 text-3xl font-bold text-center text-gray-800">Agregar Nueva Receta</h2>
            <form action="{{ route('recipes.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-600">Nombre:</label>
                    <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
                </div>
                <div class="mb-4">
                    <label for="difficult" class="block mb-2 text-sm font-medium text-gray-600">Dificultad:</label>
                    <select name="difficult" id="difficult" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
                        <option value="">Selecciona la dificultad</option>
                        <option value="Fácil">Fácil</option>
                        <option value="Media">Media</option>
                        <option value="Difícil">Difícil</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="image" class="block mb-2 text-sm font-medium text-gray-600">Imagen (URL):</label>
                    <input type="text" name="image" id="image" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
                </div>

                <div class="mb-6">
                    <label for="timeset" class="block mb-2 text-sm font-medium text-gray-600">Tiempo de elaboración:</label>
                    <input type="text" name="timeset" id="timeset" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
                </div>

                <div class="mb-3">
                    <label for="shortdesc" class="block mb-2 text-sm font-medium text-gray-600">Añade una Descripción Breve:</label>
                    <input type="text" name="shortdesc" id="shortdesc" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
                </div>

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
                    <small class="form-text text-muted">Especifica los ingredientes necesarios para la receta. Puedes añadir más con el botón.</small>
                </div>

                <div class="mb-4">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-600">Procedimiento de la Receta:</label>
                    <textarea name="description" rows="5" cols="30" id="description" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required></textarea>
                </div>

                <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring focus:ring-blue-300 focus:outline-none">Agregar</button>
            </form>
        </div>
    </div>
</div>

<style>
    .recipe-ingredients {
        white-space: pre-line;
    }
</style>

{{-- Modal de Información de Receta --}}
<div id="modal1" class="fixed inset-0 flex items-center justify-center hidden transition-opacity duration-300 bg-black opacity-0 bg-opacity-70">
    <div class="relative p-8 transition-transform duration-300 transform scale-90 bg-white rounded-lg w-xl h-xl">
        <button class="absolute text-2xl text-black cursor-pointer top-4 right-4" id="closeModal">&times;</button>
        <h2 class="mb-4 text-3xl font-bold" id="modalRecipeName">Información de la Receta</h2>
        <div id="modalContent">
            <p class="text-lg"><strong>Ingredientes:</strong></p>
            <ul id="modalIngredients">
                <!-- Los ingredientes se insertarán aquí -->
            </ul>
            <p class="mt-4"><strong>Preparación:</strong><br><span id="modalPreparation"></span></p>
        </div>
        {{-- Botón de eliminación --}}
        <div class="flex justify-end mt-4">
            <form id="deleteRecipeForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700">Eliminar Receta</button>
            </form>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const carouselSlide = document.querySelector('.carousel-slide');
        const slides = document.querySelectorAll('.carousel-item');
        const totalSlides = slides.length;
        const slideWidth = slides[0].offsetWidth + 24; // Ajusta el valor de acuerdo con el ancho de las tarjetas + espaciado
        let currentIndex = 0;

        // Clonamos las primeras tarjetas al final para el efecto de transición infinita
        const cloneSlides = Array.from(slides).slice(0, totalSlides).map(slide => slide.cloneNode(true));
        carouselSlide.append(...cloneSlides);

        function updateCarousel() {
            const offset = -currentIndex * slideWidth;
            carouselSlide.style.transition = 'transform 0.3s ease-in-out';
            carouselSlide.style.transform = `translateX(${offset}px)`;

            // Reiniciar el carrusel sin transición para lograr el efecto infinito
            if (currentIndex >= totalSlides) {
                setTimeout(() => {
                    carouselSlide.style.transition = 'none';
                    currentIndex = 0;
                    const offset = -currentIndex * slideWidth;
                    carouselSlide.style.transform = `translateX(${offset}px)`;
                }, 300);
            } else if (currentIndex < 0) {
                setTimeout(() => {
                    carouselSlide.style.transition = 'none';
                    currentIndex = totalSlides - 1;
                    const offset = -currentIndex * slideWidth;
                    carouselSlide.style.transform = `translateX(${offset}px)`;
                }, 300);
            }
        }

        function nextSlide() {
            currentIndex++;
            updateCarousel();
        }

        function prevSlide() {
            currentIndex--;
            updateCarousel();
        }

        prevBtn.addEventListener('click', prevSlide);
        nextBtn.addEventListener('click', nextSlide);

        // Opcional: Iniciar automáticamente el carrusel
        setInterval(nextSlide, 3000); // Cambiar cada 3 segundos

        // Mostrar modal con contenido específico al hacer clic en una tarjeta
        document.querySelectorAll('.carousel-item').forEach((item, index) => {
            item.addEventListener('click', function() {
                const recipe = @json($recipes)[index];
                const ingredients = JSON.parse(recipe.ingredient);

                // Llenar el contenido del modal
                document.getElementById('modalRecipeName').innerText = recipe.name;
                const modalIngredients = document.getElementById('modalIngredients');
                modalIngredients.innerHTML = '';

                ingredients.forEach(ingredient => {
                    const inventoryItem = @json($inventories).find(i => i.name === ingredient.name);
                    const available = inventoryItem ? inventoryItem.amount : 0;
                    const required = ingredient.quantity;
                    const unit = ingredient.unit;

                    const listItem = document.createElement('li');
                    listItem.innerHTML = `${ingredient.name}: ${available}${unit} / ${required}${unit}`;
                    if (available < required) {
                        listItem.innerHTML += ` <span style="color: red;">(Faltan ${required - available}${unit})</span>`;
                    }
                    modalIngredients.appendChild(listItem);
                });

                document.getElementById('modalPreparation').innerHTML = recipe.description;

                // Configurar la acción del formulario de eliminación
                const deleteForm = document.getElementById('deleteRecipeForm');
                deleteForm.action = `/recipes/${recipe.id}`;

                // Mostrar el modal
                const modal = document.getElementById('modal1');
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    modal.classList.add('opacity-100');
                    modal.querySelector('div').classList.remove('scale-90');
                }, 10);
            });
        });

        // Cerrar modal de información
        document.getElementById('closeModal').addEventListener('click', function() {
            const modal = document.getElementById('modal1');
            modal.classList.add('opacity-0');
            modal.classList.remove('opacity-100');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300); // Duración de la transición de opacidad
        });

        // Abrir modal de agregar receta
        document.getElementById('openAddRecipeModal').addEventListener('click', function() {
            const modal = document.getElementById('addRecipeModal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
                modal.querySelector('div').classList.remove('scale-90');
            }, 10); // Para asegurar que la transición se aplique
        });

        // Cerrar modal de agregar receta
        document.getElementById('closeAddRecipeModal').addEventListener('click', function() {
            const modal = document.getElementById('addRecipeModal');
            modal.classList.add('opacity-0');
            modal.classList.remove('opacity-100');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300); // Duración de la transición de opacidad
        });

        // Añadir nuevo ingrediente
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

            // Añadir evento para eliminar el ingrediente
            newIngredientGroup.querySelector('.remove-ingredient').addEventListener('click', function() {
                newIngredientGroup.remove();
            });
        });

        // Añadir evento para eliminar ingredientes
        document.querySelectorAll('.remove-ingredient').forEach(button => {
            button.addEventListener('click', function() {
                button.closest('.ingredient-group').remove();
            });
        });
    });
</script>
@endauth

@guest
    <div class="text-center text-red-600">No tienes acceso a esta página</div>
@endguest
@endsection
