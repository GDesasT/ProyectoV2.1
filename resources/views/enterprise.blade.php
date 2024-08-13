@extends('layouts.login_app')

@section('content')
    @auth
        <div class="my-4 text-2xl font-bold text-center text-gray-800">Agregar Nueva Empresa</div>

        @if(session('success'))
            <div class="p-4 mb-4 text-center text-white bg-green-500 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="relative max-w-4xl p-6 mx-auto mt-5 overflow-x-auto bg-white rounded-lg shadow-md sm:rounded-lg">
            <form action="{{ route('enterprises.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre de la Empresa</label>
                    <input type="text" id="name" name="name" maxlength="45" required
                           class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="address" class="block text-sm font-medium text-gray-700">Dirección</label>
                    <textarea id="address" name="address" rows="4" required
                              class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                        Agregar Empresa
                    </button>
                </div>
            </form>
        </div>
    @endauth

    @guest
        <div class="mt-4 text-center text-red-600">No tienes acceso a esta página</div>
    @endguest
@endsection
