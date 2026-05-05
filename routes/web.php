<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiCoursController;
use App\Http\Controllers\ApiSignatureController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('accueil_session');
    }

    return view('login');
})->name('login');

Route::post('/login',
    [ApiAuthController::class, 'login']
)->name('login.post');

Route::middleware('auth')->group(function () {
    Route::get('/logout',
        [ApiAuthController::class, 'logout']
    )->name('logout');

    Route::get('/accueil_session', [ApiCoursController::class, 'index'])->name('accueil_session');

    Route::get('/signature/{id}', [ApiCoursController::class, 'show'])->name('signature');

    Route::post('/signature', [ApiSignatureController::class, 'store'])->name('signature.store');
});

