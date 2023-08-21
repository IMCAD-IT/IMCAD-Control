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

    <title>PDF table list</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Listas Pendientes @role('cotrrsa hombres') COTRRSA Hombres @endrole @role('cotrrsa mujeres') COTRRSA Mujeres @endrole</h1>
        @if(session('Error'))
        <div class="alert alert-danger">{{ session('Error') }}</div>
        @endif

        @if(session('Warning'))
        <div class="alert alert-warning">{{ session('Warning') }}</div>
        @endif

        @if(session('Success'))
        <div class="alert alert-success">{{ session('Success') }}</div>
        @endif

        <div class="col">
            <button class="btn btn-primary float-end mx-5" data-bs-toggle="modal" data-bs-target="#filterModal">Filtrar</button>
        </div>

        <!-- MODAL PARA FILTRAR POR MEDIO DE CATEGORIA Y DEPARTAMENTO -->
        @include('layouts.modals.filterModal')

        <table class="table text-center" id="productTable">
            <thead>
                <tr>
                    <th scope="col">Archivo PDF</th>
                    <th scope="col">Comentarios</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Departamento</th>
                    <th scope="col">Fecha y Hora de Subida
                        <a href="#" onclick="sortTable('productTable', 4, 'desc')">▼</a>
                        <a href="#" onclick="sortTable('productTable', 4, 'asc')">▲</a>
                    </th>
                    <th scope="col" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>


                @foreach($pdfDataH as $pdfDatasH)
                @role('cotrrsa hombres|administracion')
                <tr>
                    <td class="col-sm-1">{{ $pdfDatasH->id }}</td>
                    <td class="col-sm-2">{{ $pdfDatasH->comments }}</td>
                    <td class="col-sm-1">{{ $pdfDatasH->category }}</td>
                    <td class="col-sm-2">{{ $pdfDatasH->userType }}</td>
                    <td class="col-sm-2">{{ $pdfDatasH->created_at }}</td>
                    <td class="col-sm-3">
                        <a href="{{ route('pdf.showFile', $pdfDatasH->id) }}" target="_blank" class="btn btn-primary">Ver Archivo</a>

                        @role('administracion')
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModalH{{ $pdfDatasH->id }}">Aprobar</button>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#denyModalH{{ $pdfDatasH->id }}">Denegar</button>
                        @endrole
                    </td>
                </tr>
                @endrole
                @endforeach


                @role('cotrrsa mujeres|administracion')
                @foreach($pdfDataM as $pdfDatasM)
                <tr>
                    <td class="col-sm-1">{{ $pdfDatasM->id }}</td>
                    <td class="col-sm-2">{{ $pdfDatasM->comments }}</td>
                    <td class="col-sm-1">{{ $pdfDatasM->category }}</td>
                    <td class="col-sm-2">{{ $pdfDatasM->userType }}</td>
                    <td class="col-sm-2">{{ $pdfDatasM->created_at }}</td>
                    <td class="col-sm-3">
                        <a href="{{ route('pdf.showFile', $pdfDatasM->id) }}" target="_blank" class="btn btn-primary">Ver Archivo</a>

                        @role('administracion')
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModalM{{ $pdfDatasM->id }}">Aprobar</button>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#denyModalM{{ $pdfDatasM->id }}">Denegar</button>
                        @endrole
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
    </div>

    @foreach($pdfDataH as $pdfDatasH)
    <!-- Modal para aprobar Hombres-->
    <div class="modal fade" id="approveModalH{{ $pdfDatasH->id }}" tabindex="-1" role="dialog" aria-labelledby="approveModalHLabel{{ $pdfDatasH->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalHLabel{{ $pdfDatasH->id }}">Aprobar Archivo PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pdf.approveFile', $pdfDatasH->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="approve-comment" class="form-label">Comentario de Aprobación:</label>
                            <textarea class="form-control" name="approve_comment" id="approve-comment" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para denegar Hombres-->
    <div class="modal fade" id="denyModalH{{ $pdfDatasH->id }}" tabindex="-1" role="dialog" aria-labelledby="denyModalHLabel{{ $pdfDatasH->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="denyModalHLabel{{ $pdfDatasH->id }}">Denegar Archivo PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pdf.denyFile', $pdfDatasH->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="approve-comment" class="form-label">Comentario para Denegar:</label>
                            <textarea class="form-control" name="deny_comment" id="approve-comment" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @foreach($pdfDataM as $pdfDatasM)

    <!-- Modal para aprobar Mujeres-->
    <div class="modal fade" id="approveModalM{{ $pdfDatasM->id }}" tabindex="-1" role="dialog" aria-labelledby="approveModalMLabel{{ $pdfDatasM->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalMLabel{{ $pdfDatasM->id }}">Aprobar Archivo PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pdf.approveFile', $pdfDatasM->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="approve-comment" class="form-label">Comentario de Aprobación:</label>
                            <textarea class="form-control" name="approve_comment" id="approve-comment" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para denegar Mujeres-->
    <div class="modal fade" id="denyModalM{{ $pdfDatasM->id }}" tabindex="-1" role="dialog" aria-labelledby="denyModalMLabel{{ $pdfDatasM->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="denyModalMLabel{{ $pdfDatasM->id }}">Denegar Archivo PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('pdf.denyFile', $pdfDatasM->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="approve-comment" class="form-label">Comentario para Denegar:</label>
                            <textarea class="form-control" name="deny_comment" id="approve-comment" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-success">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endforeach
</body>

</html>
@endsection