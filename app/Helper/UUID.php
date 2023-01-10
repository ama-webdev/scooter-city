<?php

namespace App\Helper;

use App\Models\Booking;
use Illuminate\Support\Str;

class UUID
{
    static function generate()
    {
        $uuid = substr((string) Str::uuid(), 0, 8);
        return $uuid;
    }

    static function OrderCode()
    {
        $prefix = 'SC-';
        $flag = true;
        $start = 'SC-000001';
        $result = '';
        while ($flag) {
            $exist_code = Booking::where('code', $start)->first();
            if (!$exist_code) {
                $result = $start;
                $flag = false;
            }
            $code_without_prefix = substr($start, 3);
            $code_without_zero = ltrim($code_without_prefix, "0");
            $code_increase_one = str_pad($code_without_zero + 1, 6, "0", STR_PAD_LEFT);
            $start = $prefix . $code_increase_one;
        }
        return $result;
    }
}