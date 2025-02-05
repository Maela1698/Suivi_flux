<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class ServicesConstat
{
    public function uploadImage($path,UploadedFile $fichier)
    {
        $fileName = time() . '.' . $fichier->extension();

        $fichier->move(public_path($path), $fileName);

        return $fileName;
    }
}
