<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //

    protected $fillable = [
        'name',
        'slug',
        'icon',
       
    ];


   


    public function providers()
    {
        return $this->MorphMany(Provider::class, 'providable');
    }

    public function serviceCategory()
    {
        return $this->hasMany(ServiceCategory::class);
    }
}
