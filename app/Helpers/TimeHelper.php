<?php
namespace App\Helpers;

use Carbon\Carbon;

class TimeHelper
{
    public static function formatTimeTo12Hour($time): string
    {
        return $time->format('h:i A');
    }

    public static function formatTimeToHI($time): string
    {
        // Format the Carbon instance to the desired format
        return $time->format('h:i');
    }

}
