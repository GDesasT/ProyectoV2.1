@extends('layouts.login_app')

@section('content')
    <div class="mb-8 text-3xl text-center font-bold">Editar Producto</div>

    <!-- Formulario de edición -->
    <form method="POST" action="{{ route('inventory.update', $inventory->id) }}">
        @csrf
        @method('PUT')

        <div class="grid gap-4 mb-4 grid-cols-2">
            <div class="col-span-2">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nombre</label>
                <input type="text" name="name" id="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                    value="{{ $inventory->name }}" required>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <label for="amount" class="block mb-2 text-sm font-medium text-gray-900">Cantidad</label>
                <input type="number" name="amount" id="amount"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                    value="{{ $inventory->amount }}" required>
                
                <select id="unit" name="unit"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                    required>
                    <option selected disabled value="">Seleccionar unidad</option>
                    <option value="Kg" @if($inventory->unit == 'Kg') selected @endif>Kilogramos(Kg)</option>
                    <option value="L" @if($inventory->unit == 'L') selected @endif>Litros(L)</option>
                    <option value="Pz" @if($inventory->unit == 'Pz') selected @endif>Unidades(Pz)</option>
                </select>
            </div>

            <div class="col-span-2 sm:col-span-1">
                <label for="type" class="block mb-2 text-sm font-medium text-gray-900">Categoría</label>
                <select id="type" name="type"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                    required>
                    <option selected disabled value="">Seleccionar Categoría</option>
                    <option value="Verdura" @if($inventory->type == 'Verdura') selected @endif>Verdura</option>
                    <option value="Fruta" @if($inventory->type == 'Fruta') selected @endif>Fruta</option>
                    <option value="Proteina" @if($inventory->type == 'Proteina') selected @endif>Proteina</option>
                    <option value="Cereales y Legumbres" @if($inventory->type == 'Cereales y Legumbres') selected @endif>Cereales y Legumbres</option>
                </select>
            </div>

            <!-- El campo de Fecha de Actualización solo se muestra, pero no se puede modificar -->
            <div class="col-span-2">
                <label for="updated_at" class="block mb-2 text-sm font-medium text-gray-900">Fecha de Actualización</label>
                <input type="text" id="updated_at" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" value="{{ $inventory->updated_at }}" disabled>
            </div>
        </div>

        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
            Actualizar Producto
        </button>
    </form>
@endsection
