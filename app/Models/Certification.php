<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'issuer',
        'issue_date',
        'credential_id',
        'credential_url',
        'description',
        'display_order',
    ];

    protected $casts = [
        'display_order' => 'integer',
    ];
}

