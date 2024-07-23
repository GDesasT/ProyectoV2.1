@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestión de Recipes</h1>

    {{-- Carrusel de Recetas Recomendadas --}}
    <div class="bg-white-100">
        <div class="container p-4 mx-auto">
            <h1 class="mb-8 text-2xl font-semibold">Recetas Recomendadas</h1>

            <div class="relative overflow-hidden">
                <div class="overflow-hidden carousel-wrapper">
                    <div class="flex gap-6 carousel-slide">
                        <!-- Tarjetas del Carrusel -->
                        @foreach ($recipes as $index => $recipe)
                        <div class="block transition-transform duration-300 transform bg-white rounded-lg cursor-pointer carousel-item group shadow-secondary-1 dark:bg-surface-dark hover:scale-105" data-modal="modal1" data-content="{{ $recipe->description }}">
                            <a href="#!" class="relative block overflow-hidden rounded-lg">
                                <img class="object-cover w-full transition-transform duration-300 rounded-t-lg h-96 group-hover:scale-110" src="{{ $recipe->image }}" alt="{{ $recipe->name }}" />
                                <div class="absolute inset-0 flex items-center justify-center p-6 transition-opacity duration-300 bg-black opacity-0 bg-opacity-60 group-hover:opacity-100">
                                    <div class="text-center text-white">
                                        <h5 class="mb-3 text-2xl font-medium">{{ $recipe->name }}</h5>
                                        <p class="mb-2 text-lg">Complejidad: Media</p>
                                        <p class="mb-2 text-lg">Tiempo: {{ $recipe->timeset }}</p>
                                        <p class="text-lg">{{ $recipe->shortdesc }}</p>

                                        {{-- ACORDARME DE AÑADIR ALGO EN BD QUE DIGA EXPLICACION BREVE --}}
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


            @foreach ($recipes as $recipe)

            @endforeach


    {{-- Botón para abrir el modal de agregar receta --}}
    <button id="openAddRecipeModal" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Agregar Nueva Receta</button>


 {{-- Modal para agregar receta --}}
<div id="addRecipeModal" class="fixed inset-0 flex items-center justify-center hidden transition-opacity duration-300 bg-black bg-opacity-70">
    <div class="relative w-full h-auto max-w-2xl p-8 transition-transform duration-300 transform scale-90 bg-white rounded-lg">
        <button class="absolute text-2xl text-gray-600 cursor-pointer top-4 right-4" id="closeAddRecipeModal">&times;</button>
        <h2 class="mb-6 text-3xl font-bold text-center text-gray-800">Agregar Nueva Receta</h2>
        <form action="{{ route('recipes.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-600">Nombre:</label>
                <input type="text" name="name" id="name" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
            </div>
            <div class="mb-4">
                <label for="ingredient" class="block mb-2 text-sm font-medium text-gray-600">Ingredientes:</label>
                <input type="text" name="ingredient" id="ingredient" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
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
                <label for="timeset" class="block mb-2 text-sm font-medium text-gray-600">Añade una Descripcion Breve</label>
                <input type="text" name="shortdesc" id="shortdesc" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-600">Procedimiento de la Receta:</label>
                <textarea name="description" rows="8" cols="30" id="description" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required></textarea>

            </div>
            <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring focus:ring-blue-300 focus:outline-none">Agregar</button>
        </form>
    </div>
</div>

    {{-- Modal de Información de Receta --}}
    <div id="modal1" class="fixed inset-0 flex items-center justify-center hidden transition-opacity duration-300 bg-black opacity-0 bg-opacity-70">
        <div class="bg-white w-[1200px] h-[900px] p-8 rounded-lg relative transform scale-90 transition-transform duration-300">
            <button class="absolute text-2xl text-black cursor-pointer top-4 right-4" id="closeModal">&times;</button>
            <h2 class="mb-4 text-3xl font-bold">Información de la Receta</h2>
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
