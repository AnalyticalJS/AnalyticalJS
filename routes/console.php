<?php

use Carbon\Carbon;
use App\Models\Page;
use App\Models\Referral;
use App\Models\Session_information;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('countDupes', function () {
    $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
    $session_info = Session_information::where('created_at', '>', $lastDay);
    foreach($session_info->get() as $info){
        Session_information::where("id", $info->id)->update([
            "countCountries" => Session_information::where('created_at', '>', $lastDay)->where("website_id",$info->website_id)->where("countryName", $info->countryName)->count(),
            "countCity" => Session_information::where('created_at', '>', $lastDay)->where("website_id",$info->website_id)->where("cityName", $info->cityName)->count(),
            "countBrowser" => Session_information::where('created_at', '>', $lastDay)->where("website_id",$info->website_id)->where("browser", $info->browser)->count(),
            "countOs" => Session_information::where('created_at', '>', $lastDay)->where("website_id",$info->website_id)->where("os_title", $info->os_title)->count(),
            "countDevice" => Session_information::where('created_at', '>', $lastDay)->where("website_id",$info->website_id)->where("device_type", $info->device_type)->count()
        ]);
        $this->comment("Updated - ".$info->id);
    }
    $pages = Page::where('created_at', '>', $lastDay);
    foreach($pages->get() as $page){
        Page::where("id", $page->id)->update([
            "count" => Page::where('created_at', '>', $lastDay)->where("website_id", $page->website_id)->where("url", $page->url)->count()
        ]);
        $this->comment("Updated - ".$page->id);
    }
    $referrals = Referral::where('created_at', '>', $lastDay);
    foreach($referrals->get() as $referral){
        Referral::where("id", $referral->id)->update([
            "count" => Referral::where('created_at', '>', $lastDay)->where("website_id", $referral->website_id)->where("url", $referral->url)->count()
        ]);
        $this->comment("Updated - ".$referral->id);
    }
    $this->comment("Done!");
})->purpose('Counts the duplicates and saves it.');