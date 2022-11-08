<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LockAngkutan extends Model
{
    protected $fillable = [
        'id_angkutan',
        'status',
        'password'
    ];
}
