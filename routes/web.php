<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EntryController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Index');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



// Route::get('/', [StaticController::class, 'create'])->middleware(['throttle:200:1']);

// Route::prefix('dashboard')->middleware(['throttle:200:1', 'auth', 'verified'])->group(function () {
//     Route::get('/', [DashboardController::class, 'create']);
// });



Route::middleware(['guest'])->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});


// ->middleware(['throttle:800:1'])
Route::prefix('api')->group(function () {
    Route::prefix('entries')->group(function () {
        Route::get('/', [EntryController::class, 'getEntries']); //->middleware(['throttle:60:1']);
        Route::get('/all', [EntryController::class, 'getAllEntries']);//->middleware(['throttle:60:1']);
        Route::post('/', [EntryController::class, 'postEntry'])->middleware(['throttle:40:1']);
        Route::put('/{comment}', [EntryController::class, 'editEntry'])->middleware(['auth']);
        Route::delete('/{comment}', [EntryController::class, 'delteEntry'])->middleware(['auth']);
    });
});