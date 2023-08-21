<!DOCTYPE html>
<html>

<head>
    <title>Lista Productos</title>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            text-align: center;
            margin-bottom: 10%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
        }

        header {
            text-align: center;
        }

        .date {
            text-align: right;
        }

        body {
            position: relative;
            /* Establecer el cuerpo como posición relativa */
            font-size: 14px;
        }

        footer {
            position: absolute;
            bottom: 10%;
            text-align: center;
            display: table;
            width: 100%;
            margin-top: 5%;
        }

        footer div {
            display: table-cell;
        }
    </style>

</head>


<body>
    <header>
        @role('cotrrsa hombres')
        <h2 id="Title">Requisicion de: {{ $hombresCategory }}</h2>
        @endrole

        @role('cotrrsa mujeres')
        <h2 id="Title">Requisicion de: {{ $mujeresCategory }}</h2>
        @endrole

        <p class="date">
            Fecha: {{ $date }}
            {{ $hour }}
        </p>
        <p class="date">
            Area: {{ Auth::user()->jobPosition }}
        </p>

    </header>

    <table class="table">
        <thead>
            <tr>
                <th class="table-header">Producto</th>
                <th class="table-header">Cantidad a Solicitar</th>
                <th class="table-header">Unidad de Medida</th>
                <th class="table-header">Proveedor</th>
                <th class="table-header">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @role('cotrrsa hombres')
            @foreach($petitionsHombres as $petition)
            <tr>
                <td>{{ $petition->name }}</td>
                <td>{{ $petition->quantity }}</td>
                <td>{{ $petition->partsAvailable }}</td>
                <td>{{ $petition->supplier }}</td>
                <td>{{ $petition->observations }}</td>
            </tr>
            @endforeach
            @endrole

            @role('cotrrsa mujeres')
            @foreach($petitionsMujeres as $petition)
            <tr>
                <td>{{ $petition->name }}</td>
                <td>{{ $petition->quantity }}</td>
                <td>{{ $petition->partsAvailable }}</td>
                <td>{{ $petition->supplier }}</td>
                <td>{{ $petition->observations }}</td>
            </tr>
            @endforeach
            @endrole
        </tbody>
    </table>

    <footer>

        <div class="content-l">
            ________________________________________
            <p>Solicita: Direccion {{ Auth::user()->jobPosition }}</p>
        </div>

        <div class="content-r">
            ________________________________________
            <p>Autoriza: Direccion IMCAD</p>
        </div>

    </footer>
</body>

</html>