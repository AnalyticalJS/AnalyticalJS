<?php

namespace App\Http\Controllers;

use Request;
use GlobalFunc;
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
            $days = GlobalFunc::getCache($theWebsite->id.'dailySessions');
            $botData = GlobalFunc::getCache($theWebsite->id.'botData');
            $pagesData = GlobalFunc::getCache($theWebsite->id.'dailyPages');
            $referralData = GlobalFunc::getCache($theWebsite->id.'dailyReferral');
            $referralTypeData = GlobalFunc::getCache($theWebsite->id.'dailyReferralTypes');
            $sessionInfo = GlobalFunc::getCache($theWebsite->id.'sessionInfo');
            $realtime = GlobalFunc::getCache($theWebsite->id.'Sessions');

            //GlobalFunc::pruneCache($theWebsite->id.'Sessions');
            //dd(GlobalFunc::getCache($theWebsite->id.'Sessions'));
            
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
            if($realtime == null){
                $realtime = collect([]);
            }
            if($referralData != null){
                $referralData = collect($referralData);
            }
            
            return view('sites.view')->with("website", $theWebsite)
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
