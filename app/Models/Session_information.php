<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session_information extends Model
{

    protected $fillable = [
        'website_id',
        'session_id',
        'browser',
        'countryName',
        'countryCode',
        'cityName',
        'latitude',
        'longitude',
        'timezone'
    ];

    use SoftDeletes;
}
