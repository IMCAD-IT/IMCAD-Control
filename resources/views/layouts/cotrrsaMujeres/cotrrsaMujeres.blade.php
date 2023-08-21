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

    <title>COTRRSA Mujeres Inventario</title>
</head>

<body>

    <div class="container">
        <h1 class="text-center">Inventario COTRRSA Mujeres</h1>
        
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
                <button class="btn btn-primary float-end mx-5" data-bs-toggle="modal" data-bs-target="#filterInventarioMujeres">Filtrar</button>
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
                @foreach($CotrrsaMProducts as $CotrrsaMProduct)
                <tr >
                    <td class="col-sm-1"><img data-bs-toggle="modal" data-bs-target="#imageModal{{ $CotrrsaMProduct->id }}" class="img-thumbnail" src="{{ asset('storage/' . $CotrrsaMProduct->image) }}" alt="Imagen del Producto">
                        {{ $CotrrsaMProduct->name }}
                    </td>
                    <td class="col-sm-1">{{ $CotrrsaMProduct->quantity }}</td>
                    <td class="col-sm-1">{{ $CotrrsaMProduct->partsAvailable }}</td>
                    <td class="col-sm-1">{{ $CotrrsaMProduct->supplier }}</td>
                    <td class="col-sm-3">{{ $CotrrsaMProduct->observations }}</td>
                    <td class="col-sm-2">{{ $CotrrsaMProduct->category }}</td>
                    <td class="col-sm-2">{{$CotrrsaMProduct->created_at}}</td>
                    <td class="col-sm-1">
                        @role('administracion')
                        <form action="{{ route('cotrrsaMujeres.destroy', $CotrrsaMProduct->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                        @endrole
                        
                        @role('cotrrsa mujeres')
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addProductToList{{ $CotrrsaMProduct->id }}">Requerir</button>
                        <button type="button" class="btn btn-warning btnUpdateCotrrsaM mt-3" data-bs-toggle="modal" data-bs-target="#updateProduct{{ $CotrrsaMProduct->id }}">Movimientos</button>
                        @endrole
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            {{ $CotrrsaMProducts->appends(['categoryFilter' => Request::get('categoryFilter')])->links('pagination::bootstrap-4') }}
        </div>
    </div>

     <!-- Modal Para agrandar IMAGEN-->
     @foreach($CotrrsaMProducts as $CotrrsaMProduct)
    <div class="modal fade" id="imageModal{{ $CotrrsaMProduct->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title">{{ $CotrrsaMProduct->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body text-center">
                    <img class="img-fluid" src="{{ asset('storage/' . $CotrrsaMProduct->image) }}" alt="Imagen del Producto">
                    
                </div>

                <div class="text-center border-top p-3">
                    {{ $CotrrsaMProduct->observations }}
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
                    <form method="POST" action="{{ route('cotrrsaMujeres.insert') }}" enctype="multipart/form-data">
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

    <!-- Modales para actualizar cantidad -->
    @foreach($CotrrsaMProducts as $CotrrsaMProduct)
    <div class="modal fade" id="updateProduct{{ $CotrrsaMProduct->id }}" tabindex="-1" aria-labelledby="updateProductLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateProductLabel">Entrada de Productos al Inventario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <button type="button" class="btn btn-light" data-bs-target="#updateProduct{{ $CotrrsaMProduct->id }}" data-bs-toggle="modal">Entrada</button>
                    <button type="button" class="btn btn-light" data-bs-target="#quantityDiscountModal{{ $CotrrsaMProduct->id }}" data-bs-toggle="modal">Salida</button>

                    <form action="{{ route('actualizar-cantidad-mujeres', ['id' => $CotrrsaMProduct->id]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Producto:</label>
                            {{ $CotrrsaMProduct->name }}
                        </div>

                        <div class="mb-3">
                            <label for="recipient-quantity" class="col-form-label">Cantidad Actual:</label>
                            {{ $CotrrsaMProduct->quantity }}
                        </div>

                        <div class="mb-3">
                            <label for="quantityAdd" class="col-form-label">Cantidad a Actualizar:</label>
                            <input class="form-control" type="number" name="quantityAdd" id="quantityAdd" min="1" required>
                        </div>

                        <div class="mb-3" id="detailsID_update" hidden>
                            <label for="detailsID_update" class="col-form-label">details id:</label>
                            <input class="form-control" type="number" name="detailsID_update" id="detailsID_update" value="1" min="1" max="1" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="actualizar-btn">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
      <!-- MODAL PARA ELIMINAR O O DAR DE BAJA PRODUCTOS DE LA LISTA DE INVENTARIO}-->
      <div class="modal fade" id="quantityDiscountModal{{ $CotrrsaMProduct->id }}" tabindex="-1" aria-labelledby="quantityDiscountModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="quantityDiscountModal">Salida de Productos del Inventario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('actualizar-cantidad-mujeres', $CotrrsaMProduct->id) }}" method="POST">
                        @csrf

                        <button type="button" class="btn btn-light" data-bs-target="#updateProduct{{ $CotrrsaMProduct->id }}" data-bs-toggle="modal">Entrada</button>
                        <button type="button" class="btn btn-light" data-bs-target="#quantityDiscountModal{{ $CotrrsaMProduct->id }}" data-bs-toggle="modal">Salida</button>

                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Producto:</label>
                            {{ $CotrrsaMProduct->name }}
                        </div>
                        <div class="mb-3">
                            <label for="recipient-quantity" class="col-form-label">Cantidad Actual:</label>
                            {{ $CotrrsaMProduct->quantity }}
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
    @foreach($CotrrsaMProducts as $CotrrsaMProduct)
    <div class="modal fade" id="addProductToList{{ $CotrrsaMProduct->id }}" tabindex="-1" role="dialog" aria-labelledby="addProductToListLabel{{ $CotrrsaMProduct->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductToListLabel{{ $CotrrsaMProduct->id }}">Agregar Producto a Lista de Rquisicion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="POST" action="{{ route('addProductToListM.addProduct', $CotrrsaMProduct->id) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label">Producto:</label>
                            {{ $CotrrsaMProduct->name }}
                        </div>

                        <div class="mb-3">
                            <label for="recipient-quantity" class="col-form-label">Cantidad Actual:</label>
                            {{ $CotrrsaMProduct->quantity }}
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