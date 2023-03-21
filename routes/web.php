<?php

use App\Http\Controllers\ConnectController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
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


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', [ConnectController::class, 'index'])
        ->name('connections');

    Route::get('/connect/{name}', [ConnectController::class, 'connect'])
        ->name('connect');

    Route::get('/list/{letter}', [ConnectController::class, 'list'])
        ->name('list');

    Route::get('/get/{key}', [ConnectController::class, 'get'])
        ->name('get');

    // Route::get('/dashboard', function () {
    //     return Inertia::render('Dashboard');
    // })->name('dashboard');
});
