<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    // Muestra la vista del inventario

    public function inventory(){
        return view('inventory');
    }
   
 
    public function index()
    {
        $inventories = Inventory::all();
        return view('inventory ', compact('inventories'));
    }

    // Almacena un nuevo producto en el inventario
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:45',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:Verdura,Fruta,Proteina,Cereales y Legumbres',
        ]);

        // Crear un nuevo registro en la base de datos
        Inventory::create($request->all());

        // Redirigir y mostrar mensaje de éxito
        return redirect()->route('inventory')->with('success', 'Imagen subida exitosamente.');
    }
}
