<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Referral extends Model
{

    protected $fillable = [
        'website_id',
        'session_id',
        'pages',
        'date',
        'referral_url'
    ];

    use SoftDeletes;

    protected $hidden = [
        'ip'
    ];


    protected $casts = [
        'session_ended' => 'datetime',
    ];
}
