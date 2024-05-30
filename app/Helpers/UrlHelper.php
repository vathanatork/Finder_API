<?php

namespace App\Helpers;

class UrlHelper
{
    public static function resolveUrl($path, $customBaseUrl = null)
    {
        // Check if the path is already a full URL
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // If a MinIO URL is provided, use it
        if ($customBaseUrl) {
            return rtrim($customBaseUrl, '/') . '/' . ltrim($path, '/');
        }

        // Otherwise, use the application's base URL
        return url($path);
    }
}
