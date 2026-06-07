<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HikeDate extends Model
{
    protected $fillable = ['hike_id', 'start_date', 'end_date', 'spots_total', 'spots_taken'];

    public function hike(): BelongsTo
    {
        return $this->belongsTo(Hike::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
