<?php

namespace App\Http\Controllers;

use Request;
use Carbon\Carbon;
use App\Models\Website;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

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
            $theWebsite = $website->first();
            $days = Cache::get($theWebsite->id.'dailySessions');
            $pagesData = Cache::get($theWebsite->id.'dailyPages');
            $referralData = Cache::get($theWebsite->id.'dailyReferral');
            $referralTypeData = Cache::get($theWebsite->id.'dailyReferralTypes');
            $sessionInfo = Cache::get($theWebsite->id.'sessionInfo');

            $mins = Carbon::now()->subMinutes(30)->toDateTimeString();
            $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
            $realtime = $theWebsite->sessions->where('updated_at', '>', $mins);
           
            if($theWebsite->dailySessions != null){
                //$days = $theWebsite->dailySessions;
            }
            if($theWebsite->dailyPages != null){
                $pagesData = $pagesData;
            }
            if($theWebsite->dailyReferral != null){
                $referralData = collect($referralData);
            }
            if($theWebsite->dailyReferralTypes != null){
                //$referralTypeData = $theWebsite->dailyReferralTypes;
            }
            //$sessionInfo = collect($session_info)->values();

            return view('sites.view')->with("website", $website->first())
                                     ->with("daily", array_reverse($days))
                                     ->with("realtime", $realtime)
                                     ->with("pagesData", $pagesData)
                                     ->with("referralData", $referralData)
                                     ->with("referralTypeData", $referralTypeData)
                                     ->with("sessionInfo", $sessionInfo);
        } else {
            return view('sites.notfound')->with("domain", $domain);
        }
    }
}
