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
        'img',
        'phone_number',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'user_id'
    ];
    protected $appends = ['salonsCount'];

    public static function getStepsG(){
        return array_merge(self::getStepsService(),self::getStepsEmployee());
    }
    public static function getStepsService(){
        return [
            "address,service,employee,time"=>"Адрес -> Услуги -> Сотрудники, Время",
            "service,address,employee,time"=>"Услуги -> Адрес -> Сотрудники, Время",
        ];
    }

    public static function getStepsEmployee(){
        return [
            "address,employee,service,time"=>"Адрес -> Сотрудники -> Услуги -> Время",
            "employee,service,address,time"=>"Сотрудники -> Услуги -> Адрес -> Время",
            "employee,address,service,time"=>"Сотрудники -> Адрес -> Услуги -> Время",
            "address,service,time"=>"Адрес -> Услуги -> Время",
        ];
    }
    public static function getContactSteps(){
        return [
            'at_first',
            'after_address',
            'at_the_end'
        ];
    }
    /**
     * Get chain by id
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public static function getById($id)
    {
        $chain = self::query()->select([
            'id',
            'title',
            'img',
            'phone_number',
            'created_at',
            'updated_at'
        ])->with(['levels'])->find($id);
        return $chain;
    }

    /**
     * Get salons count attribute
     *
     * @return int
     */
    public function getSalonsCountAttribute()
    {
        return count($this->salons);
    }

    /**
     * Relationship for get salons
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function salons()
    {
        return $this->hasMany('App\Models\Salon', 'chain_id', 'id');
    }

    /**
     * Relationship for get levels
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function levels()
    {
        return $this->hasMany('App\Models\ChainPriceLevel', 'chain_id', 'id');
    }

    /**
     * @param $value
     * @return string
     *
     */
    public function getImgAttribute($value) {
        if(!$value){
            return null;
        }
        $ds = DIRECTORY_SEPARATOR;
        return 'files'.$ds.'chains'.$ds.'images'.$ds.'main'.$ds.$value;
    }
}
