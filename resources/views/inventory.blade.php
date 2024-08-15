@extends('layouts.login_app')

@section('content')
    @auth
        <div class="mb-8 text-3xl text-center font-bold">Inventario</div>
        <br>

        <!-- Notificación -->
        @if (session('status'))
            <div id="notification" class="mx-auto w-2/3 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg text-center">
                {{ session('status') }}
            </div>
        @elseif (session('delete'))
            <div id="notification" class="mx-auto w-2/3 bg-red-500 text-white px-4 py-2 rounded-md shadow-lg text-center">
                {{ session('delete') }}
            </div>
        @endif

        <div class="flex flex-wrap items-center justify-between mt-1">
            <div class="relative w-full mb-2 md:w-auto md:mb-0">
                <form method="GET" action="{{ route('inventory') }}"
                    class="flex flex-wrap gap-4">

                    <!-- Input Nombre con Tooltip -->
                    <div class="relative group flex-1 min-w-[200px]">
                        <input type="text" name="name" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Buscar producto por nombre" value="{{ request('name') }}">
                        <div class="tooltip-light hidden text-center group-hover:block absolute z-10 w-64 px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm">
                            Buscar por nombre
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </div>

                    <!-- Input Monto con Tooltip -->
                    <div class="relative group flex-1 min-w-[200px]">
                        <input type="text" name="amount" id="amount"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Buscar producto por cantidad" value="{{ request('amount') }}">
                        <div class="tooltip-light hidden text-center group-hover:block absolute z-10 w-64 px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm">
                            Buscar por cantidad
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </div>

                    <!-- Input Tipo con Tooltip -->
                    <div class="relative group flex-1 min-w-[200px]">
                        <select id="type" name="type"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required value="{{ request('type') }}">
                        <option selected disabled value="">Seleccionar Categoría</option>
                        <option value="Verdura">Verdura</option>
                        <option value="Fruta">Fruta</option>
                        <option value="Proteina">Proteina</option>
                        <option value="Cereales y Legumbres">Cereales y Legumbres</option>
                    </select>
                        <div class="tooltip-light hidden text-center group-hover:block absolute z-10 w-64 px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm">
                            Buscar por categoría
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </div>

                    <!-- Input Fecha con Tooltip -->
                    <div class="relative group flex-1 min-w-[200px]">
                        <input type="date" name="date" id="date"
                            class="bg-gray-50 border cursor-pointer border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            value="{{ request('date') }}">
                        <div class="tooltip-light hidden text-center group-hover:block absolute z-10 w-64 px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm">
                           Buscar por fecha
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </div>

                    <button type="submit"
                        class="px-4 py-2 font-medium text-white bg-blue-500 rounded hover:bg-blue-700">Buscar</button>
                </form>
            </div>

            <!-- Botones de Inventario total y Añadir -->
            <div class="flex flex-wrap gap-4 mt-4 md:mt-0">
                <!-- Botón que muestra todo el inventario -->
                <button onclick="location.href='{{ route('inventory') }}'" type="button"
                    class="w-full md:w-auto px-4 py-2 font-medium text-white bg-green-500 rounded hover:bg-green-700">Inventario total</button>

                <!-- Botón para agregar un nuevo producto -->
                <button onclick="openModal('crud-modal')" crud-modal data-modal-toggle="crud-modal" type="button"
                    class="w-full md:w-auto px-4 py-2 font-medium text-white bg-blue-500 rounded hover:bg-blue-700">Agregar
                    producto / Añadir</button>
            </div>
        </div>

        <!-- Modal para agregar producto -->
<div id="crud-modal" tabindex="-1" aria-hidden="true"
class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
<div class="relative p-4 w-full max-w-md max-h-full">
    <div class="relative bg-white rounded-lg shadow">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
            <h3 class="text-lg font-semibold text-gray-900">
                Agregar producto / Añadir
            </h3>
            <button onclick="closeModal('crud-modal')" type="button"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                data-modal-toggle="crud-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <form id="product-form" class="p-4 md:p-5" method="POST" action="{{ route('inventory.store') }}">
            @csrf
            <div class="grid gap-4 mb-4 grid-cols-1 sm:grid-cols-2">
                <div class="col-span-2">
                    <label for="name" class="block mb-2 text-sm text-center font-medium text-gray-900">Nombre</label>
                    <input type="text" name="name" id="name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                        placeholder="Nombre del producto" required>
                </div>
            
                <div>
                    <label for="amount" class="block mb-2 text-sm text-center font-medium text-gray-900">Cantidad</label>
                    <input type="number" name="amount" id="amount" step="0.01"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                        placeholder="" required>
                </div>                            
                    
                <div>
                    <label for="unit" class="block mb-2 text-sm text-center font-medium text-gray-900">Unidad</label>
                    <select id="unit" name="unit"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" required>
                        <option selected disabled value="">Seleccionar unidad</option>
                        <option value="Kg">Kilogramos(Kg)</option>
                        <option value="L">Litros(L)</option>
                        <option value="Pz">Unidades(Pz)</option>
                    </select>
                </div>
            
                <div class="col-span-2 sm:col-span-1">
                    <label for="type" class="block mb-2 text-sm text-center font-medium text-gray-900">Categoría</label>
                    <select id="type" name="type"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" required>
                        <option selected disabled value="">Seleccionar Categoría</option>
                        <option value="Verdura">Verdura</option>
                        <option value="Fruta">Fruta</option>
                        <option value="Proteina">Proteina</option>
                        <option value="Cereales y Legumbres">Cereales y Legumbres</option>
                    </select>
                </div>
            </div>

            <div class="col-span-2">
                <button type="submit"
                    class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Agregar producto / Añadir
                </button>
            </div>
        </form>
    </div>
