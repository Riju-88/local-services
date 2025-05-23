<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    //
    protected $fillable = [
        'user_id',
        'service_category_id',
        'business_name',
        'slug',
        'description',
        'phone',
        'address',
        'photos',
        'latitude',
        'longitude',
        'is_active',
        'providable_id',
        'providable_type',
        
    ];


    protected $casts = [
        'photos' => 'array',
    ];


      public function getRouteKeyName()
{
    return 'slug';
}

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function providable()
    {
        return $this->morphTo();
    }

}
