<?php
use App\Http\Controllers\YearController;
use App\Http\Controllers\ExpectancyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// EXPECTANCIES ROUTES
Route::post('/upload', [ExpectancyController::class, 'uploadFile']);
Route::get('/expectancy-data', [ExpectancyController::class, 'getExpectancyData']);
Route::get('/column-names', [ExpectancyController::class, 'getYears']);
Route::delete('/delete-all', [ExpectancyController::class, 'deleteAllData']);

// YEARS ROUTES
Route::post('/store', [YearController::class, 'store'])->name('store');
Route::get('/years', [YearController::class, 'index'])->name('years');
// Route::get('/column-names', [YearController::class, 'getYears'])->name('column-names');
Route::get('/delete-years', [YearController::class, 'deleteAllYears'])->name('delete-years');
