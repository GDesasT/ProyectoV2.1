@extends('layouts.login_app')

@section('content')
@auth

<style>
    input[name="trabajador"],
    select[name="platillo"] {
        border: 2px solid black;
        padding: 5px;
        border-radius: 4px;
    }
</style>

<div class="mx-20">
    <button type="button" class="ml-15 text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700" data-modal-target="addModal" data-modal-toggle="addModal">
        Añadir
    </button>
</div>

<div id="addModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Añadir Venta
                    </h3>
                    <div class="mt-2">
                        <input type="number" name="trabajador" placeholder="Ingrese el id del trabajador" class="form-control mb-3 border border-gray-300 p-2 rounded-md w-full">
                        <select id="platillo" name="platillo" class="form-control mb-3 border border-gray-300 p-2 rounded-md w-full">
                            <option value="">Seleccione un Platillo</option>
                            <option value="1">Platillo Normal</option>
                            <option value="2">Platillo Ligero</option>
                        </select>
                        <input type="datetime-local" name="date" placeholder="Fecha y hora" class="form-control mb-3 border border-gray-300 p-2 rounded-md w-full">
                        <input type="number" step="0.01" name="total" placeholder="Total" class="form-control mb-3 border border-gray-300 p-2 rounded-md w-full">
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <button type="button" id="saveButton" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Guardar
                </button>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" data-modal-hide="addModal">
                    Cerrar
                </button>
            </div>
        </div>
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
