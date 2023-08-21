<?php

namespace App\Http\Controllers\Layouts\CotrrsaHombres;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CotrrsaHombresInventario;
use App\Models\ActionLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InventarioHombresController extends Controller
{
    protected $inventario;

    public function __construct()
    {
        $this->middleware('auth');
        $this->inventario = 'cotrrsa_hombres_inventario';
    }

    public function cotrrsaHombresInsert(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
                'quantity' => 'required|integer',
                'partsAvailable' => 'required|string|max:255',
                'supplier' => 'required|string|max:255',
                'observations' => 'required|string|max:255',
                'category' => 'required|string|max:255',
            ]);

            $imagePath = $request->file('image')->store('images','public' );
            $nombreProducto = $request->name;
            
        } catch (\Exception $e) {
            return back()->with('Error', 'Error al validar el producto: ' . $e->getMessage());
        }
        
        try {

            CotrrsaHombresInventario::create([
                'name' => $validatedData['name'],
                'image' => $imagePath,
                'quantity' => $validatedData['quantity'],
                'partsAvailable' => $validatedData['partsAvailable'],
                'supplier' => $validatedData['supplier'],
                'observations' => $validatedData['observations'],
                'category' => $validatedData['category'],
            ]);

            return back()->with('Success', 'Producto ' . $nombreProducto . ' Agregado');
            
        } catch (\Exception $e) {
            return back()->with('Error', 'Error al agregar el producto: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $cotrrsaHProduct = CotrrsaHombresInventario::findOrFail($id);
        // Crear el registro de acción
        $nombreProducto = $cotrrsaHProduct->name;
        $total = '-' . $cotrrsaHProduct->quantity;
        $action = "Se ELIMINÓ el producto: " . $nombreProducto;
        $userId = Auth::id();
        $inventario = $this->inventario;

        ActionLog::create([
            'user_id' => $userId,
            'action' => $action,
            'quantity' => $total,
            'inventario' => $inventario,
            'details_id' => 3,
        ]);

        $imagePath = $cotrrsaHProduct->image;
        
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        $cotrrsaHProduct->delete();
        return back()->with('Success', 'Producto ' . $nombreProducto . ' Eliminado');
    }

    public function actualizarCantidad(Request $request, $id)
    {

        $cotrrsaHProduct = CotrrsaHombresInventario::findOrFail($id);

        $currentQuantity = $cotrrsaHProduct->quantity;

        $imagePath = $cotrrsaHProduct->image;

        if ($request->has('quantityAdd')) {
            $quantityUpdate = $request->input('quantityAdd');
            $details_id = $request->input('detailsID_update');
        } else {
            $quantityUpdate = $request->input('quantityDiscount');
            $details_id = $request->input('detailsID_discount');
        }

        // Realizar la resta de la cantidad
        $nuevaCantidad = $currentQuantity + $quantityUpdate;

        if ($nuevaCantidad <= 0) {

            $producto = CotrrsaHombresInventario::findOrFail($id);
            $nombreProducto = $producto->name;
            $total = "-" . $producto->quantity;
            $action = "Se AGOTÓ el producto: " . $nombreProducto . " de: " . $currentQuantity . " a " . ' 0 ';
            $userId = Auth::id();
            $inventario = $this->inventario;

            ActionLog::create([
                'user_id' => $userId,
                'action' => $action,
                'quantity' => $total,
                'inventario' => $inventario,
                'details' => $request->input('message-food'),
                'details_id' => $details_id,
            ]);

            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            $cotrrsaHProduct->delete();

            return back()->with('Warning', 'Producto ' . $nombreProducto . ' Agotado');
        } else {

            $producto = CotrrsaHombresInventario::findOrFail($id);
            $nombreProducto = $producto->name;
            //$cantidadProducto = $producto->quantity;

            // Crear el registro de acción
            $action = "Se ACTUALIZÓ la cantidad del producto: " . $nombreProducto . " de: " . $currentQuantity . " a: " . $nuevaCantidad;
            $userId = Auth::id();
            $inventario = $this->inventario;

            ActionLog::create([
                'user_id' => $userId,
                'action' => $action,
                'quantity' => $nuevaCantidad - $currentQuantity,
                'inventario' => $inventario,
                'details' => $request->input('message-food'),
                'details_id' => $details_id,
            ]);

            // Actualizar el modelo con la nueva cantidad
            $cotrrsaHProduct->quantity = $nuevaCantidad;
            $cotrrsaHProduct->save();

            // Redireccionar o retornar una respuesta JSON, según sea necesario
            return back()->with('Success', 'Producto ' . $nombreProducto . ' Actualizado');
        }
    }
}
