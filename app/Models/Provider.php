<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Provider extends Model
{
    //
   protected $fillable = [
    'user_id',
    'business_name',
    'slug',
    'description',
    'phone',
    'alternate_phone',
    'whatsapp_number',
    'email',
    'website',

    'contact_person_name',
    'contact_person_role',
    'contact_person_phone',
    'contact_person_email',
    'contact_person_whatsapp',

    'address',
    'area',
    'pincode',
    'photos',
    'logo',
    'latitude',
    'longitude',

    'working_hours',
    'established_year',
    'tags',

    'is_active',
    'is_verified',
    'featured',
    'views',

    'providable_id',
    'providable_type',
];


    protected $casts = [
    'photos' => 'array',
    'working_hours' => 'array',
    'tags' => 'array',
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
