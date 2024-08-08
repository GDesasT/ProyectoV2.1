@extends('layouts.app')

@section('content')
<style>
    * {
        font-family: 'Montserrat';
    }
</style>

<div class="container mx-auto mt-5">
    <div class="container-heading">
        <h1 id="desayunos" class="text-3xl text-center font-bold mb-4">Desayunos</h1>
    </div>
    @if($images->count() > 0)
        <div x-data="carouselData()" class="relative w-full">
            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="activeSlide === (index + 1)" class="absolute inset-0 transition-all transform duration-700"
                        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="ease-in duration-300"
                        x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
                        <img :src="'{{ Storage::url('') }}' + slide.path" class="absolute block w-full h-full object-cover" alt="">
                        <div class="absolute bottom-5 left-5 text-white bg-black bg-opacity-50 p-2 rounded">
                            <h5 class="text-lg font-semibold" x-text="'Slide ' + (index + 1)"></h5>
                            <p class="text-sm">Some representative placeholder content for the slide.</p>
                        </div>
                    </div>
                </template>
            </div>
            <button @click="prevSlide()" id="prev" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button @click="nextSlide()" id="next" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none">
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
    @else
        <p class="text-center">No hay imágenes activas en el carrusel.</p>
    @endif
    <div class="text-center mt-4">
        <button type="button" id="feedback" class="flex items-center justify-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700">
            <img src="{{ asset('img/messenger.png') }}" id="openComment" class="h-5 mr-2">Comentarios
        </button>
    </div>
    
    <div id="CommentModal" class="fixed inset-0 flex items-center justify-center hidden transition-opacity duration-300 bg-black bg-opacity-70">
        <div class="relative w-full max-w-md p-8 bg-white rounded-lg">
            <button class="absolute top-4 right-4 text-2xl text-gray-600 cursor-pointer" id="closeCommentModal">&times;</button>
            <h2 class="mb-6 text-2xl font-bold text-center text-gray-800">Deja tu Comentario</h2>
            <form action="{{ route('menu') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="comment" class="block mb-2 text-sm font-medium text-gray-600">Comentario:</label>
                    <textarea name="comment" id="comment" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required></textarea>
                </div>
                <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring focus:ring-blue-300 focus:outline-none">Enviar</button>
            </form>
        </div>
    </div>
</div>
    
<script src="{{ asset('js/app.js') }}"></script>
<script>
    function carouselData() {
        return {
            activeSlide: 1,
            slides: @json($images),
            nextSlide() {
                if (this.activeSlide === this.slides.length) {
                    this.activeSlide = 1;
                } else {
                    this.activeSlide++;
                }
            },
            prevSlide() {
                if (this.activeSlide === 1) {
                    this.activeSlide = this.slides.length;
                } else {
                    this.activeSlide--;
                }
            }
        }
    }

    document.getElementById('feedback').addEventListener('click', function () {
        document.getElementById('CommentModal').classList.remove('hidden');
        document.getElementById('CommentModal').classList.add('flex');
        document.getElementById('prev').classList.add('hidden');
        document.getElementById('prev').classList.remove('flex');
        document.getElementById('next').classList.add('hidden');
        document.getElementById('next').classList.remove('flex');
    });

    document.getElementById('closeCommentModal').addEventListener('click', function () {
        document.getElementById('CommentModal').classList.add('hidden');
        document.getElementById('CommentModal').classList.remove('flex');
        document.getElementById('prev').classList.remove('hidden');
        document.getElementById('prev').classList.add('flex');
        document.getElementById('next').classList.remove('hidden');
        document.getElementById('next').classList.add('flex');
    });
</script>
@endsection