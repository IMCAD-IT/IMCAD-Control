@extends('layouts.app')

@section('contentFoodRequest')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/products.js') }}"></script>

    <title>Approved Files</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Listas Aprobadas @role('cotrrsa hombres') COTRRSA Hombres @endrole @role('cotrrsa mujeres') COTRRSA Mujeres @endrole</h1>

        <div class="row ">

            @role('administracion')
            <div class="col">
                <form id="formDeleteAll" action="{{ route('approveFiles.clearFiles') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger " id="btnDeleteApproveFiles">Limpiar Tabla</button>
                </form>
            </div>
            @endrole

            <div class="col">
                <button class="btn btn-primary float-end mx-5" data-bs-toggle="modal" data-bs-target="#filterApprovedModal">Filtrar</button>
            </div>

            <!-- MODAL PARA FILTRAR POR MEDIO DE CATEGORIA Y DEPARTAMENTO -->
            @include('layouts.modals.filterModal')

        </div>

        <table class="table text-center" id="productTable">
            <thead>
                <tr>
                    <th scope="col">Archivo PDF</th>
                    <th scope="col">Commentarios</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Departamento</th>
                    <th scope="col">Fecha y Hora de Archivo Aprobado
                        <a href="#" onclick="sortTable('productTable', 4, 'desc')">▼</a>
                        <a href="#" onclick="sortTable('productTable', 4, 'asc')">▲</a>
                    </th>
                    <th scope="col">Razones</th>

                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @role('cotrrsa hombres|administracion')
                @foreach($pdfDataH as $pdfDatasH)
                <tr class="category-{{ $pdfDatasH->category }}">
                    <td class="col-sm-1">{{ $pdfDatasH->id }}</td>
                    <td class="col-sm-2">{{ $pdfDatasH->comments }}</td>
                    <td class="col-sm-1">{{ $pdfDatasH->category }}</td>
                    <td class="col-sm-1">{{ $pdfDatasH->userType }}</td>
                    <td class="col-sm-3">{{ $pdfDatasH->created_at }}</td>
                    <td class="col-sm-2">{{ $pdfDatasH->reasons }}</td>
                    <td class="col-sm-1">
                        <a href="{{ route('pdf.showFileApproved', $pdfDatasH->id) }}" target="_blank" class="btn btn-primary">Ver Archivo</a>
                    </td>
                </tr>
                @endforeach
                @endrole

                @role('cotrrsa mujeres|administracion')
                @foreach($pdfDataM as $pdfDatasM)
                <tr class="category-{{ $pdfDatasM->category }}">
                    <td class="col-sm-1">{{ $pdfDatasM->id }}</td>
                    <td class="col-sm-2">{{ $pdfDatasM->comments }}</td>
                    <td class="col-sm-1">{{ $pdfDatasM->category }}</td>
                    <td class="col-sm-1">{{ $pdfDatasM->userType }}</td>
                    <td class="col-sm-3">{{ $pdfDatasM->created_at }}</td>
                    <td class="col-sm-2">{{ $pdfDatasM->reasons }}</td>
                    <td class="col-sm-1">
                        <a href="{{ route('pdf.showFileApproved', $pdfDatasM->id) }}" target="_blank" class="btn btn-primary">Ver Archivo</a>
                    </td>
                </tr>
                @endforeach
                @endrole

            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            @role('administracion|cotrrsa hombres')
            {{ $pdfDataH->links('pagination::bootstrap-4') }}
            @endrole

            @role('cotrrsa mujeres')
            {{ $pdfDataM->links('pagination::bootstrap-4') }}
            @endrole
    </div>
</body>

</html>
@endsection