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
            $mapData = array();
            $browserData = array();
            $operatingData = array();
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
                $days[$i] = [
                    "hour" => $hourDisplay,
                    "sessions" => $sessions,
                    "pages" => $pages
                ];
            }

            $locations = $website->first()->sessions->where('created_at', '>', $lastDay);
            foreach($locations as $index => $location){
                array_push($mapData, [
                    "feature" => $location->session_info->countryName,
                    "name" => $location->session_info->countryName,
                ]);
            }
            $sessionInfo = Session_information::where("website_id", $website->first()->id)->where('created_at', '>', $lastDay)->get();
            $collection = collect($sessionInfo)->unique("browser");
            foreach($collection as $index => $browser){
                array_push($browserData, [
                    "label" => $browser->browser,
                    "count" => $sessionInfo->where("browser", $browser->browser)->count()
                ]);
            }

            $collection2 = collect($sessionInfo)->unique("os_title");
            foreach($collection2 as $index => $os){
                array_push($operatingData, [
                    "label" => $os->os_title,
                    "count" => $sessionInfo->where("os_family", $os->os_family)->count()
                ]);
            }
            return view('sites.view')->with("website", $website->first())
                                     ->with("daily", array_reverse($days))
                                     ->with("realtimeUsers", $realtimeUsers)
                                     ->with("realtimePages", $realtimePages)
                                     ->with("mapData", $mapData)
                                     ->with("browserData", $browserData)
                                     ->with("operatingData", $operatingData);
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
