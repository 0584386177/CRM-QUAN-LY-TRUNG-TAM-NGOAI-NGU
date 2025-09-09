<?php

namespace App\Trait;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait UploadFileTrait
{
    public function uploadFIle(UploadedFile $file, string $folder = 'uploads')
    {

        if (!$file) {
            return null;
        }

        $orignalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $filename = $orignalName . "_" . uniqid() . "." . $extension;

        return $file->storeAs($folder, $filename, 'public');
    }


    public function deleteFile(string $path)
    {

        if (!$path) {
            return false;
        }

        return Storage::disk('public')->delete($path);
    }
}
