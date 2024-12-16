<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {
    return view('register');
});

Route::post('/register', [AuthController::class, 'register']);

Route::get('/upload', function () {
    return view('upload');
})->middleware('auth');

Route::post('/upload-zip', [UploadController::class, 'uploadZip']);

Route::get('/download-file', [DownloadController::class, 'downloadFile'])->name('download-file');
