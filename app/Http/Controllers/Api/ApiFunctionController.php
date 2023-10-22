<?php

namespace App\Http\Controllers\Api;

use Request;
use Crawler;
use GlobalFunc;
use Carbon\Carbon;
use App\Models\Page;
use App\Models\Bot;
use App\Models\Website;
use App\Models\Session;
use App\Models\Referral;
use App\Models\Session_information;
use foroco\BrowserDetection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Hash;


class ApiFunctionController
{
    public function __construct()
    {

    }

    public function initDetails()
    {
        if($_SERVER['HTTP_REFERER']){
            $referrerDomain = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
        } else {
            $referrerDomain = "";
        }
        $useragent = Request::server('HTTP_USER_AGENT');
        $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
        if(!GlobalFunc::hasCache("Websites")){ GlobalFunc::initCache(); }
        $website = collect(GlobalFunc::getCache("Websites"))->where("domain",$referrerDomain)->first();
        if(!Crawler::isCrawler($useragent)) {
            $data = Request::all();
            $ip = Request::ip();
            $id = 0;
            $failed = false;
            $page = $data['page'];
            $referral = $data['referrer'];
            $Browser = new BrowserDetection;
            $browserInfo = $Browser->getAll($useragent);
            if((str_contains($ip, "192.168") || str_contains($ip, "127.0")) && env("APP_ENV") == "Production") {
                $failed = true;
            } else if(!$website) {
                $newWebsite = Website::create(["domain" => $referrerDomain]);
                $theSession = Session::create(["website_id" => $newWebsite->id, "pages" => 1]);
                GlobalFunc::addRowCache("Websites",$newWebsite);
                GlobalFunc::addRowCache($newWebsite->id."Sessions",$theSession);
                $id = $newSession->id;    
                $newSession = true;            
            } else if($website->count() > 0){
                $sessions = GlobalFunc::getCache($website->id."Sessions");
                $session = collect($sessions)->where('updated_at', '>', Carbon::now()->subMinutes(10)->toDateTimeString());
                foreach($session as $s){
                    if(Hash::check($ip, $s->uuid) == 1){
                        $match = $s;
                    }
                }
                if(isset($match)){
                    $session = $match;
                    $uSession = $session;
                    $uSession["pages"] =  $uSession["pages"]+1;
                    $theSession = Session::where("id",$session["id"])->update(["pages" => $session["pages"]+1]);
                    GlobalFunc::updateRowCache($website->id."Sessions",$uSession,$session["id"]);
                } else {
                    $ip = Hash::make($ip);
                    $theSession = Session::create(["website_id" => $website->id, "uuid" => $ip, "pages" => 1]);
                    GlobalFunc::addRowCache($website->id."Sessions",$theSession);
                    $newSession = true;
                }
            } else {
                $failed = true;
            } 

            if($failed == false){
                    $thePage = collect(GlobalFunc::getCache($website->id.'dailyPages'))->where("url", $page)->where("session_id", $id);
                    $theReferral = collect(GlobalFunc::getCache($website->id.'dailyReferral'))->where("url", $page)->where("session_id", $id);

                    if($thePage->count() < 1){
                        $newPage = Page::create([
                            "website_id" => $website->id, 
                            "session_id" => $id, 
                            "pages" => 1, 
                            "url" => $page,
                            ]);
                        GlobalFunc::addRowCache($website->id."dailyPages",$newPage);
                    } else {
                        $uPage = $thePage->first();
                        $uPage["pages"] =  $uPage["pages"]+1;
                        $newPage = Page::where("id", $uPage["id"])->update(["pages" => $thePage->first()->pages+1]);
                        GlobalFunc::updateRowCache($website->id."dailyPages",$uPage,$uPage["id"]);
                    }
                    if($theReferral->count() < 1){
                        if(!str_contains($referral, env("APP_URL"))){
                            $newReferral = Referral::create([
                                "website_id" => $website->first()->id, 
                                "session_id" => $id, 
                                "pages" => 1, 
                                "url" => $referral,
                                ]);
                            GlobalFunc::addRowCache($website->id."dailyReferral",$newReferral);
                        }
                    } else {
                        $uReferral = $theReferral->first();
                        $uReferral["pages"] =  $uReferral["pages"]+1;
                        $newReferral =  Referral::where("session_id", $uReferral["id"])->update(["pages" => $thePage->first()->pages+1]);
                        GlobalFunc::updateRowCache($website->id."dailyReferral",$uReferral,$uReferral["id"]);
                    }

                    $currentUserInfo = Location::get($ip);
                    $sessionInfo = array();
                    $sessionInfo['website_id'] = $website->first()->id;
                    $sessionInfo['session_id'] = $id;
                    $sessionInfo['browser'] = $browserInfo['browser_name'];
                    $sessionInfo['browser_version'] = $browserInfo['browser_version'];
                    $sessionInfo['os_family'] = $browserInfo['os_family'];
                    $sessionInfo['os_type'] = $browserInfo['os_type'];
                    $sessionInfo['os_name'] = $browserInfo['os_name'];
                    $sessionInfo['os_version'] = $browserInfo['os_version'];
                    $sessionInfo['os_title'] = $browserInfo['os_title'];
                    $sessionInfo['device_type'] = $browserInfo['device_type'];
                    if(isset($currentUserInfo->countryName)){
                        $sessionInfo['countryName'] = $currentUserInfo->countryName;
                        $sessionInfo['countryCode'] = $currentUserInfo->countryCode;
                        $sessionInfo['cityName'] = $currentUserInfo->cityName;
                        $sessionInfo['latitude'] = $currentUserInfo->latitude; 
                        $sessionInfo['longitude'] = $currentUserInfo->longitude; 
                        $sessionInfo['timezone'] = $currentUserInfo->timezone; 
                    }
                    $newSessionInfo = Session_information::create($sessionInfo);
                    GlobalFunc::addRowCache($website->id."session_info",$sessionInfo);
            }
            
        } else {
            $bot = Crawler::getMatches();
            $theBot = Bot::create([
                "website_id" => $website->first()->id,
                "bot" => $bot
            ]);
            GlobalFunc::addRowCache($website->id."Bots",$theBot);
            $failed = true;
        }
        
        if($failed == true){
            return [
                "id" => "error",
                "userIP" => "error", 
                "referrer" => "error",
                "referrerDomain" => "error",
                "failed" => true
            ];
        } else {
            if($sessions != null){
                $theSessions = collect($sessions)->where('updated_at', '>', $lastDay);
                $dailySessions = GlobalFunc::dailyData($website->id, $theSessions);
            }
            return [
                "id" => $id,
                "userIP" => $ip, 
                "referrer" => $referral,
                "referrerDomain" => $referrerDomain,
                "failed" => $failed
                ];               
        }
    }

