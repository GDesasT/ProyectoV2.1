@extends('layouts.login_app')

@section('content')
    @auth
        <div class="mb-8 text-3xl text-center font-bold">Inventario</div>

        <!-- Notificación -->
        @if (session('status') || session('delete'))
            <div id="notification" class="mx-auto w-2/3 {{ session('status') ? 'bg-green-500' : 'bg-red-500' }} text-white px-4 py-2 rounded-md shadow-lg text-center">
                {{ session('status') ?? session('delete') }}
            </div>
        @endif

        <div class="flex flex-wrap items-center justify-between mt-1">
            <form method="GET" action="{{ route('inventory') }}" class="flex flex-wrap gap-4 w-full md:w-auto">
                <!-- Campos de búsqueda -->
                <div class="relative group flex-1 min-w-[200px]">
                    <input type="text" name="name" id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                        placeholder="Buscar producto por nombre" value="{{ request('name') }}" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                </div>

                <div class="relative group flex-1 min-w-[200px]">
                    <input type="text" name="amount" id="amount"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                        placeholder="Buscar producto por cantidad" value="{{ request('amount') }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                </div>

                <div class="relative group flex-1 min-w-[200px]">
                    <select id="type" name="type"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                        value="{{ request('type') }}">
                        <option selected disabled value="">Seleccionar Categoría</option>
                        <option value="Verdura">Verdura</option>
                        <option value="Fruta">Fruta</option>
                        <option value="Proteina">Proteina</option>
                        <option value="Lacteo">Lacteo</option>
                        <option value="Embutido">Embutido</option>
                        <option value="Cereales y Legumbres">Cereales y Legumbres</option>
                    </select>
                </div>

                <div class="relative group flex-1 min-w-[200px]">
                    <input type="date" name="date" id="date"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                        value="{{ request('date') }}">
                </div>

                <button type="submit" class="px-4 py-2 font-medium text-white bg-blue-500 rounded hover:bg-blue-700">Buscar</button>
            </form>

            <!-- Botones de Inventario total y Añadir -->
            <div class="flex gap-4 mt-4 md:mt-0">
                <button onclick="location.href='{{ route('inventory') }}'" class="px-4 py-2 font-medium text-white bg-green-500 rounded hover:bg-green-700">Inventario total</button>
                <button onclick="openModal('crud-modal')" class="px-4 py-2 font-medium text-white bg-blue-500 rounded hover:bg-blue-700">Agregar producto / Añadir</button>
            </div>
        </div>

        <!-- Modal para agregar producto -->
        <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 justify-center items-center w-full h-full bg-gray-900 bg-opacity-50">
            <div class="relative p-4 w-full max-w-md max-h-full mx-auto bg-white rounded-lg shadow-md">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Agregar producto / Añadir</h3>
                    <button onclick="closeModal('crud-modal')" type="button" class="text-gray-400 hover:bg-gray-200 rounded-lg p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('inventory.store') }}" class="p-4">
                    @csrf
                    <input type="text" name="name" placeholder="Nombre del producto" required class="mb-4 w-full p-2 border rounded">
                    <input type="number" name="amount" placeholder="Cantidad" step="0.01" required class="mb-4 w-full p-2 border rounded">
                    <select name="unit" required class="mb-4 w-full p-2 border rounded">
                        <option disabled selected>Seleccionar unidad</option>
                        <option value="Kg">Kilogramos (Kg)</option>
                        <option value="L">Litros (L)</option>
                        <option value="Pz">Unidades (Pz)</option>
                    </select>
                    <select name="type" required class="mb-4 w-full p-2 border rounded">
                        <option disabled selected>Seleccionar Categoría</option>
                        <option value="Verdura">Verdura</option>
                        <option value="Fruta">Fruta</option>
                        <option value="Proteina">Proteina</option>
                        <option value="Lacteo">Lacteo</option>
                        <option value="Embutido">Embutido</option>
                        <option value="Cereales y Legumbres">Cereales y Legumbres</option>
                    </select>
                    <button type="submit" class="w-full text-white bg-blue-700 rounded-lg px-5 py-2.5">Agregar producto / Añadir</button>
                </form>
            </div>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-blue-200">
                    <tr>
                        <th class="px-6 py-3">Nombre</th>
                        <th class="px-6 py-3">Cantidad</th>
                        <th class="px-6 py-3">Categoría</th>
                        <th class="px-6 py-3">Fecha Actualización</th>
                        <th class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventories as $inventory)
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4">{{ $inventory->name }}</td>
                            <td class="px-6 py-4">{{ $inventory->amount }} {{ $inventory->unit }}</td>
                            <td class="px-6 py-4">{{ $inventory->type }}</td>
                            <td class="px-6 py-4">{{ $inventory->updated_at }}</td>
                            <td class="px-6 py-4 flex gap-2">
                                <button onclick="openEditModal('{{ $inventory->id }}', '{{ $inventory->name }}', '{{ $inventory->amount }}', '{{ $inventory->unit }}', '{{ $inventory->type }}')" class="bg-blue-700 text-white rounded px-4 py-2">Editar</button>
                                <form action="{{ route('inventory.destroy', $inventory->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-700 text-white rounded px-4 py-2">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal de Edición -->
        <div id="editInventoryModal" class="fixed inset-0 hidden items-center justify-center bg-gray-900 bg-opacity-50 z-50">
            <div class="w-full max-w-md mx-auto p-6 bg-white rounded-lg shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold">Editar Inventario</h2>
                    <button onclick="closeModal('editInventoryModal')" class="text-gray-400 hover:bg-gray-200 rounded p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form id="editInventoryForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <input type="text" name="name" id="editName" placeholder="Nombre" required class="mb-4 w-full p-2 border rounded">
                    <input type="number" name="quantity" id="editQuantity" placeholder="Cantidad" required class="mb-4 w-full p-2 border rounded">
                    <select name="unit" id="editUnit" required class="mb-4 w-full p-2 border rounded">
                        <option value="Kg">Kilogramos (Kg)</option>
                        <option value="L">Litros (L)</option>
                        <option value="Pz">Unidades (Pz)</option>
                    </select>
                    <select name="type" id="editType" required class="mb-4 w-full p-2 border rounded">
                        <option value="Verdura">Verdura</option>
                        <option value="Fruta">Fruta</option>
                        <option value="Proteina">Proteina</option>
                        <option value="Lacteo">Lacteo</option>
                        <option value="Embutido">Embutido</option>
                        <option value="Cereales y Legumbres">Cereales y Legumbres</option>
                    </select>
                    <button type="submit" class="w-full text-white bg-blue-600 rounded-lg px-4 py-2">Guardar Cambios</button>
                </form>
            </div>
        </div>
    @endauth

    @guest
        <div class="text-center text-red-600">No tienes acceso a esta página</div>
    @endguest
