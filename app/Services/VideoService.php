<?php


namespace App\Services;


use Illuminate\Support\Facades\Storage;

class VideoService
{
    public static function uploadVideo($file){
        $filename = time() . "." . $file->getClientOriginalExtension();
        $uploadPath = config('app.videosRoute') . $filename;
        Storage::disk('ftp')->put($uploadPath, fopen($file, 'r+'));
        return $filename;
    }

    public static function changedFile($file, $old_path){
        $upload_path = config('app.videosRoute');
        Storage::disk('ftp')->delete($upload_path . $old_path);
        return self::uploadVideo($file);
    }

}
