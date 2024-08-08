@extends('layouts.login_app')

@section('content')
@auth

<div class="mx-20">
    <button type="button" class="ml-15 text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2" data-modal-target="addModal" data-modal-toggle="addModal">
        Añadir
    </button>
</div>

<div id="addModal" class="fixed inset-0 flex items-center justify-center hidden transition-opacity duration-300 bg-black bg-opacity-75 z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="relative w-full h-auto max-w-2xl p-8 transition-transform duration-300 transform scale-90 bg-white rounded-lg">
        <button class="absolute text-2xl text-gray-600 cursor-pointer top-4 right-4" data-modal-hide="addModal">&times;</button>
        
        <h2 class="mb-6 text-3xl font-bold text-center text-gray-800" id="modal-title">Añadir Venta</h2>
        
        <form action="#" method="POST">
            <div class="mb-4">
                <label for="trabajador" class="block mb-2 text-sm font-medium text-gray-600">ID del Trabajador:</label>
                <input type="number" name="trabajador" id="trabajador" placeholder="Ingrese el id del trabajador" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
            </div>

            <div class="mb-4">
                <label for="platillo" class="block mb-2 text-sm font-medium text-gray-600">Platillo:</label>
                <select id="platillo" name="platillo" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
                    <option value="">Seleccione un Platillo</option>
                    <option value="1">Platillo Normal</option>
                    <option value="2">Platillo Ligero</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="date" class="block mb-2 text-sm font-medium text-gray-600">Fecha y Hora:</label>
                <input type="datetime-local" name="date" id="date" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
            </div>

            <div class="mb-6">
                <label for="total" class="block mb-2 text-sm font-medium text-gray-600">Total:</label>
                <input type="number" step="0.01" name="total" id="total" placeholder="Total" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300 focus:outline-none" required>
            </div>

            <div class="flex justify-end">
                <button type="button" id="saveButton" class="px-4 py-2 mr-3 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring focus:ring-blue-300 focus:outline-none">
                    Guardar
                </button>
                <button type="button" class="px-4 py-2 text-gray-700 bg-white border rounded-lg hover:bg-gray-50 focus:ring focus:ring-indigo-500 focus:outline-none" data-modal-hide="addModal">
                    Cerrar
                </button>
            </div>
        </form>
    </div>
</div>


<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500" id="dataTable">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Id
                </th>
                <th scope="col" class="px-6 py-3">
                    Nombre
                </th>
                <th scope="col" class="px-6 py-3">
                    Apellido
                </th>
                <th scope="col" class="px-6 py-3">
                    Fecha/Hora
                </th>
                <th scope="col" class="px-6 py-3">
                    Platillo
                </th>
                <th scope="col" class="px-6 py-3">
                    Total
                </th>
                <th scope="col" class="px-6 py-3">
                    Acción
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr class="bg-white border-b">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $sale->id }}</td>
                <td class="px-6 py-4">{{ $sale->customer->name }}</td>
                <td class="px-6 py-4">{{ $sale->customer->surname }}</td>
                <td class="px-6 py-4">{{ $sale->date }}</td>
                <td class="px-6 py-4">{{ $sale->dish->name }}</td>
                <td class="px-6 py-4">{{ $sale->total }}</td>
                <td class="px-6 py-4">
                    <button class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" onclick="deleteSale({{ $sale->id }})">
                        Borrar
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.getElementById('saveButton').addEventListener('click', function() {
        const trabajador = document.querySelector('input[name="trabajador"]').value;
        const platillo = document.querySelector('select[name="platillo"]').value;
        const date = document.querySelector('input[name="date"]').value;
        const total = document.querySelector('input[name="total"]').value;

        if(trabajador && platillo && date && total) {
            fetch('/sales', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    trabajador: trabajador,
                    platillo: platillo,
                    date: date,
                    total: total
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    const table = document.getElementById('dataTable').getElementsByTagName('tbody')[0];
                    const newRow = table.insertRow();

                    const idCell = newRow.insertCell(0);
                    const nombreCell = newRow.insertCell(1);
                    const apellidoCell = newRow.insertCell(2);
                    const fechaHoraCell = newRow.insertCell(3);
                    const platilloCell = newRow.insertCell(4);
                    const totalCell = newRow.insertCell(5);
                    const accionCell = newRow.insertCell(6);

                    idCell.classList.add('px-6', 'py-4', 'font-medium', 'text-gray-900', 'whitespace-nowrap');
                    idCell.textContent = data.sale.id;
                    
                    nombreCell.classList.add('px-6', 'py-4');
                    nombreCell.textContent = data.sale.customer.name;
                    
                    apellidoCell.classList.add('px-6', 'py-4');
                    apellidoCell.textContent = data.sale.customer.surname;
                    
                    fechaHoraCell.classList.add('px-6', 'py-4');
                    fechaHoraCell.textContent = new Date(data.sale.date).toLocaleString();
                    
                    platilloCell.classList.add('px-6', 'py-4');
                    platilloCell.textContent = data.sale.dish.name;
                    
                    totalCell.classList.add('px-6', 'py-4');
                    totalCell.textContent = data.sale.total;
                    
                    accionCell.classList.add('px-6', 'py-4');
                    accionCell.innerHTML = '<button class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Borrar</button>';
                    accionCell.querySelector('button').addEventListener('click', function() {
                        fetch(`/sales/${data.sale.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if(data.success) {
                                table.deleteRow(newRow.rowIndex);
                            } else {
                                alert('Hubo un error al eliminar la venta.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Hubo un error al eliminar la venta.');
                        });
                    });

                    const modalElement = document.getElementById('addModal');
                    modalElement.classList.add('hidden');
                } else {
                    alert('Hubo un error al guardar la venta.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un error al guardar la venta.');
            });
        } else {
            alert('Por favor, complete todos los campos.');
        }
    });

    function deleteSale(id) {
        fetch(`/sales/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                const row = document.querySelector(`#dataTable tbody tr[data-id="${id}"]`);
                row.remove();
            } else {
                alert('Hubo un error al eliminar la venta.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un error al eliminar la venta.');
        });
    }

    document.querySelectorAll('[data-modal-hide]').forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('[id$="Modal"]');
            modal.classList.add('hidden');
        });
    });

    document.querySelectorAll('[data-modal-toggle]').forEach(button => {
        button.addEventListener('click', function() {
            const modal = document.getElementById(this.getAttribute('data-modal-target'));
            modal.classList.toggle('hidden');
        });
    });
</script>

@endauth

@guest
    <div class="text-center text-red-600">No tienes acceso a esta página</div>
@endguest
@endsection
