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

    <title>Crear Lista de Productos</title>
</head>

<body>
    <div class="container">
        <div class="row mb-3">
            <div class="col">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProduct">Agregar Producto</button>
                <a href="{{ route('foodlist.pdfCreator') }}" class="btn btn-primary" id="pdfGenerate">Generar PDF</a>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Unidad de Medida</th>
                    <th scope="col">Proveedor</th>
                    <th scope="col">Observaciones</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Fecha de Registro</th>
                    <th scope="col">User</th>
                </tr>
            </thead>
            <tbody>
                @foreach($petitions as $petition)
                <tr>
                    <td>{{ $petition->name }}</td>
                    <td>{{ $petition->quantity }}</td>
                    <td>{{ $petition->partsAvailable }}</td>
                    <td>{{ $petition->supplier }}</td>
                    <td>{{ $petition->observations }}</td>
                    <td>{{ $petition->category }}</td>
                    <td>{{$petition->created_at}}</td>
                    <td>{{$petition->user_id}}</td>
                    <td>
                        <button method="DELETE" class="btn btn-danger btnDelete" data-id="{{ $petition->id }}">Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <form id="formDeleteAll" action="{{ route('foodlist.clearProducts') }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" id="btnDeleteAll">Limpiar Tabla</button>
        </form>

    </div>

    <!-- Modal para agregar producto -->
    <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addProductLabel">Agrega un Producto Nuevo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('foodlist.saveProduct') }}" method="POST">

                        @csrf

                        <div class="mb-3">
                            <label for="name" class="col-form-label">Producto:</label>
                            <input type="text" name="name" id="name" class="form-control @error ('name') is-invalid @enderror" value="{{ old('name') }}" required>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="col-form-label">Cantidad:</label>
                            <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" required>

                            @error('quantity')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="partsAvailable" class="col-form-label">Unidad de Medidad:</label>
                            <input type="text" name="partsAvailable" id="partsAvailable" class="form-control @error('partsAvailable') is-invalid @enderror" value="{{ old('partsAvailable') }}" required>

                            @error('partsAvailable')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="supplier" class="col-form-label">Proveedor:</label>
                            <input type="text" name="supplier" id="supplier" class="form-control @error('supplier') is-invalid @enderror" value="{{ old('supplier') }}" required>

                            @error('supplier')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="observations" class="col-form-label">Observaciones:</label>
                            <input type="text" name="observations" id="observations" class="form-control @error('observations') is-invalid @enderror" value="{{ old('observations') }}" required>

                            @error('observations')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="col-form-label">Categoria:</label>
                            <select name="category" id="category" class="form-select @error('category') is-invalid @enderror" value="{{ old('category') }}">
                            <option value="1">Abarrotes</option>
                                <option value="Verduras">Verduras</option>
                                <option value="Papeleria">Papeleria</option>
                                <option value="Limpieza">Limpieza</option>
                                <option value="Carnes-Lacteos">Carnes y Lacteos</option>
                                <option value="Granos-Legumbres">Granos y Legumbres</option>
                                <option value="Medicinas">Medicinas</option>
                            </select>

                            @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                {{ __('Cerrar') }}
                            </button>

                            <button type="submit" class="btn btn-primary">
                                {{ __('Agregar') }}
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
@endsection