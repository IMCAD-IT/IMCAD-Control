<?php

namespace App\Http\Controllers\Layouts\FoodRequest;

use App\Http\Controllers\Controller;
use Dompdf\Dompdf;
use App\Models\PdfFoodList;
use App\Models\ApproveFile;
use App\Models\DeniedFile;
use App\Models\PetitionHombres;
use App\Models\PetitionMujeres;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function pdfCreator()
    {
        try {
            $petitionsHombres = PetitionHombres::all();
            $petitionsMujeres = PetitionMujeres::all();
            $petitions = $petitionsHombres->concat($petitionsMujeres);

            // Crea una instancia de Dompdf
            $pdf = new Dompdf();

            // Agrega la fecha, hora y categorias actual al contenido HTML
            $date = Carbon::now()->format('d/m/Y');
            $hour = Carbon::now()->format('h:i:s A');
            // pluck dara un ARRAY con los valores de la propiedad 'category' y first traera solamente el primer elemento
            $hombresCategory = $petitionsHombres->pluck('category')->first();
            $mujeresCategory = $petitionsMujeres->pluck('category')->first();

            // Renderiza la vista en un archivo HTML
            $html = view('layouts.foodRequest.pdfRequest.foodListPdf', compact('petitionsHombres', 'petitionsMujeres', 'date', 'hour', 'hombresCategory', 'mujeresCategory'))->render();

            // Carga el HTML en Dompdf
            $pdf->loadHtml($html);

            // Renderiza el PDF
            $pdf->render();

            // Genera una respuesta con el PDF para su descarga
            return $pdf->stream('Lista_de_Productos.pdf');
        } catch (\Exception $e) {
            return back()->with('Error', 'Error al agregar el producto: ' . $e->getMessage());
        }
    }

    public function pdfSave(Request $request)
    {
        $validatedData = $request->validate([
            'file' => 'required|file|mimetypes:application/pdf',
            'comments' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ]);

        $file = $validatedData['file'];

        // Lee el contenido del archivo en formato BLOB
        $fileContent = file_get_contents($file->getPathname());

        // Convierte el contenido a una cadena de caracteres en formato base64
        $encodedContent = base64_encode($fileContent);

        $userType = $request->user()->jobPosition;

        // Convertir a un array si es una cadena
        if (is_string($userType)) {
            $userType = ['userType' => $userType];
        }

        // Establece el modelo según el tipo de usuario
        ($userType['userType'] === 'COTRRSA HOMBRES') ? PetitionHombres::class : PetitionMujeres::class;

        // Guarda el archivo PDF en la tabla pdf_save
        PdfFoodList::create([
            'file' => $encodedContent,
            'comments' => $validatedData['comments'],
            'category' => $validatedData['category'],
            'userType' => $userType['userType'],
        ]);

        return redirect()->back()->with('Success', 'PDF Enviado');
    }

    public function showFile($id)
    {
        $pdfData = PdfFoodList::findOrFail($id);
        $pdf = base64_decode($pdfData->file); // Decodificar el contenido base64 a su formato original

        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="archivo.pdf"');
    }

    public function approveFile($id, Request $request)
    {
        $pdfData = PdfFoodList::findOrFail($id);

        // Crear un nuevo registro en la tabla 'approve_files' con los datos del archivo aprobado
        $approveFile = new ApproveFile();
        $approveFile->file = $pdfData->file;
        $approveFile->comments = $pdfData->comments;
        $approveFile->category = $pdfData->category;
        $approveFile->userType = $pdfData->userType;
        $approveFile->reasons = $request->input('approve_comment');
        $approveFile->save();

        // Eliminar el registro de la tabla 'pdf_save'
        $pdfData->delete();

        return redirect()->back()->with('Success', 'Archivo Aprobado');
    }

    public function denyFile($id, Request $request)
    {
        $pdfData = PdfFoodList::findOrFail($id);

        // Crear un nuevo registro en la tabla 'denied_files' con los datos del archivo aprobado
        $denyFile = new DeniedFile();
        $denyFile->file = $pdfData->file;
        $denyFile->comments = $pdfData->comments;
        $denyFile->category = $pdfData->category;
        $denyFile->userType = $pdfData->userType;
        $denyFile->reasons = $request->input('deny_comment');
        $denyFile->save();

        $pdfData->delete();

        return redirect()->back()->with('Success', 'Archivo Denegado');
    }

    public function showFileApproved($id)
    {
        $pdfData = ApproveFile::findOrFail($id);
        $pdf = base64_decode($pdfData->file); // Decodificar el contenido base64 a su formato original

        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="archivo.pdf"');
    }

    public function showFileDeny($id)
    {
        $pdfData = DeniedFile::findOrFail($id);
        $pdf = base64_decode($pdfData->file); //Decodificar el contenido base64 a su formato original

        return response($pdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="archivo.pdf"');
    }
}
