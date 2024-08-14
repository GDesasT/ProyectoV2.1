@extends('layouts.adminnav_app')

@section('content')
    <div class="my-4 text-2xl font-bold text-center text-gray-800">Historial de Ventas</div>

    @if(session('success'))
        <div class="p-4 mb-4 text-center text-white bg-green-500 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="relative max-w-6xl p-6 mx-auto mt-5 overflow-x-auto bg-white rounded-lg shadow-md sm:rounded-lg">
        <form action="{{ route('sales.history') }}" method="GET" class="mb-4">
            <div class="mb-4">
                <label for="filter" class="block text-sm font-medium text-gray-700">Seleccionar Filtro:</label>
                <select id="filter" name="filter" class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="total_per_day" {{ $filter === 'total_per_day' ? 'selected' : '' }}>Ventas Totales por Día</option>
                    <option value="generate_chart" {{ $filter === 'generate_chart' ? 'selected' : '' }}>Generar Gráfica de Platillos Vendidos</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="date" class="block text-sm font-medium text-gray-700">Seleccionar Fecha:</label>
                <input type="date" id="date" name="date" value="{{ $selectedDate->format('Y-m-d') }}" class="block w-full p-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                    Aplicar Filtro
                </button>
            </div>
        </form>

        @if($filter === 'total_per_day')
            <h3 class="text-lg font-bold mb-4">Resumen de Ventas para {{ $selectedDate->format('Y-m-d') }}</h3>

            <div class="p-4 mb-4 bg-blue-200 rounded">
                <p class="text-lg font-semibold">Venta Total del Día:</p>
                <p class="text-2xl text-gray-700">{{ $totalSales }} MXN</p>
            </div>

            <div class="p-4 bg-blue-200 rounded">
                <p class="text-lg font-semibold">Platillos Vendidos:</p>
                <ul class="text-gray-700">
                    <li>Platillos Normales: {{ $platilloNormales }}</li>
                    <li>Platillos Ligeros: {{ $platilloLigeros }}</li>
                </ul>
            </div>
        @elseif($filter === 'generate_chart')
            <h3 class="text-lg font-bold mb-4">Gráfica de Platillos Vendidos</h3>
            <canvas id="salesChart" width="400" height="200"></canvas>

            <script>
                var ctx = document.getElementById('salesChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($chartData->first()->pluck('date')),
                        datasets: [{
                            label: 'Platillos Normales',
                            data: @json($chartData['platillo normal']->pluck('count')),
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2,
                            fill: false
                        },
                        {
                            label: 'Platillos Ligeros',
                            data: @json($chartData['platillo ligero']->pluck('count')),
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            fill: false
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
                                    text: 'Cantidad Vendida'
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        @endif
    </div>
@endsection
