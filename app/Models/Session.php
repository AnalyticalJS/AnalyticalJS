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

    protected $hidden = [
        'ip'
    ];

    public function session_info() {
        return $this->hasOne('App\Models\Session_information','session_id','id');
    }
}
