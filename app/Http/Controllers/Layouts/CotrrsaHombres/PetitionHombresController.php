<?php

namespace App\Http\Controllers\Layouts\CotrrsaHombres;

use App\Http\Controllers\Controller;
use App\Models\CotrrsaHombresInventario;
use Illuminate\Http\Request;
use App\Models\PetitionHombres;
use Illuminate\Support\Facades\Validator;

class PetitionHombresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addProductToList($id, Request $request)
    {
        $pdfData = CotrrsaHombresInventario::findOrFail($id);

        $petitionsH = PetitionHombres::first();

        $inventarioCategory = $pdfData->category;

        $validator = Validator::make($request->all(), [
            'numberPetition' => 'required|numeric|min:1',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }        
        
        if (!$petitionsH || $inventarioCategory === $petitionsH->category) {
            //crear nuevo registro en la tabla
            $productToList = new PetitionHombres();

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
        PetitionHombres::truncate();
        return redirect()->back();
    }

    public function deletePetitionH($id)
    {
        $petitionsH = PetitionHombres::findOrFail($id);
        $productName = $petitionsH->name;
        $petitionsH->delete();

        return redirect()->back()->with('Success', 'Producto ' . $productName . ' Eliminado de la lista');
    }
}
