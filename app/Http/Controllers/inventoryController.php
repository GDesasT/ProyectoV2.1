<?php

namespace App\Http\Controllers;

use App\Models\inventory;
use Illuminate\Http\Request;

class inventoryController extends Controller
{
    // Muestra la lista de inventario
    public function index()
    {
        $inventories = inventory::all();
        return view('inventory', compact('inventories'));
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
        inventory::create($request->all());

        // Redirigir y mostrar mensaje de éxito
        return redirect()->route('inventory')->with('success', 'Producto agregado exitosamente.');
    }

    public function edit($id)
{
    $inventory = inventory::findOrFail($id);
    return view('inventory', compact('inventory'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'amount' => 'required|numeric',
        'type' => 'required'
    ]);

    $inventory = inventory::findOrFail($id);
    $inventory->update($request->all());

    return redirect()->route('inventory')->with('success', 'Producto actualizado correctamente.');
}

public function destroy($id)
    {

    return redirect()->route('inventory')->with('success', 'Producto eliminado correctamente.');
}
}
