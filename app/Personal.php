<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = "personal";
    protected $fillable = [
        'name', 'post', 'lvl','masterId'
    ];

    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
