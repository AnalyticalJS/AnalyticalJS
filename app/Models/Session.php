<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{

    protected $fillable = [
        'pages',
        'website_id',
        'ip',
        'session_ended'
    ];

    use SoftDeletes;

    public function info() {
        $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
        return $this->hasOne('App\Models\Session_information','session_id','id')->where('updated_at', '>', $lastDay);
    }
    public function referrals() {
        $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
        return $this->hasOne('App\Models\Referral','session_id','id')->where('updated_at', '>', $lastDay);
    }
    public function pages() {
        $lastDay = Carbon::now()->subHours(24)->startOfHour()->toDateTimeString();
        return $this->hasMany('App\Models\Page','session_id','id')->where('updated_at', '>', $lastDay);
    }
}
