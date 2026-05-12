<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOpening extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'department',
        'location',
        'type',
        'experience',
        'description',
        'responsibilities',
        'requirements',
        'benefits',
        'salary',
        'deadline',
        'status',
        'posted_date',
    ];

    protected $casts = [
        'responsibilities' => 'array',
        'requirements' => 'array',
        'benefits' => 'array',
        'deadline' => 'datetime',
        'posted_date' => 'datetime',
    ];
}
