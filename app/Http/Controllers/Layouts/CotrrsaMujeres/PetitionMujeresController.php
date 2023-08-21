<?php

namespace App\Http\Controllers\Layouts\CotrrsaMujeres;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PetitionMujeres;
use App\Models\CotrrsaMujeresInventario;
use Illuminate\Support\Facades\Validator;

class PetitionMujeresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addProductToListM($id, Request $request)
    {
        $pdfData = CotrrsaMujeresInventario::findOrFail($id);

        $petitionsM = PetitionMujeres::first();

        $inventarioCategory = $pdfData->category;

        $validator = Validator::make($request->all(), [
            'numberPetition' => 'required|numeric|min:1',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }        
        
        if (!$petitionsM || $inventarioCategory === $petitionsM->category) {
            //crear nuevo registro en la tabla
            $productToList = new PetitionMujeres();

            $productToList->name = $pdfData->name;
            $productToList->quantity = $request->input('numberPetition');
            $productToList->partsAvailable = $pdfData->partsAvailable;
            $productToList->supplier = $pdfData->supplier;
            $productToList->observations = $pdfData->observations;
            $productToList->category = $pdfData->category;
            $productToList->save();

            return redirect()->back()->with('Success', 'Producto Agregado a la Lista de Requisición');
        } else {
            return redirect()->back()->with('Error', 'Ingrese productos de la misma CATEGORIA a la Lista de Requisicion');
        }
    }

    public function clearProducts()
    {
        PetitionMujeres::truncate();
        return redirect()->back();
    }

    public function deletePetitionM($id)
    {
        $petitionsM = PetitionMujeres::findOrFail($id);
        $productName = $petitionsM->name;
        $petitionsM->delete();

        return redirect()->back()->with('Success', 'Producto ' . $productName . ' Eliminado de la lista');
    }
}
