<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'excerpt',
        'content',
        'image',
        'author_name',
        'author_role',
        'author_photo',
        'published_at',
        'read_time',
        'featured',
        'tags',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'featured' => 'boolean',
        'tags' => 'array',
    ];
}
