<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Consumidor;
use App\Http\Controllers\ConsumidorController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\TransportadoraController;

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

//**********    Recursos Publicos  ************
Route::post('/login', [AuthController::class, 'login']);

// Consumidor
Route::post('/register/consumidor', [ConsumidorController::class, 'consumidorRegister']);
Route::get('/consumidor', [ConsumidorController::class, 'index']);
Route::get('/consumidor/{id}/', [ConsumidorController::class, 'show']);

//Fornecedor
Route::post('/register/fornecedor', [FornecedorController::class, 'register']);
Route::get('/fornecedor', [FornecedorController::class, 'index']);
Route::get('/fornecedor/{id}', [FornecedorController::class, 'show']);

//Transportadora
Route::post('/register/transportadora', [TransportadoraController::class, 'register']);
Route::get('/transportadora', [TransportadoraController::class, 'index']);
Route::get('/transportadora/{id}', [TransportadoraController::class, 'show']);

//**********    Recursos Protegidos  ************
Route::group(['middleware' => ['auth:sanctum']], function(){

	//consumidor
	Route::group(['middleware' => ['auth:sanctum', 'abilities:consumidor']], function(){
		Route::put('/consumidor/{id}', [ConsumidorController::class, 'update']);
		Route::delete('/consumidor/{id}', [ConsumidorController::class, 'destroy']);
	});

	//fornecedor
	Route::group(['middleware' => ['auth:sanctum', 'abilities:fornecedor']], function(){
		Route::put('/fornecedor/{id}', [FornecedorController::class, 'update']);
		Route::delete('/fornecedor/{id}', [FornecedorController::class, 'destroy']);
	});

	//transportadora
	Route::group(['middleware' => ['auth:sanctum', 'abilities:transportadora']], function(){
		Route::put('/transportadora/{id}', [TransportadoraController::class, 'update']);
		Route::delete('/transportadora/{id}', [TransportadoraController::class, 'destroy']);
	});
});


