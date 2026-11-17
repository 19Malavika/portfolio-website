<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'proficiency',
        'level_label',
        'icon',
        'display_order',
        'is_featured',
    ];

    protected $casts = [
        'proficiency' => 'integer',
        'display_order' => 'integer',
        'is_featured' => 'boolean',
    ];
}

