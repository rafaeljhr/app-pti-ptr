<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\website\LoginLogoutRegisterController;

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

// Route::get('/logout', function () {
//     Session::flush();
//     return redirect('/');
// })->name('logout');

Route::post('/register', [LoginLogoutRegisterController::class, 'register'])->name('register');
Route::get('/logout', [LoginLogoutRegisterController::class, 'logout'])->name('logout');
Route::post('/login', [LoginLogoutRegisterController::class, 'login'])->name('login');    