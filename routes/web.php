<?php

use App\Http\Controllers\YearController;
use App\Http\Controllers\ExpectancyController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// EXPECTANCY ROUTES
Route::post('/upload', [ExpectancyController::class, 'uploadFile'])->name('upload');
Route::get('/', [ExpectancyController::class, 'getExpectancyData'])->name('welcome');
Route::get('/column-names', [ExpectancyController::class, 'getYears'])->name('column-names');
Route::delete('/delete-all', [ExpectancyController::class, 'deleteAllData'])->name('delete-all');

// YEARS ROUTES
Route::post('/store', [YearController::class, 'store'])->name('store');
Route::get('/years', [YearController::class, 'index'])->name('years');
// Route::get('/column-names', [YearController::class, 'getYears'])->name('column-names');
Route::delete('/delete-years', [YearController::class, 'deleteAllYears'])->name('delete-years');
