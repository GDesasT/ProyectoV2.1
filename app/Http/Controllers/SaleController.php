<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    // Muestra la lista de ventas
    public function index()
    {
        $sales = Sale::all();
        return view('PointOfSale', compact('sales'));
    }

    // Almacena una nueva venta
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'dish_type' => 'required|in:platillo normal,platillo ligero'
        ]);

        // Obtener el nombre y apellido del cliente basado en su ID
        $customer = Customer::findOrFail($request->customer_id);

        // Crear un nuevo registro en la base de datos
        Sale::create([
            'customer_id' => $customer->id,
            'name' => $customer->name,
            'lastName' => $customer->lastname,
            'total' => 20, // Valor fijo para el total
            'dish_type' => $request->dish_type
        ]);

        // Redirigir y mostrar mensaje de éxito
        return redirect()->route('PointOfSale')->with('success', 'Venta agregada exitosamente.');
    }

    // Muestra el formulario para editar una venta existente
    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        return view('sales.edit', compact('sale'));
    }

    // Actualiza una venta existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'name' => 'required|string|max:45',
            'lastName' => 'required|string|max:45',
            'total' => 'required|numeric|min:0',
            'dish_type' => 'required|in:platillo normal,platillo ligero',
        ]);

        $sale = Sale::findOrFail($id);
        $sale->update($request->all());

        return redirect()->route('sales.index')->with('success', 'Venta actualizada correctamente.');
    }

    // Elimina una venta existente
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Venta eliminada correctamente.');
    }
}
