<?php

namespace App\Http\Controllers\Layouts;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StatusFileController;
use Illuminate\Http\Request;

use App\Models\CotrrsaHombresInventario;
use App\Models\CotrrsaMujeresInventario;
use App\Models\PdfFoodList;
use App\Models\PetitionHombres;
use App\Models\PetitionMujeres;
use App\Models\ApproveFile;
use App\Models\DeniedFile;
use App\Models\ActionLog;

class ViewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cotrrsaHombresView(Request $request)
    {
        // Recibe los datos del formulario
        $categoryFilter = $request->input('categoryFilter');

        // Inicializa las variables de datos filtrados
        $CotrrsaHProducts = [];

        // Filtrar solo por categoría
        if ($categoryFilter != 'all') {

            $CotrrsaHProducts = CotrrsaHombresInventario::where('category', 'LIKE', '%' . $categoryFilter . '%')->latest()->paginate(5);
        } else {

            $CotrrsaHProducts = CotrrsaHombresInventario::latest()->paginate(5);
        }

        return view('layouts.cotrrsaHombres.cotrrsaHombres', compact('CotrrsaHProducts'));
    }

    public function cotrrsaMujeresView(Request $request)
    {
        // Recibe los datos del formulario
        $categoryFilter = $request->input('categoryFilter');

        // Inicializa las variables de datos filtrados
        $CotrrsaMProducts = [];

        // Filtrar solo por categoría
        if ($categoryFilter != 'all') {

            $CotrrsaMProducts = CotrrsaMujeresInventario::where('category', 'LIKE', '%' . $categoryFilter . '%')->latest()->paginate(5);
        } else {

            $CotrrsaMProducts = CotrrsaMujeresInventario::latest()->paginate(5);
        }

        return view('layouts.cotrrsaMujeres.cotrrsaMujeres', ['CotrrsaMProducts' => $CotrrsaMProducts]);
    }

    public function petitionHombresView()
    {
        $petitionsH = PetitionHombres::all();

        return view('layouts.cotrrsaHombres.petitionHombres', compact('petitionsH'));
    }

    public function petitionMujeresView()
    {
        $petitionsM = PetitionMujeres::all();

        return view('layouts.cotrrsaMujeres.petitionMujeres', compact('petitionsM'));
    }

    public function pdfSaveForm()
    {
        return view('layouts.foodRequest.pdfRequest.savePdfList');
    }

    public function showPdfTable()
    {
        $pdfDataH = PdfFoodList::where('userType', 'COTRRSA HOMBRES')
            ->latest()
            ->paginate(10);

        $pdfDataM = PdfFoodList::where('userType', 'COTRRSA MUJERES')
            ->latest()
            ->paginate(10);

        return view('layouts.foodRequest.pdfRequest.pdfTable', compact('pdfDataH', 'pdfDataM'));
    }

    public function approveFileView(Request $request)
    {

        $pdfDataH = ApproveFile::where('userType', 'COTRRSA HOMBRES')
            ->latest()
            ->paginate(10);

        $pdfDataM = ApproveFile::where('userType', 'COTRRSA MUJERES')
            ->latest()
            ->paginate(10);

        return view('layouts.foodRequest.pdfRequest.approveFiles', compact('pdfDataH', 'pdfDataM'));
    }

    public function denyFileView(Request $request)
    {

        $pdfDataH = DeniedFile::where('userType', 'COTRRSA HOMBRES')
            ->latest()
            ->paginate(10);

        $pdfDataM = DeniedFile::where('userType', 'COTRRSA MUJERES')
            ->latest()
            ->paginate(10);

        return view('layouts.foodRequest.pdfRequest.deniedFiles', compact('pdfDataH', 'pdfDataM'));
    }

    public function showActionLogs()
    {
        $hombresActionLogs = ActionLog::with('user')
            ->where('details_id', 1)
            ->where('inventario', 'cotrrsa_hombres_inventario')
            ->latest()
            ->paginate(10);

        $mujeresActionLogs = ActionLog::with('user')
            ->where('details_id', 1)
            ->where('inventario', 'cotrrsa_mujeres_inventario')
            ->latest()
            ->paginate(10);

        return view('layouts.actionLogs', compact('hombresActionLogs', 'mujeresActionLogs'));
    }

    public function showActionLogsDiscount()
    {
        $hombresActionLogs = ActionLog::with('user')
        ->where('details_id', 2)
        ->where('inventario', 'cotrrsa_hombres_inventario')
        ->latest()
        ->paginate(10);

        $mujeresActionLogs = ActionLog::with('user')
        ->where('details_id', 2)
        ->where('inventario', 'cotrrsa_mujeres_inventario')
        ->latest()
        ->paginate(10);

        return view('layouts.actionLogsDiscount', compact('hombresActionLogs', 'mujeresActionLogs'));
    }

    public function showActionLogsAdministracion()
    {

        $hombresActionLogs = ActionLog::with('user')->where('details_id', 3)->latest()->get();
        $mujeresActionLogs = ActionLog::with('user')->where('details_id', 3)->latest()->get();

        return view('layouts.actionLogsAdmin', compact('hombresActionLogs', 'mujeresActionLogs'));
    }

    public function clearActions()
    {

        ActionLog::truncate();
        return redirect()->back();
    }

    public function clearApprveFiles()
    {
        ApproveFile::truncate();
        return redirect()->back();
    }

    public function filterData(Request $request)
    {
        $categoryFilter = $request->input('categoryFilter');
        $departmentFilter = $request->input('departmentFilter');

        //categoria
        if ($categoryFilter != 'all' && $departmentFilter == 'all') {
            $pdfDataH = PdfFoodList::where('userType', 'COTRRSA HOMBRES')
                ->where('category', $categoryFilter)
                ->latest()
                ->paginate(10);

            $pdfDataM = PdfFoodList::where('userType', 'COTRRSA MUJERES')
                ->where('category', $categoryFilter)
                ->latest()
                ->paginate(10);
        }
        //departamento
        elseif ($departmentFilter != 'all' && $categoryFilter == 'all') {

            $pdfDataH = PdfFoodList::where('userType', 'COTRRSA HOMBRES')
                ->where('userType', $departmentFilter)
                ->latest()
                ->paginate(10);

            $pdfDataM = PdfFoodList::where('userType', 'COTRRSA MUJERES')
                ->where('userType', $departmentFilter)
                ->latest()
                ->paginate(10);
        }
        // Filtrar por ambos
        elseif ($categoryFilter != 'all' && $departmentFilter != 'all') {
            $pdfDataH = PdfFoodList::where('userType', 'COTRRSA HOMBRES')
                ->where('category', $categoryFilter)
                ->where('userType', $departmentFilter)
                ->latest()
                ->paginate(10);

            $pdfDataM = PdfFoodList::where('userType', 'COTRRSA MUJERES')
                ->where('category', $categoryFilter)
                ->where('userType', $departmentFilter)
                ->latest()
                ->paginate(10);
        } else {
            $pdfDataH = PdfFoodList::where('userType', 'COTRRSA HOMBRES')
                ->latest()
                ->paginate(10);

            $pdfDataM = PdfFoodList::where('userType', 'COTRRSA MUJERES')
                ->latest()
                ->paginate(10);
        }

        return view('layouts.foodRequest.pdfRequest.pdfTable', compact('pdfDataH', 'pdfDataM'));
    }

    public function filterDataApprove(Request $request)
    {
        $categoryFilter = $request->input('categoryFilter');
        $departmentFilter = $request->input('departmentFilter');

        //categoria
        if ($categoryFilter != 'all' && $departmentFilter == 'all') {
            $pdfDataH = ApproveFile::where('userType', 'COTRRSA HOMBRES')
                ->where('category', $categoryFilter)
                ->latest()
                ->paginate(10);

            $pdfDataM = ApproveFile::where('userType', 'COTRRSA MUJERES')
                ->where('category', $categoryFilter)
                ->latest()
                ->paginate(10);
        }
        //departamento
        elseif ($departmentFilter != 'all' && $categoryFilter == 'all') {

            $pdfDataH = ApproveFile::where('userType', 'COTRRSA HOMBRES')
                ->where('userType', $departmentFilter)
                ->latest()
                ->paginate(10);

            $pdfDataM = ApproveFile::where('userType', 'COTRRSA MUJERES')
                ->where('userType', $departmentFilter)
                ->latest()
                ->paginate(10);
        }
        // Filtrar por ambos
        elseif ($categoryFilter != 'all' && $departmentFilter != 'all') {
            $pdfDataH = ApproveFile::where('userType', 'COTRRSA HOMBRES')
                ->where('category', $categoryFilter)
                ->where('userType', $departmentFilter)
                ->latest()
                ->paginate(10);

            $pdfDataM = ApproveFile::where('userType', 'COTRRSA MUJERES')
                ->where('category', $categoryFilter)
                ->where('userType', $departmentFilter)
                ->latest()
                ->paginate(10);
        } else {
            $pdfDataH = ApproveFile::where('userType', 'COTRRSA HOMBRES')
                ->latest()
                ->paginate(10);

            $pdfDataM = ApproveFile::where('userType', 'COTRRSA MUJERES')
                ->latest()
                ->paginate(10);
        }

        return view('layouts.foodRequest.pdfRequest.approveFiles', compact('pdfDataH', 'pdfDataM'));
    }

    public function filterDataDeny(Request $request)
    {
        $categoryFilter = $request->input('categoryFilter');
        $departmentFilter = $request->input('departmentFilter');

        //categoria
        if ($categoryFilter != 'all' && $departmentFilter == 'all') {
            $pdfDataH = DeniedFile::where('userType', 'COTRRSA HOMBRES')
                ->where('category', $categoryFilter)
                ->latest()
                ->paginate(10);

            $pdfDataM = DeniedFile::where('userType', 'COTRRSA MUJERES')
                ->where('category', $categoryFilter)
                ->latest()
                ->paginate(10);
        }
        //departamento
        elseif ($departmentFilter != 'all' && $categoryFilter == 'all') {

            $pdfDataH = DeniedFile::where('userType', 'COTRRSA HOMBRES')
                ->where('userType', $departmentFilter)
                ->latest()
                ->paginate(10);

            $pdfDataM = DeniedFile::where('userType', 'COTRRSA MUJERES')
                ->where('userType', $departmentFilter)
                ->latest()
                ->paginate(10);
        }
        // Filtrar por ambos
        elseif ($categoryFilter != 'all' && $departmentFilter != 'all') {
            $pdfDataH = DeniedFile::where('userType', 'COTRRSA HOMBRES')
                ->where('category', $categoryFilter)
                ->where('userType', $departmentFilter)
                ->latest()
                ->paginate(10);

            $pdfDataM = DeniedFile::where('userType', 'COTRRSA MUJERES')
                ->where('category', $categoryFilter)
                ->where('userType', $departmentFilter)
                ->latest()
                ->paginate(10);
        } else {
            $pdfDataH = DeniedFile::where('userType', 'COTRRSA HOMBRES')
                ->latest()
                ->paginate(10);

            $pdfDataM = DeniedFile::where('userType', 'COTRRSA MUJERES')
                ->latest()
                ->paginate(10);
        }

        return view('layouts.foodRequest.pdfRequest.deniedFiles', compact('pdfDataH', 'pdfDataM'));
    }

    public function filterDataLog(Request $request)
    {
        $departmentFilter = $request->input('departmentFilter');

        //departamento
        if ($departmentFilter != 'all') {

            $hombresActionLogs = ActionLog::where('inventario', 'cotrrsa_hombres_inventario')
                ->where('details_id', 1)
                ->where('inventario', $departmentFilter)
                ->latest()
                ->paginate(10);

            $mujeresActionLogs = ActionLog::where('inventario', 'cotrrsa_mujeres_inventario')
                ->where('details_id', 1)
                ->where('inventario', $departmentFilter)
                ->latest()
                ->paginate(10);
        } else {
            $hombresActionLogs = ActionLog::where('inventario', 'cotrrsa_hombres_inventario')
                ->where('details_id', 1)
                ->latest()
                ->paginate(10);

            $mujeresActionLogs = ActionLog::where('inventario', 'cotrrsa_mujeres_inventario')
                ->where('details_id', 1)
                ->latest()
                ->paginate(10);
        }

        return view('layouts.actionLogs', compact('hombresActionLogs', 'mujeresActionLogs'));
    }

    public function filterDataLogDiscount(Request $request)
    {
        $departmentFilter = $request->input('departmentFilter');

        //departamento
        if ($departmentFilter != 'all') {

            $hombresActionLogs = ActionLog::where('inventario', $departmentFilter)
                ->where('details_id', 2)
                ->latest()
                ->paginate(10);

            $mujeresActionLogs = ActionLog::where('inventario', $departmentFilter)
                ->where('details_id', 2)
                ->latest()
                ->paginate(10);
        } else {
            $hombresActionLogs = ActionLog::where('inventario', 'cotrrsa_hombres_inventario')
                ->where('details_id', 2)
                ->latest()
                ->paginate(10);

            $mujeresActionLogs = ActionLog::where('inventario', 'cotrrsa_mujeres_inventario')
                ->where('details_id', 2)
                ->latest()
                ->paginate(10);
        }

        return view('layouts.actionLogsDiscount', compact('hombresActionLogs', 'mujeresActionLogs'));
    }
}
