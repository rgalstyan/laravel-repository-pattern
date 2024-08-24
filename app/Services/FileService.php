<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

final class FileService
{
    public static function upload(UploadedFile $file, array $data): array
    {
        $dir = public_path($data['path']);
        if( !File::isDirectory($dir) )
            File::makeDirectory($dir, 493, true);
        $uniqueFileName = uniqid().'.'.$file->getClientOriginalExtension();
        $image = Image::make($file);
        if(!empty($data['cropParams']))
        {
            list($x, $y, $width, $height) = array_values($data['cropParams']);
            $image->crop((int)$width, (int)$height, (int)$x, (int)$y);
        }
        if(!empty($data['fitParams']))
        {
            list($width, $height) = array_values($data['fitParams']);

            $image->fit((int)$width, (int)$height);
        }
        $image->save($dir.'/'.$uniqueFileName);
        return [
            'originalName' => $file->getClientOriginalName(),
            'uniqueName'   => $uniqueFileName
        ];
    }

    public static function getDocumentNames(UploadedFile $file): array
    {
        return [
            'name' => $file->getClientOriginalName(),
            'uniqueName'   => uniqid().'.'.$file->getClientOriginalExtension(),
            'type' => $file->getClientOriginalExtension()
        ];
    }

    public static function uploadDocument(UploadedFile $file, array $data)
    {

        $dir = public_path($data['path']);
        if( !File::isDirectory($dir) )
            File::makeDirectory($dir, 493, true);
        $move = $file->move($dir, $data['file']);

        if($data['old_file']){
            $old_file = $dir.'/'.$data['old_file'];
            return self::delete($old_file);
        }
        return $move;
    }

    public static function delete($filename): bool
    {
        if(File::exists($filename))
            File::delete($filename);
        return !File::exists($filename);
    }

    public static function uploadBase64($file, array $data): array
    {
        $dir = public_path($data['path']);
        if( !File::isDirectory($dir) )
            File::makeDirectory($dir, 493, true);
        $uniqueFileName = uniqid().'.jpeg';
        $image = Image::make(file_get_contents($file));
        $image->save($dir.'/'.$uniqueFileName);
        return [
            'uniqueName'   => $uniqueFileName
        ];
    }
}