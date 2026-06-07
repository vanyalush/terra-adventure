<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = ['user_id', 'hike_date_id', 'last_name', 'first_name', 'middle_name', 'birth_date', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hikeDate(): BelongsTo
    {
        return $this->belongsTo(HikeDate::class);
    }
}
