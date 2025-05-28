<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class OperatingHour extends Model
{
    protected $fillable = [
        'cinema_id',
        'day_of_week',
        'opens_at',
        'closes_at'
    ];

    protected $casts = [
        'opens_at' => 'datetime',
        'closes_at' => 'datetime'
    ];

    public function cinema(): BelongsTo
    {
        return $this->belongsTo(Cinema::class);
    }

    public function isOpen(Carbon $dateTime): bool
    {
        if ($this->opens_at === null || $this->closes_at === null) {
            return false;
        }

        $time = Carbon::parse($dateTime)->format('H:i');
        return $time >= $this->opens_at->format('H:i') && 
               $time <= $this->closes_at->format('H:i');
    }
}
