<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'summary',
        'director',
        'year',
        'country',
        'duration_minutes',
        'poster_url',
    ];

    protected $casts = [
        'duration_minutes' => 'integer',
        'credits' => 'array',
        'casting' => 'array',
    ];
}