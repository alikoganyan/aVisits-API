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
        'description',
        'created_at',
        'updated_at'
    ];
    protected $hidden = [
        'user_id'
    ];
    protected $appends = ['salonsCount'];

    /**
     * Get chain by id
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public static function getById($id)
    {
        $chain = self::query()->with(['levels'])->find($id);
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
}
