<?php

namespace App\Http\Traits;

trait ImageUploadTrait
{
    public function uploadImage($file, $pathName)
    {
        $imageName = time() . '_' . rand(111, 999) . '.' . $file->getClientOriginalExtension();
        $path = 'upload/' . $pathName . '/';
        $ext = $file->getClientOriginalExtension();
        $file->move(public_path($path), $imageName);
        return $path . $imageName;
    }

    public function MultipleUploadImage($file, $pathName)
    {
        foreach ($file as $fs) {
            $imageName = time() . '_' . rand(111, 999) . '.' . $fs->getClientOriginalExtension();
            $path = 'upload/' . $pathName . '/';
            $fs->move(public_path($path), $imageName);
            // dd($fs);
            return $path . $imageName;
        }
    }
}
