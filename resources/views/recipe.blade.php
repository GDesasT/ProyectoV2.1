@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestión de Recipes</h1>

    {{-- Carrusel de Recetas Recomendadas --}}
    <div class="bg-white-100">
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-semibold mb-8">Recetas Recomendadas</h1>
            
            <div class="relative overflow-hidden">
                <div class="carousel-wrapper overflow-hidden">
                    <div class="carousel-slide flex gap-6">
                        <!-- Tarjetas del Carrusel -->
                        @foreach ($recipes as $index => $recipe)
                        <div class="carousel-item group block rounded-lg bg-white shadow-secondary-1 dark:bg-surface-dark transform transition-transform duration-300 hover:scale-105 cursor-pointer" data-modal="modal1" data-content="{{ $recipe->description }}">
                            <a href="#!" class="block relative overflow-hidden rounded-lg">
                                <img class="w-full h-96 object-cover rounded-t-lg transition-transform duration-300 group-hover:scale-110" src="{{ $recipe->image }}" alt="{{ $recipe->name }}" />
                                <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center opacity-0 transition-opacity duration-300 group-hover:opacity-100 p-6">
                                    <div class="text-white text-center">
                                        <h5 class="text-2xl font-medium mb-3">{{ $recipe->name }}</h5>
                                        <p class="mb-2 text-lg">Complejidad: Media</p>
                                        <p class="mb-2 text-lg">Tiempo: {{ $recipe->timeset }}</p>
                                        <p class="text-lg">Una breve explicación de la receta...</p>
                                        {{-- ACORDARME DE AÑADIR ALGO EN BD QUE DIGA EXPLICACION BREVE --}}
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Navegación del Carrusel -->
                    <button class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-700 text-white rounded-full p-2" id="prevBtn">&lt;</button>
                    <button class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-700 text-white rounded-full p-2" id="nextBtn">&gt;</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Lista de Recipes --}}
    <h2>Lista de Recipes</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Ingredientes</th>
                <th>Descripción</th>
                <th>Imagen</th>
                <th>Tiempo de elaboración</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($recipes as $recipe)
            <tr>
                <td>{{ $recipe->name }}</td>
                <td>{{ $recipe->ingredient }}</td>
                <td>{{ $recipe->description }}</td>
                <td><img src="{{ $recipe->image }}" alt="{{ $recipe->name }}" width="50"></td>
                <td>{{ $recipe->timeset }}</td>
                <td>
                    <a href="{{ route('recipes.edit', $recipe->id) }}" class="btn btn-primary btn-sm">Editar</a>
                    <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Botón para abrir el modal de agregar receta --}}
    <h2>Agregar Recipe</h2>
    <button id="openAddRecipeModal" class="btn btn-primary mb-3">Agregar Nueva Recipe</button>

    {{-- Modal para agregar receta --}}
    <div id="addRecipeModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden transition-opacity duration-300 opacity-0">
        <div class="bg-white w-[600px] h-auto p-8 rounded-lg relative transform scale-90 transition-transform duration-300">
            <button class="absolute top-4 right-4 text-black text-2xl cursor-pointer" id="closeAddRecipeModal">&times;</button>
            <h2 class="text-3xl font-bold mb-4">Agregar Nueva Recipe</h2>
            <form action="{{ route('recipes.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre:</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="ingredient" class="form-label">Ingredientes:</label>
                    <input type="text" name="ingredient" id="ingredient" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción:</label>
                    <input type="text" name="description" id="description" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Imagen (URL):</label>
                    <input type="text" name="image" id="image" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="timeset" class="form-label">Tiempo de elaboración:</label>
                    <input type="text" name="timeset" id="timeset" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Agregar</button>
            </form>
        </div>
    </div>

    {{-- Modal de Información de Receta --}}
    <div id="modal1" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden transition-opacity duration-300 opacity-0">
        <div class="bg-white w-[1200px] h-[900px] p-8 rounded-lg relative transform scale-90 transition-transform duration-300">
            <button class="absolute top-4 right-4 text-black text-2xl cursor-pointer" id="closeModal">&times;</button>
            <h2 class="text-3xl font-bold mb-4">Información de la Receta</h2>
            <div id="modalContent">
                <!-- El contenido específico de cada receta se insertará aquí -->
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
            const cloneSlides = Array.from(slides).slice(0, 6).map(slide => slide.cloneNode(true));
            carouselSlide.append(...cloneSlides);

            // Ajusta el ancho del contenedor para todas las tarjetas
            carouselSlide.style.width = `${slideWidth * totalSlides}px`;

            function updateCarousel() {
                const offset = -currentIndex * slideWidth;
                carouselSlide.style.transform = `translateX(${offset}px)`;
            }

            function nextSlide() {
                currentIndex++;
                if (currentIndex >= totalSlides) {
                    currentIndex = 0;
                }
                updateCarousel();
            }

            function prevSlide() {
                currentIndex--;
                if (currentIndex < 0) {
                    currentIndex = totalSlides - 1;
                }
                updateCarousel();
            }

            prevBtn.addEventListener('click', prevSlide);
            nextBtn.addEventListener('click', nextSlide);

            // Opcional: Iniciar automáticamente el carrusel
            setInterval(nextSlide, 3000); // Cambiar cada 3 segundos

            // Mostrar modal con contenido específico al hacer clic en una tarjeta
            document.querySelectorAll('.carousel-item').forEach(item => {
                item.addEventListener('click', function() {
                    const modalId = this.getAttribute('data-modal');
                    const modalContent = this.getAttribute('data-content');
                    const modal = document.getElementById(modalId);
                    const modalContentContainer = document.getElementById('modalContent');
                    
                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        modal.classList.remove('opacity-0');
                        modal.classList.add('opacity-100');
                        modal.querySelector('div').classList.remove('scale-90');
                    }, 10);
                    
                    modalContentContainer.innerHTML = modalContent;
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
        });
    </script>
</div>
@endsection
