<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearCartCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart:clear {user? : The ID of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear cart cache and reset cart data';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $userId = $this->argument('user');
        
        if ($userId) {
            $user = \App\Models\User::find($userId);
            if ($user) {
                // Clear user-specific cart data if needed
                $this->info("Clearing cart for user: {$user->name} (ID: {$user->id})");
                
                // Reset temp_data if it exists
                if (isset($user->temp_data)) {
                    $user->temp_data = null;
                    $user->save();
                    $this->info("Cleared user temp_data");
                }
            } else {
                $this->error("User with ID {$userId} not found");
                return;
            }
        } else {
            $this->info("Clearing all cart session data");
        }
        
        // Clear session files
        $sessionPath = storage_path('framework/sessions');
        $this->info("Cleaning session files from: {$sessionPath}");
        
        $sessionFiles = glob("{$sessionPath}/*");
        $count = count($sessionFiles);
        
        foreach ($sessionFiles as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        
        $this->info("Cleared {$count} session files");
        
        // Clear cache
        $this->call('cache:clear');
        
        $this->info("Cart cache cleared successfully");
    }
}
