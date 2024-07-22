@extends('layouts.login_app')

@section('content')
@auth

<div class="mx-20">
    <input type="text" name="idtrabajador" placeholder="Ingrese el id">

<select id="platillo" name="platillo" class="ml-10 mb-5">
    <option value="">Seleccione un Platillo</option>
    <option value="1">Platillo Normal</option>
    <option value="2">Platillo Ligero</option>
</select>

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
            </tr>
        </tbody>
    </table>
</div>

@endauth

@guest
    <div class="text-center text-red-600">No tienes acceso a esta página</div>
@endguest
@endsection
