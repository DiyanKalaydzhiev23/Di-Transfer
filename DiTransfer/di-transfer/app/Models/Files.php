<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class Files extends Model
{
    protected $fillable = ['name', 'url'];

    // Method to upload file and save its URL
    public static function uploadAndSaveFile($file)
    {
        $uploadedFileUrl = Cloudinary::upload($file->getRealPath())->getSecurePath();

        return self::create([
            'name' => $file->getClientOriginalName(),
            'url' => $uploadedFileUrl,
        ]);
    }
}
