<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\ExportController;

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
    return view('welcome');
});

Route::group( ['prefix' => 'column'], function() {
    Route::get('/', [ColumnController::class, 'index']);
    Route::post('/', [ColumnController::class, 'store']);
    Route::delete('/{id}', [ColumnController::class, 'destroy']);
});

Route::group( ['prefix' => 'card'], function() {
    Route::delete('/{id}', [CardController::class, 'destroy']);
    Route::get('/{id}', [CardController::class, 'edit']);
    Route::post('/', [CardController::class, 'store']);
    Route::post('/indexing', [CardController::class, 'indexing']);
});
Route::get('/export', [ExportController::class, 'export']);
