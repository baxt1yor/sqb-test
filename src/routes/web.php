<?php

use App\Http\Controllers\Web\CurrencyController;
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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [CurrencyController::class, 'index'])->name('currency.index');
Route::post('sync', [CurrencyController::class, 'sync'])->name('currency.sync');
Route::get('currency/{id}', [CurrencyController::class, 'show'])->name('currency.show');
Route::post('currency/sync-child', [CurrencyController::class, 'syncCurrencyChild'])->name('currency.child.sync');
