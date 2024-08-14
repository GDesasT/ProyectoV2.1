@extends('layouts.adminnav_app')

@section('content')
    <div class="my-4 text-2xl font-bold text-center text-gray-800">Estadísticas de Ventas</div>

    @if(session('success'))
        <div class="p-4 mb-4 text-center text-white bg-green-500 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Panel 1: Ventas Totales por Día -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4">Ventas Totales por Día</h3>
            <form action="{{ route('sales.history') }}" method="GET" class="mb-4">
                <input type="hidden" name="filter" value="total_per_day">
                <div class="mb-4">
                    <label for="date" class="block text-sm font-medium text-gray-700">Seleccionar Fecha:</label>
                    <input type="date" id="date" name="date" value="{{ $selectedDate->format('Y-m-d') }}" class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                        Mostrar
                    </button>
                </div>
            </form>
            <div>
                <p class="text-lg font-semibold">Venta Total del Día: {{ $totalSales }} MXN</p>
                <ul class="mt-2 text-gray-700">
                    <li>Platillos Normales: {{ $platilloNormales }} ({{ $totalPlatilloNormales }} MXN)</li>
                    <li>Platillos Ligeros: {{ $platilloLigeros }} ({{ $totalPlatilloLigeros }} MXN)</li>
                </ul>
            </div>
        </div>

        <!-- Panel 2: Gráfica de Barras por Día -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4">Gráfica de Barras por Día</h3>
            <canvas id="dailySalesChart" width="400" height="200"></canvas>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var ctx = document.getElementById('dailySalesChart').getContext('2d');
                    var labels = @json($chartData->pluck('date'));
                    var normalData = @json($chartData->pluck('total_normales'));
                    var ligeroData = @json($chartData->pluck('total_ligeros'));

                    var chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Platillos Normales',
                                data: normalData,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Platillos Ligeros',
                                data: ligeroData,
                                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Fecha'
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Cantidad Vendida (MXN)'
                                    },
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
            </script>
        </div>

        <!-- Panel 3: Ventas Totales por Mes -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4">Ventas Totales por Mes</h3>
            <form action="{{ route('sales.history') }}" method="GET" class="mb-4">
                <input type="hidden" name="filter" value="total_per_month">
                <div class="mb-4">
                    <label for="month" class="block text-sm font-medium text-gray-700">Seleccionar Mes:</label>
                    <input type="month" id="month" name="month" value="{{ $selectedMonth->format('Y-m') }}" class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                        Mostrar
                    </button>
                </div>
            </form>
            <div>
                <p class="text-lg font-semibold">Venta Total del Mes: {{ $totalSalesMonth }} MXN</p>
                <ul class="mt-2 text-gray-700">
                    <li>Platillos Normales: {{ $platilloNormalesMonth }} ({{ $totalPlatilloNormalesMonth }} MXN)</li>
                    <li>Platillos Ligeros: {{ $platilloLigerosMonth }} ({{ $totalPlatilloLigerosMonth }} MXN)</li>
                </ul>
            </div>
        </div>

        <!-- Panel 4: Gráfica de Barras por Mes -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-bold mb-4">Gráfica de Barras por Mes</h3>
            <canvas id="monthlySalesChart" width="400" height="200"></canvas>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var ctx = document.getElementById('monthlySalesChart').getContext('2d');
                    var labels = @json($monthlyChartData->pluck('date'));
                    var normalData = @json($monthlyChartData->pluck('total_normales'));
                    var ligeroData = @json($monthlyChartData->pluck('total_ligeros'));

                    var chart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Platillos Normales',
                                data: normalData,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Platillos Ligeros',
                                data: ligeroData,
                                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Fecha'
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Cantidad Vendida (MXN)'
                                    },
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
            </script>
        </div>
    </div>
@endsection
