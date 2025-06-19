<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Service extends Model
{
    use HasFactory;
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
