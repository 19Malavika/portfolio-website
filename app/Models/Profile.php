<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'tagline',
        'short_intro',
        'career_objective',
        'bio',
        'phone',
        'email',
        'location',
        'avatar_url',
        'resume_path',
        'strengths',
        'interests',
        'stats',
    ];

    protected $casts = [
        'strengths' => 'array',
        'interests' => 'array',
        'stats' => 'array',
    ];
}
