<?php

use Illuminate\Support\Facades\Route;

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
});

Auth::routes();

Route::get('/', [App\Http\Controllers\ContactController::class, 'index'])->name('home');
Route::any('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::match(['GET', 'POST'], '/contact/edit/{id}', [App\Http\Controllers\ContactController::class, 'edit'])->name('contact.edit');
Route::post('/contact/delete', [App\Http\Controllers\ContactController::class, 'delete'])->name('contact.delete');
