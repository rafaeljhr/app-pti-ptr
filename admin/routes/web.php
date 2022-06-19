<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsumidoresController;
use App\Http\Controllers\TransportadorasController;
use App\Http\Controllers\FornecedoresController;
use App\Http\Controllers\AdminsController;

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
    return redirect('/login');
});



Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/checklogin', [AuthController::class, 'checklogin'])->name('checklogin');

Route::get('/home', [AuthController::class, 'home'])->name('home');; 
Route::get('/signout', [AuthController::class, 'signOut'])->name('signout');

/******************** CONSUMIDORES ********************/

Route::get('/consumidores', [ConsumidoresController::class, 'index'])->name('consumidores.index');
Route::post('/consumidores', [ConsumidoresController::class, 'store'])->name('consumidores.store');
Route::get('/consumidores/{id}/edit', [ConsumidoresController::class, 'edit'])->name('consumidores.edit');
Route::delete('/consumidores/{id}', [ConsumidoresController::class, 'destroy'])->name('consumidores.destroy');

Route::get('/fornecedores', [FornecedoresController::class, 'index'])->name('fornecedores.index');
Route::post('/fornecedores', [FornecedoresController::class, 'store'])->name('fornecedores.store');
Route::get('/fornecedores/{id}/edit', [FornecedoresController::class, 'edit'])->name('fornecedores.edit');
Route::delete('/fornecedores/{id}', [FornecedoresController::class, 'destroy'])->name('fornecedores.destroy');

Route::get('/transportadoras', [TransportadorasController::class, 'index'])->name('transportadoras.index');
Route::post('/transportadoras', [TransportadorasController::class, 'store'])->name('transportadoras.store');
Route::get('/transportadoras/{id}/edit', [TransportadorasController::class, 'edit'])->name('transportadoras.edit');
Route::delete('/transportadoras/{id}', [TransportadorasController::class, 'destroy'])->name('transportadoras.destroy');

Route::get('/admins', [AdminsController::class, 'index'])->name('admins');
Route::post('/addAdmin', [AdminsController::class, 'addAdmin'])->name('addAdmin');