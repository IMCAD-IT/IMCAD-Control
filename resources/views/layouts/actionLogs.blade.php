@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/products.js') }}"></script>

    <title>Action Log</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Registro de Acciones de Altas</h1>

        @role('administracion')
        <form id="formDeleteAll" action="{{ route('Action-Logs.clearActions') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" id="btnDeleteAll">Limpiar Tabla</button>
        </form>
        @endrole

        <div class="col">
            <button class="btn btn-primary float-end mx-5" data-bs-toggle="modal" data-bs-target="#filterModalLog">Filtrar</button>
        </div>

        <!-- MODAL PARA FILTRAR POR MEDIO DE CATEGORIA Y DEPARTAMENTO -->
        @include('layouts.modals.filterModal')

        <table class="table text-center" id="productTable">
            <thead>
                <tr>

                    <th>Departamento</th>
                    <th>Acción</th>
                    <th>Cantidad</th>
                    <th>Fecha
                        <a href="#" onclick="sortTable('productTable', 3, 'desc')">▼</a>
                        <a href="#" onclick="sortTable('productTable', 3, 'asc')">▲</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @role('cotrrsa hombres|administracion')
                @foreach($hombresActionLogs as $hombresActionLog)
                <tr >

                    <td>{{ $hombresActionLog->inventario }}</td>
                    <td>{{ $hombresActionLog->action }}</td>
                    <td>{{ $hombresActionLog->quantity }}</td>
                    <td>{{ $hombresActionLog->created_at }}</td>
                </tr>
                @endforeach
                @endrole

                @role('cotrrsa mujeres|administracion')
                @foreach($mujeresActionLogs as $mujeresActionLog)
                <tr >

                    <td>{{ $mujeresActionLog->inventario }}</td>
                    <td>{{ $mujeresActionLog->action }}</td>
                    <td>{{ $mujeresActionLog->quantity }}</td>
                    <td>{{ $mujeresActionLog->created_at }}</td>
                </tr>
                @endforeach
                @endrole
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            
            @role('administracion|cotrrsa hombres')
            {{ $hombresActionLogs->links('pagination::bootstrap-4') }}
            @endrole
            
            @role('cotrrsa mujeres')
            {{ $mujeresActionLogs->links('pagination::bootstrap-4') }}
            @endrole
        </div>
    </div>
</body>

</html>
@endsection