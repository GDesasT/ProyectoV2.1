<?php

namespace App\Http\Controllers;

use App\Models\CarouselImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselImageController extends Controller
{
    // Mostrar el formulario para subir nuevas imágenes
    public function create()
    {
        return view('carousel.create'); // Asegúrate de tener esta vista
    }

    // Almacenar una nueva imagen en el carrusel
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Validaciones para la imagen
        ]);

        // Subir la imagen y obtener la ruta
        $path = $request->file('image')->store('carousel_images', 'public');

        // Crear una nueva entrada en la base de datos
        CarouselImage::create([
            'path' => $path,
            'is_active' => true, // Marcar la imagen como activa por defecto
        ]);

        return redirect()->route('carousel.index')->with('success', 'Imagen subida exitosamente.');
    }

    // Mostrar la lista de imágenes del carrusel
    public function index()
    {
        $images = CarouselImage::all();
        return view('carousel.index', compact('images')); // Asegúrate de tener esta vista
    }

    // Activar o desactivar una imagen del carrusel
    public function toggleActive($id)
    {
        $image = CarouselImage::findOrFail($id);
        $image->is_active = !$image->is_active;
        $image->save();

        return redirect()->route('carousel.index')->with('success', 'Estado de la imagen actualizado.');
    }

    // Eliminar una imagen del carrusel
    public function destroy($id)
    {
        $image = CarouselImage::findOrFail($id);
        
        // Eliminar la imagen del almacenamiento
        Storage::disk('public')->delete($image->path);
        
        // Eliminar la entrada en la base de datos
        $image->delete();

        return redirect()->route('carousel.index')->with('success', 'Imagen eliminada exitosamente.');
    }
}
