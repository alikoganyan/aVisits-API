<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'father_name',
        'photo',
        'sex',
        'birthday',
        'email',
        'phone',
        'phone_2',
        'address',
        'card_number',
        'card_number_optional',
        'deposit',
        'bonuses',
        'invoice_sum',
        'position_id',
        'public_position',
        'comment'
    ];

    protected $hidden = [
        'chain_id'
    ];
}