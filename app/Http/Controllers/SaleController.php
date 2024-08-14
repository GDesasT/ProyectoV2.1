<?php

namespace App\Http\Controllers;

use App\Models\sale;
use App\Models\customer;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    // Muestra la lista de ventas
    public function index(Request $request)
    {
        $query = Sale::query();

        if ($request->filled('enterprise_id')) {
            $query->where('enterprise_id', $request->enterprise_id);
        }

        if ($request->filled('number')) {
            $query->where('number', $request->number);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('lastName')) {
            $query->where('lastName', 'like', '%' . $request->lastName . '%');
        }

        if ($request->filled('date')) {
            $query->whereDate('updated_at', $request->date);
        }

        if ($request->filled('dish_type')) {
            $query->where('dish_type', $request->dish_type);
        }

        $sales = $query->get();
        $enterprises = Enterprise::all();

        return view('PointOfSale', compact('sales', 'enterprises'));
    }

    // Almacena una nueva venta
    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|exists:customers,number',
            'dish_type' => 'required|in:platillo normal,platillo ligero',
            'enterprise_id' => 'required|exists:enterprises,id'
        ]);

        $customer = Customer::where('number', $request->number)->firstOrFail();

        $existingSale = Sale::where('customer_id', $customer->id)
            ->where('enterprise_id', $request->enterprise_id)
            ->whereDate('created_at', now()->format('Y-m-d'))
            ->first();

        if ($existingSale) {
            return redirect()->route('PointOfSale')->with('error', 'Este cliente ya ha comprado un platillo hoy en esta empresa.');
        }

        Sale::create([
            'number' => $customer->id,
            'customer_id' => $customer->id,
            'name' => $customer->name,
            'lastName' => $customer->lastname,
            'total' => 50,
            'dish_type' => $request->dish_type,
            'enterprise_id' => $request->enterprise_id,
        ]);

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
            'enterprise_id' => 'required|exists:enterprises,id'
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

        return redirect()->route('PointOfSale')->with('delete', 'Venta eliminada correctamente.');
    }
}
