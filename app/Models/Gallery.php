<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'gallery';

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
