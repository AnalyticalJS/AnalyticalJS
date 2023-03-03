<?php

namespace App\Models;

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
        return $this->hasOne('App\Models\Session_information','session_id','id');
    }
    public function referrals() {
        return $this->hasOne('App\Models\Referral','session_id','id');
    }
    public function pages() {
        return $this->hasOne('App\Models\Page','session_id','id');
    }
}
