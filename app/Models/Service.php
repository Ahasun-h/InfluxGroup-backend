<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'icon',
        'description',
        'long_description',
        'features',
        'process',
        'image',
    ];

    protected $casts = [
        'features' => 'array',
        'process' => 'array',
    ];
}
