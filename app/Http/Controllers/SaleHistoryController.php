<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sale;
use Carbon\Carbon;

class SaleHistoryController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'total_per_day');
        $selectedDate = $request->input('date') ? Carbon::parse($request->input('date')) : Carbon::today();
        $selectedMonth = $request->input('month') ? Carbon::parse($request->input('month')) : Carbon::now();

        // Variables para ventas diarias
        $totalSales = 0;
        $platilloNormales = 0;
        $platilloLigeros = 0;
        $totalPlatilloNormales = 0;
        $totalPlatilloLigeros = 0;
        $chartData = collect();

        // Variables para ventas mensuales
        $totalSalesMonth = 0;
        $platilloNormalesMonth = 0;
        $platilloLigerosMonth = 0;
        $totalPlatilloNormalesMonth = 0;
        $totalPlatilloLigerosMonth = 0;
        $monthlyChartData = collect();

        // Calcular ventas totales por día
        if ($filter === 'total_per_day') {
            $sales = sale::whereDate('created_at', $selectedDate)->get();
            $platilloNormales = $sales->where('dish_type', 'platillo normal')->count();
            $platilloLigeros = $sales->where('dish_type', 'platillo ligero')->count();

            $totalPlatilloNormales = $platilloNormales * 50;
            $totalPlatilloLigeros = $platilloLigeros * 50;

            $totalSales = $totalPlatilloNormales + $totalPlatilloLigeros;

            $chartData = sale::selectRaw('DATE(created_at) as date, COUNT(*) * 50 as total')
                ->whereDate('created_at', $selectedDate)
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        }

        // Calcular ventas totales por mes
        if ($filter === 'total_per_month') {
            $sales = Sale::whereYear('created_at', $selectedMonth->year)
                         ->whereMonth('created_at', $selectedMonth->month)
                         ->get();
                         
            $platilloNormalesMonth = $sales->where('dish_type', 'platillo normal')->count();
            $platilloLigerosMonth = $sales->where('dish_type', 'platillo ligero')->count();

            $totalPlatilloNormalesMonth = $platilloNormalesMonth * 50;
            $totalPlatilloLigerosMonth = $platilloLigerosMonth * 50;

            $totalSalesMonth = $totalPlatilloNormalesMonth + $totalPlatilloLigerosMonth;

            $monthlyChartData = sale::selectRaw('DATE(created_at) as date, COUNT(*) * 50 as total')
                ->whereYear('created_at', $selectedMonth->year)
                ->whereMonth('created_at', $selectedMonth->month)
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        }

        return view('salehistory', compact(
            'totalSales', 'platilloNormales', 'platilloLigeros', 
            'totalPlatilloNormales', 'totalPlatilloLigeros', 'selectedDate', 
            'selectedMonth', 'filter', 'chartData',
            'totalSalesMonth', 'platilloNormalesMonth', 'platilloLigerosMonth', 
            'totalPlatilloNormalesMonth', 'totalPlatilloLigerosMonth', 'monthlyChartData'
        ));
    }
}
