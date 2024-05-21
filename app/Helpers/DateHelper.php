<?php
namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
	public static function parseDateTimeMobile($datetime): ?string
	{
        return self::format($datetime, config('format.clock.mobile.date_time'));
    }

    public static function getNow(): Carbon
    {
        return Carbon::now();
    }

    public static function getSpecificDate($days): Carbon
    {
        return Carbon::now()->subDays($days);
    }


    public static function parseDateMobile($date, $format = null): ?string
    {
        return self::format($date, $format ?? config('format.clock.mobile.date'));
    }

    public static function parseTimeMobile($time): ?string
    {
        return self::format($time, config('format.clock.mobile.time'));
    }

	public static function parseDateTimeWebsite($datetime): ?string
	{
        return self::format($datetime, config('format.clock.website.date_time'));
    }

    public static function parseDateWebsite($date, $format = null): ?string
    {
        return self::format($date, $format ?? config('format.clock.website.date'));
    }

    public static function parseTimeWebsite($time): ?string
    {
        return self::format($time, config('format.clock.website.time'));
    }

    public static function format($datetime, $format): ?string
    {
        if(!$datetime) return null;
        return Carbon::parse($datetime)->format($format);
    }
}
