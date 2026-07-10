<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsEvent extends Model
{
    protected $fillable = [
        'session_id',
        'event_type',
        'event_data',
        'url',
    ];

    protected $casts = [
        'event_data' => 'array',
        'created_at' => 'datetime',
    ];

    public $timestamps = false;

    /**
     * Get the visitor that owns the analytics event.
     */
    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'session_id', 'session_id');
    }

    /**
     * Scope a query to only include events for a specific period.
     */
    public function scopeForPeriod($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope a query to only include events of a specific type.
     */
    public function scopeForType($query, $type)
    {
        return $query->where('event_type', $type);
    }
}
