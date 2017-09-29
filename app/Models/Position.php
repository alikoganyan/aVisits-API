<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'title',
        'description'
    ];
    protected $hidden = [
        'chain_id'
    ];
}
