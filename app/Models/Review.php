<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //

    protected $fillable = [
        'provider_id',
        'user_id',
        'rating',
        'title',
        'comment',
        'photos',
    ];


    protected $casts = [
        'photos' => 'array',
    ];


    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
