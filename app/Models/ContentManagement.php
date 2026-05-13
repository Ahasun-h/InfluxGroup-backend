<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentManagement extends Model
{
    protected $table = 'content_management';

    protected $fillable = [
        'section_name',
        'section_item_name',
        'section_content',
        'attributes',
        'media_files',
    ];

    protected $casts = [
        'attributes' => 'array',
        'media_files' => 'array',
    ];
}
