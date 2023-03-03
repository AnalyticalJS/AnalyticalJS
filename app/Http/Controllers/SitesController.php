<?php

namespace App\Http\Controllers;

use Request;
use Carbon\Carbon;
use App\Models\Website;
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
            $days = [];
            $pagesData = [];
            $referralData = [];

            $mins = Carbon::now()->subMinutes(30)->toDateTimeString();
            $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
            $theWebsite = $website->first();
            $theSessions = $theWebsite->sessions->where('created_at', '>', $lastDay);
            $session_info = $theWebsite->session_info->where('created_at', '>', $lastDay);
            $realtime = $theSessions->where('updated_at', '>', $mins);
           
            if($theWebsite->dailySessions != null){
                $days = $theWebsite->dailySessions;
            }
            if($theWebsite->dailyPages != null){
                $pagesData = $theWebsite->dailyPages;
            }
            if($theWebsite->dailyReferral != null){
                $referralData = $theWebsite->dailyReferral;
            }
            $sessionInfo = collect($session_info)->values();

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