    public function realtime($id)
    {
        $mins = Carbon::now()->subMinutes(10)->toDateTimeString();
        $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
        $sessions = collect(GlobalFunc::getCache($id.'Sessions'))->where('updated_at', '>', $lastDay);
        $sessionInfo = collect(GlobalFunc::getCache($id.'session_info'));
        $days = GlobalFunc::getCache($id.'dailySessions');
        $botData = GlobalFunc::getCache($id.'botData');
        $referralData = GlobalFunc::getCache($id.'dailyReferral');
        $minsAgo = collect($sessions)->where('updated_at', '>', $mins);
        if($sessionInfo){
            $realtime = [
                    GlobalFunc::count_format2($minsAgo->count()),
                    GlobalFunc::count_format2($minsAgo->sum("pages")),
                    GlobalFunc::count_format2($sessions->count()),
                    GlobalFunc::count_format2($sessions->sum("pages")),
                    GlobalFunc::count_format2($sessionInfo->unique("countryName")->count()),
                    GlobalFunc::count_format2($sessionInfo->unique("cityName")->count()),
                    GlobalFunc::count_format2($sessionInfo->unique("browser")->count()),
                    GlobalFunc::count_format2($sessionInfo->unique("device_type")->count()),
                    GlobalFunc::count_format2($sessionInfo->unique("os_title")->count()),
                    GlobalFunc::count_format2(collect($referralData)->sum("count"))
                ];
        } else {
            $realtime = [
                GlobalFunc::count_format2($minsAgo->count()),
                GlobalFunc::count_format2($minsAgo->sum("pages")),
                GlobalFunc::count_format2($sessions->count()),
                GlobalFunc::count_format2($sessions->sum("pages"))
            ];
        }
        return [$realtime,$days];
    }
}