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


    protected $casts = [
        'session_ended' => 'datetime',
    ];
}
