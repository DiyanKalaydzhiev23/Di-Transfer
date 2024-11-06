<?php

use App\Models\Files;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

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
});

Route::post('/upload-files', function (Request $request) {
    $request->validate([
        'files.*' => 'required|file|max:2048', // Validates each file individually
    ]);

    // Create a temporary file for the ZIP archive
    $zipPath = storage_path('app/temp_upload.zip');
    $zip = new ZipArchive;

    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        // Add each file to the ZIP archive
        foreach ($request->file('files') as $file) {
            $zip->addFile($file->getRealPath(), $file->getClientOriginalName());
        }
        $zip->close();
    } else {
        return response()->json(['error' => 'Could not create ZIP file'], 500);
    }

    // Upload the ZIP file to Cloudinary
    $uploadedFileUrl = Cloudinary::uploadFile($zipPath)->getSecurePath();

    // Save the ZIP file record in the database
    $uploadedFile = Files::create([
        'name' => 'compressed_files.zip',
        'url' => $uploadedFileUrl,
    ]);

    // Delete the temporary ZIP file
    unlink($zipPath);

    return response()->json([
        'message' => 'Files uploaded successfully as ZIP',
        'file' => $uploadedFile,
    ]);
});

