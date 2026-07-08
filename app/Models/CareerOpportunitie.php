<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CareerOpportunitie extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'career_opportunities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'department',
        'location',
        'type',
        'posted_date',
        'expiry_date',
        'experience',
        'salary',
        'description',
        'requirements',
        'responsibilities',
        'benefits',
        'is_active',
        'order',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expiry_date' => 'date',
        'requirements' => 'array',
        'responsibilities' => 'array',
        'benefits' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the user who created the job.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the job.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope to get only active jobs.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by order field.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at', 'desc');
    }

    /**
     * Scope to get all jobs (including inactive)
     */
    public function scopeAllJobs($query)
    {
        return $query->withTrashed();
    }
}
