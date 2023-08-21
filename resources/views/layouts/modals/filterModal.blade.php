<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Modal</title>
</head>

<body>

    <!-- Modal para FILTRAR TABLA DE TABLA DE INVENTARIO HOMBRES-->
    <div class="modal fade" id="filterInventarioHombres" tabindex="-1" role="dialog" aria-labelledby="filterInventarioHombresLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterInventarioHombresLabel">Filtrar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('cotrrsaHombresView') }}" method="GET" data-url="filterData">
                        @csrf

                        <div class="mb-3">
                            <label for="departmen" class="form-label">CATEGORIA:</label>
                            <select name="categoryFilter" class="form-select">
                                <option value="all">Todos los Productos</option>
                                <option value="Abarrotes">Abarrotes</option>
                                <option value="Frutas-Verduras">Frutas y Verduras</option>
                                <option value="Papelería">Papelería</option>
                                <option value="Limpieza">Limpieza</option>
                                <option value="Carnes-Lacteos">Carnes y Lacteos</option>
                                <option value="Granos-Legumbres">Granos y Legumbres</option>
                                <option value="Medicinas">Medicinas</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success float-end">Filtrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para FILTRAR TABLA DE TABLA DE INVENTARIO MUJERES-->
    <div class="modal fade" id="filterInventarioMujeres" tabindex="-1" role="dialog" aria-labelledby="filterInventarioMujeresLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterInventarioMujeresLabel">Filtrar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('cotrrsaMujeresView') }}" method="GET" data-url="filterData">
                        @csrf

                        <div class="mb-3">
                            <label for="departmen" class="form-label">CATEGORIA:</label>
                            <select name="categoryFilter" class="form-select">
                                <option value="all">Todos los Productos</option>
                                <option value="Abarrotes">Abarrotes</option>
                                <option value="Frutas-Verduras">Frutas y Verduras</option>
                                <option value="Papelería">Papelería</option>
                                <option value="Limpieza">Limpieza</option>
                                <option value="Carnes-Lacteos">Carnes y Lacteos</option>
                                <option value="Granos-Legumbres">Granos y Legumbres</option>
                                <option value="Medicinas">Medicinas</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success float-end">Filtrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para FILTRAR TABLA DE ARCHIVOS PENDIENTES-->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filtrar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('filterData-pending') }}" method="GET" data-url="filterData">
                        @csrf

                        <div class="mb-3">
                            <label for="departmen" class="form-label">COTRRSA:</label>
                            <select name="departmentFilter" class="form-select">
                                @role('administracion')
                                <option value="all">Todos los Departamentos</option>
                                @endrole

                                @role('administracion|cotrrsa hombres')
                                <option value="COTRRSA HOMBRES">COTRRSA HOMBRES</option>
                                @endrole

                                @role('administracion|cotrrsa mujeres')
                                <option value="COTRRSA MUJERES">COTRRSA MUJERES</option>
                                @endrole
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="departmen" class="form-label">CATEGORIA:</label>
                            <select name="categoryFilter" class="form-select">
                                <option value="all">Todos los Productos</option>
                                <option value="Abarrotes">Abarrotes</option>
                                <option value="Frutas-Verduras">Frutas y Verduras</option>
                                <option value="Papelería">Papelería</option>
                                <option value="Limpieza">Limpieza</option>
                                <option value="Carnes-Lacteos">Carnes y Lacteos</option>
                                <option value="Granos-Legumbres">Granos y Legumbres</option>
                                <option value="Medicinas">Medicinas</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success float-end">Filtrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para FILTRAR TABLA de ARCHIVOS APROBADOS-->
    <div class="modal fade" id="filterApprovedModal" tabindex="-1" role="dialog" aria-labelledby="filterApprovedModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterApprovedModalLabel">Filtrar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('filterData-approve') }}" method="GET" data-url="filterData">
                        @csrf

                        <div class="mb-3">
                            <label for="departmen" class="form-label">COTRRSA:</label>
                            <select name="departmentFilter" class="form-select">
                                @role('administracion')
                                <option value="all">Todos los Departamentos</option>
                                @endrole

                                @role('administracion|cotrrsa hombres')
                                <option value="COTRRSA HOMBRES">COTRRSA HOMBRES</option>
                                @endrole

                                @role('administracion|cotrrsa mujeres')
                                <option value="COTRRSA MUJERES">COTRRSA MUJERES</option>
                                @endrole
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="departmen" class="form-label">CATEGORIA:</label>
                            <select name="categoryFilter" class="form-select">
                                <option value="all">Todos los Productos</option>
                                <option value="Abarrotes">Abarrotes</option>
                                <option value="Frutas-Verduras">Frutas y Verduras</option>
                                <option value="Papelería">Papelería</option>
                                <option value="Limpieza">Limpieza</option>
                                <option value="Carnes-Lacteos">Carnes y Lacteos</option>
                                <option value="Granos-Legumbres">Granos y Legumbres</option>
                                <option value="Medicinas">Medicinas</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success float-end">Filtrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para FILTRAR TABLA de ARCHIVOS DENEGADOS-->
    <div class="modal fade" id="filterDenyModal" tabindex="-1" role="dialog" aria-labelledby="filterDenyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterDenyModalLabel">Filtrar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('filterData-deny') }}" method="GET" data-url="filterData">
                        @csrf

                        <div class="mb-3">
                            <label for="departmen" class="form-label">COTRRSA:</label>
                            <select name="departmentFilter" class="form-select">
                                @role('administracion')
                                <option value="all">Todos los Departamentos</option>
                                @endrole

                                @role('administracion|cotrrsa hombres')
                                <option value="COTRRSA HOMBRES">COTRRSA HOMBRES</option>
                                @endrole

                                @role('administracion|cotrrsa mujeres')
                                <option value="COTRRSA MUJERES">COTRRSA MUJERES</option>
                                @endrole
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="departmen" class="form-label">CATEGORIA:</label>
                            <select name="categoryFilter" class="form-select">
                                <option value="all">Todos los Productos</option>
                                <option value="Abarrotes">Abarrotes</option>
                                <option value="Frutas-Verduras">Frutas y Verduras</option>
                                <option value="Papelería">Papelería</option>
                                <option value="Limpieza">Limpieza</option>
                                <option value="Carnes-Lacteos">Carnes y Lacteos</option>
                                <option value="Granos-Legumbres">Granos y Legumbres</option>
                                <option value="Medicinas">Medicinas</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success float-end">Filtrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para FILTRAR TABLA DE LOGS-->
    <div class="modal fade" id="filterModalLog" tabindex="-1" role="dialog" aria-labelledby="filterModalLogLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLogLabel">Filtrar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('filterData-log') }}" method="GET" data-url="filterData">
                        @csrf

                        <div class="mb-3">
                            <label for="departmen" class="form-label">COTRRSA:</label>
                            <select name="departmentFilter" class="form-select">
                                @role('administracion')
                                <option value="all">Todos los Departamentos</option>
                                @endrole

                                @role('administracion|cotrrsa hombres')
                                <option value="cotrrsa_hombres_inventario">COTRRSA HOMBRES</option>
                                @endrole

                                @role('administracion|cotrrsa mujeres')
                                <option value="cotrrsa_mujeres_inventario">COTRRSA MUJERES</option>
                                @endrole
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success float-end">Filtrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para FILTRAR TABLA DE LOGS DISCOUNT-->
    <div class="modal fade" id="filterModalLogDiscount" tabindex="-1" role="dialog" aria-labelledby="filterModalLogDiscountLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLogDiscountLabel">Filtrar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('filterData-log-discount') }}" method="GET" data-url="filter-Data-Log-discount">
                        @csrf

                        <div class="mb-3">
                            <label for="departmen" class="form-label">COTRRSA:</label>
                            <select name="departmentFilter" class="form-select">
                                @role('administracion')
                                <option value="all">Todos los Departamentos</option>
                                @endrole

                                @role('administracion|cotrrsa hombres')
                                <option value="cotrrsa_hombres_inventario">COTRRSA HOMBRES</option>
                                @endrole

                                @role('administracion|cotrrsa mujeres')
                                <option value="cotrrsa_mujeres_inventario">COTRRSA MUJERES</option>
                                @endrole
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success float-end">Filtrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>