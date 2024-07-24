<?php

namespace App\Http\Controllers;

use App\Models\CarouselImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselImageController extends Controller
{
    public function create()
    {
        return view('carousel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('image')->store('carousel_images', 'public');

        CarouselImage::create([
            'path' => $path,
            'is_active' => true,
        ]);

        return redirect()->route('carousel.index')->with('success', 'Imagen subida exitosamente.');
    }

    public function index()
    {
        $images = CarouselImage::all();
        return view('carousel.index', compact('images'));
    }

    public function toggleActive($id)
    {
        $image = CarouselImage::findOrFail($id);
        $image->is_active = !$image->is_active;
        $image->save();

        return redirect()->route('carousel.index')->with('success', 'Estado de la imagen actualizado.');
    }

    public function destroy($id)
    {
        $image = CarouselImage::findOrFail($id);
        
        Storage::disk('public')->delete($image->path);
        
        $image->delete();

        return redirect()->route('carousel.index')->with('success', 'Imagen eliminada exitosamente.');
    }
}
