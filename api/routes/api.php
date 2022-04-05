<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsumidorController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\TransportadoraController;
use App\Http\Controllers\ArmazemController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\Base_TransportadoraController;

//**********    Recursos Publicos  ************

//Route::post('/login', [AuthController::class, 'login']);

//***************************  Consumidor ***************************//
Route::post('/api/consumidor', [ConsumidorController::class, 'consumidorRegister']);
Route::get('/api/consumidores', [ConsumidorController::class, 'index']);
Route::get('/api/consumidores/{id}/', [ConsumidorController::class, 'show']);

//***************************  Fornecedor ***************************//
Route::post('/api/fornecedor', [FornecedorController::class, 'register']);
Route::get('/api/fornecedores', [FornecedorController::class, 'index']);
Route::get('/api/fornecedores/{id}', [FornecedorController::class, 'show']);

//inventario
Route::get('/api/fornecedores/{id}/produto', [FornecedorController::class, 'show_inventory']);
Route::get('/api/fornecedores/{id}/produto/{id_product}', [ProdutoController::class, 'show_product']);


//***************************  Transportadora ***************************//
Route::post('/api/transportadora', [TransportadoraController::class, 'register']);
Route::get('/api/transportadoras', [TransportadoraController::class, 'index']);
Route::get('/api/transportadoras/{id}', [TransportadoraController::class, 'show']);


//***************************  Recursos Protegidos ***************************//
Route::group(['middleware' => ['auth:sanctum']], function(){

	//consumidor
	Route::group(['middleware' => ['auth:sanctum', 'abilities:consumidor']], function(){
		Route::put('/api/consumidores/{id}', [ConsumidorController::class, 'update']);
		Route::delete('/api/consumidores/{id}', [ConsumidorController::class, 'destroy']);

		//Encomendas
		Route::get('/api/consumidores/{id}/encomendas', [ConsumidorController::class, 'show_orders']);
	});

	//fornecedor
	Route::group(['middleware' => ['auth:sanctum', 'abilities:fornecedor']], function(){

		Route::put('/api/fornecedores/{id}', [FornecedorController::class, 'update']);
		Route::delete('/api/fornecedores/{id}', [FornecedorController::class, 'destroy']);

		//Inventario
		Route::post('/api/fornecedores/{id}/produto', [ProdutoController::class, 'create_product']);
		Route::put('/api/fornecedores/{id}/produto/{id_product}', [ProdutoController::class, 'update_product']);
		Route::delete('/api/fornecedores/{id}/produto/{id_product}', [ProdutoController::class, 'destroy_product']);

		//Armazem
		Route::get('/api/fornecedores/{id}/armazem', [FornecedorController::class, 'show_all_warehouses']);
		Route::post('/api/fornecedores/{id}/armazem', [ArmazemController::class, 'create_warehouse']);

		Route::get('/api/fornecedores/{id}/armazem/{warehouse}', [ArmazemController::class, 'show_warehouse']);
		Route::put('/api/fornecedores/{id}/armazem/{warehouse}', [ArmazemController::class, 'update_warehouse']);
		Route::delete('/api/fornecedores/{id}/armazem/{warehouse}', [ArmazemController::class, 'destroy_warehouse']);

		Route::get('/api/fornecedores/{id}/armazem/{warehouse}/produto', [ArmazemController::class, 'warehouse_inventory']);
		Route::post('/api/fornecedores/{id}/armazem/{warehouse}/produto', [ArmazemController::class, 'store_warehouse']);

	});

	//transportadora
	Route::group(['middleware' => ['auth:sanctum', 'abilities:transportadora']], function(){
		Route::put('/api/transportadoras/{id}', [TransportadoraController::class, 'update']);
		Route::delete('/api/transportadoras/{id}', [TransportadoraController::class, 'destroy']);

		//Bases
		Route::get('/api/transportadoras/{id}/base', [TransportadoraController::class, 'show_all_bases']);
		Route::post('/api/transportadoras/{id}/base', [Base_TransportadoraController::class, 'create_base']);

		Route::get('/api/transportadoras/{id}/base/{id_base}', [Base_TransportadoraController::class, 'show_base']);
		Route::put('/api/transportadoras/{id}/base/{id_base}', [Base_TransportadoraController::class, 'update_base']);
		Route::delete('/api/transportadoras/{id}/base/{id_base}', [Base_TransportadoraController::class, 'destroy_base']);
	});
});