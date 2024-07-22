@extends('layouts.login_app')

@section('content')
@auth

<style>
    input[name="trabajador"],
select[name="platillo"] {
    border: 2px solid black;
    padding: 5px;
    border-radius: 4px;
}
</style>


<div class="mx-20">
    <input type="text" name="trabajador" placeholder="Ingrese el id">

    <select id="platillo" name="platillo" class="mx-10 mb-10 ">
        <option value="">Seleccione un Platillo</option>
        <option value="1">Platillo Normal</option>
        <option value="2">Platillo Ligero</option>
    </select>

    <button id="añadir" name="añadir" class="ml-15 text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
        Añadir
    </button>
</div>


<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Id
                </th>
                <th scope="col" class="px-6 py-3">
                    Nombre
                </th>
                <th scope="col" class="px-6 py-3">
                    Apellido
                </th>
                <th scope="col" class="px-6 py-3">
                    Fecha/Hora
                </th>
                <th scope="col" class="px-6 py-3">
                    Platillo
                </th>

            </tr>
        </thead>
        <tbody>
            <tr class="bg-white border-b">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    170061
                </th>
                <td class="px-6 py-4">
                    Gerardo
                </td>
                <td class="px-6 py-4">
                    Alcantar
                </td>
                <td class="px-6 py-4">
                    18-07-2024 12:15
                </td>
                <td class="px-6 py-4">
                    Ligero
                </td>
            </tr>
        </tbody>
    </table>
</div>

@endauth

@guest
    <div class="text-center text-red-600">No tienes acceso a esta página</div>
@endguest
@endsection
