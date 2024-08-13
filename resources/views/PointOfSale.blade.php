@extends('layouts.login_app')

@section('content')
    @auth

        <div class="mb-8 text-3xl font-bold text-center">Punto de venta</div>
        @if (session('success'))
            <div id="notification" class="mx-auto w-2/3 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg text-center">
                {{ session('success') }}
            </div>
        @elseif (session('delete'))
            <div id="notification" class="mx-auto w-2/3 bg-red-500 text-white px-4 py-2 rounded-md shadow-lg text-center">
                {{ session('delete') }}
            </div>
        @endif
        <br>

        <div class="flex flex-wrap items-center justify-between mt-1">
            <div class="relative w-full mb-2 md:w-auto md:mb-0">
                <form method="GET" action="{{ route('PointOfSale') }}"
                    class="flex flex-wrap items-center space-x-2 md:flex-nowrap md:space-x-4">
                    <input type="text" name="number" id="number"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                        placeholder="Buscar por Numero de Trabajador" value="{{ request('number') }}">
                    <input type="text" name="customer_id" id="customer_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                        placeholder="Buscar por ID de comedor" value="{{ request('customer_id') }}">

                    <input type="text" name="name" id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                        placeholder="Buscar por nombre" value="{{ request('name') }}">

                    <input type="text" name="lastName" id="lastName"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                        placeholder="Buscar por apellido" value="{{ request('lastName') }}">

                    <input type="date" name="date" id="date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                        value="{{ request('date') }}">

                    <select name="dish_type" id="dish_type"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                        <option value="" disabled selected>Filtrar por tipo de platillo</option>
                        <option value="platillo normal" {{ request('dish_type') == 'platillo normal' ? 'selected' : '' }}>
                            Platillo Normal</option>
                        <option value="platillo ligero" {{ request('dish_type') == 'platillo ligero' ? 'selected' : '' }}>
                            Platillo Ligero</option>
                    </select>

                    <button type="submit"
                        class="px-4 py-2 ml-2 font-medium text-white bg-blue-500 rounded hover:bg-blue-700">Buscar</button>
                </form>
            </div>

            <div class="flex flex-wrap items-center w-full space-x-2 md:w-auto md:flex-nowrap md:space-x-4">
                <button onclick="filterTodaySales()" type="button"
                    class="w-full px-4 py-2 font-medium text-white bg-green-500 rounded md:w-auto hover:bg-green-700">Ventas de
                    Hoy</button>

                <button onclick="openModal()" crud-modal data-modal-toggle="crud-modal" type="button"
                    class="w-full px-4 py-2 font-medium text-white bg-blue-500 rounded md:w-auto hover:bg-blue-700">Agregar
                    Venta</button>
            </div>
        </div>

        <div id="crud-modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 z-50 hidden overflow-y-auto">
            <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-50"></div>
            <div class="flex items-center justify-center min-h-screen p-4 text-center">
                <div
                    class="relative w-full max-w-md transition-transform transform scale-95 bg-white border border-gray-200 rounded-lg shadow-xl opacity-0">
                    <div class="flex items-center justify-between p-6">
                        <h3 class="text-2xl font-bold text-gray-900">
                            Agregar Venta
                        </h3>
                        <button onclick="closeModal()" type="button"
                            class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Cerrar modal</span>
                        </button>
                    </div>
                    <form id="product-form" class="p-6" method="POST" action="{{ route('sales.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="number" class="block mb-2 text-sm font-medium text-gray-900">Numero de
                                Trabajador</label>
                            <input type="text" name="number" id="number"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                placeholder="Numero de Trabajador" required>
                        </div>
                        <div class="mb-4">
                            <label for="dish_type" class="block mb-2 text-sm font-medium text-gray-900">Tipo de platillo</label>
                            <select name="dish_type" id="dish_type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                required>
                                <option value="" disabled selected>Selecciona el tipo de platillo</option>
                                <option value="platillo normal">Platillo Normal</option>
                                <option value="platillo ligero">Platillo Ligero</option>
                            </select>
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Agregar nueva venta
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <br>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table id="product-table" class="w-full text-sm text-left text-gray-500 rtl:text-right">
                <thead class="text-xs text-gray-700 uppercase bg-blue-200 ">
                    <tr>
                        <th scope="col" class="px-6 py-3"><strong>ID del comedor</strong></th>
                        <th scope="col" class="px-6 py-3"><strong>Nombre</strong></th>
                        <th scope="col" class="px-6 py-3"><strong>Apellido</strong></th>
                        <th scope="col" class="px-6 py-3"><strong>Tipo platillo</strong></th>
                        <th scope="col" class="px-6 py-3"><strong>Total</strong></th>
                        <th scope="col" class="px-6 py-3"><strong>Fecha de venta</strong></th>
                        <th scope="col" class="px-6 py-3"><strong>Acciones</strong></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                        <tr class="bg-white border-b    dark:hover:bg-gray-100">
                            <td class="px-6 py-4">{{ $sale->customer_id }}</td>
                            <td class="px-6 py-4">{{ $sale->name }}</td>
                            <td class="px-6 py-4">{{ $sale->lastName }}</td>
                            <td class="px-6 py-4">{{ $sale->dish_type }}</td>
                            <td class="px-6 py-4">{{ $sale->total }}</td>
                            <td class="px-6 py-4">{{ $sale->updated_at }}</td>
                            <td class="px-6 py-4 flex space-x-2">
                                <form action="{{ route('sales.destroy', $sale->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 focus:outline-none"
                                        onclick="return confirm('¿Estás seguro de que quieres eliminar esta venta?');">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <br>
    @endauth

    @guest
        <div class="text-center text-red-600">No tienes acceso a esta página</div>
    @endguest
@endsection

<script>
    function openModal() {
        const modal = document.getElementById("crud-modal");
        const modalContent = modal.querySelector('.relative');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('.bg-opacity-50').classList.add('opacity-100');
            modalContent.classList.remove('opacity-0', 'scale-95');
            modalContent.classList.add('opacity-100', 'scale-100');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById("crud-modal");
        const modalContent = modal.querySelector('.relative');

        modalContent.classList.remove('opacity-100', 'scale-100');
        modalContent.classList.add('opacity-0', 'scale-95');
        modal.querySelector('.bg-opacity-50').classList.remove('opacity-100');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200); // Tiempo reducido para cerrar más rápido
    }

    function filterTodaySales() {
        const today = new Date().toISOString().split('T')[0];
        window.location.href = `{{ route('PointOfSale') }}?date=${today}`;
    }
    document.addEventListener('DOMContentLoaded', function() {
        const notification = document.getElementById('notification');
        if (notification) {
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => notification.remove(),
                500); // Elimina el elemento del DOM después de la animación
            }, 3000); // La notificación desaparecerá después de 3 segundos
        }
    })
</script>
