<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsumidorController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\TransportadoraController;
use App\Http\Controllers\ArmazemController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\Base_TransportadoraController;
use App\Http\Controllers\AuthController;




//**********    Recursos Publicos  ************

Route::post('/login', [AuthController::class, 'login']);

//***************************  Consumidor ***************************//
Route::post('/consumidores', [ConsumidorController::class, 'consumidorRegister']);
Route::get('/consumidores', [ConsumidorController::class, 'index']);
Route::get('/consumidores/{id}/', [ConsumidorController::class, 'show']);

//***************************  Fornecedor ***************************//
Route::post('/fornecedores', [FornecedorController::class, 'register']);
Route::get('/fornecedores', [FornecedorController::class, 'index']);
Route::get('/fornecedores/{id}', [FornecedorController::class, 'show']);

//inventario
Route::get('/fornecedores/{id}/produto', [FornecedorController::class, 'show_inventory']);
Route::get('/fornecedores/{id}/produto/{id_product}', [ProdutoController::class, 'show_product']);


//***************************  Transportadora ***************************//
Route::post('/transportadoras', [TransportadoraController::class, 'register']);
Route::get('/transportadoras', [TransportadoraController::class, 'index']);
Route::get('/transportadoras/{id}', [TransportadoraController::class, 'show']);


//***************************  Recursos Protegidos ***************************//
Route::group(['middleware' => ['auth:sanctum']], function(){

	//consumidor
	Route::group(['middleware' => ['auth:sanctum', 'abilities:consumidor']], function(){
		Route::put('/consumidores/{id}', [ConsumidorController::class, 'update']);
		Route::delete('/consumidores/{id}', [ConsumidorController::class, 'destroy']);

		//Encomendas
		Route::get('/consumidores/{id}/encomendas', [ConsumidorController::class, 'show_orders']);
		Route::get('/consumidores/{id}/encomendas/{id_order}', [ConsumidorController::class, 'show_specific_order']);

		Route::delete('/consumidores/{id}/encomendas/{id_order}', [ConsumidorController::class, 'remove_order']);

	});

	//fornecedor
	Route::group(['middleware' => ['auth:sanctum', 'abilities:fornecedor']], function(){

		Route::put('/fornecedores/{id}', [FornecedorController::class, 'update']);
		Route::delete('/fornecedores/{id}', [FornecedorController::class, 'destroy']);

		//Inventario
		Route::post('/fornecedores/{id}/produto', [ProdutoController::class, 'create_product']);
		Route::put('/fornecedores/{id}/produto/{id_product}', [ProdutoController::class, 'update_product']);
		Route::delete('/fornecedores/{id}/produto/{id_product}', [ProdutoController::class, 'destroy_product']);

		//Armazem
		Route::get('/fornecedores/{id}/armazem', [FornecedorController::class, 'show_all_warehouses']);
		Route::post('/fornecedores/{id}/armazem', [ArmazemController::class, 'create_warehouse']);

		Route::get('/fornecedores/{id}/armazem/{warehouse}', [ArmazemController::class, 'show_warehouse']);
		Route::put('/fornecedores/{id}/armazem/{warehouse}', [ArmazemController::class, 'update_warehouse']);
		Route::delete('/fornecedores/{id}/armazem/{warehouse}', [ArmazemController::class, 'destroy_warehouse']);

		Route::get('/fornecedores/{id}/armazem/{warehouse}/produto', [ArmazemController::class, 'warehouse_inventory']);
		Route::post('/fornecedores/{id}/armazem/{warehouse}/produto', [ArmazemController::class, 'store_warehouse']);

	});

	//transportadora
	Route::group(['middleware' => ['auth:sanctum', 'abilities:transportadora']], function(){
		Route::put('/transportadoras/{id}', [TransportadoraController::class, 'update']);
		Route::delete('/transportadoras/{id}', [TransportadoraController::class, 'destroy']);

		//Bases
		Route::get('/transportadoras/{id}/base', [TransportadoraController::class, 'show_all_bases']);
		Route::post('/transportadoras/{id}/base', [Base_TransportadoraController::class, 'create_base']);

		Route::get('/transportadoras/{id}/base/{id_base}', [Base_TransportadoraController::class, 'show_base']);
		Route::put('/transportadoras/{id}/base/{id_base}', [Base_TransportadoraController::class, 'update_base']);
		Route::delete('/transportadoras/{id}/base/{id_base}', [Base_TransportadoraController::class, 'destroy_base']);
	});
});