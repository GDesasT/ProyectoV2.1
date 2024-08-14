<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use Carbon\Carbon;

class SaleHistoryController extends Controller
{
    public function index(Request $request)
    {
        // Obtener la fecha seleccionada o la fecha de hoy por defecto
        $selectedDate = $request->input('date') ? Carbon::parse($request->input('date')) : Carbon::today();
        $filter = $request->input('filter', 'total_per_day');

        // Obtener las ventas de la fecha seleccionada
        $sales = Sale::whereDate('created_at', $selectedDate)->get();

        // Calcular la venta total de la fecha seleccionada
        $totalSales = $sales->sum('total');

        // Contar cuántos platillos de cada tipo se vendieron
        $platilloNormales = $sales->where('dish_type', 'platillo normal')->count();
        $platilloLigeros = $sales->where('dish_type', 'platillo ligero')->count();

        // Preparar datos para la gráfica si el filtro es "generate_chart"
        $chartData = [];
        if ($filter === 'generate_chart') {
            $chartData = Sale::selectRaw('DATE(created_at) as date, dish_type, COUNT(*) as count')
                ->groupBy('date', 'dish_type')
                ->orderBy('date')
                ->get()
                ->groupBy('dish_type');
        }

        // Pasar los datos a la vista
        return view('salehistory', compact('totalSales', 'platilloNormales', 'platilloLigeros', 'selectedDate', 'filter', 'chartData'));
    }
}
