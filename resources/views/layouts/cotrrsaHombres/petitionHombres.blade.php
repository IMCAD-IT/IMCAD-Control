@extends('layouts.app')

@section('contentFoodRequest')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/products.js') }}"></script>

    <title>Crear Lista Hombres</title>
</head>

<body>
    <h1 class="text-center">Lista de Requisicion</h1>

    <div class="container">
        
        @if(session('Error'))
        <div class="alert alert-danger">{{ session('Error') }}</div>
        @endif

        @if(session('Warning'))
        <div class="alert alert-warning">{{ session('Warning') }}</div>
        @endif

        @if(session('Success'))
        <div class="alert alert-success">{{ session('Success') }}</div>
        @endif

        <div class="row mb-3">
            <div class="col">
                <a href="{{ route('pdf.creator') }}" class="btn btn-primary" id="pdfGenerate">Generar PDF</a>
            </div>
        </div>

        <table class="table text-center">
            <thead>
                <tr>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad a Pedir</th>
                    <th scope="col">Unidad de Medida</th>
                    <th scope="col">Proveedor</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Observaciones</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($petitionsH as $petitionH)
                <tr>
                    <td class="col-sm-1">{{ $petitionH->name }}</td>
                    <td class="col-sm-2">{{ $petitionH->quantity }}</td>
                    <td class="col-sm-2">{{ $petitionH->partsAvailable }}</td>
                    <td class="col-sm-1">{{ $petitionH->supplier }}</td>
                    <td class="col-sm-2">{{ $petitionH->category }}</td>
                    <td class="col-sm-3">{{ $petitionH->observations }}</td>
                    <td>
                        <form action="{{ route('petitionH.destroy', $petitionH->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="row mb-3">
            <form id="formDeleteAll" action="{{ route('petitionHombres.clearProducts') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" id="btnDeleteAll">Limpiar Tabla</button>
            </form>

        </div>

    </div>

</body>

</html>
@endsection