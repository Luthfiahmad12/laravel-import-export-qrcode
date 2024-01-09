<?php

use App\Http\Controllers\MahasiswaController;
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

Route::get('/', [MahasiswaController::class, 'index']);

Route::post('/import', [MahasiswaController::class, 'import'])->name('import');
Route::get('/export-mhs', [MahasiswaController::class, 'export'])->name('export');
Route::get('/export', [MahasiswaController::class, 'exportPDF'])->name('exportPDF');
Route::get('/qrcode/{id}', [MahasiswaController::class, 'getQRCODE'])->name('getQRCODE');
