@extends('layouts.app')

@section('content')
<style>
    * {
        font-family: 'Montserrat';
    }
</style>

<div class="container mx-auto mt-5">
    <div class="container-heading">
        <h1 class="text-3xl text-center font-bold mb-4">Menú</h1>
    </div>
    
    <!-- Carrusel de Imágenes -->
    <div x-data="{ activeSlide: 1, slides: @json($images->pluck('id')) }" class="relative w-full">
        <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="activeSlide === slide" 
                     class="absolute inset-0 transition-all transform duration-700" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 transform scale-95" 
                     x-transition:enter-end="opacity-100 transform scale-100" 
                     x-transition:leave="ease-in duration-300" 
                     x-transition:leave-start="opacity-100 transform scale-100" 
                     x-transition:leave-end="opacity-0 transform scale-95">
                    <img :src="'{{ Storage::url('') }}' + $store.images[slide].path" 
                         class="absolute block w-full h-full object-cover" 
                         alt="Imagen del Carrusel">
                    <div class="absolute bottom-5 left-5 text-white bg-black bg-opacity-50 p-2 rounded">
                        <h5 class="text-lg font-semibold" x-text="'Slide ' + (index + 1)"></h5>
                        <p class="text-sm">Some representative placeholder content for the slide.</p>
                    </div>
                </div>
            </template>
        </div>
        <button @click="activeSlide = activeSlide === 1 ? slides.length : activeSlide - 1" 
                class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none">
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button @click="activeSlide = activeSlide === slides.length ? 1 : activeSlide + 1" 
                class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none">
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>

    <!-- Otros contenidos del menú -->
</div>
@endsection
