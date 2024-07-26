@extends('layouts.login_app')

@section('content')
<div class="container mx-auto mt-10 max-w-lg p-6 bg-white rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-6 text-center">{{ __('Agregar Nueva Imagen') }}</h1>
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('carousel.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="mb-4">
            <label for="dropzone-file" class="block text-gray-700 font-semibold mb-2">{{ __('Imagen:') }}</label>
            <div class="flex items-center justify-center w-full">
                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 relative transition duration-200">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-10 h-10 mb-3 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">{{ __('Haz clic para subir') }}</span> o arrastra y suelta</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('SVG, PNG, JPG o GIF (MAX. 800x400px)') }}</p>
                    </div>
                    <input id="dropzone-file" type="file" name="image" class="hidden" accept="image/*" required>
                    <img id="preview" src="#" alt="Preview" class="absolute top-0 left-0 w-full h-full object-cover rounded hidden"/>
                </label>
            </div>
            <span id="file-name" class="text-gray-500 block mt-2"></span>
        </div>
        <div class="flex justify-center">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-3 rounded-md shadow-md transition duration-200">{{ __('Guardar Imagen') }}</button>
        </div>
    </form>
</div>

@section('scripts')
<script>
document.getElementById('dropzone-file').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');
    const fileName = document.getElementById('file-name');
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        };
        
        reader.readAsDataURL(file);
        fileName.textContent = file.name;
    } else {
        preview.src = '#';
        preview.classList.add('hidden');
        fileName.textContent = '';
    }
});
</script>
@endsection

@endsection
