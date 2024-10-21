<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ItemController;

Route::get('/', function () {
    return view('pages.login');
})->middleware('authCheck');

Route::post('/auth', [ AuthenticatedSessionController::class, 'authenticate' ])
                ->middleware('guest')
                ->name('auth');

Route::post('/auth_validate', [ AuthenticatedSessionController::class, 'validate_auth' ])
                ->middleware('guest')
                ->name('auth.validate');

Route::post('/send_code', [ AuthenticatedSessionController::class, 'send_code' ])
                ->middleware('guest')
                ->name('auth.sendcode');


Route::get('/test', [ ItemController::class, 'get_employee' ]);

require __DIR__.'/auth.php';
