<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $table = 'education';

    protected $fillable = [
        'degree',
        'institution',
        'university',
        'location',
        'duration',
        'cgpa',
        'description',
        'highlights',
        'display_order',
    ];

    protected $casts = [
        'highlights' => 'array',
        'display_order' => 'integer',
    ];
}

