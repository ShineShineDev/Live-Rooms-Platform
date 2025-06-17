<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

trait FileUpload
{
    protected function uploadFile($file, $path, $prefix = null)
    {
        $uploadPath = public_path('uploads/' . $path);
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $file_name = $prefix . uniqid() . '.webp';
        $file_path = $uploadPath . '/' . $file_name;
        $file_url = '/uploads/' . $path . '/' . $file_name;

        Image::make($file)
            ->encode('webp', 50) // You can change quality if needed
            ->save($file_path);
            
        return [
            'path' => $file_url,
            'original_name' => $file->getClientOriginalName(),
            'stored_name' => $file_name,
            'file_size' => filesize($file_path),
            'mime_type' => 'webp',
            'block' => $path,
        ];
    }
    public function updateFile(UploadedFile $file, $uploadPath, $oldFilePath, $prefiex)
    {
        $this->deleteFile($oldFilePath);
        return $this->uploadFile($file, $uploadPath, $prefiex);
    }
    protected function deleteFile($filePath)
    {
        if (File::exists(public_path($filePath))) {
            File::delete(public_path($filePath));
        }
    }

    public function copyFile($sourcePath, $block)
    {
        $absoluteSourcePath = public_path($sourcePath);
        $fileName = pathinfo($absoluteSourcePath, PATHINFO_BASENAME);
        $destinationDirectory = public_path("/uploads/$block");
        $destinationPath = $destinationDirectory . '/' . $fileName;
        if (file_exists($absoluteSourcePath)) {
            if (!file_exists($destinationDirectory)) {
                mkdir($destinationDirectory, 0777, true);
            } else {
                \Log::error("Destination directory not exist " . $sourcePath);
            }
            if (copy($absoluteSourcePath, $destinationPath)) {
                return true;
            } else {
                \Log::error("Failed to copy file: " . $sourcePath);
                return false;
            }
        } else {
            \Log::error("Source file not found: " . $sourcePath);
            return false;
        }
    }
}