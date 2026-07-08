<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'galleries';

    protected $fillable = [
        'type',
        'title',
        'category',
        'url',
        'thumbnail',
        'caption',
        'alt',
        'project_id',
        'date',
        'featured',
        'order',
    ];

    protected $casts = [
        'date' => 'datetime',
        'featured' => 'boolean',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
