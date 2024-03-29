<?php
namespace App\Console;

use GlobalFunc;
use Carbon\Carbon;
use App\Models\Bot;
use App\Models\Page;
use App\Models\Referral;
use App\Models\Website;
use App\Models\Session;
use App\Models\Session_information;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Command
{
    public static function reloadCache($command)
    {
        $command->comment("Working...");
        if(GlobalFunc::hasCache("Websites")){ GlobalFunc::initCache(); }
        $command->comment("Done!");
    }


    public static function countHourly($command)
    {
        if(!GlobalFunc::hasCache("Websites")){ GlobalFunc::initCache(); }
        $websites = collect(GlobalFunc::getCache("Websites"));
        foreach($websites as $website){
            $sessions = GlobalFunc::getCache($website->id."Sessions");
            $days = array();
            $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
            if($sessions != null){
                $theSessions = collect($sessions)->where('updated_at', '>', $lastDay);
                $dailySessions = GlobalFunc::dailyData($website->id, $theSessions);
            }
            $command->comment($website->domain." Updated");
        }
        $command->comment("Done!");
    }


    public static function countDupes($command)
    {
        $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
        $websites = collect(GlobalFunc::getCache("Websites"));
        foreach($websites as $website){
            $sessions = collect(GlobalFunc::getCache($website->id."Sessions"))->where('updated_at', '>', $lastDay);
            $session_info = collect(GlobalFunc::getCache($website->id."session_info"))->where('created_at', '>', $lastDay);
            foreach($sessions as $session){
                if($session->info != null){
                    Session_information::where("id", $session->info->id)->update([
                        "countCountries" => Session_information::where('created_at', '>', $lastDay)->where("website_id",$session->website_id)->where("countryName", $session->info->countryName)->count(),
                        "countCity" => Session_information::where('created_at', '>', $lastDay)->where("website_id",$session->website_id)->where("cityName", $session->info->cityName)->count(),
                        "countBrowser" => Session_information::where('created_at', '>', $lastDay)->where("website_id",$session->website_id)->where("browser", $session->info->browser)->count(),
                        "countOs" => Session_information::where('created_at', '>', $lastDay)->where("website_id",$session->website_id)->where("os_title", $session->info->os_title)->count(),
                        "countDevice" => Session_information::where('created_at', '>', $lastDay)->where("website_id",$session->website_id)->where("device_type", $session->info->device_type)->count()
                    ]);
                    if($session->info->countryName == null){
                        Session_information::where("id", $session->info->id)->update(["countryName" => "Not set"]);
                    }
                    if($session->info->cityName == null){
                        Session_information::where("id", $session->info->id)->update(["cityName" => "Not set"]);
                    }
                }
                if($session->referrals != null){
                    Referral::where("id", $session->referrals->id)->update([
                        "count" => Referral::where('created_at', '>', $lastDay)->where("website_id", $session->website_id)->where("url", $session->referrals->url)->count()
                    ]);
                    if($session->referrals->url == null){
                        Referral::where("id", $session->referrals->id)->update(["url" => "Not set"]);
                    }
                    if(Website::where("id", $session->referrals->website_id)->count() > 0){
                        if(str_contains($session->referrals->url, "https://".Website::where("id", $session->referrals->website_id)->first()->domain)){
                            Referral::where("id", $session->referrals->id)->delete();
                        }
                    }
                    $search = explode("|",file_get_contents(base_path()."/public_html/search.txt"));
                    $social = explode("|",file_get_contents(base_path()."/public_html/social.txt"));
                    $video = explode("|",file_get_contents(base_path()."/public_html/video.txt"));
                    $searchResult = GlobalFunc::contains($session->referrals->url, $search);
                    $socialResult = GlobalFunc::contains($session->referrals->url, $social);
                    $videoResult = GlobalFunc::contains($session->referrals->url, $video);
                    if($searchResult != false){
                        Referral::where("id", $session->referrals->id)->update([
                            "type" => "Search"
                        ]);
                        $command->comment("Search match success - ".$searchResult);
                    }  else if($socialResult != false){
                        Referral::where("id", $session->referrals->id)->update([
                            "type" => "Social"
                        ]);
                        $command->comment("Social match success - ".$socialResult);
                    } else if($videoResult != false){
                        Referral::where("id", $session->referrals->id)->update([
                            "type" => "Video"
                        ]);
                        $command->comment("Video match success - ".$videoResult);
                    } else {
                        Referral::where("id", $session->referrals->id)->update([
                            "type" => "Referral"
                        ]);
                        $command->comment("Set as referral");
                    }
                }
                foreach($session->pages()->get() as $page){
                    if($page != null){
                        Page::where("id", $page->id)->update([
                            "count" => Page::where('created_at', '>', $lastDay)->where("website_id", $session->website_id)->where("url", $page->url)->count()
                        ]);
                        if($page->url == null){
                            Page::where("id", $page->id)->update(["url" => "Not set"]);
                        }
                    }
                }

                $command->comment("Updated - ".$session->id." Sessions");
            }

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