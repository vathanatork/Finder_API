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
    public function uploadBase64($base64, string $dir = 'supplier'): ?string
    {
        // Check if the input is a URL and return the path if it is.
        if (CoreBase::isUrl($base64)) {
            return str_replace(url('/') . '/', '', $base64);
        }

        // Define allowed file types.
        $allowed = ['png', 'jpg', 'jpeg', 'pdf'];

        // Extract the base64 encoded string from the input.
        if (str_starts_with($base64, 'data:image') || str_starts_with($base64, 'data:application')) {
            $base64 = explode(";base64,", $base64)[1];
        }

        // Decode the base64 string.
        $data = base64_decode($base64);
        if ($data === false) {
            return null; // Invalid base64 data
        }

        $mimeType = null;
        $imageInfo = getimagesizefromstring($data);
        if ($imageInfo) {
            $mimeType = $imageInfo['mime'];
        }

        // Map MIME types to file extensions.
        $mimeToExtension = [
            'image/png' => 'png',
            'image/jpeg' => 'jpeg',
            'image/jpg' => 'jpg',
            'application/pdf' => 'pdf'
        ];

        // Get the file extension from the MIME type.
        $imageType = $mimeToExtension[$mimeType] ?? null;
        if (!$imageType || !in_array($imageType, $allowed)) {
            return null; // Unsupported file type
        }

        // Generate a unique filename.
        $filename = uniqid() . '-' . time() . '.' . $imageType;

        $dirSmallPath = 'uploads/';

//        // Define the directory path.
//        $dirSmallPath = 'uploads/' . $dir . '/' . date('Y') . '/' . date('m') . '/' . date('d') . '/';

        // Create the directory if it doesn't exist.
        if (!is_dir(public_path($dirSmallPath))) {
            if (!mkdir(public_path($dirSmallPath), 0755, true) && !is_dir(public_path($dirSmallPath))) {
                return null; // Failed to create directory
            }
        }

        // Define the full path for the file.
        $fullPath = $dirSmallPath . $filename;

        // Store the file using the 'uploads' disk configuration.
        Storage::disk(env('FILESYSTEM_DISK', 'local'))->put($fullPath, $data);

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
