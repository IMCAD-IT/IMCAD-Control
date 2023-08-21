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

        @role('administracion')
        <div class="col ">
            <select id="departmentFilter" class="float-end mx-5">
                <option value="all">Todos los Departamentos</option>
                <option value="cotrrsa-hombres-inventario">COTRRSA hombres inventario</option>
                <option value="cotrrsa-mujeres-inventario">COTRRSA mujeres inventario</option>
            </select>
        </div>
        @endrole

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
                @foreach($hombresActionLogs as $hombresActionLog)
                <tr class="inventario-{{ str_replace('_', '-', strtolower($hombresActionLog->inventario)) }}">

                    <td>{{ $hombresActionLog->inventario }}</td>
                    <td>{{ $hombresActionLog->action }}</td>
                    <td>{{ $hombresActionLog->quantity }}</td>
                    <td>{{ $hombresActionLog->created_at }}</td>
                </tr>
                @endforeach

                @foreach($mujeresActionLogs as $mujeresActionLog)
                <tr class="inventario-{{ str_replace('_', '-', strtolower($mujeresActionLog->inventario)) }}">

                    <td>{{ $mujeresActionLog->inventario }}</td>
                    <td>{{ $mujeresActionLog->action }}</td>
                    <td>{{ $mujeresActionLog->quantity }}</td>
                    <td>{{ $mujeresActionLog->created_at }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</body>

</html>
@endsection