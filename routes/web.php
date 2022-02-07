<?php

use App\Http\Controllers\CentroController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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

    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

// Para acceder a esta ruta es necesario estar autenticado
Route::resource('{lang}/centros', CentroController::class)->middleware('auth');

//Si la ruta no existe puedo indicar qué vista mostrar
Route::fallback(function(){
  Abort(403);
});