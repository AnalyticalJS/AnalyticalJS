<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{

    protected $fillable = [
        'website_id',
        'session_id',
        'pages',
        'url',
        'date'
    ];

    use SoftDeletes;
}
