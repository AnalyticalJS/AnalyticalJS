<?php

namespace App\Http\Controllers;

use Request;
use Carbon\Carbon;
use App\Models\Website;

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
        $website = Website::where("domain",$domain)->with("days");
        if($website->count() > 0){
            $days = array();
            $mins = Carbon::now()->subMinutes(30)->toDateTimeString();
            $realtimeUsers = $website->first()->days()->where('updated_at', '>', $mins)->count();
            $realtimePages = $website->first()->days()->where('updated_at', '>', $mins)->sum("pages");
            for ($i = 0; $i < 24; $i++) {
                $hour = Carbon::now()->subHours($i)->startOfHour()->toDateTimeString();
                $hourDisplay = Carbon::now()->subHours($i)->startOfHour()->toTimeString();
                $hourEnd = Carbon::now()->subHours($i)->endOfHour()->toDateTimeString();
                $sessions = $website->first()->days()->where('created_at', '>=', $hour)->where('created_at', '<', $hourEnd)->count();
                $pages = $website->first()->days()->where('created_at', '>=', $hour)->where('created_at', '<', $hourEnd)->sum("pages");
                $days[$i] = [
                    "hour" => $hourDisplay,
                    "sessions" => $sessions,
                    "pages" => $pages
                ];
            }
            return view('sites.view')->with("website", $website->first())->with("daily", array_reverse($days))->with("realtimeUsers", $realtimeUsers)->with("realtimePages", $realtimePages);
        } else {
            return view('sites.notfound')->with("domain", $domain);
        }
    }
}
