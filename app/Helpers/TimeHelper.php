<?php
namespace App\Helpers;

use Carbon\Carbon;

class TimeHelper
{
    public static function formatTimeTo12Hour($time): string
    {
        // Create a Carbon instance from the provided time string
        $dateTime = Carbon::createFromFormat('H:i', $time);

        // Format the Carbon instance to the desired format
        return $dateTime->format('h:i A');
    }

}
