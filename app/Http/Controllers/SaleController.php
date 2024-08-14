<?php
namespace App\Http\Controllers;

use App\Models\sale;
use App\Models\Customer;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    // Muestra la lista de ventas
    public function index(Request $request)
    {
        // Obtener los parámetros de búsqueda
        $number = $request->input('number');
        $customer_id = $request->input('customer_id');
        $name = $request->input('name');
        $lastName = $request->input('lastName');
        $date = $request->input('date');
        $dish_type = $request->input('dish_type');

        // Crear una consulta base
        $query = sale::query();

        // Aplicar los filtros si existen
        if ($number) {
            $query->where('number', $number);
        }

        if ($customer_id) {
            $query->where('customer_id', $customer_id);
        }

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($lastName) {
            $query->where('lastName', 'like', '%' . $lastName . '%');
        }

        if ($date) {
            $query->whereDate('updated_at', $date);
        }

        if ($dish_type) {
            $query->where('dish_type', $dish_type);
        }

        // Obtener las ventas filtradas
        $sales = $query->get();

        return view('PointOfSale', compact('sales'));
    }

    // Almacena una nueva venta
    public function store(Request $request)
{
    // Validar los datos del formulario
    $request->validate([
        'number' => 'required|exists:customers,number',
        'dish_type' => 'required|in:platillo normal,platillo ligero'
    ]);

    // Obtener el cliente basado en su número de trabajador
    $customer = customer::where('number', $request->number)->firstOrFail();

    // Verificar si ya compró un platillo hoy
    $existingSale = sale::where('customer_id', $customer->id)
                        ->whereDate('created_at', now()->format('Y-m-d'))
                        ->first();

    if ($existingSale) {
        // Si ya existe una venta para este cliente hoy, redirigir con un mensaje de error
        return redirect()->route('PointOfSale')->with('error', 'Este cliente ya ha comprado un platillo hoy.');
    }

    // Crear un nuevo registro en la base de datos
    sale::create([
        'number' => $customer->id, // Asegúrate de que este sea el id de customer
        'customer_id' => $customer->id, // Aquí está el ID correcto
        'name' => $customer->name,
        'lastName' => $customer->lastname,
        'total' => 50, // Valor fijo para el total
        'dish_type' => $request->dish_type
    ]);

    // Redirigir y mostrar mensaje de éxito
    return redirect()->route('PointOfSale')->with('success', 'Venta agregada exitosamente.');
}


    // Muestra el formulario para editar una venta existente
    public function edit($id)
    {
        $sale = sale::findOrFail($id);
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

        $sale = sale::findOrFail($id);
        $sale->update($request->all());

        return redirect()->route('sales.index')->with('success', 'Venta actualizada correctamente.');
    }

    // Elimina una venta existente
    public function destroy($id)
    {
        $sale = sale::findOrFail($id);
        $sale->delete();

        return redirect()->route('PointOfSale')->with('delete', 'Venta eliminada correctamente.');
    }
}