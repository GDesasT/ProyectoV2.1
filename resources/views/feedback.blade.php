@extends('layouts.adminnav_app')

@section('content')
    @auth
        <div class="mb-8 text-3xl text-center"><strong>Comentarios</strong></div>

        @if(session('success'))
            <div class="p-4 mb-4 text-center text-white bg-green-500 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Sección de comentarios -->
        @if($comments->isEmpty())
            <div id="no-comments-message" class="text-center text-gray-500">
                No hay comentarios disponibles.
            </div>
        @else
            <div id="comment-section" class="relative mt-5 overflow-x-auto shadow-md sm:rounded-lg">
                <table id="comment-table" class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-blue-200">
                        <tr>
                            <th scope="col" class="px-6 py-3"><strong>Comentarios</strong></th>
                            <th scope="col" class="px-6 py-3"><strong>Fecha</strong></th>
                            <th scope="col" class="px-6 py-3"><strong>Acciones</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comments as $comment)
                            <tr class="bg-white border-b">
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
        @endif
        
        <!-- Mensaje cuando no hay fotos -->
        <div id="no-photos-message" class="text-center text-gray-500" style="display: none;">
            No hay fotos disponibles, por lo tanto, los comentarios están deshabilitados.
        </div>
        
        <br>
    @endauth

    @guest
        <div class="text-center text-red-600">No tienes acceso a esta página</div>
    @endguest
@endsection

@section('scripts')
<script>

</script>
@endsection
