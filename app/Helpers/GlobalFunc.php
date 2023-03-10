<?php
namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
            if (str_contains($value, trim($a))){
                return "Success !! ^^^ SEARCH FOUND ^^^ ".$a;
            }
        }
        return false;
    }

    public static function saveCache($key, $value)
    {
        if (Cache::has($key)) {
            return Cache::put($key, $value);
        } else {
            return Cache::forever($key, $value);
        }
    }

    public static function getCache($key)
    {
        return Cache::get($key);
    }

    public static function pruneCache($key, $period = 24)
    {
        $lastDay = Carbon::now()->subHours($period)->startOfHour()->toDateTimeString();
        $results = Cache::get($key);
    }
    
    public static function addRowCache($key, $value)
    {
        if (Cache::has($key)) {
            $results = Cache::get($key);
        } else {
            $results = [];
        }
        $result = array_merge($results, [$value]);
        GlobalFunc::saveCache($key, $result);
    }

    public static function dailyData($id, $sessions)
    {
        $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
        $theSessions = collect($sessions)->where('updated_at', '>', $lastDay);
        if($theSessions->count() > 0){
            GlobalFunc::saveCache($id.'Sessions', $theSessions);
        }
        $days = array();
        for ($i = 0; $i < 24; $i++) {
            $hour = Carbon::now()->subHours($i)->startOfHour()->toDateTimeString();
            $hourDisplay = Carbon::now()->subHours($i)->startOfHour()->toTimeString();
            $hourEnd = Carbon::now()->subHours($i)->endOfHour()->toDateTimeString();
            $sessions = $theSessions->where('created_at', '>=', $hour)->where('created_at', '<', $hourEnd)->count();
            $pages = $theSessions->where('created_at', '>=', $hour)->where('created_at', '<', $hourEnd)->sum("pages");
            $theBots = collect(GlobalFunc::getCache($id.'botData'))->where('created_at', '>=', $hour)->where('created_at', '<', $hourEnd)->count();
            array_push($days, [
                "hour" => $hourDisplay,
                "sessions" => $sessions,
                "pages" => $pages,
                "bots" => $theBots
            ]);
        }
        $dailySessions = GlobalFunc::saveCache($id.'dailySessions', $days);
    }

}