<?php
namespace App\Console;

use Carbon\Carbon;
use App\Models\Bot;
use App\Models\Page;
use App\Models\Referral;
use App\Models\Website;
use App\Models\Session_information;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Command
{
    public static function countHourly($command)
    {
        $websites = Website::get();
        foreach($websites as $website){
            $days = array();
            $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
            $theSessions = $website->sessions->where('created_at', '>', $lastDay);
            for ($i = 0; $i < 24; $i++) {
                $hour = Carbon::now()->subHours($i)->startOfHour()->toDateTimeString();
                $hourDisplay = Carbon::now()->subHours($i)->startOfHour()->toTimeString();
                $hourEnd = Carbon::now()->subHours($i)->endOfHour()->toDateTimeString();
                $sessions = $theSessions->where('created_at', '>=', $hour)->where('created_at', '<', $hourEnd)->count();
                $pages = $theSessions->where('created_at', '>=', $hour)->where('created_at', '<', $hourEnd)->sum("pages");
                $theBots = $website->bots()->where('created_at', '>=', $hour)->where('created_at', '<', $hourEnd)->count();
                array_push($days, [
                    "hour" => $hourDisplay,
                    "sessions" => $sessions,
                    "pages" => $pages,
                    "bots" => $theBots
                ]);
            }
            $pagesData = collect($website->pages->where('created_at', '>', $lastDay))->unique("url")->sortByDesc("count");
            $referralData = collect($website->referrals->where('created_at', '>', $lastDay))->unique("url")->sortByDesc("count");
            $website->update([
                "dailySessions" => $days,
                "dailyReferral" => $referralData->values(),
                "dailyPages" => $pagesData->values()
            ]);
            $command->comment($website->domain." Updated");
        }
        $command->comment("Updated");
    }

    public static function countDupes($command)
    {
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
            if($info->countryName == null){
                Session_information::where("id", $info->id)->update(["countryName" => "Not set"]);
            }
            if($info->cityName == null){
                Session_information::where("id", $info->id)->update(["cityName" => "Not set"]);
            }
            $command->comment("Updated - ".$info->id." Sessions");
        }
        $pages = Page::where('created_at', '>', $lastDay);
        foreach($pages->get() as $page){
            Page::where("id", $page->id)->update([
                "count" => Page::where('created_at', '>', $lastDay)->where("website_id", $page->website_id)->where("url", $page->url)->count()
            ]);
            if($page->url == null){
                Page::where("id", $page->id)->update(["url" => "Not set"]);
            }
            $command->comment("Updated - ".$page->id." Pages");
        }
        $referrals = Referral::where('created_at', '>', $lastDay);
        foreach($referrals->get() as $referral){
            Referral::where("id", $referral->id)->update([
                "count" => Referral::where('created_at', '>', $lastDay)->where("website_id", $referral->website_id)->where("url", $referral->url)->count()
            ]);
            if($referral->url == null){
                Referral::where("id", $referral->id)->update(["url" => "Not set"]);
            }
            if(str_contains($referral->url, "https://".Website::where("id", $referral->website_id)->first()->domain)){
                Referral::where("id", $referral->id)->delete();
            }
            $command->comment("Updated - ".$referral->id." Referrals");
        }

        $bots = Bot::where('created_at', '>', $lastDay);
        foreach($bots->get() as $bot){
            Bot::where("id", $bot->id)->update([
                "count" => Bot::where('created_at', '>', $lastDay)->where("website_id", $bot->website_id)->where("bot", $bot->bot)->count()
            ]);
            $command->comment("Updated - ".$bot->id." Bots");
        }
        $command->comment("Done!");
    }
}