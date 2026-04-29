<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiCoursController;
use App\Http\Controllers\ApiSignatureController;
use Illuminate\Support\Facades\Route;

// Temporary debug route to test HTTP 500 issue with /jump/qr
Route::get('/jump/qr', function () {
    return 'Jump QR test route';
});

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('accueil_session');
    }

    return app(ApiAuthController::class)->showLoginForm();
})->name('login');

Route::post('/login', [ApiAuthController::class, 'login'])->name('login.post');
Route::get('/logout', [ApiAuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/accueil_session', [ApiCoursController::class, 'index'])->name('accueil_session');
    Route::get('/signature/{id}', [ApiCoursController::class, 'show'])->name('signature');

    Route::post('/signature', [ApiSignatureController::class, 'store'])->name('signature.store');
});

