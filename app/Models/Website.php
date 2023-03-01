<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Website extends Model
{

    protected $fillable = [
        'domain'
    ];

    use SoftDeletes;

    public function sessions() {
        return $this->hasMany('App\Models\Session','website_id','id');
    }
    public function session_info() {
        return $this->hasMany('App\Models\Session_information','website_id','id');
    }
    public function pages() {
        return $this->hasMany('App\Models\Page','website_id','id');
    }
    public function referrals() {
        return $this->hasMany('App\Models\Referral','website_id','id');
    }
    public function bots() {
        return $this->hasMany('App\Models\Bot','website_id','id');
    }
}