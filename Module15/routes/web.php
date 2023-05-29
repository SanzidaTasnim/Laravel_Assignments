<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return redirect('/dashboard', 302);
});
Route::middleware([AuthMiddleware::class])->group(function () {
    Route::get('/profile', function () {
        // Profile route logic
    });
    Route::get('/settings', function () {
        // Settings route logic
    });
});
Route::get('/registration',[RegisterController::class, 'registration']);
Route::post('/contact',[ContactController::class]);
