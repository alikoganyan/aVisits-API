<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentHasServices extends Model
{
    protected $fillable = [
        'appointment_id',
        'service_id',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [];
}
