<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Files;
use Illuminate\Support\Facades\Storage;

class CleanupExpiredFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired files from storage and database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fetch all expired files
        $expiredFiles = Files::where('expires_at', '<', now())->get();

        foreach ($expiredFiles as $file) {
            // Delete the file from local storage
            if (Storage::disk('local')->exists($file->path)) {
                Storage::disk('local')->delete($file->path);
                $this->info("Deleted file: {$file->path}");
            }

            // Remove the file record from the database
            $file->delete();
        }

        $this->info('Cleanup of expired files complete.');
    }
}
