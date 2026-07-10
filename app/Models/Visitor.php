<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = [
        'session_id',
        'ip_address',
        'user_agent',
        'first_visit',
        'last_visit',
        'visit_count',
        'device_type',
        'browser',
        'platform',
    ];

    protected $casts = [
        'first_visit' => 'datetime',
        'last_visit' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the page views for the visitor.
     */
    public function pageViews()
    {
        return $this->hasMany(PageView::class, 'session_id', 'session_id');
    }

    /**
     * Get the analytics events for the visitor.
     */
    public function analyticsEvents()
    {
        return $this->hasMany(AnalyticsEvent::class, 'session_id', 'session_id');
    }

    /**
     * Scope a query to only include visitors for a specific period.
     */
    public function scopeForPeriod($query, $startDate, $endDate)
    {
        return $query->whereBetween('first_visit', [$startDate, $endDate]);
    }

    /**
     * Scope a query to only include unique visitors (first time).
     */
    public function scopeUniqueVisitors($query, $period = null)
    {
        if ($period) {
            return $query->where('first_visit', '>=', $period);
        }
        return $query;
    }

    /**
     * Scope a query to only include returning visitors.
     */
    public function scopeReturningVisitors($query)
    {
        return $query->where('visit_count', '>', 1);
    }

    /**
     * Check if this is a returning visitor.
     */
    public function isReturning(): bool
    {
        return $this->visit_count > 1;
    }
}
