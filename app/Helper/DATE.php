<?php

namespace App\Helper;

use Illuminate\Support\Str;

class DATE
{
    static function duration($start_date, $end_date)
    {
        $now = time();
        $start_date_time = strtotime($start_date);
        $end_date_time = strtotime($end_date);
        $datediff =  $end_date_time - $start_date_time;
        $dateCount = round($datediff / (60 * 60 * 24));
        return $dateCount;
    }
}