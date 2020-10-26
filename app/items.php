<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class items extends Model
{
    protected $fillable = [
        'id','user_id', 'items','created_at','updated_at'
    ];
}
