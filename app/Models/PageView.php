<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    protected $fillable = [
        'session_id',
        'url',
        'title',
        'referer',
        'method',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public $timestamps = false;

    /**
     * Get the visitor that owns the page view.
     */
    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'session_id', 'session_id');
    }

    /**
     * Scope a query to only include page views for a specific period.
     */
    public function scopeForPeriod($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope a query to only include page views for a specific URL.
     */
    public function scopeForUrl($query, $url)
    {
        return $query->where('url', 'like', '%' . $url . '%');
    }

    /**
     * Scope a query to only include page views from a specific referer.
     */
    public function scopeForReferer($query, $referer)
    {
        return $query->where('referer', 'like', '%' . $referer . '%');
    }
}
