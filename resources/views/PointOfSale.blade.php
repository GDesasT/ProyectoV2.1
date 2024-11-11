@extends('layouts.login_app')

@section('content')
    @auth
        <div class="mb-8 text-3xl font-bold text-center">Punto de venta</div>

        <!-- Notificaciones -->
        @if (session('success') || session('delete') || session('error'))
            <div id="notification" class="mx-auto w-2/3 p-4 text-white text-center rounded-md shadow-lg
                {{ session('success') ? 'bg-green-500' : 'bg-red-500' }}">
                {{ session('success') ?? session('delete') ?? session('error') }}
            </div>
        @endif

        <!-- Selección de Empresa -->
        <form method="POST" action="{{ route('set-enterprise') }}" class="flex items-center justify-center mb-4">
            @csrf
            <select name="enterprise_id" id="enterprise_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                <option value="" disabled selected>Selecciona la Empresa</option>
                @foreach($enterprises as $enterprise)
                    <option value="{{ $enterprise->id }}" {{ session('enterprise_id') == $enterprise->id ? 'selected' : '' }}>
                        {{ $enterprise->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 ml-2 text-white bg-blue-500 rounded hover:bg-blue-700">Guardar</button>
        </form>

        <!-- Formulario de Búsqueda -->
        <div class="flex flex-wrap items-center justify-between mt-1">
            <form method="GET" action="{{ route('PointOfSale') }}" class="flex flex-wrap gap-4 w-full">
                <input type="hidden" name="enterprise_id" value="{{ session('enterprise_id') }}">

                <!-- Campos de búsqueda -->
                @foreach (['number' => 'Número de Trabajador', 'customer_id' => 'ID de comedor', 'name' => 'Nombre', 'lastName' => 'Apellido'] as $field => $placeholder)
                    <div class="relative flex-1 min-w-[200px] group">
                        <input type="text" name="{{ $field }}" placeholder="Buscar por {{ $placeholder }}"
                               value="{{ request($field) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5"
                               oninput="this.value = this.value.replace(/[^{{ $field === 'number' || $field === 'customer_id' ? '0-9' : 'a-zA-Z\\s' }}]/g, '')">
                        <div class="tooltip-light hidden text-center group-hover:block absolute z-10 w-64 px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm">
                            Buscar por {{ $placeholder }}
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </div>
                @endforeach

                <input type="date" name="date" value="{{ request('date') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">

                <select name="dish_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                    <option value="" disabled selected>Filtrar por tipo de platillo</option>
                    <option value="platillo normal" {{ request('dish_type') == 'platillo normal' ? 'selected' : '' }}>Platillo Normal</option>
                    <option value="platillo ligero" {{ request('dish_type') == 'platillo ligero' ? 'selected' : '' }}>Platillo Ligero</option>
                </select>

                <button type="submit" class="px-4 py-2 ml-2 text-white bg-blue-500 rounded hover:bg-blue-700">Buscar</button>
            </form>

            <!-- Botones adicionales -->
            <div class="flex gap-4 mt-4 md:mt-0">
                <button onclick="filterTodaySales()" class="px-4 py-2 text-white bg-green-500 rounded hover:bg-green-700">Ventas de Hoy</button>
                <button onclick="openModal()" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-700">Agregar Venta</button>
            </div>
        </div>

        <!-- Modal -->
        <div id="crud-modal" tabindex="-1" class="fixed inset-0 z-50 hidden overflow-y-auto">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50" onclick="closeModal()"></div>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative w-full max-w-md bg-white rounded-lg shadow-xl p-6">
                    <h3 class="text-2xl font-bold text-gray-900">Agregar Venta</h3>
                    <button onclick="closeModal()" type="button"
                        class="absolute top-3 right-3 inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Cerrar modal</span>
                    </button>
                    <form id="product-form" method="POST" action="{{ route('sales.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-900">Número de Trabajador</label>
                            <input type="text" name="number" class="bg-gray-50 border border-gray-300 rounded-lg p-2.5 w-full" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-900">Tipo de platillo</label>
                            <select name="dish_type" class="bg-gray-50 border border-gray-300 rounded-lg p-2.5 w-full" required>
                                <option value="" disabled selected>Selecciona el tipo de platillo</option>
                                <option value="platillo normal">Platillo Normal</option>
                                <option value="platillo ligero">Platillo Ligero</option>
                            </select>
                        </div>
                        <input type="hidden" name="enterprise_id" value="{{ session('enterprise_id') }}">
                        <button type="submit" class="w-full text-white bg-blue-600 rounded-lg px-5 py-2.5">Agregar nueva venta</button>
                    </form>                    
                </div>
            </div>
        </div>

        <!-- Tabla de Ventas -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table id="product-table" class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs bg-blue-200 text-gray-700 uppercase">
                    <tr>
                        @foreach (['ID del comedor', 'Nombre', 'Apellido', 'Tipo platillo', 'Empresa', 'Total', 'Fecha de venta', 'Acciones'] as $header)
                            <th class="px-6 py-3"><strong>{{ $header }}</strong></th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sales as $sale)
                        <tr class="bg-white border-b hover:bg-gray-100">
                            <td class="px-6 py-4">{{ $sale->number }}</td>
                            <td class="px-6 py-4">{{ $sale->name }}</td>
                            <td class="px-6 py-4">{{ $sale->lastName }}</td>
                            <td class="px-6 py-4">{{ $sale->dish_type }}</td>
                            <td class="px-6 py-4">{{ $sale->customer->enterprise->name }}</td>
                            <td class="px-6 py-4">{{ $sale->total }}</td>
                            <td class="px-6 py-4">{{ $sale->updated_at }}</td>
                            <td class="px-6 py-4">
                                <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-red-700 rounded-lg px-5 py-2.5">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endauth

    @guest
        <div class="text-center text-red-600">No tienes acceso a esta página</div>
    @endguest
@endsection

<style>
    .tooltip-light {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        bottom: 125%;
        background-color: white;
        color: #1f2937;
        border: 1px solid #e5e7eb;
        padding: 0.5rem;
        border-radius: 0.5rem;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        white-space: nowrap;
        z-index: 1000;
    }

    .group:hover .tooltip-light {
        display: block;
    }

    .tooltip-arrow {
        position: absolute;
        bottom: -0.25rem;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 0.25rem solid transparent;
        border-right: 0.25rem solid transparent;
        border-top: 0.25rem solid #e5e7eb;
    }
</style>
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
        }, 200);
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
                500);
            }, 3000);
        }
    })
</script>
