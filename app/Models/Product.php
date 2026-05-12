<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'specifications',
        'features',
        'image',
        'brochure',
    ];

    protected $casts = [
        'specifications' => 'array',
        'features' => 'array',
    ];
}
