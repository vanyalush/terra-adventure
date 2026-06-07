<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hike extends Model
{
    protected $fillable = [
        'category_id', 'name', 'description', 'route',
        'distance_km', 'duration_days', 'min_age',
        'max_participants', 'difficulty', 'price', 'region', 'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function dates()
    {
        return $this->hasMany(HikeDate::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
