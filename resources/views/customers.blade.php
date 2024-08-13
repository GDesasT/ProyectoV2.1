@extends('layouts.adminnav_app')

@section('content')
    @auth
        <div class="my-4 text-2xl font-bold text-center text-gray-800">Agregar Nuevo Empleado</div>

        @if(session('success'))
            <div class="p-4 mb-4 text-center text-white bg-green-500 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="relative max-w-4xl p-6 mx-auto mt-5 overflow-x-auto bg-white rounded-lg shadow-md sm:rounded-lg">
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="number" class="block text-sm font-medium text-gray-700">Número de Empleado:</label>
                    <input type="text" id="number" name="number" maxlength="45" required
                           class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" id="name" name="name" maxlength="45" required
                        class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="lastname" class="block text-sm font-medium text-gray-700">Apellido</label>
                    <input type="text" id="lastname" name="lastname" maxlength="45" required
                        class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" maxlength="45" required
                        class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="enterprise_id" class="block text-sm font-medium text-gray-700">Empresa</label>
                    <select id="enterprise_id" name="enterprise_id" required
                            class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="" disabled selected>Selecciona una empresa</option>
                        @foreach($enterprises as $enterprise)
                            <option value="{{ $enterprise->id }}">{{ $enterprise->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                        Agregar Empleado
                    </button>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="p-4 mt-8 mb-4 text-center text-green-700 bg-green-200 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-8">
            <h2 class="my-4 text-2xl font-bold text-center text-gray-800">Buscar Empleado</h2>
            <form action="{{ route('customers.search') }}" method="GET" class="max-w-xl mx-auto">
                <div class="mb-4">
                    <label for="search_email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="search_email" name="email"
                        class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="search_number" class="block text-sm font-medium text-gray-700">Número de Empleado</label>
                    <input type="text" id="search_number" name="number"
                        class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="mb-4">
                    <label for="search_enterprise_id" class="block text-sm font-medium text-gray-700">Empresa</label>
                    <select id="search_enterprise_id" name="enterprise_id"
                        class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="" disabled selected>Selecciona una empresa</option>
                        @foreach($enterprises as $enterprise)
                            <option value="{{ $enterprise->id }}">{{ $enterprise->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                        Buscar Empleado
                    </button>
                </div>
            </form>
        </div>

        @if(isset($customers) && $customers->isNotEmpty())
            <div class="p-4 mt-8 text-center bg-gray-100 rounded-lg">
                <h3 class="text-lg font-bold">Empleados Encontrados:</h3>
                @foreach($customers as $customer)
                    <div class="my-4 p-2 bg-white rounded shadow-md">
                        <p>Numero de Empleado: {{ $customer->number }}</p>
                        <p>ID: {{ $customer->id }}</p>
                        <p>Nombre: {{ $customer->name }} {{ $customer->lastname }}</p>
                        <p>Email: {{ $customer->email }}</p>
                        <p>Empresa: {{ $customer->enterprise->name }}</p>

                        <!-- Formulario para eliminar al empleado -->
                        <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este empleado?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 mt-4 font-bold text-white bg-red-500 rounded hover:bg-red-700">
                                Eliminar Empleado
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @elseif(isset($customers))
            <div class="p-4 mt-8 text-center text-red-700 bg-red-200 rounded">
                No se encontraron empleados.
            </div>
        @endif
    @endauth

    @guest
        <div class="mt-4 text-center text-red-600">No tienes acceso a esta página</div>
    @endguest
@endsection
