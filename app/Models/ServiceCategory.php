<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

class ServiceCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'parent_id',
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
     * Get service category by id
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public static function getById($id)
    {
        $serviceCategory = self::query()->with(['groups'])->find($id);
        return $serviceCategory;
    }

    /**
     * Get service categories by parent id
     *
     * @param $parent_id
     * @return $this
     */
    public static function getByParentId($parent_id) {
        $serviceCategories=self::query()->where('parent_id',$parent_id)->get();
        return $serviceCategories;
    }

    /**
     * Relationship for get groups
     *
     * @return $this
     */
    public function groups()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')
            ->with('services');
    }

    /**
     * Relationship for get services
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'service_category_id', 'id');
    }
}
