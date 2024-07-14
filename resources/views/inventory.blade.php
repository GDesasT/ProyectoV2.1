@extends('layouts.app')

@section('content')
@auth
    <div class="text-center">Acceso correcto</div>
    <a type="submit" class="w-full py-2 px-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" href="/logout">Logout</a>
@endauth

@guest
    <div class="text-center text-red-600">No tienes acceso a esta página</div>
@endguest
@endsection
