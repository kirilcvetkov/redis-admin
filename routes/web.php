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
    Route::get('/{selectedConnection?}', [ConnectController::class, 'serverStats'])
        ->name('home');

    Route::get('/item/{selectedConnection}/{key}', [ConnectController::class, 'show'])
        ->name('show');

    // Route::post('/item/{selectedConnection}/{key}', [ConnectController::class, 'store'])
    //     ->name('store');

    Route::delete('/item/{selectedConnection}/{key}', [ConnectController::class, 'destroy'])
        ->name('delete');
});
