<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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



// ##############
// NAVBAR ROUTES
// ##############

Route::get('/', function () {
    return view('home');
})->name('home-url');

Route::get('/about', function () {
    return view('about');
})->name('about-url');

Route::get('/contact', function () {
    return view('contact');
})->name('contact-url');

Route::get('/signin', function () {
    return view('signin');
})->name('signin-url');

Route::get('/register', function () {
    return view('register');
})->name('register-url');

Route::get('/profile', function () {
    return view('profile');
})->name('profile-url');


/* !Temporario! */
Route::get('/inventory', function () {
    return view('inventory');
})->name('inventory-url');
/* !Temporario! */


// ###################
// CONTROLLERS ROUTES
// ###################
/* depois mexe altera o que quiseres rafa G */

// Ir buscar os produtos do fornecedor, meter na session (quando clica inventario no dropdown menu)
Route::post('/inventory-controller', [ProductsController::class, "getAllProducts"])->name('inventory-controller');

Route::post('/product-register-controller', [ProductsController::class, "productRegister"])->name('product-register-controller');
Route::post('/product-delete-controller', [ProductsController::class, "productDelete"])->name('product-delete-controller');
Route::post('/product-edit-controller', [ProductsController::class, "productEdit"])->name('product-edit-controller');
Route::post('/product-add-event-controller', [ProductsController::class, "productAddEvent"])->name('product-add-event-controller');
Route::post('/product-remove-event-controller', [ProductsController::class, "productRemoveEvent"])->name('product-remove-event-controller');


Route::post('/register-controller', [UserController::class, 'register'])->name('register-controller');
Route::get('/logout-controller', [UserController::class, 'logout'])->name('logout-controller');
Route::post('/login-controller', [UserController::class, 'login'])->name('login-controller');
Route::post('/edit-profile-controller', [UserController::class, 'update'])->name('edit-profile-controller');
Route::post('/delete-profile-controller', [UserController::class, 'delete'])->name('delete-profile-controller');