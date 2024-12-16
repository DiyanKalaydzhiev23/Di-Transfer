<?php

use App\Http\Controllers\UploadController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
});


Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'name' => 'required|string|max:255',
        'password' => 'required|string',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/upload'); // Redirect to upload or intended page
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
});

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return redirect('/upload');
});

Route::get('/upload', function () {
    return view('upload');
})->middleware('auth');

Route::post('/upload-zip', [UploadController::class, 'uploadZip']);

Route::get('/download-file', function (Request $request) {
    $request->validate([
        'path' => 'required|string',
    ]);

    $filePath = $request->input('path');

    if (!Storage::disk('local')->exists($filePath)) {
        return response()->json(['error' => 'File not found'], 404);
    }

    // Serve the file for download
    return Storage::disk('local')->download($filePath);
})->name('download-file');
