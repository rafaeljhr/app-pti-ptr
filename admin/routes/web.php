<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsumidoresController;
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

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('/checklogin', [AuthController::class, 'checklogin'])->name('checklogin');

Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');; 
Route::get('signout', [AuthController::class, 'signOut'])->name('signout');

Route::get('dashboard/consumidores', [ConsumidoresController::class, 'index'])->name('consumidores');

Route::get('dashboard/admins', [AdminsController::class, 'index'])->name('admins');
Route::post('dashboard/addAdmin', [AdminsController::class, 'addAdmin'])->name('addAdmin');