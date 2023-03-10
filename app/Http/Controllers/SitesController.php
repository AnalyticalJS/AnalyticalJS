<?php

namespace App\Http\Controllers;

use Request;
use Carbon\Carbon;
use App\Models\Website;
use App\Models\Session;
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
        $website = Website::where("domain",$domain)->select('domain','id');
        if($website->count() > 0){
            $theWebsite = $website->first();
            $days = Cache::get($theWebsite->id.'dailySessions');
            $botData = Cache::get($theWebsite->id.'botData');
            $pagesData = Cache::get($theWebsite->id.'dailyPages');
            $referralData = Cache::get($theWebsite->id.'dailyReferral');
            $referralTypeData = Cache::get($theWebsite->id.'dailyReferralTypes');
            $sessionInfo = Cache::get($theWebsite->id.'sessionInfo');
            
            $mins = Carbon::now()->subMinutes(30)->toDateTimeString();
            $realtime = Session::where('website_id', $theWebsite->id)->where('updated_at', '>', $mins);
            
            if($sessionInfo == null){
                $sessionInfo = collect([]);
            }
            if($days == null){
                $days = [];
            }
            if($botData == null){
                $botData = [];
            }
            if($pagesData == null){
                $pagesData = [];
            }
            if($referralData != null){
                $referralData = collect($referralData);
            }
            
            return view('sites.view')->with("website", $website->first())
                                     ->with("daily", array_reverse($days))
                                     ->with("realtime", $realtime)
                                     ->with("botData", $botData)
                                     ->with("pagesData", $pagesData)
                                     ->with("referralData", $referralData)
                                     ->with("referralTypeData", $referralTypeData)
                                     ->with("sessionInfo", $sessionInfo);
        } else {
            return view('sites.notfound')->with("domain", $domain);
        }
    }
}
