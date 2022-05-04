<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;

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
    return redirect()->route('login');
});


Route::get('/login', [WebController::class, 'login'])->name('login');
Route::post('/checklogin', [WebController::class, 'checklogin']);
Route::get('/index', [WebController::class, 'index'])->name('index');
Route::get('/logout', [WebController::class, 'logout']);
Route::post('/GetToken', [WebController::class, 'GetToken']);
