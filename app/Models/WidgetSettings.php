<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WidgetSettings extends Model
{
    protected $table = "chains";

    protected $fillable = [
        'id',
        'w_color',
        'w_group_by_category',
        'w_show_any_employee',
        'w_step_display',
        'w_step_search',
        'w_let_check_steps',
        'w_steps_g',
        'w_steps_service',
        'w_steps_employee',
        'w_contact_step',
        'w_to_group_category'
    ];

    protected $hidden = [
        "title",
        "img",
        "phone_number",
        "user_id",
        "created_at",
        "updated_at",
    ];

    public static function getStepsG()
    {
        return array_merge(self::getStepsService(), self::getStepsEmployee());
    }

    public static function getStepsService()
    {
        return [
            "address,service,employee_time" => "Адрес -> Услуги -> Сотрудники, Время",
            "service,address,employee_time" => "Услуги -> Адрес -> Сотрудники, Время",
        ];
    }

    public static function getStepsEmployee()
    {
        return [
            "address,employee,service,time" => "Адрес -> Сотрудники -> Услуги -> Время",
            "employee,service,address,time" => "Сотрудники -> Услуги -> Адрес -> Время",
            "employee,address,service,time" => "Сотрудники -> Адрес -> Услуги -> Время",
            "address,service,time" => "Адрес -> Услуги -> Время",
        ];
    }
    
    public function getSalonsCountAttribute()
    {
        return count($this->salons);
    }
}