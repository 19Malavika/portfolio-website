<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'short_description',
        'full_description',
        'problem_statement',
        'features',
        'technologies',
        'highlights',
        'image_url',
        'github_url',
        'live_url',
        'is_featured',
        'display_order',
    ];

    protected $casts = [
        'features' => 'array',
        'technologies' => 'array',
        'highlights' => 'array',
        'is_featured' => 'boolean',
        'display_order' => 'integer',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('display_order');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }
}

