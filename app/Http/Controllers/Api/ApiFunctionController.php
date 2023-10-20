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
use Stevebauman\Location\Facades\Location;


class ApiFunctionController
{
    public function __construct()
    {

    }

    public function initDetails()
    {
        $referrerDomain = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
        $useragent = Request::server('HTTP_USER_AGENT');
        $website = Website::where("domain",$referrerDomain);
        $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
        if(!Crawler::isCrawler($useragent)) {
            $data = Request::all();
            $ip = Request::ip();
            $id = 0;
            $page = $data['page'];
            $referral = $data['referrer'];
            $Browser = new BrowserDetection;
            $browserInfo = $Browser->getAll($useragent);

            if((str_contains($ip, "192.168") || str_contains($ip, "127.0")) && env("APP_ENV") == "Production") {
                $failed = true;
                return [
                    "id" => "error",
                    "userIP" => "error", 
                    "referrer" => "error",
                    "referrerDomain" => "error",
                    "failed" => true
                    ];
            } else if($website->get()->count() > 0){
                $failed = false;
                if(Request::session()->has('session')){
                    $session = Session::where('updated_at', '>', Carbon::now()->subMinutes(10)->toDateTimeString())->where("id", Request::session()->get('session'))->where("website_id", $website->first()->id);
                    $session->first()->update(["pages" => $session->first()->pages+1]);
                    $id = $session->first()->id;
                    $thePage = Page::where("url", $page)->where("session_id", $id);
                    $theReferral = Referral::where("url", $referral)->where("session_id", $id);

                    if($thePage->count() < 1){
                        $newPage = Page::create([
                            "website_id" => $website->first()->id, 
                            "session_id" => $id, 
                            "pages" => 1, 
                            "url" => $page,
                            ]);
                    } else {
                        $newPage = $thePage->update(["pages" => $thePage->first()->pages+1]);
                    }
                    if($theReferral->count() < 1){
                        if(!str_contains($referral, env("APP_URL"))){
                            $newReferral = Referral::create([
                                "website_id" => $website->first()->id, 
                                "session_id" => $id, 
                                "pages" => 1, 
                                "url" => $referral,
                                ]);
                        }
                    } else {
                            $newReferral = $theReferral->update(["pages" => $theReferral->first()->pages+1]);
                    }
                    $cache = GlobalFunc::dailyData($website->first()->id, $website->first()->sessions);
                } else {
                    $newSession = Session::create(["website_id" => $website->first()->id, "pages" => 1]);
                    $id = $newSession->id;
                    Request::session()->put('session', $id);
                    $newPage = Page::create(["website_id" => $website->first()->id, "session_id" => $id, "pages" => 1, "url" => $page]);
                    if(!str_contains($referral, env("APP_URL"))){
                        $newReferral = Referral::create(["website_id" => $website->first()->id, "session_id" => $id, "pages" => 1, "url" => $referral]);
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
                    $sessionInfo["countBrowser"] = Session_information::where('created_at', '>', $lastDay)->where("website_id",$website->first()->id)->where("browser", $browserInfo['browser_name'])->count();
                    $sessionInfo["countOs"] = Session_information::where('created_at', '>', $lastDay)->where("website_id",$website->first()->id)->where("os_title", $browserInfo['os_title'])->count();
                    $sessionInfo["countDevice"] = Session_information::where('created_at', '>', $lastDay)->where("website_id",$website->first()->id)->where("device_type", $browserInfo['device_type'])->count();
                    if(isset($currentUserInfo->countryName)){
                        $sessionInfo['countryName'] = $currentUserInfo->countryName;
                        $sessionInfo['countryCode'] = $currentUserInfo->countryCode;
                        $sessionInfo['cityName'] = $currentUserInfo->cityName;
                        $sessionInfo['latitude'] = $currentUserInfo->latitude; 
                        $sessionInfo['longitude'] = $currentUserInfo->longitude; 
                        $sessionInfo['timezone'] = $currentUserInfo->timezone; 
                        $sessionInfo["countCountries"] = Session_information::where('created_at', '>', $lastDay)->where("website_id",$website->first()->id)->where("countryName", $currentUserInfo->countryName)->count();
                        $sessionInfo["countCity"] = Session_information::where('created_at', '>', $lastDay)->where("website_id",$website->first()->id)->where("cityName", $currentUserInfo->cityName)->count();
                    }
                    $newSessionInfo = Session_information::create($sessionInfo);
                }
                $cache = GlobalFunc::dailyData($website->first()->id, $website->first()->sessions);
            } else if($website->get()->count() < 1) {
                $failed = false;
                $newWebsite = Website::create(["domain" => $referrerDomain]);
                $newSession = Session::create(["website_id" => $newWebsite->id, "pages" => 1]);
                $id = $newSession->id;
            } else {
                $failed = true;
            }
            return [
                "id" => $id,
                "userIP" => $ip, 
                "referrer" => $referral,
                "referrerDomain" => $referrerDomain,
                "failed" => $failed
                ];
                
        } else {
            $bot = Crawler::getMatches();
            Bot::create([
                "website_id" => $website->first()->id,
                "bot" => $bot,
                "count" => Bot::where('created_at', '>', $lastDay)->where("website_id",$website->first()->id)->where("bot",$bot)->count()
            ]);
            return [
                "id" => "error",
                "userIP" => "error", 
                "referrer" => "error",
                "referrerDomain" => "error",
                "failed" => true
                ];
        }
    }

    public function realtime($id)
    {
        $mins = Carbon::now()->subMinutes(30)->toDateTimeString();
        $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
        $sessions = collect(GlobalFunc::getCache($id.'Sessions'))->where('updated_at', '>', $lastDay);
        $sessionInfo = GlobalFunc::getCache($id.'sessionInfo');
        $days = GlobalFunc::getCache($id.'dailySessions');
        $botData = GlobalFunc::getCache($id.'botData');
        /*$pagesData = GlobalFunc::getCache($id.'dailyPages');
        $referralTypeData = GlobalFunc::getCache($id.'dailyReferralTypes');*/
        $referralData = GlobalFunc::getCache($id.'dailyReferral');
        $minsAgo = collect($sessions)->where('updated_at', '>', $mins);
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
                GlobalFunc::count_format2($referralData->sum("count"))
            ];
        return [$realtime,$days];
    }
}
