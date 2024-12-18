<?php
namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{
    public function uploadZip(Request $request)
    {
        Log::channel('stderr')->debug('Start');
        try {
            $request->validate([
                'file' => 'required|file|mimes:zip',
            ], [
                'file.required' => 'The file is required. Please upload a ZIP file.',
                'file.file' => 'The uploaded file is not valid.',
                'file.mimes' => 'The file must be a ZIP file.',
                'file.max' => 'The file size must not exceed 5000MB.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        }
        Log::channel('stderr')->debug('After validation');

        try {
            // Step 1: Save the file to local storage
            $fileName = 'uploaded_' . uniqid() . '.zip';
            $filePath = 'temp/' . $fileName;
            Log::channel('stderr')->debug('Before save');
            $request->file('file')->storeAs('temp', $fileName);
            Log::channel('stderr')->debug('After save');

            // Step 2: Save file details in the database
            $uploadedFile = Files::create([
                'name' => $fileName,
                'path' => $filePath,
                'expires_at' => now()->addWeek(),
            ]);

            // Step 3: Generate a download link
            $downloadLink = route('download-file', ['path' => $filePath]);
            Log::channel('stderr')->debug('The link');
            Log::channel('stderr')->debug($downloadLink);
            // Step 4: Return response
            return response()->json([
                'message' => 'File uploaded successfully',
                'file' => $uploadedFile,
                'downloadLink' => $downloadLink,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'File upload failed',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
