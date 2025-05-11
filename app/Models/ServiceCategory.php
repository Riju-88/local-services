<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceCategory extends Model
{
    //

    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'slug',
        'service_id',
    ];


    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function providers()
    {
        return $this->MorphMany(Provider::class, 'providable');
    }
}
