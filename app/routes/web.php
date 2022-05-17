<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ArmazensController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\NotificationController;

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

Route::get('/storage', function () {

    if(session()->has('armazens')){

        return view('storage');

    } else {

        ArmazensController::getAllArmazens();
        return view('storage');

    }
})->name('storage');

Route::get('/inventory', function () {

    if(session()->has('all_fornecedor_produtos')){

        return view('inventory');

    } else {

        ProductsController::rebuild_fornecedor_session();
        return view('inventory');

    }
})->name('inventory');

Route::get('/products', [ProductsController::class, "allProducts"])->name('products');



// ##############################################
// GOOGLE ROUTES
// ##############################################
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth/google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth/google/callback');



// ##############################################
// PRODUCTS RELATED ROUTES
// ##############################################

Route::post('/product-info-controller', [ProductsController::class, "productInfo"])->name('product-info');

Route::post('/product-filter', [ProductsController::class, "filterProduct"])->name('product-filter');
Route::post('/product-categories', [ProductsController::class, "changeSub"])->name('product-changeSub');

Route::post('/product-register-controller', [ProductsController::class, "productRegister"])->name('product-register-controller');
Route::post('/product-delete-controller', [ProductsController::class, "productDelete"])->name('product-delete-controller');
Route::post('/product-remove-last-added', [ProductsController::class, "productRemoveLastAdded"])->name('product-remove-last-added');
Route::post('/product-remove', [ProductsController::class, "productRemove"])->name('product-remove');
Route::post('/product-edit-controller', [ProductsController::class, "productEdit"])->name('product-edit-controller');

Route::post('/product-add-event-controller', [ProductsController::class, "productAddEvent"])->name('product-add-event-controller');
Route::post('/product-edit-event-controller', [ProductsController::class, "productEditEvent"])->name('product-edit-event-controller');
Route::post('/product-remove-event-controller', [ProductsController::class, "productRemoveEvent"])->name('product-remove-event-controller');

Route::post('/product-add-carrinho-controller', [ProductsController::class, "productAddCarrinho"])->name('product-add-carrinho');

// ##############################################
// ARMAZENS RELATED ROUTES
// ##############################################

Route::post('/armazem-info-controller', [ArmazensController::class, "storageInfo"])->name('storage-info');

Route::post('/armazem-register-controller', [ArmazensController::class, "armazemRegister"])->name('armazem-register-controller');
Route::post('/armazem-edit-controller', [ArmazensController::class, "armazemEdit"])->name('armazem-edit-controller');
Route::post('/armazem-delete-controller', [ArmazensController::class, "armazemDelete"])->name('armazem-delete-controller');



// ##############################################
// USERS RELATED ROUTES
// ##############################################

Route::post('/register-etapa1-controller', [UserController::class, 'register_etapa1'])->name('register-etapa1-controller');


Route::post('/register-controller', [UserController::class, 'register'])->name('register-controller');
Route::get('/logout-controller', [UserController::class, 'logout'])->name('logout-controller');
Route::post('/login-controller', [UserController::class, 'login'])->name('login-controller');
Route::post('/edit-profile-controller', [UserController::class, 'update'])->name('edit-profile-controller');
Route::post('/delete-profile-controller', [UserController::class, 'delete'])->name('delete-profile-controller');
Route::post('/update-password-controller', [UserController::class, 'changePassword'])->name('update-password-controller');
Route::post('/update-avatar-controller', [UserController::class, 'changeAvatar'])->name('update-avatar-controller');


// ##############################################
// ROUTES TO HANDLE SESSION STUFF
// ##############################################

Route::get('/forget-google-user', function () {
    session()->forget('user_email');
    session()->forget('user_path_imagem');
    session()->forget('user_nome');
    session()->forget('user_google_id');
    return "ok";
})->name('forget-google-user');


// ##############################################
// ROUTES TO HANDLE NOTIFICATIONS
// ##############################################

Route::post('/delete-notification', [NotificationController::class, 'hideNotification'])->name('delete-notification');