@endsection

<style>
    .tooltip-light { position: absolute; left: 50%; transform: translateX(-50%); bottom: 125%; background-color: white; color: #1f2937; border: 1px solid #e5e7eb; padding: 0.5rem; border-radius: 0.5rem; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); white-space: nowrap; z-index: 1000; }
    .group:hover .tooltip-light { display: block; }
    .tooltip-arrow { position: absolute; bottom: -0.25rem; left: 50%; transform: translateX(-50%); width: 0; height: 0; border-left: 0.25rem solid transparent; border-right: 0.25rem solid transparent; border-top: 0.25rem solid #e5e7eb; }
</style>

<script>
    function openModal(modalId) {
        // Mostrar el modal
        document.getElementById(modalId).style.display = 'flex';

        // Animación para hacer visible el modal
        setTimeout(() => {
            document.getElementById(modalId).style.opacity = '1';
            document.getElementById(modalId).firstElementChild.style.transform = 'scale(1)';
        }, 10);
    }

    function closeModal(modalId) {
        // Ocultar el modal con animación
        document.getElementById(modalId).style.opacity = '0';
        document.getElementById(modalId).firstElementChild.style.transform = 'scale(0.9)';

        // Después de la animación, ocultar completamente el modal
        setTimeout(() => {
            document.getElementById(modalId).style.display = 'none';
        }, 300);
    }

    function openEditModal(id, name, amount, unit, type) {
        // Rellenar los campos del formulario con los valores actuales
        document.getElementById('editName').value = name;
        document.getElementById('editQuantity').value = amount;
        document.getElementById('editUnit').value = unit;
        document.getElementById('editType').value = type;

        // Establecer la acción del formulario para enviar la actualización a la ruta correcta
        document.getElementById('editInventoryForm').action = `/inventory/${id}`;

        // Mostrar el modal de edición
        openModal('editInventoryModal');
    }
</script>
