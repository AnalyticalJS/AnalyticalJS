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
            $theWebsite = $website->first();
            $session_info = $theWebsite->session_info->where('created_at', '>', $lastDay);
            $theSessions = $theWebsite->sessions->where('created_at', '>', $lastDay);
            $realtime = $theSessions->where('updated_at', '>', $mins);
            for ($i = 0; $i < 24; $i++) {
                $hour = Carbon::now()->subHours($i)->startOfHour()->toDateTimeString();
                $hourDisplay = Carbon::now()->subHours($i)->startOfHour()->toTimeString();
                $hourEnd = Carbon::now()->subHours($i)->endOfHour()->toDateTimeString();
                $sessions = $theSessions->where('created_at', '>=', $hour)->where('created_at', '<', $hourEnd)->count();
                $pages = $theSessions->where('created_at', '>=', $hour)->where('created_at', '<', $hourEnd)->sum("pages");
                $theBots = $theWebsite->bots()->where('created_at', '>=', $hour)->where('created_at', '<', $hourEnd)->count();
                array_push($days, [
                    "hour" => $hourDisplay,
                    "sessions" => $sessions,
                    "pages" => $pages,
                    "bots" => $theBots
                ]);
            }

            $sessionInfo = collect($session_info)->values();
            $pagesData = collect($website->first()->pages->where('created_at', '>', $lastDay))->unique("url")->sortByDesc("count");
            $referralData = collect($website->first()->referrals->where('created_at', '>', $lastDay))->unique("url")->sortByDesc("count");

            return view('sites.view')->with("website", $website->first())
                                     ->with("daily", array_reverse($days))
                                     ->with("realtime", $realtime)
                                     ->with("pagesData", $pagesData)
                                     ->with("referralData", $referralData)
                                     ->with("sessionInfo", $sessionInfo);
        } else {
            return view('sites.notfound')->with("domain", $domain);
        }
    }
}
