<?php

namespace App\Http\Controllers\Api;

use Request;
use Carbon\Carbon;
use App\Models\Page;
use App\Models\Website;
use App\Models\Session;
use App\Models\Referral;
use App\Models\Session_information;
use Stevebauman\Location\Facades\Location;


class ApiFunctionController
{
    public function __construct()
    {

    }

    public function initDetails()
    {
        $ip = Request::ip();
        $id = 0;
        $referrer = $_SERVER['HTTP_REFERER'];
        $referrerDomain = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
        $website = Website::where("domain",$referrerDomain);
        $page = Request::header('referer');
        $referral = Request::server('HTTP_REFERER');

        if(str_contains($ip, "192.168") && env("APP_ENV") == "Production") {
            $failed = true;
        } else if($website->get()->count() > 0){
            $failed = false;
            $session = Session::where('updated_at', '>', Carbon::now()->subMinutes(10)->toDateTimeString())->where("ip", $ip)->where("website_id", $website->first()->id);
            if($session->get()->count() > 0){
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
                    $newReferral = Referral::create([
                        "website_id" => $website->first()->id, 
                        "session_id" => $id, 
                        "pages" => 1, 
                        "url" => $referral,
                        ]);
                } else {
                    $newReferral = $theReferral->update(["pages" => $theReferral->first()->pages+1]);
                }
            } else {
                $newSession = Session::create(["website_id" => $website->first()->id, "ip" => $ip, "pages" => 1]);
                $id = $newSession->id;
                $newPage = Page::create(["website_id" => $website->first()->id, "session_id" => $id, "pages" => 1, "url" => $page]);
                if(str_contains($referral, env("APP_URL"))){
                    $newReferral = Referral::create(["website_id" => $website->first()->id, "session_id" => $id, "pages" => 1, "url" => $referral]);
                }
                $currentUserInfo = Location::get($ip);
                $sessionInfo = array();
                $sessionInfo['website_id'] = $website->first()->id;
                $sessionInfo['session_id'] = $id;
                $sessionInfo['browser'] = Request::header('User-Agent');
                if(isset($currentUserInfo->countryName)){
                    $sessionInfo['countryName'] = $currentUserInfo->countryName;
                    $sessionInfo['countryCode'] = $currentUserInfo->countryCode;
                    $sessionInfo['cityName'] = $currentUserInfo->countryCode;
                    $sessionInfo['latitude'] = $currentUserInfo->cityName; 
                    $sessionInfo['longitude'] = $currentUserInfo->longitude; 
                    $sessionInfo['timezone'] = $currentUserInfo->timezone; 
                }
                $newSessionInfo = Session_information::create($sessionInfo);
            }
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
            "referrer" => $referrer,
            "referrerDomain" => $referrerDomain,
            "failed" => $failed
            ];
    }
}
