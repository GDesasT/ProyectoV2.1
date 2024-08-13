@extends('layouts.login_app')

@section('content')
    @auth
        <div class="text-center"><strong>Comentarios</strong></div>

        @if(session('success'))
            <div class="p-4 mb-4 text-center text-white bg-green-500 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="relative mt-5 overflow-x-auto shadow-md sm:rounded-lg">
            <table id="comment-table" class="w-full text-sm text-left text-gray-500 rtl:text-right">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Comentario</th>
                        <th scope="col" class="px-6 py-3">Fecha</th>
                        <th scope="col" class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comments as $comment)
                        <tr>
                            <td class="px-6 py-4">{{ $comment->comment }}</td>
                            <td class="px-6 py-4">{{ $comment->created_at }}</td>
                            <td class="flex px-6 py-4 space-x-2">
                                <form action="{{ route('feedback.destroy', $comment->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('¿Estás seguro de que quieres eliminar este comentario?');">Eliminar</button>
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
