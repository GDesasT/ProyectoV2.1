@extends('layouts.login_app')

@section('content')
    @auth
    <div class="mb-8 text-3xl text-center font-bold">Punto de venta y Kevin está bien estúpido</div>

        <div class="flex justify-between items-center mt-1">
            <div class="relative">
                <form method="GET" action="{{ route('PointOfSale') }}" class="flex items-center space-x-4">
                    <input type="text" name="customer_id" id="customer_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Buscar por ID de trabajador" value="{{ request('customer_id') }}">
                    
                    <input type="text" name="name" id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Buscar por nombre" value="{{ request('name') }}">
                    
                    <input type="text" name="lastName" id="lastName"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Buscar por apellido" value="{{ request('lastName') }}">

                    <input type="date" name="date" id="date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        value="{{ request('date') }}">

                    <select name="dish_type" id="dish_type"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="" disabled selected>Filtrar por tipo de platillo</option>
                        <option value="platillo normal" {{ request('dish_type') == 'platillo normal' ? 'selected' : '' }}>Platillo Normal</option>
                        <option value="platillo ligero" {{ request('dish_type') == 'platillo ligero' ? 'selected' : '' }}>Platillo Ligero</option>
                    </select>
                    
                    <button type="submit"
                        class="ml-2 px-4 py-2 text-white bg-blue-500 hover:bg-blue-700 font-medium rounded">Buscar</button>
                </form>
            </div>

            <div class="flex items-center space-x-4">
                <button onclick="filterTodaySales()" type="button"
                    class="px-4 py-2 text-white bg-green-500 hover:bg-green-700 font-medium rounded">Ventas de Hoy</button>

                <button onclick="openModal()" crud-modal data-modal-toggle="crud-modal" type="button"
                    class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-700 font-medium rounded">Agregar Venta</button>
            </div>
        </div>

        <div id="crud-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Agregar Venta
                        </h3>
                        <button onclick="closeModal()" type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="crud-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form id="product-form" class="p-4 md:p-5" method="POST" action="{{ route('sales.store') }}">
                        @csrf
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="customer_id" class="block mb-2 text-center text-sm font-medium text-gray-900 dark:text-white">ID usuario</label>
                                <input type="text" name="customer_id" id="customer_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="ID del usuario " required>
                            </div>         
                            <div class="col-span-2 sm:col-span-1">
                                <label for="dish_type" class="block mb-2 text-sm text-center font-medium text-gray-900 dark:text-white">Tipo de platillo</label>
                                
                                <select name="dish_type" id="dish_type"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    required>
                                    <option value="" disabled selected>Selecciona el tipo de platillo</option>
                                    <option value="platillo normal">Platillo Normal</option>
                                    <option value="platillo ligero">Platillo Ligero</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Agregar nueva venta
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <br>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table id="product-table" class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID usuario</th>
                        <th scope="col" class="px-6 py-3">Nombre</th>
                        <th scope="col" class="px-6 py-3">Apellido</th>
                        <th scope="col" class="px-6 py-3">Tipo platillo</th>
                        <th scope="col" class="px-6 py-3">Total</th>
                        <th scope="col" class="px-6 py-3">Fecha de venta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                    <tr>
                        <td class="px-6 py-4">{{ $sale->customer_id }}</td>
                        <td class="px-6 py-4">{{ $sale->name }}</td>
                        <td class="px-6 py-4">{{ $sale->lastName }}</td>
                        <td class="px-6 py-4">{{ $sale->dish_type }}</td>
                        <td class="px-6 py-4">{{ $sale->total }}</td>
                        <td class="px-6 py-4">{{ $sale->updated_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
    @endauth

    @guest
        <div class="text-center text-red-600">No tienes acceso a esta página y Kevin está bien estúpido</div>
    @endguest
@endsection

<script>
    function openModal() {
        document.getElementById("crud-modal").style.display = 'flex';
    }

    function closeModal() {
        document.getElementById("crud-modal").style.display = 'none';
    }

    function filterTodaySales() {
        const today = new Date().toISOString().split('T')[0];
        window.location.href = `{{ route('PointOfSale') }}?date=${today}`;
    }
</script>
