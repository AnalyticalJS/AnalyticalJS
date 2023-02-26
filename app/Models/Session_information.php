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
        'timezone',
        'browser_version',
        'os_family',
        'os_type',
        'os_name',
        'os_version',
        'os_title',
        'device_type',
        'countCountries',
        'countCity',
        'countBrowser',
        'countOs',
        'countDevice'
    ];

    use SoftDeletes;

    public function session()
    {
        return $this->belongsTo('App\Models\Session','id','session_id');
    }
}