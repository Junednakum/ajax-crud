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

use App\Http\Controllers\UserController;

Route::get('/', [UserController::class, 'index']);
Route::get('user-list/{id}/edit', [UserController::class, 'edit']);
Route::post('user-list/store', [UserController::class, 'store']);
Route::post('user-list/delete/', [UserController::class, 'destroy']);
