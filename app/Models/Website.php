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

    public function days() {
        return $this->hasMany('App\Models\Session','website_id','id');
    }
}
