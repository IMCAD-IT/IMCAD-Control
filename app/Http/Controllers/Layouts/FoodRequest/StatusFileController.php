<?php

namespace App\Http\Controllers\Layouts\FoodRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApproveFile;
use App\Models\DeniedFile;
use App\Models\PdfFoodList;

class StatusFileController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function approveFilesClear()
    {
        ApproveFile::truncate();
        return redirect()->back();
    }

    public function denyFilesClear()
    {
        DeniedFile::truncate();
        return redirect()->back();
    }
}
