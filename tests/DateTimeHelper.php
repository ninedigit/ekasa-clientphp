<?php

namespace NineDigit\eKasa\Client\Tests;

use DateTime;
use DateTimeZone;
use Exception;

final class DateTimeHelper
{
    /**
     * @throws Exception
     */
    public static function createUtc(
        int $year,
        int $month,
        int $day,
        int $hour,
        int $minute,
        int $second = 0,
        int $microsecond = 0
    ): DateTime {
        $date = new DateTime("now", new DateTimeZone("UTC"));
        $date = $date->setDate($year, $month, $day);
        return $date->setTime($hour, $minute, $second, $microsecond);
    }

    /**
     * @throws Exception
     */
    public static function createEuropeBratislava(
        int $year,
        int $month,
        int $day,
        int $hour,
        int $minute,
        int $second = 0,
        int $microsecond = 0
    ): DateTime {
        $date = new DateTime("now", new DateTimeZone("Europe/Bratislava"));
        $date = $date->setDate($year, $month, $day);
        return $date->setTime($hour, $minute, $second, $microsecond);
    }
}
