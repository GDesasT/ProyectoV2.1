<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['customer', 'dish'])->get();
        return view('sales.index', compact('sales'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'trabajador' => 'required|exists:customers,id',
            'platillo' => 'required|exists:dishes,id',
        ]);

        $sale = Sale::create([
            'date' => now(),
            'total' => 0, // Asigna el total apropiadamente
            'customer_id' => $validatedData['trabajador'],
            'dish_id' => $validatedData['platillo'],
        ]);

        return response()->json(['success' => true, 'sale' => $sale->load('customer', 'dish')]);
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return response()->json(['success' => true]);
    }

    public function PointOfSale()
    {
        $sales = Sale::with(['customer', 'dish'])->get();
        return view('PointOfSale', compact('sales'));
    }
}
