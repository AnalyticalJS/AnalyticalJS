<?php

namespace App\Http\Controllers\Api;

use Request;
use Carbon\Carbon;
use App\Models\Website;
use App\Models\Session;


class ApiFunctionController
{
    public function __construct()
    {

    }

    public function initDetails()
    {
        $ip = Request::ip();
        $referrer = $_SERVER['HTTP_REFERER'];
        $referrerDomain = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
        $website = Website::where("domain",$referrerDomain);
        $id = 0;

        if(str_contains($ip, "192.168") && env("APP_ENV") == "Production") {
            $failed = true;
        } else if($website->get()->count() > 0){
            $failed = false;
            $session = Session::where('updated_at', '>', Carbon::now()->subMinutes(10)->toDateTimeString())->where("ip", $ip)->where("website_id", $website->first()->id);
            if($session->get()->count() > 0){
                $session->first()->update(["pages" => $session->first()->pages+1]);
                $id = $session->first()->id;
            } else {
                $newSession = Session::create(["website_id" => $website->first()->id, "pages" => 1, "ip" => $ip]);
                $id = $newSession->id;
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

    public function unmount($id)
    {
        Session::where("id", $id)->update(["session_ended" => Carbon::now()]);
    }
}
