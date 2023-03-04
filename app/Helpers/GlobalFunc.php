<?php
namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class GlobalFunc
{
    public static function count_format($n, $point='.', $sep=',') {
        if ($n < 0) {
            return 0;
        }
    
        if ($n < 10000) {
            return number_format($n, 0, $point, $sep);
        }
    
        $d = $n < 1000000 ? 1000 : 1000000;
    
        $f = round($n / $d, 1);
    
        return number_format($f, $f - intval($f) ? 1 : 0, $point, $sep) . ($d == 1000 ? 'k' : 'M');
    }

    public static function count_format2($n, $point='.', $sep=',') {
        if ($n < 0) {
            return 0;
        }
    
            return number_format($n, 0, $point, $sep);
        
    }

    public static function count_format3($n, $decimal=4, $point='.', $sep=',') {

            return number_format($n, $decimal, $point, $sep);
    }

    public static function contains($value, array $array)
    {
        foreach($array as $a) {
            if (stripos($value,$a) !== false) return true;
        }
        return false;
    }

}