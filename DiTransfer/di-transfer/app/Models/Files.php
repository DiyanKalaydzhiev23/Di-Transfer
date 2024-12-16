<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class Files extends Model
{
    protected $fillable = ['name', 'path', 'expires_at'];

    public static function uploadAndSaveFile($file)
    {
        $uniqueFileName = uniqid() . '_' . $file->getClientOriginalName();
        $filePath = 'temp/' . $uniqueFileName;

        Storage::disk('local')->put($filePath, file_get_contents($file));

        $expirationDate = Carbon::now()->addWeek();

        return self::create([
            'name' => $file->getClientOriginalName(),
            'path' => $filePath,
            'expires_at' => $expirationDate,
        ]);
    }

    public function isExpired()
    {
        return Carbon::now()->greaterThan($this->expires_at);
    }
}
