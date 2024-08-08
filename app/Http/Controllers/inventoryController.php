<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    // Muestra la lista de inventario
    public function index()
    {
        $inventories = Inventory::all();
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
        Inventory::create($request->all());

        // Redirigir y mostrar mensaje de éxito
        return redirect()->route('inventory')->with('success', 'Producto agregado exitosamente.');
    }

    public function edit($id)
{
    $inventory = Inventory::findOrFail($id);
    return view('inventory', compact('inventory'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'amount' => 'required|numeric',
        'type' => 'required',
    ]);

    $inventory = Inventory::findOrFail($id);
    $inventory->update($request->all());

    return redirect()->route('inventory')->with('success', 'Producto actualizado correctamente.');
}

public function destroy($id)
{
    $inventory = Inventory::findOrFail($id);
    $inventory->delete();

    return redirect()->route('inventory')->with('success', 'Producto eliminado correctamente.');
}
}
