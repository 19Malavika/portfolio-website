<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'position',
        'location',
        'start_date',
        'end_date',
        'is_current',
        'description',
        'technologies',
        'achievements',
        'display_order',
    ];

    protected $casts = [
        'is_current' => 'boolean',
        'technologies' => 'array',
        'achievements' => 'array',
        'display_order' => 'integer',
    ];
}

