<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function downloadFile(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        $filePath = $request->input('path');

        if (!Storage::disk('local')->exists($filePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return Storage::disk('local')->download($filePath);
    }
}
