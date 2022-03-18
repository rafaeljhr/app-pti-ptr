<?php

use App\Models\fornecedor;
use App\Models\transportadora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\consumidorController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });





Route::resource('consumidor', consumidorController::class)->only([
    'store', 'index', 'show', 'update', 'destroy'
]);
  
// Route::resource('/consumidor', consumidorController::class)->only([
//     'index', 'show', 'update', 'destroy'
// ])->middleware('jwt');



Route::get('/fornecedor', function () {
    return fornecedor::all();
});

Route::get('/fornecedor/{id}', function($id) {
    return fornecedor::find($id);
});


Route::get('/transportadora', function () {
    return transportadora::all();
});

Route::get('/transportadora/{id}', function($id) {
    return transportadora::find($id);
});

