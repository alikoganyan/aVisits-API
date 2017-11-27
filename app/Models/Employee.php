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

    public function position() {
        return $this->hasOne('App\Models\Position', 'id', 'position_id');
    }

    public static function empolyees($chain,$filter = null)
    {
        $query = self::query();
        $query->select(['employees.id','first_name','last_name','father_name','photo','sex','birthday','position_id','public_position']);
        $query->with('position');
        $query->where('chain_id','=',$chain);

        if($filter !== null){
            /*when need to filter by ID of Salon*/
            if(isset($filter['salon_id']) && !empty($filter['salon_id'])) {
                $salonId = $filter['salon_id'];
                $query->join('salon_has_employees', function ($join) use($salonId) {
                    $join->on('employees.id', '=', 'salon_has_employees.employee_id')
                        ->where('salon_has_employees.salon_id', '=', $salonId);
                });
                /*when need to filter by Address or By Latitide Longitude*/
            }elseIf(isset($filter['address']) && !empty($filter['address'])) {
                $address = $filter['address'];
                $query->join('salon_has_employees', function ($join) {
                    $join->on('employees.id', '=', 'salon_has_employees.employee_id');
                });
                $query->join('salons', function ($join) use( $address ) {
                    $join->on('salons.id', '=', 'salons.salon_id');
                    if(isset($address['country']) && !empty($address['country'])) {
                        $join->where('salons.country','=',$address['country']);
                    }
                    if(isset($address['city']) && !empty($address['city'])) {
                        $join->where('salons.city','=',$address['city']);
                    }
                    if(isset($address['address']) && !empty($address['address'])) {
                        $join->where('salons.address','=',$address['address']);
                    }
                    if(isset($address['street_number']) && !empty($address['street_number'])) {
                        $join->where('salons.street_number','=',$address['street_number']);
                    }
                    if((isset($address['latitude']) && isset($address['longitude'])) && (!empty($address['longitude']) && !empty($address['latitude']))) {
                        $join->where([
                            'salons.latitude'=>$address['latitude'],
                            'salons.longitude'=>$address['longitude']
                        ]);
                    }
                });
            }
        }

        $query->where('dismissed','=',0);
        return $query->get();
    }
}