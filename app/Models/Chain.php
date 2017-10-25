<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chain extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'phone_number',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'user_id'
    ];
}
