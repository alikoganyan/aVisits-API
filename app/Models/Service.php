<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_category_id',
        'title',
        'description',
        'duration',
        'price',
        'created_at',
        'updated_at'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'chain_id',
    ];

    /**
     * Get service by id
     *
     * @param $id
     * @return mixed
     */
    public static function getById($id)
    {
        $service = self::query()->with(['servicePrice'])->find($id);
        return $service;
    }

    /**
     * Relationship for get service prices
     *
     * @return $this
     */
    public function servicePrice()
    {
        return $this->hasMany('App\Models\ServicePrice', 'service_id', 'id')->with(['level']);
    }

    public static function getServices($filter = null){
        $query = Employee::query();
        $query->select([
            'salon_employee_services.price',
            'salon_employee_services.duration',
            'services.id',
            'services.service_category_id',
            'services.title',
            'services.duration as default_duration',
            'services.description',
            'services.available_for_online_recording',
            'services.only_for_online_recording',
        ]);
        $query->distinct();
        if($filter !== null){
            if(isset($filter['salon_id'])){
                $salonId = $filter['salon_id'];
                if(isset($filter['employees']) && count($filter['employees'])){
                    $employees = $filter['employees'];
                    $query->join('salon_has_employees', function ($join) use($salonId,$employees) {
                        $join->on('employees.id', '=', 'salon_has_employees.employee_id')
                            ->where('salon_has_employees.salon_id', '=', $salonId)
                            ->whereIn('employee_id',$employees);
                    });
                    $query->join('salon_employee_services',function($join){
                        $join->on('salon_has_employees.id','=','salon_employee_services.shm_id')
                            /*->where()*/;
                    });
                    $query->join('services',function($join){
                        $join->on('services.id','=','salon_employee_services.service_id');
                    });
                }
            }
        }
        return $query->get();
    }
}
