<?php

namespace App\Service;

use App\Helpers\CoreBase;
use Illuminate\Support\Facades\Storage;

class MediaService
{

	/**
	 * @param $base64
	 * @param string $dir
	 * @return string|null
	 */
	public function uploadBase64($base64, string $dir = 'supplier'): string|null
    {
        if (CoreBase::isUrl($base64))
        {
            return str_replace(url('/') . '/', '', $base64);
        }
        $allowed = ['png', 'jpg', 'jpeg', 'pdf'];
        if (explode("/", $base64)[0] == "data:image") {
            $base64 = explode(";base64,", $base64)[1];
        }elseif (explode("/", $base64)[0] == "data:application") {
            // If the base64 data represents a PDF, extract the PDF data.
            $base64 = explode(";base64,", $base64)[1];
        }

        $data = base64_decode($base64);
        $f = finfo_open();
        $imageType = finfo_buffer($f, $data, FILEINFO_EXTENSION);
        if (explode("/", $imageType)[0] == "jpeg") {
            $imageType = "jpeg";
        }

        if (!in_array($imageType, $allowed)) {
            return null;
        }


        $filename =   uniqid() . '-' . time() . '.' . $imageType;
        $dirSmallPath = 'uploads/'.$dir.'/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';

        if (!is_dir(public_path($dirSmallPath))) {
            @mkdir(public_path($dirSmallPath), 0755, true);
        }


        $fullPath = $dirSmallPath . $filename;

        Storage::disk('uploads')->put($fullPath,$data);

        return $fullPath;
    }

    public function uploadAudio($base64): string|null
    {
        if (!$base64)
        {
            return null;
        }
        $extension = explode(";", explode('audio/', $base64)[1])[0];
        if (explode("/", $base64)[0] == "data:audio") {
            $base64 = explode(";base64,", $base64)[1];
        }

        $data = base64_decode($base64);

        $f = finfo_open();
        $audioType = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);

        // Adjust this array for allowed audio file types
//        $allowed = ['audio/mp3', 'audio/mpeg', 'audio/wav', 'audio/flac', 'audio/aac', 'audio/ogg', 'audio/x-ms-wma', 'audio/mpeg'];
//
//        if (!in_array($audioType, $allowed)) {
//            return null; // Not a valid audio type
//        }

        $filename = uniqid() . '-' . time() . '.' . $extension;
        $dirPath = 'uploads/audio/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';

        if (!is_dir(public_path($dirPath))) {
            @mkdir(public_path($dirPath), 0755, true);
        }

        $fullPath = $dirPath . $filename;

        Storage::disk('uploads')->put($fullPath, $data);

        return $fullPath;

    }

    public function uploadVideo($base64): string|null
    {
        if (!$base64)
        {
            return null;
        }
        if (CoreBase::isUrl($base64))
        {
            return str_replace(url('/') . '/', '', $base64);
        }

        $extension = explode(";", explode('video/', $base64)[1])[0];
        if (explode("/", $base64)[0] == "data:video") {
            $base64 = explode(";base64,", $base64)[1];
        }

        $data = base64_decode($base64);

        $f = finfo_open();
        $videoType = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);

        // Adjust this array for allowed video file types
//        $allowed = ['video/mp4', 'video/webm', 'video/ogg'];
//
//        if (!in_array($videoType, $allowed)) {
//            return null; // Not a valid video type
//        }

        $filename = uniqid() . '-' . time() . '.' . $extension;
        $dirPath = 'uploads/videos/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';

        if (!is_dir(public_path($dirPath))) {
            @mkdir(public_path($dirPath), 0755, true);
        }

        $fullPath = $dirPath . $filename;

        Storage::disk('uploads')->put($fullPath, $data);

        return $fullPath;
    }

}
