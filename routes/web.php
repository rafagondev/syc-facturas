<?php

use App\Http\Controllers\FacturasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Route::get('/consultar-clientes', [FacturasController::class,'consultarClientes'])->name('consultar.clientes');
Route::get('/consultar-estados', [FacturasController::class,'consultarEstados'])->name('consultar.estados');
Route::get('/consultar-facturas', [FacturasController::class,'consultarFacturas'])->name('consultar.facturas');
Route::post('/registrar-factura', [FacturasController::class,'registrarFactura'])->name('registrar.factura');