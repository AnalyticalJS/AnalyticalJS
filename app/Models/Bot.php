<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bot extends Model
{

    protected $fillable = [
        'website_id',
        'bot',
        'count'
    ];

    use SoftDeletes;
}
