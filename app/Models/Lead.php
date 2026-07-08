<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'notes',
        'assigned_to',
        'contacted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'contacted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the user that the lead is assigned to.
     */
    public function assignedTo()
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_to');
    }

    /**
     * Scope a query to only include new leads.
     */
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    /**
     * Scope a query to only include contacted leads.
     */
    public function scopeContacted($query)
    {
        return $query->where('status', 'contacted');
    }

    /**
     * Scope a query to only include qualified leads.
     */
    public function scopeQualified($query)
    {
        return $query->where('status', 'qualified');
    }

    /**
     * Scope a query to only include converted leads.
     */
    public function scopeConverted($query)
    {
        return $query->where('status', 'converted');
    }

    /**
     * Scope a query to only include lost leads.
     */
    public function scopeLost($query)
    {
        return $query->where('status', 'lost');
    }

    /**
     * Check if lead is new.
     */
    public function isNew(): bool
    {
        return $this->status === 'new';
    }

    /**
     * Check if lead is contacted.
     */
    public function isContacted(): bool
    {
        return $this->status === 'contacted';
    }

    /**
     * Check if lead is converted.
     */
    public function isConverted(): bool
    {
        return $this->status === 'converted';
    }
}
