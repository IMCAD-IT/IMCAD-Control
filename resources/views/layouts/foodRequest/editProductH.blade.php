@extends('layouts.app')

@section('contentFoodRequest')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> </div>

                    <div class="card-body">

                        <form method="POST" action="{{ route('producto.update', $producto->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="col-form-label">Producto:</label>
                                <input type="text" name="name" id="name" class="form-control @error ('name') is-invalid @enderror" value="{{ $producto->name }}" required>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="quantity" class="col-form-label">Cantidad:</label>
                                <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ $producto->quantity }}" required>

                                @error('quantity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="partsAvailable" class="col-form-label">Unidad de Medida:</label>
                                <input type="text" name="partsAvailable" id="partsAvailable" class="form-control @error('partsAvailable') is-invalid @enderror" value="{{ $producto->partsAvailable }}" required>

                                @error('partsAvailable')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="supplier" class="col-form-label">Proveedor:</label>
                                <input type="text" name="supplier" id="supplier" class="form-control @error('supplier') is-invalid @enderror" value="{{ $producto->supplier }}" required>

                                @error('supplier')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="observations" class="col-form-label">Observaciones:</label>
                                <input type="text" name="observations" id="observations" class="form-control @error('observations') is-invalid @enderror" value="{{ $producto->observations }}" required>

                                @error('observations')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category" class="col-form-label">Categoría:</label>
                                <select name="category" id="category" class="form-select @error('category') is-invalid @enderror" value="{{ $producto->category }}">
                                    <option value="1" {{ $producto->category == Abarrotes ? 'selected' : '' }}>Abarrotes</option>
                                    <option value="2" {{ $producto->category == Verduras ? 'selected' : '' }}>Verduras</option>
                                    <option value="3" {{ $producto->category == Papelería ? 'selected' : '' }}>Papelería</option>
                                    <option value="4" {{ $producto->category == Limpieza ? 'selected' : '' }}>Limpieza</option>
                                    <option value="5" {{ $producto->category == Carnes-Lácteos ? 'selected' : '' }}>Carnes y Lácteos</option>
                                    <option value="6" {{ $producto->category == Granos-Legumbres ? 'selected' : '' }}>Granos y Legumbres</option>
                                    <option value="7" {{ $producto->category == Medicinas ? 'selected' : '' }}>Medicinas</option>
                                </select>

                                @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="modal-footer">

                                <button type="submit" class="btn btn-primary">
                                    {{ __('Actualizar') }}
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