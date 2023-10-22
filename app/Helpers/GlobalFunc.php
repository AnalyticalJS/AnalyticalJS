<?php
namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Website;
use App\Models\Session_information;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
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

    public static function initCache()
    {
        $websites = Website::get();
        $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
        GlobalFunc::saveCache('Websites', $websites);
        foreach ($websites as $website){
            $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
            $theSessions = collect($website->sessions)->where('website_id', $website->id)->where('updated_at', '>', $lastDay)->values();
            $theSessionsInfo = Session_information::where('website_id', $website->id)->where('updated_at', '>', $lastDay)->get()->values();
            $thePages = collect($website->pages)->where('website_id', $website->id)->where('updated_at', '>', $lastDay)->values();
            $theReferrals = collect($website->referrals)->where('website_id', $website->id)->where('updated_at', '>', $lastDay)->values();
            $theBots = collect($website->bots)->where('website_id', $website->id)->where('updated_at', '>', $lastDay)->values();
            GlobalFunc::saveCache($website->id.'Sessions', $theSessions);
            GlobalFunc::saveCache($website->id.'dailyPages', $thePages);
            GlobalFunc::saveCache($website->id.'dailyReferral', $theReferrals);
            GlobalFunc::saveCache($website->id.'Bots', $theBots);
            GlobalFunc::saveCache($website->id.'session_info', $theSessionsInfo);
        }
    }

    public static function saveCache($key, $value)
    {
        if (Cache::has($key)) {
            return Cache::put($key, $value);
        } else {
            return Cache::forever($key, $value);
        }
    }

    public static function hasCache($key)
    {
        if (Cache::has($key)) {
            return true;
        } else {
            return false;
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
        if(!is_array($results)){
            $result = [$value];
        } else {
            $result = array_merge($results, [$value]);
        }
        GlobalFunc::saveCache($key, $result);
    }

    public static function updateRowCache($key, $value, $id){
        $items = GlobalFunc::getCache($key);
        $i = array_search($id, array_column(json_decode(json_encode($items),TRUE), 'id'));
        $items[$i] = $value;
        GlobalFunc::saveCache($key, $items);
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
            $theBots = collect(GlobalFunc::getCache($id.'Bots'))->where('created_at', '>=', $hour)->where('created_at', '<', $hourEnd)->count();
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