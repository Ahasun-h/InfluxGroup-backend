<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'icon',
        'description',
        'long_description',
        'features',
        'applications',
        'image',
        'case_study',
    ];

    protected $casts = [
        'features' => 'array',
        'applications' => 'array',
    ];
}
