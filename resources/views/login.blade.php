@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <form class="space-y-6">
            <h1 class="text-3xl font-bold text-center text-gray-900">LOGIN</h1>
            <div class="space-y-4">
                <div class="input-group">
                    <input type="text" id="usuario" name="Usuario" placeholder="Usuario" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                </div>
                <div class="input-group">
                    <input type="password" id="contraseña" name="Contraseña" placeholder="Contraseña" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                </div>
            </div>
            <div>
                <button type="submit" id="boton" class="w-full py-2 px-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Entrar</button>
            </div>
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" id="recordar" class="form-checkbox h-4 w-4 text-blue-600">
                    <span class="ml-2 text-sm text-gray-900">Recordarme</span>
                </label>
            </div>
            <div class="text-center">
                <a href="#" id="recuperar" class="text-sm text-blue-500 hover:underline">Olvidé mi contraseña</a>
            </div>
        </form>
    </div>
</div>
@endsection
