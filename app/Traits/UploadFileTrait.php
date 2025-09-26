<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadFileTrait
{

    public function __construct()
    {
    }


    public function uploadAvatar(UploadedFile $file, string $folder = 'uploads/avatar')
    {


        if (!$file) {
            return null;
        }

        $orignalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $filename = date('d-m-Y') . "/" . Str::slug($orignalName) . "." . $extension;
        $path = $file->storeAs($folder, $filename, 'public');
        return Storage::url($path);
    }


    public function deleteFile(string $path)
    {

        if (!$path) {
            return false;
        }

        return Storage::disk('public')->delete($path);
    }
}
