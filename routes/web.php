<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Layouts\ViewsController;
use App\Http\Controllers\Layouts\CotrrsaHombres\InventarioHombresController;
use App\Http\Controllers\Layouts\CotrrsaHombres\PetitionHombresController;
use App\Http\Controllers\Layouts\CotrrsaMujeres\InventarioMujeresController;
use App\Http\Controllers\Layouts\CotrrsaMujeres\PetitionMujeresController;
use App\Http\Controllers\Layouts\FoodRequest\PdfController;
use App\Http\Controllers\Layouts\FoodRequest\StatusFileController;
use App\Models\PetitionHombres;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

//VIEWS
Route::get('/cotrrsaHombres',[ViewsController::class, 'cotrrsaHombresView'])->name('cotrrsaHombresView');
Route::get('/cotrrsaMujeres',[ViewsController::class, 'cotrrsaMujeresView'])->name('cotrrsaMujeresView');
Route::get('/petitionHombres', [ViewsController::class, 'petitionHombresView'])->name('petitionHombres.petitionView');
Route::get('/petitionMujeres', [ViewsController::class, 'petitionMujeresView'])->name('petitionMujeres.petitionView');
Route::get('/showPdfTable', [ViewsController::class, 'showPdfTable'])->name('pdf.table');
Route::get('/pdfSaveForm',[ViewsController::class, 'pdfSaveForm'])->name('pdfSaveForm.view');
Route::get('/approveFiles', [ViewsController::class, 'approveFileView'])->name('pdf.approveFileView');
Route::get('/denyFiles', [ViewsController::class, 'denyFileView'])->name('pdf.denyFileView');

Route::post('/actualizar-cantidad-hombres/{id}', [InventarioHombresController::class, 'actualizarCantidad'])->name('actualizar-cantidad');
Route::post('/actualizar-cantidad-mujeres/{id}', [InventarioMujeresController::class, 'actualizarCantidad'])->name('actualizar-cantidad-mujeres');

Route::get('/action-logs', [ViewsController::class, 'showActionLogs'])->name('action-logs');
Route::get('/action-logs-discount', [ViewsController::class, 'showActionLogsDiscount'])->name('action-logs-discount');
Route::get('/action-logs-admin', [ViewsController::class, 'showActionLogsAdministracion'])->name('action-logs-admin');

Route::get('/filterDataPending', [ViewsController::class, 'filterData'])->name('filterData-pending');
Route::get('/filterDataApprove', [ViewsController::class, 'filterDataApprove'])->name('filterData-approve');
Route::get('/filterDataDeny', [ViewsController::class, 'filterDataDeny'])->name('filterData-deny');

Route::get('/filter-Data-Log', [ViewsController::class, 'filterDataLog'])->name('filterData-log');
Route::get('/filter-Data-Log-discount', [ViewsController::class, 'filterDataLogDiscount'])->name('filterData-log-discount');

//GET
//seccion lista pendiente view
Route::get('/pdf-creator', [PdfController::class, 'pdfCreator'])->name('pdf.creator');
Route::get('/pdf/{id}', [PdfController::class, 'showFile'])->name('pdf.showFile');
//seccion de listas aprovadas
Route::get('/pdf-approved-view/{id}', [PdfController::class, 'showFileApproved'])->name('pdf.showFileApproved');
//seccion de listas denegadas
Route::get('/pdf-deny-view/{id}', [PdfController::class, 'showFileDeny'])->name('pdf.showFileDeny');

// Ruta para aprobar el archivo PDF
Route::post('pdf/approve/{id}', [PdfController::class, 'approveFile'])->name('pdf.approveFile');
// Ruta para denegar el archivo PDF
Route::post('pdf/deny/{id}', [PdfController::class, 'denyFile'])->name('pdf.denyFile');


//POST
Route::post('/cotrrsaHombres/insert', [InventarioHombresController::class, 'cotrrsaHombresInsert'])->name('cotrrsaHombres.insert');
Route::post('/cotrrsaMujeres/insert', [InventarioMujeresController::class, 'cotrrsaMujeresInsert'])->name('cotrrsaMujeres.insert');
//GUARDAR ARCHIVO PDF EN LA BASE DE DATOS
Route::post('/pdfSave', [PdfController::class, 'pdfSave'])->name('pdfSave.save');
Route::post('/savePetitionMujeres', [PetitionMujeresController::class, 'savePetitionMujeres'])->name('savePetitionMujeres.saveProduct');

Route::post('/addProductToList/{id}', [PetitionHombresController::class, 'addProductToList'])->name('addProductToList.addProduct');
Route::post('/addProductToListM/{id}', [PetitionMujeresController::class, 'addProductToListM'])->name('addProductToListM.addProduct');

//DELETE
Route::delete('/cotrrsaHombres/{id}', [InventarioHombresController::class, 'destroy'])->name('cotrrsaHombres.destroy');
Route::delete('/cotrrsaMujeres/{id}', [InventarioMujeresController::class, 'destroy'])->name('cotrrsaMujeres.destroy');

Route::delete('/petitionHombres/deleteProduct/{id}', [PetitionHombresController::class, 'deletePetitionH'])->name('petitionH.destroy');
Route::delete('/petitionMujeres/deleteProduct/{id}', [PetitionMujeresController::class, 'deletePetitionM'])->name('petitionM.destroy');

Route::delete('/petitionHombres/clearProducts', [PetitionHombresController::class, 'clearProducts'])->name('petitionHombres.clearProducts');
Route::delete('/petitionMujeres/clearProducts', [PetitionMujeresController::class, 'clearProducts'])->name('petitionMujeres.clearProducts');

Route::delete('/Action-Logs/clearActions', [ViewsController::class, 'clearActions'])->name('Action-Logs.clearActions');

Route::delete('/approveFiles/clearFiles', [StatusFileController::class, 'approveFilesClear'])->name('approveFiles.clearFiles');
Route::delete('/denyFiles/clearFiles', [StatusFileController::class, 'denyFilesClear'])->name('denyFiles.clearFiles');

//PUT
Route::put('/pdf/{id}/update-comment', [PdfController::class, 'updateComment'])->name('pdf.updateComment');
