<?php

namespace App\Http\Controllers;

use Request;
use Carbon\Carbon;
use App\Models\Website;
use App\Models\Session_information;
use Illuminate\Support\Collection;

class SitesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }


    public function site($domain = "analyticaljs.com")
    {
        $website = Website::where("domain",$domain);
        if($website->count() > 0){
            $days = array();
            $bots = array();

            $mins = Carbon::now()->subMinutes(30)->toDateTimeString();
            $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
            $realtimeUsers = $website->first()->sessions->where('updated_at', '>', $mins)->count();
            $realtimePages = $website->first()->sessions->where('updated_at', '>', $mins)->sum("pages");
            for ($i = 0; $i < 24; $i++) {
                $hour = Carbon::now()->subHours($i)->startOfHour()->toDateTimeString();
                $hourDisplay = Carbon::now()->subHours($i)->startOfHour()->toTimeString();
                $hourEnd = Carbon::now()->subHours($i)->endOfHour()->toDateTimeString();
                $sessions = $website->first()->sessions()->where('created_at', '>=', $hour)->where('created_at', '<', $hourEnd)->count();
                $pages = $website->first()->sessions()->where('created_at', '>=', $hour)->where('created_at', '<', $hourEnd)->sum("pages");
                $theBots = $website->first()->bots()->where('created_at', '>=', $hour)->where('created_at', '<', $hourEnd)->count();
                array_push($days, [
                    "hour" => $hourDisplay,
                    "sessions" => $sessions,
                    "pages" => $pages
                ]);
                array_push($bots, [
                    "hour" => $hourDisplay,
                    "bots" => $theBots
                ]);
            }

            $sessionInfo = collect($website->first()->session_info->where('created_at', '>', $lastDay))->values();
            $pagesData = collect($website->first()->pages->where('created_at', '>', $lastDay))->unique("url")->sortByDesc("count");
            $referralData = collect($website->first()->referrals->where('created_at', '>', $lastDay))->unique("url")->sortByDesc("count");
            
            return view('sites.view')->with("website", $website->first())
                                     ->with("daily", array_reverse($days))
                                     ->with("realtimeUsers", $realtimeUsers)
                                     ->with("realtimePages", $realtimePages)
                                     ->with("pagesData", $pagesData)
                                     ->with("referralData", $referralData)
                                     ->with("bots", array_reverse($bots))
                                     ->with("sessionInfo", $sessionInfo);
        } else {
            return view('sites.notfound')->with("domain", $domain);
        }
    }

    public function searchArray($arrays, $key, $search) {
        $count = 0;
     
        foreach($arrays as $object) {
            if(is_object($object)) {
               $object = get_object_vars($object);
            }
     
            if(array_key_exists($key, $object) && $object[$key] == $search) $count++;
        }
     
        return $count;
     }
}
