<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlasonController;
use App\Http\Controllers\MeublesController;
use App\Http\Controllers\Auth\RegisterController;

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

Route::get('/', [BlasonController::class, 'create_random'])->name('welcome');

Route::get('admin_access', [RegisterController::class, 'admin_access']);
Route::post('admin_access', [RegisterController::class, 'admin_login']);

Route::get('new_meuble', [MeublesController::class, 'create'])->name('new_meuble')->middleware('auth');
Route::post('new_meuble', [MeublesController::class, 'store'])->middleware('auth');

