<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\GaleriLaboratorium;
use App\Models\Gambar;

class MigrateImagesToStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:images-to-storage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing images from public directory to Laravel storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting migration of images to storage...');

        $this->migrateGaleriImages();
        $this->migrateEquipmentImages();
        $this->migrateArticleImages();
        $this->migrateStaffImages();

        $this->info('Migration completed successfully!');
        return 0;
    }

    private function migrateGaleriImages()
    {
        $this->info('Migrating galeri images...');
        
        $galeriItems = GaleriLaboratorium::whereNotNull('gambar_url')->get();
        $count = 0;

        foreach ($galeriItems as $item) {
            $oldPath = public_path($item->gambar_url);
            
            if (file_exists($oldPath) && str_starts_with($item->gambar_url, 'images/galeri/')) {
                $filename = basename($item->gambar_url);
                $newPath = 'gallery/' . date('Y/m', strtotime($item->created_at ?? 'now')) . '/' . $filename;
                
                // Create directory if it doesn't exist
                Storage::disk('public')->makeDirectory(dirname($newPath));
                
                // Copy file to storage
                if (Storage::disk('public')->put($newPath, file_get_contents($oldPath))) {
                    // Update database
                    $item->update(['gambar_url' => $newPath]);
                    
                    // Delete old file
                    unlink($oldPath);
                    $count++;
                    
                    $this->line("Migrated: {$item->gambar_url} -> {$newPath}");
                }
            }
        }
        
        $this->info("Migrated {$count} galeri images.");
    }

    private function migrateEquipmentImages()
    {
        $this->info('Migrating equipment images...');
        
        $gambarItems = Gambar::where('kategori', 'ALAT')
            ->where('url', 'like', 'images/equipment/%')
            ->get();
        $count = 0;

        foreach ($gambarItems as $gambar) {
            $oldPath = public_path($gambar->url);
            
            if (file_exists($oldPath)) {
                $filename = basename($gambar->url);
                $newPath = 'equipment/' . date('Y/m', strtotime($gambar->created_at ?? 'now')) . '/' . $filename;
                
                // Create directory if it doesn't exist
                Storage::disk('public')->makeDirectory(dirname($newPath));
                
                // Copy file to storage
                if (Storage::disk('public')->put($newPath, file_get_contents($oldPath))) {
                    // Update database
                    $gambar->update(['url' => $newPath]);
                    
                    // Delete old file
                    unlink($oldPath);
                    $count++;
                    
                    $this->line("Migrated: {$gambar->url} -> {$newPath}");
                }
            }
        }
        
        $this->info("Migrated {$count} equipment images.");
    }

    private function migrateArticleImages()
    {
        $this->info('Migrating article images...');
        
        $gambarItems = Gambar::where('kategori', 'ACARA')
            ->where('url', 'like', 'images/articles/%')
            ->get();
        $count = 0;

        foreach ($gambarItems as $gambar) {
            $oldPath = public_path($gambar->url);
            
            if (file_exists($oldPath)) {
                $filename = basename($gambar->url);
                $newPath = 'articles/' . date('Y/m', strtotime($gambar->created_at ?? 'now')) . '/' . $filename;
                
                // Create directory if it doesn't exist
                Storage::disk('public')->makeDirectory(dirname($newPath));
                
                // Copy file to storage
                if (Storage::disk('public')->put($newPath, file_get_contents($oldPath))) {
                    // Update database
                    $gambar->update(['url' => $newPath]);
                    
                    // Delete old file
                    unlink($oldPath);
                    $count++;
                    
                    $this->line("Migrated: {$gambar->url} -> {$newPath}");
                }
            }
        }
        
        $this->info("Migrated {$count} article images.");
    }

    private function migrateStaffImages()
    {
        $this->info('Migrating staff images...');
        
        $gambarItems = Gambar::where('kategori', 'PENGURUS')
            ->where('url', 'like', 'images/staff/%')
            ->get();
        $count = 0;

        foreach ($gambarItems as $gambar) {
            $oldPath = public_path($gambar->url);
            
            if (file_exists($oldPath)) {
                $filename = basename($gambar->url);
                $newPath = 'staff/' . date('Y/m', strtotime($gambar->created_at ?? 'now')) . '/' . $filename;
                
                // Create directory if it doesn't exist
                Storage::disk('public')->makeDirectory(dirname($newPath));
                
                // Copy file to storage
                if (Storage::disk('public')->put($newPath, file_get_contents($oldPath))) {
                    // Update database
                    $gambar->update(['url' => $newPath]);
                    
                    // Delete old file
                    unlink($oldPath);
                    $count++;
                    
                    $this->line("Migrated: {$gambar->url} -> {$newPath}");
                }
            }
        }
        
        $this->info("Migrated {$count} staff images.");
    }
}
