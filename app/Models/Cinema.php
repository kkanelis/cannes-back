<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cinema extends Model
{
    public function openingHours(): HasMany
    {
        return $this->hasMany(OperatingHour::class);
    }
}
