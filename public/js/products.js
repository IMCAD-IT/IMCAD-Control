//FUNCINALIDAD DEL BOTON GENERAR PDF PARA VERIFICAR SI HAY COMO MINIMO UN PRODUCTO EN LA LISTA DE REQUISICION
document.addEventListener('DOMContentLoaded', function () {
  var pdfGenerate = document.getElementById('pdfGenerate');

  if (pdfGenerate) { // Verifica si el elemento existe
    pdfGenerate.addEventListener('click', function (event) {
      var rowElement = document.getElementsByTagName('tr');
      var rowCount = rowElement.length;

      if (rowCount <= 1) {
        event.preventDefault();
        alert('Ingrese como mínimo 1 producto nuevo');
      }
    });
  }
});

//ELIMINAR TODOS LOS REGISTROS DE LA TABLA DE APPROVEFILES HOMBRES/MUJERES DE PRODUCTOS
$(document).ready(function () {
  // Manejar el evento de clic en el botón para eliminar todos los registros
  $('#btnDeleteApproveFiles').click(function () {
    if (confirm('¿Estás seguro de que deseas eliminar todos los registros? Esta acción no se puede deshacer.')) {
      // Realizar una petición AJAX para eliminar todos los registros
      $.ajax({
        url: "{{ route('approveFiles.clearFiles') }}",
        type: "DELETE",
        data: {
          _token: "{{ csrf_token() }}"
        },
        success: function (response) {
          // Si la eliminación es exitosa, recargar la página
          location.reload();
        },
        error: function (xhr) {
          // Manejar los errores en caso de que la eliminación falle
          alert('Ha ocurrido un error al eliminar los registros.');
        }
      });
    }
  });
});

//ELIMINAR TODOS LOS REGISTROS DE LA TABLA DE DENYFILES HOMBRES/MUJERES DE PRODUCTOS
$(document).ready(function () {
  // Manejar el evento de clic en el botón para eliminar todos los registros
  $('#btnDeleteDenyFiles').click(function () {
    if (confirm('¿Estás seguro de que deseas eliminar todos los registros? Esta acción no se puede deshacer.')) {
      // Realizar una petición AJAX para eliminar todos los registros
      $.ajax({
        url: "{{ route('denyFiles.clearFiles') }}",
        type: "DELETE",
        data: {
          _token: "{{ csrf_token() }}"
        },
        success: function (response) {
          // Si la eliminación es exitosa, recargar la página
          location.reload();
        },
        error: function (xhr) {
          // Manejar los errores en caso de que la eliminación falle
          alert('Ha ocurrido un error al eliminar los registros.');
        }
      });
    }
  });
});


//FUNCION PARA FILTRAR POR DEPARTAMENTO
document.addEventListener('DOMContentLoaded', function () {
  // Obtener el elemento select y la tabla
  var departmentFilter = document.getElementById('departmentFilter');
  var productTable = document.getElementById('productTable');

  if (departmentFilter) { // Verifica si el elemento existe
    // Agregar un evento change al elemento select
    departmentFilter.addEventListener('change', function () {
      var selectedDepartment = departmentFilter.value;
      var rows = productTable.getElementsByTagName('tr');

      // Recorrer las filas de la tabla y mostrar/ocultar según la categoría seleccionada
      for (var i = 0; i < rows.length; i++) {
        var row = rows[i + 1];

        if (selectedDepartment === 'all' || row.classList.contains('inventario-' + selectedDepartment)) {
          row.style.display = 'table-row';
        } else {
          row.style.display = 'none';
        }
      }
    });
  }
});

//ORDENAR POR MEDIO DE LA FECHAS ASC/DESC
function sortTable(tableId, column, order) {
  var table = document.getElementById(tableId);
  var rows = Array.from(table.tBodies[0].rows);

  rows.sort(function (a, b) {
    var valueA = new Date(a.cells[column].textContent);
    var valueB = new Date(b.cells[column].textContent);

    if (order === 'asc') {
      return valueA - valueB;
    } else {
      return valueB - valueA;
    }
  });

  rows.forEach(function (row) {
    table.tBodies[0].appendChild(row);
  });
}