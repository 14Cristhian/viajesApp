<?php

use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\convertirMoneda;
use App\Http\Controllers\WeatherController;
use App\Models\Consulta;
use Facade\FlareClient\Stacktrace\File;
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

Route::get('/{any?}', function () {
    return view('index');
})->where('any', '^(|pantalla1|pantalla2|pantalla3|consulta)$');


Route::post('/consultas', [ConsultaController::class, 'store']);
Route::delete('/consultas/{id}', [ConsultaController::class, 'destroy']);


Route::get('/api', function () {
    $consultas = Consulta::latest()->take(5)->get();
    return response()->json($consultas);
});


Route::post('/get-weather', [WeatherController::class, 'getWeather']);
Route::post('/convert-currency',  [convertirMoneda::class, 'convertirMoneda']);
