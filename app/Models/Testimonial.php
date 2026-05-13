<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'company',
        'company_logo',
        'content',
        'rating',
        'project_name',
        'image',
        'featured',
        'date',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'date' => 'date',
    ];
}
