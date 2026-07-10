<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuoteRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'requirements',
        'status',
        'quotation_id',
        'admin_notes',
        'contacted_at',
        'quoted_at',
        'customer_id',
    ];

    protected $casts = [
        'contacted_at' => 'datetime',
        'quoted_at' => 'datetime',
    ];

    /**
     * Get the quotation for this quote request.
     */
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    /**
     * Get the customer for this quote request.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Scope a query to only include pending requests.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include quoted requests.
     */
    public function scopeQuoted($query)
    {
        return $query->where('status', 'quoted');
    }

    /**
     * Scope a query to only include converted requests.
     */
    public function scopeConverted($query)
    {
        return $query->where('status', 'converted');
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-600 dark:text-white',
            'contacted' => 'bg-blue-100 text-blue-800 dark:bg-blue-600 dark:text-white',
            'quoted' => 'bg-purple-100 text-purple-800 dark:bg-purple-600 dark:text-black',
            'converted' => 'bg-green-100 text-green-800 dark:bg-green-600 dark:text-white',
            'closed' => 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-white',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get status label.
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Pending',
            'contacted' => 'Contacted',
            'quoted' => 'Quoted',
            'converted' => 'Converted',
            'closed' => 'Closed',
            default => 'Unknown',
        };
    }
}
