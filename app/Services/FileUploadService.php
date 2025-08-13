<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload file hasil pengujian dengan best practices untuk hosting
     */
    public function uploadTestingResult(UploadedFile $file, string $trackingCode): array
    {
        // Validate file
        $this->validateFile($file, [
            'max_size' => 10 * 1024 * 1024, // 10MB
            'allowed_types' => ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png']
        ]);

        // Generate secure filename
        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $sanitizedName = $this->sanitizeFilename($originalName);
        
        // Create organized path: year/month/tracking_code_timestamp.extension
        $directory = 'testing-results/' . date('Y/m');
        $filename = $trackingCode . '_' . time() . '_' . Str::random(8) . '.' . $extension;
        
        // Store file
        $filePath = $file->storeAs($directory, $filename, 'public');
        
        return [
            'file_path' => $filePath,
            'original_name' => $originalName,
            'file_size' => $this->formatFileSize($file->getSize()),
            'mime_type' => $file->getMimeType(),
            'filename' => $filename
        ];
    }

    /**
     * Upload file pendukung pengajuan
     */
    public function uploadSupportingFile(UploadedFile $file, string $trackingCode): array
    {
        // Validate file
        $this->validateFile($file, [
            'max_size' => 5 * 1024 * 1024, // 5MB
            'allowed_types' => ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png']
        ]);

        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        
        // Create organized path for supporting files
        $directory = 'supporting-files/' . date('Y/m');
        $filename = 'support_' . $trackingCode . '_' . time() . '.' . $extension;
        
        // Store file
        $filePath = $file->storeAs($directory, $filename, 'public');
        
        return [
            'file_path' => $filePath,
            'original_name' => $originalName,
            'file_size' => $this->formatFileSize($file->getSize()),
            'mime_type' => $file->getMimeType(),
            'filename' => $filename
        ];
    }

    /**
     * Validate uploaded file
     */
    private function validateFile(UploadedFile $file, array $rules): void
    {
        // Check file size
        if ($file->getSize() > $rules['max_size']) {
            throw new \InvalidArgumentException('File terlalu besar. Maksimal ' . $this->formatFileSize($rules['max_size']));
        }

        // Check file type
        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $rules['allowed_types'])) {
            throw new \InvalidArgumentException('Tipe file tidak didukung. Gunakan: ' . implode(', ', $rules['allowed_types']));
        }

        // Check if file is valid
        if (!$file->isValid()) {
            throw new \InvalidArgumentException('File tidak valid atau rusak');
        }
    }

    /**
     * Sanitize filename for security
     */
    private function sanitizeFilename(string $filename): string
    {
        // Remove path traversal attempts
        $filename = basename($filename);
        
        // Remove dangerous characters
        $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
        
        // Limit length
        if (strlen($filename) > 100) {
            $pathInfo = pathinfo($filename);
            $name = substr($pathInfo['filename'], 0, 90);
            $filename = $name . '.' . $pathInfo['extension'];
        }
        
        return $filename;
    }

    /**
     * Format file size to human readable format
     */
    public function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Delete file safely
     */
    public function deleteFile(string $filePath): bool
    {
        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->delete($filePath);
        }
        
        return false;
    }

    /**
     * Upload gambar untuk galeri laboratorium
     */
    public function uploadGalleryImage(UploadedFile $file): array
    {
        $this->validateFile($file, [
            'max_size' => 2 * 1024 * 1024, // 2MB
            'allowed_types' => ['jpg', 'jpeg', 'png', 'gif', 'webp']
        ]);

        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        
        $directory = 'gallery/' . date('Y/m');
        $filename = 'gallery_' . time() . '_' . Str::random(8) . '.' . $extension;
        
        $filePath = $file->storeAs($directory, $filename, 'public');
        
        return [
            'file_path' => $filePath,
            'original_name' => $originalName,
            'file_size' => $this->formatFileSize($file->getSize()),
            'mime_type' => $file->getMimeType(),
            'filename' => $filename
        ];
    }

    /**
     * Upload gambar untuk equipment/alat
     */
    public function uploadEquipmentImage(UploadedFile $file): array
    {
        $this->validateFile($file, [
            'max_size' => 2 * 1024 * 1024, // 2MB
            'allowed_types' => ['jpg', 'jpeg', 'png', 'gif']
        ]);

        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        
        $directory = 'equipment/' . date('Y/m');
        $filename = 'equipment_' . time() . '_' . Str::random(8) . '.' . $extension;
        
        $filePath = $file->storeAs($directory, $filename, 'public');
        
        return [
            'file_path' => $filePath,
            'original_name' => $originalName,
            'file_size' => $this->formatFileSize($file->getSize()),
            'mime_type' => $file->getMimeType(),
            'filename' => $filename
        ];
    }

    /**
     * Upload gambar untuk articles
     */
    public function uploadArticleImage(UploadedFile $file): array
    {
        $this->validateFile($file, [
            'max_size' => 2 * 1024 * 1024, // 2MB
            'allowed_types' => ['jpg', 'jpeg', 'png', 'gif']
        ]);

        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        
        $directory = 'articles/' . date('Y/m');
        $filename = 'article_' . time() . '_' . Str::random(8) . '.' . $extension;
        
        $filePath = $file->storeAs($directory, $filename, 'public');
        
        return [
            'file_path' => $filePath,
            'original_name' => $originalName,
            'file_size' => $this->formatFileSize($file->getSize()),
            'mime_type' => $file->getMimeType(),
            'filename' => $filename
        ];
    }

    /**
     * Upload gambar untuk staff
     */
    public function uploadStaffImage(UploadedFile $file): array
    {
        $this->validateFile($file, [
            'max_size' => 2 * 1024 * 1024, // 2MB
            'allowed_types' => ['jpg', 'jpeg', 'png', 'gif']
        ]);

        $originalName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        
        $directory = 'staff/' . date('Y/m');
        $filename = 'staff_' . time() . '_' . Str::random(8) . '.' . $extension;
        
        $filePath = $file->storeAs($directory, $filename, 'public');
        
        return [
            'file_path' => $filePath,
            'original_name' => $originalName,
            'file_size' => $this->formatFileSize($file->getSize()),
            'mime_type' => $file->getMimeType(),
            'filename' => $filename
        ];
    }

    /**
     * Get file download URL
     */
    public function getFileUrl(string $filePath): string
    {
        return Storage::disk('public')->url($filePath);
    }

    /**
     * Check if file exists
     */
    public function fileExists(string $filePath): bool
    {
        return Storage::disk('public')->exists($filePath);
    }
}

