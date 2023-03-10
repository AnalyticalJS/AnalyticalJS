<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Website extends Model
{

    protected $fillable = [
        'domain',
        'dailySessions',
        'dailyReferral',
        'dailyReferralTypes',
        'dailyPages'
    ];

    use SoftDeletes;

    protected $casts = [
        'dailySessions' => 'array',
        'dailyReferral' => 'array',
        'dailyReferralTypes' => 'array',
        'dailyPages' => 'array'
    ];

    public function sessions() {
        $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
        return $this->hasMany('App\Models\Session','website_id','id')->where('updated_at', '>', $lastDay);
    }
    public function session_info() {
        $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
        return $this->hasMany('App\Models\Session_information','website_id','id')->where('updated_at', '>', $lastDay);
    }
    public function pages() {
        $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
        return $this->hasMany('App\Models\Page','website_id','id')->where('updated_at', '>', $lastDay);
    }
    public function referrals() {
        $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
        return $this->hasMany('App\Models\Referral','website_id','id')->where('updated_at', '>', $lastDay);
    }
    public function bots() {
        $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
        return $this->hasMany('App\Models\Bot','website_id','id')->where('updated_at', '>', $lastDay);
    }
}