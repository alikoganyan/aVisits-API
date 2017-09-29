<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'salon_id',
        'employee_id',
        'start_time',
        'end_time',
        'day',
        'working_status',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [

    ];
}
