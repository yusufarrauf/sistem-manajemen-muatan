<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataMuatan extends Model
{
    protected $fillable = [
        'muatan',
        'asal'
    ];
}
