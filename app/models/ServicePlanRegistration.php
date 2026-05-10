<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\ServiceCate;

class ServicePlanRegistration extends Model
{
    protected $table = 'service_plan_registrations';

    protected $fillable = [
        'service_category_id',
        'plan_title',
        'full_name',
        'phone',
        'email',
        'address',
        'ip',
    ];

    public function category()
    {
        return $this->belongsTo(ServiceCate::class, 'service_category_id');
    }
}
