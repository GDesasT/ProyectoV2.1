<?php

namespace App\Http\Controllers;

use App\Models\inventory;
use Illuminate\Http\Request;

class inventoryController extends Controller
{
    // Muestra la lista de inventario
    public function index(Request $request)
    {
        $name = $request->input('name');
        $amount = $request->input('amount');
        $type = $request->input('type');
        $unit = $request->input('unit');
        $date = $request->input('date');
    
        // Crear una consulta base
        $query = inventory::query();
    
        // Aplicar los filtros si existen
        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }
    
        if ($amount) {
            $query->where('amount', $amount);
        }
    
        if ($type) {
            $query->where('type', $type);
        }
    
        if ($unit) {
            $query->where('unit', $unit);
        }
    
        if ($date) {
            $query->whereDate('updated_at', $date);
        }
    
        // Obtener los inventarios filtrados
        $inventories = $query->get();
    
        // Retornar la vista con los inventarios filtrados
        return view('inventory', compact('inventories'));
    }
    
    // Almacena un nuevo producto en el inventario 
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:45',
            'amount' => 'required|numeric|min:0',
            'type' => 'required|in:Verdura,Fruta,Proteina,Cereales y Legumbres,Lacteo,Embutido,Especia',
            'unit' => 'required|in:Kg,L,Pz',
        ]);

        // Capitalizar la primera letra de cada palabra en 'name' y 'type'
        $request->merge([
            'name' => ucwords(strtolower($request->input('name'))),
            'type' => ucwords(strtolower($request->input('type')))
        ]);

        // Verificar si el producto ya existe en el inventario con el mismo nombre y categoría
        $existingProduct = inventory::where('name', $request->name)
            ->where('type', $request->type)
            ->where('unit', $request->unit)
            ->first();

        if ($existingProduct) {
            // Si el producto ya existe, sumar la cantidad
            $existingProduct->amount += $request->amount;
            $existingProduct->save();

            // Redirigir y mostrar mensaje de éxito
            return redirect()->route('inventory')->with('status', 'Cantidad agregada exitosamente al producto existente.');
        } else {
            // Si el producto no existe, crear un nuevo registro
            inventory::create($request->all());

            // Redirigir y mostrar mensaje de éxito
            return redirect()->route('inventory')->with('status', 'Producto agregado exitosamente.');
        }
    }

    public function edit($id)
    {
        $inventory = inventory::findOrFail($id);
        return view('inventory.edit', compact('inventory'));
    }

    public function update(Request $request, $id)
    {
        $inventory = inventory::findOrFail($id);

        // Capitalizar la primera letra de cada palabra en 'name' y 'type'
        $inventory->name = ucwords(strtolower($request->input('name')));
        $inventory->amount = $request->input('quantity');
        $inventory->unit = $request->input('unit');
        $inventory->type = ucwords(strtolower($request->input('type')));

        $inventory->save();

        return redirect()->route('inventory')->with('status', 'Producto actualizado correctamente');
    }
    
    public function destroy($id)
    {
        $inventory = inventory::findOrFail($id);
        $inventory->delete();

        return redirect()->route('inventory')->with('delete', 'Producto eliminado correctamente.');
    }
}
