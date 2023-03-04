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
            $pagesData = collect($website->pages->where('created_at', '>', $lastDay))->unique("url")->take(100)->sortByDesc("count");
            $referrals = collect($website->referrals->where('created_at', '>', $lastDay));
            $referralData = $referrals->unique("url")->take(100)->sortByDesc("count");
            $referralTypesData = $referrals->unique("type");
            foreach($referralTypesData as $index => $type){
                $type->typeCount = Referral::where('created_at', '>', $lastDay)->where("website_id", $website->id)->where("type", $type->type)->count();
                if($type->type == null){
                    $type->type = "Direct or unknown";
                }
            }
            $website->update([
                "dailySessions" => $days,
                "dailyReferral" => $referralData->values(),
                "dailyReferralTypes" => $referralTypesData->values(),
                "dailyPages" => $pagesData->values()
            ]);
            $command->comment($website->domain." Updated");
        }
        $command->comment("Done!");
    }

    public static function countDupes($command)
    {
        $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
        $sessions = Session::where('created_at', '>', $lastDay);
        $session_info = Session_information::where('created_at', '>', $lastDay);

        foreach($sessions->get() as $session){
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
                if(GlobalFunc::contains($session->referrals->url, $search) == true){
                    Referral::where("id", $session->referrals->id)->update([
                        "type" => "Search",
                        "typeCount" => Referral::where('created_at', '>', $lastDay)->where("website_id", $session->website_id)->where("type", "Search")->count()
                    ]);
                }  else if(GlobalFunc::contains($session->referrals->url, $social) == true){
                    Referral::where("id", $session->referrals->id)->update([
                        "type" => "Social",
                        "typeCount" => Referral::where('created_at', '>', $lastDay)->where("website_id", $session->website_id)->where("type", "Social")->count()
                    ]);
                } else if(GlobalFunc::contains($session->referrals->url, $video) == true){
                    Referral::where("id", $session->referrals->id)->update([
                        "type" => "Video",
                        "typeCount" => Referral::where('created_at', '>', $lastDay)->where("website_id", $session->website_id)->where("type", "Video")->count()
                    ]);
                } else {
                    Referral::where("id", $session->referrals->id)->update([
                        "type" => "Referral",
                        "typeCount" => Referral::where('created_at', '>', $lastDay)->where("website_id", $session->website_id)->where("type", "Referral")->count()
                    ]);
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