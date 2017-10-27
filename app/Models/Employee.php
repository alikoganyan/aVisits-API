<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * Get employee by id
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public static function getById($id)
    {
        $employee = self::query()->with(['salons'])->find($id);
        return $employee;
    }

    protected $fillable = [
        'first_name',
        'last_name',
        'father_name',
        'photo',
        'birthday',
        'email',
        'phone',
        'address',
//        'deposit',
//        'bonuses',
//        'invoice_sum',
        'position_id',
        'public_position',
        'comment'
    ];

    protected $hidden = [
        'chain_id'
    ];

    /**
     * Relationship for get salons
     *
     * @return $this
     */
    public function salons()
    {
        return $this->hasMany('App\Models\SalonHasEmployees', 'employee_id', 'id')->with('salon');
    }
}