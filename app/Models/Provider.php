<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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


     protected static function booted()
    {
        static::deleting(function ($provider) {
            if (is_array($provider->photos)) {
                foreach ($provider->photos as $photo) {
                    Storage::disk('public')->delete($photo);
                }
            }
        });
    }
}
