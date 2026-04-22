<?php

use App\Http\Controllers\ApiCoursController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

// Temporary debug route to test HTTP 500 issue with /jump/qr
Route::get('/jump/qr', function () {
    return 'Jump QR test route';
});

Route::get('/accueil_session', [ApiCoursController::class, 'index']);
Route::get('/signature/{id}', [ApiCoursController::class, 'show'])->name('signature');
