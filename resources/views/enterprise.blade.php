@extends('layouts.adminnav_app')

@section('content')
    @auth
        <div class="my-4 text-2xl font-bold text-center text-gray-800">Agregar Nueva Empresa</div>

        @if(session('success'))
            <div class="p-4 mb-4 text-center text-white bg-green-500 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-4 text-center text-white bg-red-500 rounded">
                {{ session('error') }}
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
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" maxlength="45" required
                           class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Número de Teléfono</label>
                    <input type="text" id="phone" name="phone" maxlength="45" required
                           class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                           title="Solo se permiten números" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
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

        <div class="relative max-w-4xl p-6 mx-auto mt-5 overflow-x-auto bg-white rounded-lg shadow-md sm:rounded-lg">
            <h2 class="my-4 text-2xl font-bold text-center text-gray-800">Buscar Empresa</h2>
            <form action="{{ route('enterprises.search') }}" method="GET" class="max-w-xl mx-auto">
                <div class="mb-4">
                    <label for="search_name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" id="search_name" name="name"
                        class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="search_email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="search_email" name="email"
                        class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="search_phone" class="block text-sm font-medium text-gray-700">Número de Teléfono</label>
                    <input type="text" id="search_phone" name="phone" pattern="[0-9]+"
                        class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        title="Solo se permiten números" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                        Buscar Empresa
                    </button>
                </div>
            </form>
        </div>

        @if(isset($enterprises) && $enterprises->isNotEmpty())
            <div class="p-4 mt-8 text-center bg-gray-100 rounded-lg">
                <h3 class="text-lg font-bold">Empresas Encontradas:</h3>
                @foreach($enterprises as $enterprise)
                    <div class="my-4 p-2 bg-white rounded shadow-md">
                        <p>Nombre: {{ $enterprise->name }}</p>
                        <p>Email: {{ $enterprise->email }}</p>
                        <p>Teléfono: {{ $enterprise->phone }}</p>
                        <p>Dirección: {{ $enterprise->address }}</p>

                        <!-- Formulario para eliminar la empresa -->
                        <form action="{{ route('enterprises.destroy', $enterprise->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta empresa?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 mt-4 font-bold text-white bg-red-500 rounded hover:bg-red-700">
                                Eliminar Empresa
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @elseif(isset($enterprises))
            <div class="p-4 mt-8 text-center text-red-700 bg-red-200 rounded">
                No se encontraron empresas.
            </div>
        @endif
    @endauth

    @guest
        <div class="mt-4 text-center text-red-600">No tienes acceso a esta página</div>
    @endguest
@endsection
