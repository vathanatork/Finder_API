<?php

namespace App\Helpers;

class CoreBase
{


    public static function formatPhoneNumber(String | null $phoneNumber): ?string
    {
        if (!$phoneNumber)
        {
            return $phoneNumber;
        }
        if (str_starts_with($phoneNumber, "855") && strlen($phoneNumber) > 9)
        {
            $phoneNumber = "0" . substr($phoneNumber, 3);
        }
        else if (str_starts_with($phoneNumber, "+855"))
        {
            $phoneNumber = "0" . substr($phoneNumber, 4);
        }
        else if (!str_starts_with($phoneNumber, 0))
        {
            $phoneNumber = "0" . $phoneNumber;
        }

        return $phoneNumber;
    }

    public static function convertUrl($value)
    {
        if (!$value)
        {
            return $value;
        }

        return url('/') . '/' . $value;
    }

    public static function getGender($gender): string
    {
        if (str_starts_with($gender, 'M') || str_starts_with($gender, 'm'))
        {
            return 'Male';
        }
        return 'Female';
    }

    public static function isUrl($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }


    public static function isBase64($value): bool
    {
        return str_contains($value, 'base64');
        // Use base64_decode and base64_encode to check if the value is a valid Base64-encoded string
    }

}
