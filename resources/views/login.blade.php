@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-amber-50">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <form method="POST" action="{{ route('login.submit') }}" class="space-y-6">
            @csrf
            <h1 class="text-3xl font-bold text-center text-gray-900">LOGIN</h1>
            <div class="space-y-4">
                <div class="input-group">
                    <input type="text" id="user" name="user" placeholder="Usuario" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                </div>
                <div class="input-group">
                    <input type="password" id="password" name="password" placeholder="Contraseña" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-500">
                </div>
            </div>
            <div>
                <button type="submit" class="w-full py-2 px-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Entrar</button>
            </div>
            @if ($errors->any())
                <div class="text-red-500">
                    {{ $errors->first('message') }}
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
