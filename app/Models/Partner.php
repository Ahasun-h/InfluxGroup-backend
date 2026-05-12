<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'type',
        'logo',
        'website',
        'description',
        'partnership_type',
        'since',
        'featured',
        'order',
    ];

    protected $casts = [
        'featured' => 'boolean',
    ];
}