</div>
</div>



        <br>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table id="product-table" class="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-blue-200">
                    <tr>
                        <th scope="col" class="px-6 py-3"><strong>Nombre</strong></th>
                        <th scope="col" class="px-6 py-3"><strong>Cantidad</strong></th>
                        <th scope="col" class="px-6 py-3"><strong>Categoría</strong></th>
                        <th scope="col" class="px-6 py-3"><strong>Fecha Actualización</strong></th>
                        <th scope="col" colspan="2" class="px-6 py-3"><strong>Acciones</strong></th> <!-- colspan="2" asegura que haya espacio para ambos botones -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventories as $inventory)
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4">{{ $inventory->name }}</td>
                            <td class="px-6 py-4">{{ $inventory->amount }} {{ $inventory->unit }}</td>
                            <td class="px-6 py-4">{{ $inventory->type }}</td>
                            <td class="px-6 py-4">{{ $inventory->updated_at }}</td>
                            <td class="px-6 py-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <button type="button"
                                        class="w-full h-10 text-center font-medium text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-lg">
                                        Editar
                                    </button>
                                    <form action="{{ route('inventory.destroy', $inventory->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full h-10 text-center font-medium text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 rounded-lg"
                                            onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

        <br>

<!-- Modal de Edición -->
<div id="editInventoryModal" class="fixed inset-0 items-center justify-center hidden transition-opacity duration-300 bg-black bg-opacity-70">
    <div class="relative w-full max-w-lg p-4 bg-white rounded-lg overflow-auto transform scale-90 transition-transform duration-300 max-h-full sm:max-w-xl md:max-w-2xl">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
            <h2 class="text-lg font-semibold text-gray-900">
                Editar Inventario
            </h2>
            <button onclick="closeModal('editInventoryModal')" type="button"
                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                data-modal-toggle="editInventoryModal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
        <form id="editInventoryForm" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="editName" class="block mb-2 text-sm font-medium text-gray-600">Nombre:</label>
                <input type="text" name="name" id="editName" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
            </div>
            <div class="mb-4">
                <label for="editQuantity" class="block mb-2 text-sm font-medium text-gray-600">Cantidad:</label>
                <input type="number" name="quantity" id="editQuantity" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
            </div>
            <div class="mb-4">
                <label for="editUnit" class="block mb-2 text-sm font-medium text-gray-600">Unidad:</label>
                <select name="unit" id="editUnit" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
                    <option value="Kg">Kilogramos(Kg)</option>
                    <option value="L">Litros(L)</option>
                    <option value="Pz">Unidades(Pz)</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="editType" class="block mb-2 text-sm font-medium text-gray-600">Categoría:</label>
                <select name="type" id="editType" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
                    <option value="Verdura">Verdura</option>
                    <option value="Fruta">Fruta</option>
                    <option value="Proteina">Proteina</option>
                    <option value="Cereales y Legumbres">Cereales y Legumbres</option>
                </select>
            </div>

            <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring focus:ring-blue-300 focus:outline-none">Guardar Cambios</button>
        </form>
    </div>
</div>

    @endauth

    @guest
        <div class="text-center text-red-600">No tienes acceso a esta página</div>
    @endguest
@endsection

<style>
    
    #editInventoryModal {
    opacity: 0;
    transition: opacity 0.3s ease, transform 0.3s ease;
}

#editInventoryModal > div {
    transform: scale(0.9);
    transition: transform 0.3s ease;
}

    .tooltip-light {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        bottom: 125%; /* Ajusta la posición vertical del tooltip */
        background-color: white;
        color: #1f2937; /* text-gray-900 */
        border: 1px solid #e5e7eb; /* border-gray-200 */
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
        border-top: 0.25rem solid #e5e7eb; /* border-gray-200 */
    }
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
