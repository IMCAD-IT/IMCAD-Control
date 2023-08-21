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

    <link rel="stylesheet" href="css/tableStyle.css">
    
    <title>COTRRSA Hombres Inventario</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Inventario COTRRSA Hombres</h1>

        @if(session('Error'))
        <div class="alert alert-danger">{{ session('Error') }}</div>
        @endif

        @if(session('Warning'))
        <div class="alert alert-warning">{{ session('Warning') }}</div>
        @endif

        @if(session('Success'))
        <div class="alert alert-success">{{ session('Success') }}</div>
        @endif

        <div class="row ">

            @role('inventario|administracion')
            <div class="col">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProduct">Agregar Producto</button>
            </div>
            @endrole

            <div class="col">
                <button class="btn btn-primary float-end mx-5" data-bs-toggle="modal" data-bs-target="#filterInventarioHombres">Filtrar</button>
            </div>

            <!-- MODAL PARA FILTRAR POR MEDIO DE CATEGORIA Y DEPARTAMENTO -->
            @include('layouts.modals.filterModal')

        </div>

        <table class="table text-center" id="productTable">
            <thead>
                <tr>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Unidad de Medida</th>
                    <th scope="col">Proveedor</th>
                    <th scope="col">Observaciones</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Fecha de Registro
                        <a href="#" onclick="sortTable('productTable', 6, 'desc')">▼</a>
                        <a href="#" onclick="sortTable('productTable', 6, 'asc')">▲</a>
                    </th>

                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($CotrrsaHProducts as $CotrrsaHProduct)
                <tr >
                    <td class="col-sm-1"><img data-bs-toggle="modal" data-bs-target="#imageModal{{ $CotrrsaHProduct->id }}" class="img-thumbnail" src="{{ asset('storage/' . $CotrrsaHProduct->image) }}" alt="Imagen del Producto">
                        {{ $CotrrsaHProduct->name }}
                    </td>
                    <td class="col-sm-1">{{ $CotrrsaHProduct->quantity }}</td>
                    <td class="col-sm-1">{{ $CotrrsaHProduct->partsAvailable }}</td>
                    <td class="col-sm-1">{{ $CotrrsaHProduct->supplier }}</td>
                    <td class="col-sm-3">{{ $CotrrsaHProduct->observations }}</td>
                    <td class="col-sm-2">{{ $CotrrsaHProduct->category }}</td>
                    <td class="col-sm-2">{{$CotrrsaHProduct->created_at}}</td>

                    <td class="col-sm-1">
                        @role('administracion')
                        <form action="{{ route('cotrrsaHombres.destroy', $CotrrsaHProduct->id ) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">
                                Eliminar
                            </button>
                        </form>
                        @endrole
                        @role('cotrrsa hombres')
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addProductToList{{ $CotrrsaHProduct->id }}">Requerir</button>
                        <button type="button" class="btn btn-warning mt-3" data-bs-toggle="modal" data-bs-target="#updateProduct{{ $CotrrsaHProduct->id }}">Movimientos</button>                        @endrole
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            {{ $CotrrsaHProducts->appends(['categoryFilter' => Request::get('categoryFilter')])->links('pagination::bootstrap-4') }}
        </div>
    </div>

    <!-- Modal Para agrandar IMAGEN-->
    @foreach($CotrrsaHProducts as $CotrrsaHProduct)
    <div class="modal fade" id="imageModal{{ $CotrrsaHProduct->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title">{{ $CotrrsaHProduct->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body text-center">
                    <img class="img-fluid" src="{{ asset('storage/' . $CotrrsaHProduct->image) }}" alt="Imagen del Producto">
                    
                </div>

                <div class="text-center border-top p-3">
                    {{ $CotrrsaHProduct->observations }}
                </div>

            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal para agregar producto -->
    <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addProductLabel">Agrega un Producto Nuevo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{ route('cotrrsaHombres.insert') }}" enctype="multipart/form-data">
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
                            <label for="image" class="col-form-label">Imagen:</label>
                            <input type="file" name="image" id="image" class="form-control @error ('image') is-invalid @enderror" value="{{ old('image') }}" required>

                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="col-form-label">Cantidad:</label>
                            <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="0" min="0" max="0" required>

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
                                <option value="Abarrotes">Abarrotes</option>
                                <option value="Frutas-Verduras">Frutas y Verduras</option>
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
                                {{ __('Guardar') }}
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal para ACTUALIZAR producto a la lista del inventario -->
    @foreach($CotrrsaHProducts as $CotrrsaHProduct)
    <div class="modal fade" id="updateProduct{{ $CotrrsaHProduct->id }}" tabindex="-1" aria-labelledby="updateProductLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateProductLabel">Entrada de Productos al Inventario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('actualizar-cantidad', $CotrrsaHProduct->id) }}" method="POST">
                        @csrf

                        <button type="button" class="btn btn-light" data-bs-target="#updateProduct{{ $CotrrsaHProduct->id }}" data-bs-toggle="modal">Entrada</button>
                        <button type="button" class="btn btn-light" data-bs-target="#quantityDiscountModal{{ $CotrrsaHProduct->id }}" data-bs-toggle="modal">Salida</button>

                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Producto:</label>
                            {{ $CotrrsaHProduct->name }}
                        </div>
                        <div class="mb-3">
                            <label for="recipient-quantity" class="col-form-label">Cantidad Actual:</label>
                            {{ $CotrrsaHProduct->quantity }}
                        </div>

                        <div class="mb-3" id="quantityAdd">
                            <label for="quantityAdd" class="col-form-label">Cantidad a Agregar:</label>
                            <input class="form-control" type="number" name="quantityAdd" id="quantityAdd" min="1" required>
                        </div>

                        <div class="mb-3" id="detailsID_update" hidden>
                            <label for="detailsID_update" class="col-form-label">details id:</label>
                            <input class="form-control" type="number" name="detailsID_update" id="detailsID_update" value="1" min="1" max="1" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" id="actualizar-btn">Actualizar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA ELIMINAR O O Salida PRODUCTOS DE LA LISTA DE INVENTARIO}-->
    <div class="modal fade" id="quantityDiscountModal{{ $CotrrsaHProduct->id }}" tabindex="-1" aria-labelledby="quantityDiscountModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="quantityDiscountModal">Salida de Productos del Inventario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('actualizar-cantidad', $CotrrsaHProduct->id) }}" method="POST">
                        @csrf

                        <button type="button" class="btn btn-light" data-bs-target="#updateProduct{{ $CotrrsaHProduct->id }}" data-bs-toggle="modal">Entrada</button>
                        <button type="button" class="btn btn-light" data-bs-target="#quantityDiscountModal{{ $CotrrsaHProduct->id }}" data-bs-toggle="modal">Salida</button>

                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Producto:</label>
                            {{ $CotrrsaHProduct->name }}
                        </div>
                        <div class="mb-3">
                            <label for="recipient-quantity" class="col-form-label">Cantidad Actual:</label>
                            {{ $CotrrsaHProduct->quantity }}
                        </div>

                        <div class="mb-3" id="quantityDiscount">
                            <label for="quantityDiscount" class="col-form-label">Cantidad a Descontar:</label>
                            <input class="form-control" type="number" name="quantityDiscount" id="quantityDiscount" max="-1" required>
                        </div>

                        <div class="mb-3" id="message-food">
                            <label for="message-text" class="col-form-label">Observaciones:</label>
                            <input class="form-control" type="text" name="message-food" id="message-food" required>
                        </div>

                        <div class="mb-3" id="detailsID_discount" hidden>
                            <label for="detailsID_discount" class="col-form-label">details id:</label>
                            <input class="form-control" type="number" name="detailsID_discount" id="detailsID_discount" value="2" min="2" max="2" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-success" id="actualizar-btn">Actualizar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal Para Agregar Producto a la Lista-->
    @foreach($CotrrsaHProducts as $CotrrsaHProduct)
    <div class="modal fade" id="addProductToList{{ $CotrrsaHProduct->id }}" tabindex="-1" role="dialog" aria-labelledby="addProductToListLabel{{ $CotrrsaHProduct->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductToListLabel{{ $CotrrsaHProduct->id }}">Agregar Producto a Lista de Rquisicion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="{{ route('addProductToList.addProduct', $CotrrsaHProduct->id) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Producto:</label>
                            {{ $CotrrsaHProduct->name }}
                        </div>

                        <div class="mb-3">
                            <label for="recipient-quantity" class="col-form-label">Cantidad Actual:</label>
                            {{ $CotrrsaHProduct->quantity }}
                        </div>

                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Cantidad a Pedir:</label>
                            <input class="form-control" type="number" name="numberPetition" id="numberPetition" min='1' required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" id="btnAddProductToList">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach

</body>

</html>
@endsection